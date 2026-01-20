<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ContactController;

// Redirect root to default locale (English)
Route::get('/', function () {
    return redirect('/en');
});

// Admin Authentication Routes (no locale prefix)
Route::get('/hli-admin', function () {
    return auth()->check() ? redirect('/hli-admin/dashboard') : redirect('/hli-admin/login');
});
Route::get('/login', function () {
    return auth()->check() ? redirect('/hli-admin/dashboard') : redirect('/hli-admin/login');
});

Route::get('/hli-admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get'); // Fallback for CSRF token expiration

// Protected Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('/hli-admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    
    // User Management Routes
    Route::resource('hli-admin/users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    
    // Profile Management Routes
    Route::get('/hli-admin/profile', [UserController::class, 'profile'])->name('admin.profile');
    Route::put('/hli-admin/profile', [UserController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/hli-admin/change-password', [UserController::class, 'changePassword'])->name('admin.change-password');
    Route::post('/hli-admin/change-password', [UserController::class, 'updatePassword'])->name('admin.password.update');
    
    // Test route for debugging
    Route::get('/hli-admin/test', function () {
        return Inertia::render('Admin/Dashboard', ['user' => auth()->user()]);
    })->name('admin.test');
    
    // Test departments route without auth
    Route::get('/hli-admin/departments-test', function () {
        $departments = App\Models\Department::paginate(10);
        return Inertia::render('Admin/Departments', [
            'departments' => $departments,
            'filters' => [],
            'user' => auth()->user()
        ]);
    })->name('admin.departments.test');
    
    // Department Management Routes
    Route::resource('hli-admin/departments', DepartmentController::class)->names([
        'index' => 'admin.departments.index',
        'create' => 'admin.departments.create',
        'store' => 'admin.departments.store',
        'show' => 'admin.departments.show',
        'edit' => 'admin.departments.edit',
        'update' => 'admin.departments.update',
        'destroy' => 'admin.departments.destroy',
    ]);
    
    // Department additional routes
    Route::patch('/hli-admin/departments/{department}/toggle-status', [DepartmentController::class, 'toggleStatus'])->name('admin.departments.toggle-status');
    Route::get('/api/departments', [DepartmentController::class, 'getDepartments'])->name('api.departments');
    
    // Vacancies Management
    Route::resource('hli-admin/vacancies', VacancyController::class)->names([
        'index' => 'admin.vacancies.index',
        'create' => 'admin.vacancies.create',
        'store' => 'admin.vacancies.store',
        'show' => 'admin.vacancies.show',
        'edit' => 'admin.vacancies.edit',
        'update' => 'admin.vacancies.update',
        'destroy' => 'admin.vacancies.destroy',
    ]);
    
    // Vacancy status update route
    Route::post('/hli-admin/vacancies/{vacancy}/update-status', [VacancyController::class, 'updateStatus'])->name('admin.vacancies.update-status');
    
    
    // Career Applications Management
    Route::get('/hli-admin/career-applications', [App\Http\Controllers\CareerApplicationController::class, 'index'])->name('admin.career-applications.index');
    Route::get('/hli-admin/talent-pool', [App\Http\Controllers\CareerApplicationController::class, 'talentPool'])->name('admin.talent-pool.index');
    Route::get('/hli-admin/career-applications/{careerApplication}', [App\Http\Controllers\CareerApplicationController::class, 'show'])->name('admin.career-applications.show');
    Route::post('/hli-admin/career-applications/{careerApplication}/update-status', [App\Http\Controllers\CareerApplicationController::class, 'updateStatus'])->name('admin.career-applications.update-status');
    Route::post('/hli-admin/career-applications/bulk-update', [App\Http\Controllers\CareerApplicationController::class, 'bulkUpdate'])->name('admin.career-applications.bulk-update');
    Route::post('/hli-admin/career-applications/bulk-delete', [App\Http\Controllers\CareerApplicationController::class, 'bulkDelete'])->name('admin.career-applications.bulk-delete');
    Route::get('/hli-admin/career-applications/{careerApplication}/download-pdf', [App\Http\Controllers\CareerApplicationController::class, 'downloadPDF'])->name('admin.career-applications.download-pdf');
    Route::delete('/hli-admin/career-applications/{careerApplication}', [App\Http\Controllers\CareerApplicationController::class, 'destroy'])->name('admin.career-applications.destroy');
    
    // Publication Management Routes
    Route::resource('hli-admin/publications', PublicationController::class)->names([
        'index' => 'admin.publications.index',
        'create' => 'admin.publications.create',
        'store' => 'admin.publications.store',
        'show' => 'admin.publications.show',
        'edit' => 'admin.publications.edit',
        'update' => 'admin.publications.update',
        'destroy' => 'admin.publications.destroy',
    ]);
    
    // Publication additional routes
    Route::patch('/hli-admin/publications/{publication}/toggle-status', [PublicationController::class, 'toggleStatus'])->name('admin.publications.toggle-status');
    Route::patch('/hli-admin/publications/{publication}/toggle-featured', [PublicationController::class, 'toggleFeatured'])->name('admin.publications.toggle-featured');
    Route::get('/api/publications', [PublicationController::class, 'getPublications'])->name('api.publications');
    
    // Contact Submissions Management
    Route::get('/hli-admin/contact-submissions', [ContactController::class, 'index'])->name('admin.contact-submissions.index');
    Route::delete('/hli-admin/contact-submissions/{contactSubmission}', [ContactController::class, 'destroy'])->name('admin.contact-submissions.destroy');
});

// Public routes with locale prefix
Route::prefix('{locale}')->where(['locale' => 'en|id'])->middleware('locale')->group(function () {
    // Home
    Route::get('/', function () {
        return Inertia::render('Home');
    })->name('home');
    
    // Company
    Route::get('/company', function () {
        return Inertia::render('Company');
    })->name('company');
    
    // Career
    Route::get('/career', function () {
        return Inertia::render('Career');
    })->name('career');
    
    // Career Application Routes
    Route::get('/submission-form', [App\Http\Controllers\CareerApplicationController::class, 'create'])->name('career.form');
    Route::post('/submission-form', [App\Http\Controllers\CareerApplicationController::class, 'store'])->name('career.store');
    Route::post('/career-applications', [App\Http\Controllers\CareerApplicationController::class, 'store'])->name('career.applications.store');
    Route::get('/career/success', [App\Http\Controllers\CareerApplicationController::class, 'success'])->name('career.success');
    
    // Contact
    Route::get('/contact', function () {
        return Inertia::render('Contact');
    })->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/contact/success', [ContactController::class, 'success'])->name('contact.success');
    
    // Factory
    Route::get('/factory', function () {
        return Inertia::render('Factory');
    })->name('factory');
    
    // Publication
    Route::get('/publication', function () {
        return Inertia::render('Publication');
    })->name('publication');
    
    // Privacy Policy
    Route::get('/privacy-policy', function () {
        return Inertia::render('Policy');
    })->name('privacy-policy');
    
    // Sustainability
    Route::get('/sustainability', function () {
        return Inertia::render('Sustainability');
    })->name('sustainability');
});

Route::get('/article/{slug}', function ($slug) {
    return Inertia::render('Article', ['publicationSlug' => $slug]);
})->name('article');

// API Routes for frontend (no locale prefix)
Route::get('/api/publication-data', [PublicationController::class, 'getPublicationData'])->name('api.publication-data');
Route::get('/api/life-at-hli-data', [PublicationController::class, 'getLifeAtHliData'])->name('api.life-at-hli-data');
Route::get('/api/publications/{slug}', [PublicationController::class, 'getPublication'])->name('api.publications.get');
Route::get('/api/vacancies', [VacancyController::class, 'getVacancies'])->name('api.vacancies');

// CSRF Token refresh route (no locale prefix)
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->name('csrf.token');

// Career Application submission route (no locale prefix - for form submissions)
Route::post('/career-applications', [App\Http\Controllers\CareerApplicationController::class, 'store'])->name('career.applications.store.no-locale');
