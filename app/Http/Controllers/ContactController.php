<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Store a newly created contact submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'agree' => 'required|boolean|accepted',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        ContactSubmission::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('contact.success')
            ->with('success', 'Your message has been sent successfully!');
    }

    /**
     * Show the contact success page
     */
    public function success()
    {
        return Inertia::render('Contact-Success');
    }

    /**
     * Display a listing of contact submissions (Admin)
     */
    public function index(Request $request)
    {
        $query = ContactSubmission::query();

        // Search functionality
        if ($request->has('search') && !empty(trim($request->search))) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Subject filter
        if ($request->has('subject') && !empty($request->subject)) {
            $query->where('subject', $request->subject);
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(20);

        return Inertia::render('Admin/ContactSubmissions', [
            'submissions' => $submissions,
            'filters' => $request->only(['search', 'subject']),
            'user' => auth()->user()
        ]);
    }

    /**
     * Remove the specified contact submission
     */
    public function destroy(ContactSubmission $contactSubmission)
    {
        try {
            $contactSubmission->delete();

            return redirect()->route('admin.contact-submissions.index')
                ->with('success', 'Contact submission deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting contact submission: ' . $e->getMessage());
            return redirect()->route('admin.contact-submissions.index')
                ->with('error', 'An error occurred while deleting the submission. Please try again.');
        }
    }
}

