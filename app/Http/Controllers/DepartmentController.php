<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments
     */
    public function index(Request $request)
    {
        try {
            $query = Department::query();

            // Apply search filter
            if ($request->filled('search')) {
                $query->search($request->search);
            }

            // Apply status filter
            if ($request->filled('status')) {
                if ($request->status === 'active') {
                    $query->active();
                } elseif ($request->status === 'inactive') {
                    $query->where('is_active', false);
                }
            }

            // Apply sorting
            $sortBy = $request->get('sort_by', 'sort_order');
            $sortDirection = $request->get('sort_direction', 'asc');
            
            if ($sortBy === 'name') {
                $query->orderBy('name', $sortDirection);
            } elseif ($sortBy === 'code') {
                $query->orderBy('code', $sortDirection);
            } elseif ($sortBy === 'created_at') {
                $query->orderBy('created_at', $sortDirection);
            } else {
                $query->ordered();
            }

            $departments = $query->paginate(7)->withQueryString();

            return Inertia::render('Admin/Departments', [
                'departments' => $departments,
                'filters' => $request->only(['search', 'status', 'sort_by', 'sort_direction']),
                'user' => auth()->user()
            ]);
        } catch (\Exception $e) {
            \Log::error('Department index error: ' . $e->getMessage());
            return Inertia::render('Admin/Departments', [
                'departments' => collect([]),
                'filters' => $request->only(['search', 'status', 'sort_by', 'sort_direction']),
                'error' => 'Unable to load departments. Please try again.',
                'user' => auth()->user()
            ]);
        }
    }

    /**
     * Show the form for creating a new department
     */
    public function create()
    {
        return Inertia::render('Admin/DepartmentForm', [
            'department' => null,
            'mode' => 'create',
            'user' => auth()->user()
        ]);
    }

    /**
     * Store a newly created department
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        Department::create($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified department
     */
    public function show(Department $department)
    {
        $department->load('jobs');
        
        return Inertia::render('Admin/DepartmentShow', [
            'department' => $department,
            'user' => auth()->user()
        ]);
    }

    /**
     * Show the form for editing the specified department
     */
    public function edit(Department $department)
    {
        return Inertia::render('Admin/DepartmentForm', [
            'department' => $department,
            'mode' => 'edit',
            'user' => auth()->user()
        ]);
    }

    /**
     * Update the specified department
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('departments', 'code')->ignore($department->id)
            ],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $department->update($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified department
     */
    public function destroy(Department $department)
    {
        // Check if department has jobs
        if ($department->jobs()->count() > 0) {
            return redirect()->route('admin.departments.index')
                ->with('error', 'Cannot delete department that has associated jobs.');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    /**
     * Toggle department status
     */
    public function toggleStatus(Department $department)
    {
        $department->update(['is_active' => !$department->is_active]);

        $status = $department->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.departments.index')
            ->with('success', "Department {$status} successfully.");
    }

    /**
     * Get departments for API/select options
     */
    public function getDepartments(Request $request)
    {
        $query = Department::active()->ordered();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        return response()->json($query->get(['id', 'name', 'code']));
    }
}
