<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PublicationController extends Controller
{
    /**
     * Display a listing of publications (Admin)
     */
    public function index(Request $request)
    {
        $query = Publication::with(['creator', 'updater']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('featured', $request->featured);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where('published_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('published_date', '<=', $request->date_to);
        }

        $publications = $query->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Admin/Publications', [
            'publications' => $publications,
            'filters' => $request->only(['search', 'status', 'category', 'featured', 'date_from', 'date_to']),
            'user' => $request->user()
        ]);
    }

    /**
     * Show the form for creating a new publication
     */
    public function create()
    {
        return Inertia::render('Admin/PublicationForm', [
            'user' => request()->user()
        ]);
    }

    /**
     * Store a newly created publication
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|in:press-release,company-activities,life-at-hli,article',
            'published_date' => 'nullable|date',
            'status' => 'required|in:draft,published,archived',
            'featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('publications', 'public');
        }

        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        Publication::create($data);

        return redirect()->route('admin.publications.index')->with('success', 'Publication created successfully!');
    }

    /**
     * Display the specified publication (Admin)
     */
    public function show(Publication $publication)
    {
        $publication->load(['creator', 'updater']);

        return Inertia::render('Admin/PublicationShow', [
            'publication' => $publication,
            'user' => request()->user()
        ]);
    }

    /**
     * Show the form for editing the specified publication
     */
    public function edit(Publication $publication)
    {
        return Inertia::render('Admin/PublicationForm', [
            'publication' => $publication,
            'user' => request()->user()
        ]);
    }

    /**
     * Update the specified publication
     */
    public function update(Request $request, Publication $publication)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|in:press-release,company-activities,life-at-hli,article',
            'published_date' => 'nullable|date',
            'status' => 'required|in:draft,published,archived',
            'featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($publication->image) {
                Storage::disk('public')->delete($publication->image);
            }
            $data['image'] = $request->file('image')->store('publications', 'public');
        }

        // Set updated_by
        $data['updated_by'] = auth()->id();

        $result = $publication->update($data);

        return redirect()->route('admin.publications.index')->with('success', 'Publication updated successfully!');
    }

    /**
     * Remove the specified publication
     */
    public function destroy(Publication $publication)
    {
        try {
            \Log::info('Deleting publication', [
                'id' => $publication->id,
                'title' => $publication->title,
                'image' => $publication->image
            ]);
            
            // Delete associated image
            if ($publication->image) {
                $deleted = Storage::disk('public')->delete($publication->image);
                \Log::info('Image deletion result', [
                    'image_path' => $publication->image,
                    'deleted' => $deleted
                ]);
            }

            $publication->delete();
            
            \Log::info('Publication deleted successfully', ['id' => $publication->id]);

            return redirect()->route('admin.publications.index')->with('success', 'Publication deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to delete publication', [
                'id' => $publication->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('admin.publications.index')->with('error', 'Failed to delete publication. Please try again.');
        }
    }

    /**
     * Toggle publication status
     */
    public function toggleStatus(Request $request, Publication $publication)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $publication->update([
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Publication status updated successfully!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Publication $publication)
    {
        $publication->update([
            'featured' => !$publication->featured,
            'updated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Publication featured status updated successfully!');
    }

    /**
     * Get publications for frontend (API)
     */
    public function getPublications(Request $request)
    {
        $query = Publication::published();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured) {
            $query->featured();
        }

        $publications = $query->orderByPublished()->paginate($request->get('per_page', 12));

        return response()->json($publications);
    }

    /**
     * Get publications for Publication page
     */
    public function getPublicationData()
    {
        $pressReleases = Publication::published()
            ->byCategory('press-release')
            ->orderByPublished()
            ->get()
            ->map(function ($publication) {
                if ($publication->image) {
                    $publication->image_url = Storage::url($publication->image);
                }
                return $publication;
            });

        $activities = Publication::published()
            ->byCategory('company-activities')
            ->orderByPublished()
            ->get()
            ->map(function ($publication) {
                if ($publication->image) {
                    $publication->image_url = Storage::url($publication->image);
                }
                return $publication;
            });

        $articles = Publication::published()
            ->byCategory('article')
            ->orderByPublished()
            ->get()
            ->map(function ($publication) {
                if ($publication->image) {
                    $publication->image_url = Storage::url($publication->image);
                }
                return $publication;
            });

        $lifeAtHli = Publication::published()
            ->byCategory('life-at-hli')
            ->orderByPublished()
            ->get()
            ->map(function ($publication) {
                if ($publication->image) {
                    $publication->image_url = Storage::url($publication->image);
                }
                return $publication;
            });

        return response()->json([
            'press_releases' => $pressReleases,
            'activities' => $activities,
            'articles' => $articles,
            'life_at_hli' => $lifeAtHli,
        ]);
    }

    /**
     * Get publications for Career page (Life at HLI section)
     */
    public function getLifeAtHliData()
    {
        $publications = Publication::published()
            ->byCategory('life-at-hli')
            ->orderByPublished()
            ->limit(10)
            ->get();

        return response()->json($publications);
    }

    /**
     * Get single publication by slug for frontend
     */
    public function getPublication($slug)
    {
        $publication = Publication::published()->where('slug', $slug)->firstOrFail();
        
        // Add image URL
        if ($publication->image) {
            $publication->image_url = Storage::url($publication->image);
        }
        
        return response()->json($publication);
    }
}