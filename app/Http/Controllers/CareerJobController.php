<?php

namespace App\Http\Controllers;

use App\Models\CareerJob;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CareerJobController extends Controller
{
    /**
     * Display a listing of career jobs
     */
    public function index(Request $request)
    {
        $query = CareerJob::with(['department', 'creator', 'updater'])
            ->withCount('applications');

        // Search functionality
        if ($request->has('search') && !empty(trim($request->search))) {
            $query->search(trim($request->search));
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by department
        if ($request->has('department_id') && $request->department_id) {
            $query->byDepartment($request->department_id);
        }

        // Filter by employment type
        if ($request->has('employment_type') && $request->employment_type) {
            $query->byEmploymentType($request->employment_type);
        }

        // Filter by experience level
        if ($request->has('experience_level') && $request->experience_level) {
            $query->byExperienceLevel($request->experience_level);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('featured', $request->featured);
        }

        $jobs = $query->orderBy('created_at', 'desc')->paginate(20);
        $departments = Department::where('is_active', true)->get();

        // Append accessor attributes to jobs
        $jobs->getCollection()->transform(function ($job) {
            // Use the applications_count from the query
            $job->application_count = $job->applications_count ?? 0;
            return $job;
        });

        return Inertia::render('Admin/CareerJobs', [
            'jobs' => $jobs,
            'departments' => $departments,
            'filters' => $request->only(['search', 'status', 'department_id', 'employment_type', 'experience_level', 'featured']),
            'user' => auth()->user()
        ]);
    }

    /**
     * Show the form for creating a new career job
     */
    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        
        return Inertia::render('Admin/CareerJobForm', [
            'departments' => $departments,
            'user' => auth()->user()
        ]);
    }

    /**
     * Store a newly created career job
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'employment_type' => 'required|in:full-time,part-time,contract,internship',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'location' => 'required|string|max:255',
            'remote_allowed' => 'boolean',
            'salary_range' => 'nullable|string|max:100',
            'application_deadline' => 'nullable|date|after:today',
            'max_applications' => 'nullable|integer|min:1',
            'application_instructions' => 'nullable|string',
            'status' => 'required|in:draft,published,closed,archived',
            'featured' => 'boolean',
            'priority' => 'nullable|integer|min:0|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        // Set published_at if status is published
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        CareerJob::create($data);

        return redirect()->route('admin.career-jobs.index')
            ->with('success', 'Career job created successfully!');
    }

    /**
     * Display the specified career job
     */
    public function show(CareerJob $careerJob)
    {
        $careerJob->load(['department', 'creator', 'updater', 'applications']);
        
        return Inertia::render('Admin/CareerJobShow', [
            'job' => $careerJob,
            'user' => auth()->user()
        ]);
    }

    /**
     * Show the form for editing the specified career job
     */
    public function edit(CareerJob $careerJob)
    {
        $departments = Department::where('is_active', true)->get();
        
        return Inertia::render('Admin/CareerJobForm', [
            'job' => $careerJob,
            'departments' => $departments,
            'user' => auth()->user()
        ]);
    }

    /**
     * Update the specified career job
     */
    public function update(Request $request, CareerJob $careerJob)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'benefits' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'employment_type' => 'required|in:full-time,part-time,contract,internship',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'location' => 'required|string|max:255',
            'remote_allowed' => 'boolean',
            'salary_range' => 'nullable|string|max:100',
            'application_deadline' => 'nullable|date|after:today',
            'max_applications' => 'nullable|integer|min:1',
            'application_instructions' => 'nullable|string',
            'status' => 'required|in:draft,published,closed,archived',
            'featured' => 'boolean',
            'priority' => 'nullable|integer|min:0|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['updated_by'] = auth()->id();

        // Set published_at if status is changing to published
        if ($data['status'] === 'published' && $careerJob->status !== 'published') {
            $data['published_at'] = now();
        }

        $careerJob->update($data);

        return redirect()->route('admin.career-jobs.index')
            ->with('success', 'Career job updated successfully!');
    }

    /**
     * Remove the specified career job
     */
    public function destroy(CareerJob $careerJob)
    {
        // Check if job has applications
        if ($careerJob->applications()->count() > 0) {
            return back()->with('error', 'Cannot delete job with existing applications. Please archive it instead.');
        }

        $careerJob->delete();

        return redirect()->route('admin.career-jobs.index')
            ->with('success', 'Career job deleted successfully!');
    }

    /**
     * Toggle the status of a career job
     */
    public function toggleStatus(CareerJob $careerJob)
    {
        $newStatus = match($careerJob->status) {
            'draft' => 'published',
            'published' => 'closed',
            'closed' => 'archived',
            'archived' => 'draft',
            default => 'draft'
        };

        $data = ['status' => $newStatus, 'updated_by' => auth()->id()];

        // Set published_at if status is changing to published
        if ($newStatus === 'published') {
            $data['published_at'] = now();
        }

        $careerJob->update($data);

        return back()->with('success', "Job status changed to {$newStatus}!");
    }

    /**
     * Toggle the featured status of a career job
     */
    public function toggleFeatured(CareerJob $careerJob)
    {
        $careerJob->update([
            'featured' => !$careerJob->featured,
            'updated_by' => auth()->id()
        ]);

        $status = $careerJob->featured ? 'featured' : 'unfeatured';
        return back()->with('success', "Job {$status} successfully!");
    }

    /**
     * Get jobs for API (for frontend career page)
     */
    public function getJobs(Request $request)
    {
        $query = CareerJob::published()->with('department');

        // Filter by department
        if ($request->has('department_id') && $request->department_id) {
            $query->byDepartment($request->department_id);
        }

        // Filter by employment type
        if ($request->has('employment_type') && $request->employment_type) {
            $query->byEmploymentType($request->employment_type);
        }

        // Filter by experience level
        if ($request->has('experience_level') && $request->experience_level) {
            $query->byExperienceLevel($request->experience_level);
        }

        // Filter by remote
        if ($request->has('remote') && $request->remote) {
            $query->remote();
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $jobs = $query->orderByPriority()->paginate(12);

        return response()->json($jobs);
    }
}
