<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class VacancyController extends Controller
{
    /**
     * Display a listing of vacancies
     */
    public function index(Request $request)
    {
        $query = Vacancy::with(['creator', 'updater'])
            ->withCount('applications');

        // Search functionality
        if ($request->has('search') && !empty(trim($request->search))) {
            $query->search(trim($request->search));
        }

        $vacancies = $query->orderByCreated()->paginate(20);

        // Append accessor attributes to vacancies
        $vacancies->getCollection()->transform(function ($vacancy) {
            $vacancy->application_count = $vacancy->applications_count ?? 0;
            return $vacancy;
        });

        return Inertia::render('Admin/Vacancies', [
            'vacancies' => $vacancies,
            'filters' => $request->only(['search']),
            'user' => auth()->user()
        ]);
    }

    /**
     * Show the form for creating a new vacancy
     */
    public function create()
    {
        return Inertia::render('Admin/VacancyForm', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Store a newly created vacancy
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'requirements' => 'nullable|string',
            'description' => 'required|string',
            'department_name' => 'required|string|max:255',
            'employee_benefit' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        
        // Set default is_active to 1 if not provided
        if (!isset($data['is_active'])) {
            $data['is_active'] = 1;
        }

        Vacancy::create($data);

        return redirect()->route('admin.vacancies.index')
            ->with('success', 'Vacancy created successfully!');
    }

    /**
     * Display the specified vacancy
     */
    public function show(Vacancy $vacancy)
    {
        $vacancy->load(['creator', 'updater', 'applications']);
        
        return Inertia::render('Admin/VacancyShow', [
            'vacancy' => $vacancy,
            'user' => auth()->user()
        ]);
    }

    /**
     * Show the form for editing the specified vacancy
     */
    public function edit(Vacancy $vacancy)
    {
        return Inertia::render('Admin/VacancyForm', [
            'vacancy' => $vacancy,
            'user' => auth()->user()
        ]);
    }

    /**
     * Update the specified vacancy
     */
    public function update(Request $request, Vacancy $vacancy)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'requirements' => 'nullable|string',
            'description' => 'required|string',
            'department_name' => 'required|string|max:255',
            'employee_benefit' => 'nullable|string',
            'is_active' => 'nullable|integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['updated_by'] = auth()->id();

        $vacancy->update($data);

        return redirect()->route('admin.vacancies.index')
            ->with('success', 'Vacancy updated successfully!');
    }

    /**
     * Remove the specified vacancy
     */
    public function destroy(Vacancy $vacancy)
    {
        try {
            // Check if vacancy has applications
            $applicationCount = $vacancy->applications()->count();
            
            if ($applicationCount > 0) {
                return redirect()->route('admin.vacancies.index')
                    ->with('error', "Cannot delete vacancy with {$applicationCount} existing applications. Please remove all applications first.");
            }

            $vacancyTitle = $vacancy->title;
            $vacancy->delete();

            return redirect()->route('admin.vacancies.index')
                ->with('success', "Vacancy '{$vacancyTitle}' deleted successfully!");
        } catch (\Exception $e) {
            \Log::error('Error deleting vacancy: ' . $e->getMessage());
            return redirect()->route('admin.vacancies.index')
                ->with('error', 'An error occurred while deleting the vacancy. Please try again.');
        }
    }

    /**
     * Get vacancies for API (for frontend career page)
     */
    public function getVacancies(Request $request)
    {
        $query = Vacancy::active(); // Only show active vacancies

        // Search
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $vacancies = $query->orderByCreated()->paginate(12);

        return response()->json($vacancies);
    }

    /**
     * Update vacancy status (active/inactive)
     */
    public function updateStatus(Request $request, Vacancy $vacancy)
    {
        $validator = Validator::make($request->all(), [
            'is_active' => 'required|integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $vacancy->update([
            'is_active' => $request->is_active,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.vacancies.index')
            ->with('success', 'Vacancy status updated successfully!');
    }
}
