<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Application - {{ $careerApplication->full_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'IBM Plex Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f9fafb;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #7ACAB3;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #111827;
            margin: 0;
            margin-bottom: 8px;
        }
        .header p {
            font-size: 16px;
            color: #6b7280;
            margin: 0;
        }
        .print-button {
            background-color: #4D9F95;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            font-family: 'IBM Plex Sans', Arial, sans-serif;
            margin-top: 16px;
            transition: background-color 0.2s;
        }
        .print-button:hover {
            background-color: #3d7f75;
        }
        .section {
            margin-bottom: 32px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            border-bottom: 1px solid #7ACAB3;
            padding-bottom: 8px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 16px;
        }
        .info-column {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .info-label {
            font-weight: 500;
            color: #374151;
            font-size: 14px;
        }
        .info-value {
            color: #111827;
            font-size: 14px;
        }
        .certification-item, .achievement-item {
            border: 1px solid #e5e7eb;
            margin-bottom: 16px;
            padding: 16px;
            border-radius: 8px;
            background-color: #f9fafb;
        }
        .item-header {
            font-weight: 600;
            margin-bottom: 12px;
            color: #111827;
            font-size: 16px;
        }
        .language-item, .skill-item {
            margin-bottom: 8px;
            padding: 12px;
            background-color: #f3f4f6;
            border-radius: 6px;
            border-left: 4px solid #7ACAB3;
        }
        .no-data {
            font-style: italic;
            color: #6b7280;
            font-size: 14px;
        }
        .page-break {
            page-break-before: always;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: white;
            }
            .container {
                max-width: none;
                margin: 0;
                padding: 20px;
                box-shadow: none;
                border-radius: 0;
            }
            .header {
                margin-bottom: 24px;
            }
            .header button {
                display: none;
            }
            .section {
                margin-bottom: 24px;
            }
            .certification-item, .achievement-item {
                page-break-inside: avoid;
                background-color: white;
                border: 1px solid #d1d5db;
            }
            .language-item, .skill-item {
                background-color: #f9fafb;
                border-left: 4px solid #7ACAB3;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>{{ $careerApplication->full_name }}</h1>
            <p>Career Application Summary</p>
            <button onclick="window.print()" class="print-button">
                Print / Save as PDF
            </button>
        </div>

        <!-- Personal Information -->
        <div class="section">
            <div class="section-title">Personal Information</div>
            <div class="info-grid">
                <div class="info-column">
                    <div class="info-item">
                        <span class="info-label">Nationality:</span>
                        <span class="info-value">{{ $careerApplication->nationality ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date of Birth:</span>
                        <span class="info-value">{{ $careerApplication->date_of_birth ? \Carbon\Carbon::parse($careerApplication->date_of_birth)->format('F j, Y') : 'Not provided' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Place of Birth:</span>
                        <span class="info-value">{{ $careerApplication->place_of_birth ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Marital Status:</span>
                        <span class="info-value">{{ $careerApplication->marital_status ? ucfirst($careerApplication->marital_status) : 'Not provided' }}</span>
                    </div>
                </div>
                <div class="info-column">
                    <div class="info-item">
                        <span class="info-label">ID Address:</span>
                        <span class="info-value">{{ $careerApplication->id_address ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Current Address:</span>
                        <span class="info-value">{{ $careerApplication->current_address ?? 'Not provided' }}</span>
                    </div>
                </div>
                <div class="info-column">
                    <div class="info-item">
                        <span class="info-label">Phone Number:</span>
                        <span class="info-value">{{ $careerApplication->phone_number ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email Address:</span>
                        <span class="info-value">{{ $careerApplication->email ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">LinkedIn:</span>
                        <span class="info-value">{{ $careerApplication->linkedin_profile ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Current Salary:</span>
                        <span class="info-value">{{ $careerApplication->current_salary ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Reason for Leaving:</span>
                        <span class="info-value">{{ $careerApplication->reason_for_leaving ?? 'Not provided' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Education -->
        <div class="section">
            <div class="section-title">Education</div>
            @if($careerApplication->educations && count($careerApplication->educations) > 0)
                @foreach($careerApplication->educations as $education)
                    <div style="margin-bottom: 16px;">
                        <div style="font-weight: 600; margin-bottom: 8px; color: #111827; font-size: 16px;">
                            {{ $education->school_name ?? 'Not provided' }}
                            @if($education->is_current)
                                <span style="background-color: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 4px; font-size: 12px; margin-left: 8px;">Current</span>
                            @endif
                        </div>
                        <div class="info-grid">
                            <div class="info-column">
                                <div class="info-item">
                                    <span class="info-label">Level:</span>
                                    <span class="info-value">
                                        @switch($education->level)
                                            @case('smk1') SMK 1 @break
                                            @case('smk2') SMK 2 @break
                                            @case('d3-1') D3 1 @break
                                            @case('d3-2') D3 2 @break
                                            @case('s1') S1 @break
                                            @case('s2') S2 @break
                                            @case('s3') S3 @break
                                            @default Not specified
                                        @endswitch
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Faculty:</span>
                                    <span class="info-value">{{ $education->faculty ?? 'Not provided' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Major:</span>
                                    <span class="info-value">{{ $education->major ?? 'Not provided' }}</span>
                                </div>
                            </div>
                            <div class="info-column">
                                <div class="info-item">
                                    <span class="info-label">Start Year:</span>
                                    <span class="info-value">{{ $education->start_year ?? 'Not provided' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">End Year:</span>
                                    <span class="info-value">{{ $education->end_year ?? 'Not provided' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Graduate Year:</span>
                                    <span class="info-value">{{ $education->graduate_year ?? 'Not provided' }}</span>
                                </div>
                            </div>
                        </div>
                        @if($education->description)
                            <div style="margin-top: 12px;">
                                <span class="info-label">Description:</span>
                                <div style="margin-top: 4px; color: #111827;">{{ $education->description }}</div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="no-data">No education information provided</div>
            @endif
        </div>

        <!-- Languages -->
        <div class="section">
            <div class="section-title">Language</div>
            @if($careerApplication->languages && count($careerApplication->languages) > 0)
                <div class="space-y-2">
                    @foreach($careerApplication->languages as $language)
                        <div class="text-gray-900">
                            <span class="font-medium">{{ ucfirst($language->language_name) }}:</span> {{ ucfirst($language->proficiency_level) }}
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-data">No language information provided</div>
            @endif
        </div>

        <!-- Experience -->
        <div class="section">
            <div class="section-title">Work Experience</div>
            @if($careerApplication->experiences && count($careerApplication->experiences) > 0)
                @foreach($careerApplication->experiences as $experience)
                    <div style="margin-bottom: 16px;">
                        <div style="font-weight: 600; margin-bottom: 8px; color: #111827; font-size: 16px;">
                            {{ $experience->position }}
                            @if($experience->is_current)
                                <span style="background-color: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 4px; font-size: 12px; margin-left: 8px;">Current</span>
                            @endif
                        </div>
                        <div class="info-grid">
                            <div class="info-column">
                                <div class="info-item">
                                    <span class="info-label">Company Name:</span>
                                    <span class="info-value">{{ $experience->company_name }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Position:</span>
                                    <span class="info-value">{{ $experience->position }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Start Year:</span>
                                    <span class="info-value">{{ $experience->start_year ?? 'Not provided' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">End Year:</span>
                                    <span class="info-value">{{ $experience->is_current ? 'Present' : ($experience->end_year ?? 'Not provided') }}</span>
                                </div>
                            </div>
                        </div>
                        @if($experience->job_description)
                            <div style="margin-top: 12px;">
                                <span class="info-label">Job Description:</span>
                                <div style="margin-top: 4px; color: #111827;">{{ $experience->job_description }}</div>
                            </div>
                        @endif
                        @if($experience->responsibilities)
                            <div style="margin-top: 12px;">
                                <span class="info-label">Responsibilities:</span>
                                <div style="margin-top: 4px; color: #111827;">{{ $experience->responsibilities }}</div>
                            </div>
                        @endif
                        @if($experience->achievements)
                            <div style="margin-top: 12px;">
                                <span class="info-label">Achievements:</span>
                                <div style="margin-top: 4px; color: #111827;">{{ $experience->achievements }}</div>
                            </div>
                        @endif
                        @if($experience->reasons_for_leaving && !$experience->is_current)
                            <div style="margin-top: 12px;">
                                <span class="info-label">Reasons for Leaving:</span>
                                <div style="margin-top: 4px; color: #111827;">{{ $experience->reasons_for_leaving }}</div>
                            </div>
                        @endif
                        @if($experience->supervisor_name)
                            <div style="margin-top: 12px;">
                                <span class="info-label">Supervisor:</span>
                                <span class="info-value">{{ $experience->supervisor_name }} {{ $experience->supervisor_contact ? "({$experience->supervisor_contact})" : '' }}</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="no-data">No work experience provided</div>
            @endif
        </div>

        <!-- Application Information -->
        <div class="section">
            <div class="section-title">Application Information</div>
            <div class="info-grid">
                <div class="info-column">
                    <div class="info-item">
                        <span class="info-label">Applied Position:</span>
                        <span class="info-value">{{ $careerApplication->applied_position ?? 'Not specified' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Applied Date:</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($careerApplication->created_at)->format('F j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievements -->
        <div class="section">
            <div class="section-title">Achievements</div>
            @if($careerApplication->achievements && count($careerApplication->achievements) > 0)
                <div class="space-y-2">
                    @foreach($careerApplication->achievements as $achievement)
                        <div class="text-gray-900">
                            <span class="font-bold">{{ $achievement->year ?? ($achievement->achievement_date ? \Carbon\Carbon::parse($achievement->achievement_date)->format('Y') : 'N/A') }}</span> - {{ $achievement->title }}
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-data">No achievements provided</div>
            @endif
        </div>

        <!-- References -->
        <div class="section">
            <div class="section-title">References</div>
            @if($careerApplication->references && count($careerApplication->references) > 0)
                <div class="space-y-2">
                    @foreach($careerApplication->references as $reference)
                        <div class="text-gray-900">
                            <span class="font-medium">{{ $reference->name }}:</span> {{ $reference->relationship }} at {{ $reference->organization }}
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-data">No reference information provided</div>
            @endif
        </div>

        <!-- Skills -->
        <div class="section">
            <div class="section-title">List of Skills</div>
            @if($careerApplication->skills && count($careerApplication->skills) > 0)
                <div class="space-y-2">
                    @foreach($careerApplication->skills as $skill)
                        <div class="text-gray-900">
                            {{ $skill->skill_name }}
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-data">No skills information provided</div>
            @endif
        </div>

        <!-- Certifications -->
        <div class="section">
            <div class="section-title">List of Certifications</div>
            @if($careerApplication->certifications && count($careerApplication->certifications) > 0)
                <div class="space-y-2">
                    @foreach($careerApplication->certifications as $certification)
                        <div class="text-gray-900">
                            <span class="font-bold">{{ $certification->issue_date ? \Carbon\Carbon::parse($certification->issue_date)->format('Y') : 'N/A' }}</span> - {{ $certification->certification_name }}
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-data">No certifications provided</div>
            @endif
        </div>

        <!-- Additional Comments -->
        @if($careerApplication->notes)
        <div class="section">
            <div class="section-title">Others</div>
            <div class="space-y-4">
                <div class="text-gray-900">
                    <span class="font-medium">Additional Comments:</span> {{ $careerApplication->notes }}
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>