<?php

namespace App\Http\Controllers;

use App\Models\CareerApplication;
use App\Models\CareerApplicationEducation;
use App\Models\CareerApplicationLanguage;
use App\Models\CareerApplicationExperience;
use App\Models\CareerApplicationAchievement;
use App\Models\CareerApplicationReference;
use App\Models\CareerApplicationSkill;
use App\Models\CareerApplicationCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CareerApplicationController extends Controller
{
    /**
     * Display a listing of career applications (Admin)
     */
    public function index(Request $request)
    {
        // Only load essential relationships for list view to improve performance
        $query = CareerApplication::with([
            'vacancy:id,title', // Only load id and title from vacancy
            'educations' => function($query) {
                $query->select('id', 'career_application_id', 'level', 'school_name', 'major', 'faculty', 'sort_order')
                      ->ordered()
                      ->limit(1); // Only get highest education for display
            },
            'experiences' => function($query) {
                $query->select('id', 'career_application_id', 'company_name', 'position', 'is_current', 'start_year', 'sort_order')
                      ->ordered()
                      ->limit(1); // Only get current/most recent experience
            }
        ]);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by read status
        if ($request->has('read_status') && $request->read_status) {
            if ($request->read_status === 'unread') {
                $query->where('read_status', false);
            } elseif ($request->read_status === 'read') {
                $query->where('read_status', true);
            }
        }

        // Filter by status (for specific workflow statuses)
        if ($request->has('status') && $request->status) {
            $query->byStatus($request->status);
        }

        // Filter by talent pool
        if ($request->has('talent_pool') && $request->talent_pool !== null && $request->talent_pool !== '') {
            $inPool = filter_var($request->talent_pool, FILTER_VALIDATE_BOOLEAN);
            $query->inTalentPool($inPool);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Admin/CareerApplications', [
            'applications' => $applications,
            'filters' => $request->only(['search', 'status', 'talent_pool', 'read_status', 'date_from', 'date_to']),
            'user' => $request->user()
        ]);
    }

    /**
     * Display a listing of talent pool applicants (Admin)
     */
    public function talentPool(Request $request)
    {
        // Only load essential relationships for list view to improve performance
        $query = CareerApplication::with([
            'vacancy:id,title', // Only load id and title from vacancy
            'educations' => function($query) {
                $query->select('id', 'career_application_id', 'level', 'school_name', 'major', 'faculty', 'sort_order')
                      ->ordered()
                      ->limit(1); // Only get highest education for display
            },
            'experiences' => function($query) {
                $query->select('id', 'career_application_id', 'company_name', 'position', 'is_current', 'start_year', 'sort_order')
                      ->ordered()
                      ->limit(1); // Only get current/most recent experience
            }
        ])->where('talent_pool', true);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by read status
        if ($request->has('read_status') && $request->read_status) {
            if ($request->read_status === 'unread') {
                $query->where('read_status', false);
            } elseif ($request->read_status === 'read') {
                $query->where('read_status', true);
            }
        }

        // Filter by status (for specific workflow statuses)
        if ($request->has('status') && $request->status) {
            $query->byStatus($request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Admin/CareerApplications', [
            'applications' => $applications,
            'filters' => $request->only(['search', 'status', 'read_status', 'date_from', 'date_to']),
            'user' => $request->user(),
            'pageTitle' => 'Talent Pool',
            'isTalentPool' => true
        ]);
    }

    /**
     * Show the form for creating a new career application
     */
    public function create()
    {
        return Inertia::render('Form');
    }

    /**
     * Store a newly created career application
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Personal Data Validation
            'personal.fullName' => 'required|string|max:100',
            'personal.nationality' => 'required|string|max:50',
            'personal.sex' => 'nullable|in:male,female',
            'personal.dob' => 'required|date|before:today',
            'personal.pob' => 'required|string|max:100',
            'personal.maritalStatus' => 'required|string|max:50',
            'personal.idaddress' => 'required|string|max:1000',
            'personal.currentaddress' => 'required|string|max:1000',
            'personal.phone' => 'required|string|max:20',
            'personal.email' => 'required|email|max:100',
            'personal.linkedin' => 'nullable|string|max:255',
            'personal.social_media' => 'nullable|string|max:255',
            
            // Application Info
            'applied_position' => 'nullable|string|max:100',
            'privacy_policy_agreed' => 'required|in:1,true',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB max
            'vacancy_id' => 'nullable|integer|exists:vacancies,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Debug: Log the incoming request data
            \Log::info('Career Application Submission Data:', $request->all());
            
            // Debug: Log specific data sections
            \Log::info('Education History Count:', ['count' => count($request->input('education.history', []))]);
            \Log::info('Languages Count:', ['count' => count($request->input('languages', []))]);
            \Log::info('Experience History Count:', ['count' => count($request->input('experience.history', []))]);
            \Log::info('Achievements History Count:', ['count' => count($request->input('achievements.history', []))]);
            \Log::info('References History Count:', ['count' => count($request->input('references.history', []))]);
            \Log::info('Skills Count:', ['count' => count($request->input('others.skills', []))]);
            \Log::info('Certifications Count:', ['count' => count($request->input('others.certifications', []))]);
            
            // Handle resume upload
            $resumePath = null;
            if ($request->hasFile('resume')) {
                $resume = $request->file('resume');
                $resumePath = $resume->store('resumes', 'public');
            }

            // Get and validate vacancy_id
            $vacancyId = $request->input('vacancy_id');
            if (!empty($vacancyId)) {
                $vacancyId = (int) $vacancyId;
            } else {
                $vacancyId = null;
            }
            
            \Log::info('Career Application - Vacancy ID:', ['vacancy_id' => $vacancyId, 'input' => $request->input('vacancy_id')]);

            // Create the main application record
            $application = CareerApplication::create([
                'full_name' => $request->input('personal.fullName'),
                'nationality' => $request->input('personal.nationality'),
                'sex' => $request->input('personal.sex'),
                'date_of_birth' => $request->input('personal.dob'),
                'place_of_birth' => $request->input('personal.pob'),
                'marital_status' => $request->input('personal.maritalStatus'),
                'id_address' => $request->input('personal.idaddress'),
                'current_address' => $request->input('personal.currentaddress'),
                'same_as_id_address' => $request->input('personal.sameAsIdAddress') === '1',
                'phone_number' => $request->input('personal.phone'),
                'email' => $request->input('personal.email'),
                'linkedin_profile' => $request->input('personal.linkedin'),
                'social_media' => $request->input('personal.social_media'),
                'applied_position' => $request->input('applied_position'),
                'current_salary' => $request->input('current_salary'),
                'reason_for_leaving' => $request->input('reason_for_leaving'),
                'application_source' => 'website',
                'additional_comments' => $request->input('others.comments'),
                'privacy_policy_agreed' => $request->input('privacy_policy_agreed') === '1',
                'privacy_policy_agreed_at' => $request->input('privacy_policy_agreed') === '1' ? now() : null,
                'status' => 'unread',
                'vacancy_id' => $vacancyId,
                'resume_path' => $resumePath,
            ]);

        // Handle file uploads
            $uploadedFiles = [];
            
            // Add resume to uploaded files if uploaded
            if ($resumePath) {
                $uploadedFiles[] = $resumePath;
            }

            // Process education history
            try {
                $educationHistory = $request->input('education.history', []);
                \Log::info('Education history data:', $educationHistory);
                
                if (!empty($educationHistory)) {
                    foreach ($educationHistory as $index => $education) {
                        $educationData = [
                            'career_application_id' => $application->id,
                            'level' => $education['level'] ?? null,
                            'school_name' => $education['schoolName'] ?? null,
                            'faculty' => $education['faculty'] ?? null,
                            'major' => $education['major'] ?? null,
                            'start_year' => $education['startYear'] ?? null,
                            'end_year' => $education['endYear'] ?? null,
                            'graduate_year' => $education['graduateYear'] ?? null,
                            'gpa' => $education['gpa'] ?? null,
                            'description' => $education['description'] ?? null,
                            'is_current' => ($education['isCurrent'] ?? false) === '1' || ($education['isCurrent'] ?? false) === true,
                            'sort_order' => $index,
                        ];

                        // Handle certificate file upload
                        if ($request->hasFile("education.history.{$index}.certificate")) {
                            $file = $request->file("education.history.{$index}.certificate");
                            $path = $file->store('certificates/education', 'public');
                            $educationData['certificate_path'] = $path;
                            $uploadedFiles[] = $path;
                        }

                        $educationRecord = CareerApplicationEducation::create($educationData);
                        \Log::info("Created education record with ID: {$educationRecord->id}");
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error processing education history: ' . $e->getMessage());
            }

            // Process languages
            try {
                $languages = $request->input('languages', []);
                \Log::info('Languages data:', $languages);
                
                if (!empty($languages)) {
                    foreach ($languages as $index => $language) {
                        // Skip if language name is empty (required field)
                        if (empty($language['name'])) {
                            \Log::warning("Skipping language record - empty language name");
                            continue;
                        }
                        
                        $languageRecord = CareerApplicationLanguage::create([
                            'career_application_id' => $application->id,
                            'language_name' => $language['name'],
                            'proficiency_level' => $language['proficiency'] ? strtolower($language['proficiency']) : 'intermediate',
                            'speaking_level' => $language['speaking'] ? strtolower($language['speaking']) : null,
                            'writing_level' => $language['writing'] ? strtolower($language['writing']) : null,
                            'reading_level' => $language['reading'] ? strtolower($language['reading']) : null,
                            'listening_level' => $language['listening'] ? strtolower($language['listening']) : null,
                            'certificate_name' => $language['certificateName'] ?? null,
                            'certificate_path' => $language['certificatePath'] ?? null,
                            'certificate_date' => $language['certificateDate'] ?? null,
                            'notes' => $language['notes'] ?? null,
                            'sort_order' => $index,
                        ]);
                        \Log::info("Created language record with ID: {$languageRecord->id}");
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error processing languages: ' . $e->getMessage());
            }

            // Process experience history
            try {
                $experienceHistory = $request->input('experience.history', []);
                \Log::info('Experience history data:', $experienceHistory);
                
                if (!empty($experienceHistory)) {
                    foreach ($experienceHistory as $index => $experience) {
                        // Skip if required fields are empty
                        if (empty($experience['companyName']) || empty($experience['position'])) {
                            \Log::warning("Skipping experience record - missing required fields", [
                                'companyName' => $experience['companyName'] ?? 'empty',
                                'position' => $experience['position'] ?? 'empty'
                            ]);
                            continue;
                        }
                        
                        $experienceRecord = CareerApplicationExperience::create([
                            'career_application_id' => $application->id,
                            'company_name' => $experience['companyName'],
                            'position' => $experience['position'],
                            'job_description' => $experience['jobDesc'] ?? null,
                            'start_year' => $experience['startYear'] ?? null,
                            'end_year' => $experience['endYear'] ?? null,
                            'employment_type' => $experience['employmentType'] ?? null,
                            'salary_range' => $experience['salaryRange'] ?? null,
                            'reasons_for_leaving' => $experience['reasonsForLeaving'] ?? null,
                            'supervisor_name' => $experience['supervisorName'] ?? null,
                            'supervisor_contact' => $experience['supervisorContact'] ?? null,
                            'achievements' => $experience['achievements'] ?? null,
                            'responsibilities' => $experience['responsibilities'] ?? null,
                            'is_current' => ($experience['isCurrent'] ?? false) === '1' || ($experience['isCurrent'] ?? false) === true,
                            'sort_order' => $index,
                        ]);
                        \Log::info("Created experience record with ID: {$experienceRecord->id}");
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error processing experience history: ' . $e->getMessage());
            }

            // Process achievements
            try {
                $achievementsHistory = $request->input('achievements.history', []);
                \Log::info('Achievements history data:', $achievementsHistory);
                
                if (!empty($achievementsHistory)) {
                    foreach ($achievementsHistory as $index => $achievement) {
                        $achievementRecord = CareerApplicationAchievement::create([
                            'career_application_id' => $application->id,
                            'title' => $achievement['title'] ?? null,
                            'description' => $achievement['description'] ?? null,
                            'organization' => $achievement['organization'] ?? null,
                            'achievement_date' => $achievement['achievementDate'] ?? null,
                            'year' => $achievement['year'] ?? null,
                            'category' => $achievement['category'] ?? null,
                            'certificate_path' => $achievement['certificatePath'] ?? null,
                            'verification_url' => $achievement['verificationUrl'] ?? null,
                            'impact' => $achievement['impact'] ?? null,
                            'sort_order' => $index,
                        ]);
                        \Log::info("Created achievement record with ID: {$achievementRecord->id}");
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error processing achievements: ' . $e->getMessage());
            }

            // Process references
            try {
                $referencesHistory = $request->input('references.history', []);
                \Log::info('References history data:', $referencesHistory);
                
                if (!empty($referencesHistory)) {
                    foreach ($referencesHistory as $index => $reference) {
                        $referenceRecord = CareerApplicationReference::create([
                            'career_application_id' => $application->id,
                            'name' => $reference['name'] ?? null,
                            'organization' => $reference['organization'] ?? null,
                            'phone' => $reference['phone'] ?? null,
                            'relationship' => $reference['relationship'] ?? null,
                            'email' => $reference['email'] ?? null,
                            'notes' => $reference['notes'] ?? null,
                            'sort_order' => $index,
                        ]);
                        \Log::info("Created reference record with ID: {$referenceRecord->id}");
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error processing references: ' . $e->getMessage());
            }

            // Process skills
            try {
                $skills = $request->input('others.skills', []);
                \Log::info('Skills data:', $skills);
                
                if (!empty($skills)) {
                    foreach ($skills as $index => $skill) {
                        // Skip if skill name is empty (required field)
                        if (empty($skill)) {
                            \Log::warning("Skipping skill record - empty skill name");
                            continue;
                        }
                        
                        $skillRecord = CareerApplicationSkill::create([
                            'career_application_id' => $application->id,
                            'skill_name' => $skill,
                            'proficiency_level' => 'intermediate', // Default level
                            'category' => 'general',
                            'years_experience' => null,
                            'description' => null,
                            'certification_name' => null,
                            'certification_path' => null,
                            'certification_date' => null,
                            'notes' => null,
                            'sort_order' => $index,
                        ]);
                        \Log::info("Created skill record with ID: {$skillRecord->id}");
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error processing skills: ' . $e->getMessage());
            }

            // Process certifications
            try {
                $certifications = $request->input('others.certifications', []);
                \Log::info('Certifications data:', $certifications);
                
            if (!empty($certifications)) {
                foreach ($certifications as $index => $certification) {
                    \Log::info("Processing certification {$index}:", $certification);
                    
                    // Skip if required fields are empty
                    if (empty($certification['title']) || empty($certification['issuer']) || empty($certification['year'])) {
                        \Log::warning("Skipping certification record - missing required fields", [
                            'title' => $certification['title'] ?? 'empty',
                            'issuer' => $certification['issuer'] ?? 'empty',
                            'year' => $certification['year'] ?? 'empty'
                        ]);
                        continue;
                    }
                    
                    $certificationData = [
                        'career_application_id' => $application->id,
                        'certification_name' => $certification['title'],
                        'issuing_organization' => $certification['issuer'],
                        'issue_date' => $certification['year'] ? $certification['year'] . '-01-01' : null,
                        'expiry_date' => $certification['expiryDate'] ?? null,
                        'certification_number' => $certification['certificationNumber'] ?? null,
                        'credential_id' => $certification['credentialId'] ?? null,
                        'certification_type' => $certification['type'] ?? 'professional',
                        'status' => 'active',
                        'description' => $certification['description'] ?? null,
                        'notes' => $certification['notes'] ?? null,
                        'is_verified' => false,
                        'sort_order' => $index,
                    ];

                    // Handle certificate file upload
                    if ($request->hasFile("others.certifications.{$index}.certificate")) {
                        $file = $request->file("others.certifications.{$index}.certificate");
                        $path = $file->store('certificates/certifications', 'public');
                        $certificationData['certificate_path'] = $path;
                        $uploadedFiles[] = $path;
                    }
                    
                    $certificationRecord = CareerApplicationCertification::create($certificationData);
                    \Log::info("Created certification record with ID: {$certificationRecord->id}");
                }
            }
            } catch (\Exception $e) {
                \Log::error('Error processing certifications: ' . $e->getMessage());
            }

            // Store uploaded files info
            $application->update(['uploaded_files' => $uploadedFiles]);

            // Log summary of created records
            \Log::info("Career Application Summary - ID: {$application->id}", [
                'education_records' => CareerApplicationEducation::where('career_application_id', $application->id)->count(),
                'language_records' => CareerApplicationLanguage::where('career_application_id', $application->id)->count(),
                'experience_records' => CareerApplicationExperience::where('career_application_id', $application->id)->count(),
                'achievement_records' => CareerApplicationAchievement::where('career_application_id', $application->id)->count(),
                'reference_records' => CareerApplicationReference::where('career_application_id', $application->id)->count(),
                'skill_records' => CareerApplicationSkill::where('career_application_id', $application->id)->count(),
                'certification_records' => CareerApplicationCertification::where('career_application_id', $application->id)->count(),
            ]);

        return response()->json(['success' => true, 'message' => 'Your application has been submitted successfully!']);

        } catch (\Exception $e) {
            \Log::error('Error storing career application: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while submitting your application. Please try again.'], 500);
        }
    }

    /**
     * Display the specified career application (Admin)
     */
    public function show(CareerApplication $careerApplication)
    {
        $careerApplication->load([
            'educations' => function($query) {
                $query->ordered();
            },
            'languages' => function($query) {
                $query->orderBy('sort_order')->orderBy('created_at');
            },
            'experiences' => function($query) {
                $query->ordered();
            },
            'achievements' => function($query) {
                $query->orderBy('sort_order')->orderBy('created_at');
            },
            'skills' => function($query) {
                $query->orderBy('sort_order')->orderBy('created_at');
            },
            'certifications' => function($query) {
                $query->orderBy('sort_order')->orderBy('created_at');
            },
            'references' => function($query) {
                $query->orderBy('sort_order')->orderBy('created_at');
            },
            'updatedBy',
            'vacancy'
        ]);

        // Mark as read and update status if it's unread
        if (!$careerApplication->read_status) {
            $updateData = [
                'read_status' => true,
                'read_at' => now(),
                'updated_by' => auth()->id()
            ];
            
            // Change status from 'unread' to 'read' so we can show Read badge
            if ($careerApplication->status === 'unread') {
                $updateData['status'] = 'read';
            }
            
            $careerApplication->update($updateData);
        }

        return Inertia::render('Admin/CareerApplicationShow', [
            'application' => $careerApplication,
            'user' => request()->user()
        ]);
    }

    /**
     * Update the status of a career application (Admin)
     */
    public function updateStatus(Request $request, CareerApplication $careerApplication)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:shortlisted,interview,not_suitable',
            'notes' => 'nullable|string|max:1000',
            'talent_pool' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $updateData = [
            'status' => $request->status,
            'updated_by' => $request->user()->id,
        ];

        // Only mark as read if it wasn't already read
        if (!$careerApplication->read_status) {
            $updateData['read_status'] = true;
            $updateData['read_at'] = now();
        }

        if ($request->has('notes')) {
            $updateData['notes'] = $request->notes;
        }

        // Handle talent_pool boolean conversion
        if ($request->has('talent_pool')) {
            $updateData['talent_pool'] = filter_var($request->talent_pool, FILTER_VALIDATE_BOOLEAN);
        }

        $careerApplication->update($updateData);

        return back()->with('success', 'Application status updated successfully!');
    }

    /**
     * Bulk update career applications (Admin)
     */
    public function bulkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_ids' => 'required|array',
            'application_ids.*' => 'required|exists:career_applications,id',
            'status' => 'nullable|in:shortlisted,interview,not_suitable',
            'talent_pool' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $updateData = [
            'updated_by' => $request->user()->id,
        ];

        // Only mark as read if the application is not already read
        // This preserves the read_status when updating status
        $applications = CareerApplication::whereIn('id', $request->application_ids)->get();
        foreach ($applications as $application) {
            $appUpdateData = ['updated_by' => $request->user()->id];
            
            if ($request->has('status') && $request->status) {
                $appUpdateData['status'] = $request->status;
            }
            
            if ($request->has('talent_pool')) {
                $appUpdateData['talent_pool'] = filter_var($request->talent_pool, FILTER_VALIDATE_BOOLEAN);
            }
            
            // Only mark as read if it wasn't already read
            if (!$application->read_status) {
                $appUpdateData['read_status'] = true;
                $appUpdateData['read_at'] = now();
            }
            
            $application->update($appUpdateData);
        }

        $count = count($request->application_ids);
        return back()->with('success', "Successfully updated {$count} application(s)!");
    }

    /**
     * Bulk delete career applications (Admin)
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_ids' => 'required|array',
            'application_ids.*' => 'required|exists:career_applications,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $applications = CareerApplication::whereIn('id', $request->application_ids)->get();

        foreach ($applications as $application) {
            // Delete associated files
            if ($application->certificate_path) {
                Storage::disk('public')->delete($application->certificate_path);
            }
            
            if ($application->other_certificate_path) {
                Storage::disk('public')->delete($application->other_certificate_path);
            }
        }

        CareerApplication::whereIn('id', $request->application_ids)->delete();

        $count = count($request->application_ids);
        return back()->with('success', "Successfully deleted {$count} application(s)!");
    }

    /**
     * Remove the specified career application (Admin)
     */
    public function destroy(CareerApplication $careerApplication)
    {
        // Delete associated files
        if ($careerApplication->certificate_path) {
            Storage::disk('public')->delete($careerApplication->certificate_path);
        }
        
        if ($careerApplication->other_certificate_path) {
            Storage::disk('public')->delete($careerApplication->other_certificate_path);
        }

        $careerApplication->delete();

        return back()->with('success', 'Application deleted successfully!');
    }

    /**
     * Download PDF of career application
     */
    public function downloadPDF(CareerApplication $careerApplication)
    {
        $careerApplication->load([
            'educations' => function($query) {
                $query->ordered();
            },
            'languages' => function($query) {
                $query->orderBy('sort_order')->orderBy('created_at');
            },
            'experiences' => function($query) {
                $query->ordered();
            },
            'achievements' => function($query) {
                $query->orderBy('sort_order')->orderBy('created_at');
            },
            'skills' => function($query) {
                $query->orderBy('sort_order')->orderBy('created_at');
            },
            'certifications' => function($query) {
                $query->orderBy('sort_order')->orderBy('created_at');
            },
            'references' => function($query) {
                $query->orderBy('sort_order')->orderBy('created_at');
            }
        ]);

        // Generate HTML content for PDF
        $html = view('pdf.career-application', compact('careerApplication'))->render();
        
        // For now, return HTML view - user can print to PDF from browser
        return response()->view('pdf.career-application', compact('careerApplication'))
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'inline; filename="career-application-' . $careerApplication->id . '.html"');
    }
}