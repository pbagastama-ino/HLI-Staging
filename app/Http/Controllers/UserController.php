<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        try {
            $query = User::query();

            // Apply search filter
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->search) . '%'])
                      ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($request->search) . '%'])
                      ->orWhereRaw('LOWER(position) LIKE ?', ['%' . strtolower($request->search) . '%']);
                });
            }

            // Apply sorting
            $sortBy = $request->get('sort_by', 'created_at');
            $sortDirection = $request->get('sort_direction', 'desc');
            
            if ($sortBy === 'name') {
                $query->orderBy('name', $sortDirection);
            } elseif ($sortBy === 'email') {
                $query->orderBy('email', $sortDirection);
            } elseif ($sortBy === 'position') {
                $query->orderBy('position', $sortDirection);
            } elseif ($sortBy === 'status') {
                $query->orderBy('email_verified_at', $sortDirection);
            } else {
                $query->orderBy('created_at', $sortDirection);
            }

            $users = $query->paginate(8)->withQueryString();

            return Inertia::render('Admin/Users', [
                'users' => $users,
                'filters' => $request->only(['search', 'sort_by', 'sort_direction']),
                'user' => auth()->user()
            ]);
        } catch (\Exception $e) {
            \Log::error('User index error: ' . $e->getMessage());
            return Inertia::render('Admin/Users', [
                'users' => collect([]),
                'filters' => $request->only(['search', 'sort_by', 'sort_direction']),
                'user' => auth()->user(),
                'error' => 'Unable to load users. Please try again.'
            ]);
        }
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return Inertia::render('Admin/UserForm', [
            'user' => null,
            'mode' => 'create',
            'currentUser' => auth()->user()
        ]);
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        return Inertia::render('Admin/UserShow', [
            'user' => $user,
            'currentUser' => auth()->user()
        ]);
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        return Inertia::render('Admin/UserForm', [
            'user' => $user,
            'mode' => 'edit',
            'currentUser' => auth()->user()
        ]);
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent user from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        return Inertia::render('Admin/Profile', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(auth()->id())
            ],
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        auth()->user()->update($validated);

        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show change password form
     */
    public function changePassword()
    {
        return Inertia::render('Admin/ChangePassword', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+/', 'confirmed'],
        ], [
            'current_password.required' => 'The current password field is required.',
            'current_password.current_password' => 'The current password is incorrect.',
            'password.required' => 'The new password field is required.',
            'password.min' => 'The new password must be at least 8 characters.',
            'password.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'password.confirmed' => 'The new password confirmation does not match.',
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('admin.change-password')
            ->with('success', 'Password changed successfully.');
    }
}
