<template>
  <Head title="Application Details - HLI Admin" />
  <AdminLayout 
    current-page="career-applications" 
    title="Application Details" 
    :user="user"
  >
    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <Link
            href="/hli-admin/career-applications"
            class="inline-flex items-center text-sm font-medium text-[#4D9F95] hover:text-[#3d7f75] mb-2"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Applications
          </Link>
          <h2 class="text-xl font-semibold text-gray-800">Application Details</h2>
          <p class="text-sm text-gray-600 mt-1">Review application information and documents</p>
        </div>
        <div class="flex space-x-3">
          <button
            @click="downloadPDF"
            class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
          >
            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Download PDF
          </button>
          <button
            @click="confirmDelete"
            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
          >
            Delete Application
          </button>
        </div>
      </div>
    </div>

    <!-- Success/Error Messages -->
    <div v-if="$page.props.flash?.success" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
      {{ $page.props.flash.success }}
    </div>
    <div v-if="$page.props.flash?.error" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
      {{ $page.props.flash.error }}
    </div>

    <!-- Application Status Update -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-[#4D9F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Application Status
      </h3>
      <form @submit.prevent="updateStatus" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select
              v-model="statusUpdateForm.status"
              class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            >
              <option value="" disabled>- Select Status -</option>
              <option value="shortlisted">Shortlisted</option>
              <option value="interview">Interview</option>
              <option value="not_suitable">Not Suitable</option>
            </select>
          </div>
          
          <!-- Talent Pool -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Talent Pool</label>
            <div class="flex items-center">
              <input
                type="checkbox"
                v-model="statusUpdateForm.talent_pool"
                class="h-4 w-4 text-[#4D9F95] focus:ring-[#4D9F95] border-gray-300 rounded"
              />
              <label class="ml-2 text-sm text-gray-700">Add to Talent Pool</label>
            </div>
          </div>
        </div>
        
        <!-- Notes -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
          <textarea
            v-model="statusUpdateForm.notes"
            rows="3"
            placeholder="Add any notes about this application..."
            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          ></textarea>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-end">
          <button
            type="submit"
            :disabled="statusUpdateForm.processing"
            class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95] disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="statusUpdateForm.processing">Updating...</span>
            <span v-else>Update Status</span>
          </button>
        </div>
      </form>
    </div>

    <div class="w-full">
      <!-- Main Content -->
      <div class="space-y-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#4D9F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Personal Information
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-500">Full Name</label>
              <p class="mt-1 text-sm text-gray-900">{{ application.full_name || 'Not provided' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Email</label>
              <p class="mt-1 text-sm text-gray-900">{{ application.email || 'Not provided' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Phone Number</label>
              <p class="mt-1 text-sm text-gray-900">{{ application.phone_number || 'Not provided' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Nationality</label>
              <p class="mt-1 text-sm text-gray-900">{{ application.nationality || 'Not provided' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Date of Birth</label>
              <p class="mt-1 text-sm text-gray-900">{{ formatDate(application.date_of_birth) }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Place of Birth</label>
              <p class="mt-1 text-sm text-gray-900">{{ application.place_of_birth || 'Not provided' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Marital Status</label>
              <p class="mt-1 text-sm text-gray-900">{{ application.marital_status ? application.marital_status.charAt(0).toUpperCase() + application.marital_status.slice(1) : 'Not provided' }}</p>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-500">ID Address</label>
              <p class="mt-1 text-sm text-gray-900">{{ application.id_address || 'Not provided' }}</p>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-500">Current Address</label>
              <p class="mt-1 text-sm text-gray-900">{{ application.current_address || 'Not provided' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">LinkedIn</label>
              <p class="mt-1 text-sm text-gray-900">
                <a v-if="application.linkedin_profile" :href="application.linkedin_profile" target="_blank" class="text-[#4D9F95] hover:text-[#3d7f75]">
                  {{ application.linkedin_profile }}
                </a>
                <span v-else>Not provided</span>
              </p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Current Salary</label>
              <p class="mt-1 text-sm text-gray-900">{{ application.current_salary || 'Not provided' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Reason for Leaving</label>
              <p class="mt-1 text-sm text-gray-900">{{ application.reason_for_leaving || 'Not provided' }}</p>
            </div>
            <div v-if="application.resume_path" class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-500 mb-2">Resume</label>
              <a 
                :href="`/storage/${application.resume_path}`"
                target="_blank"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-[#4D9F95] bg-[#4D9F95]/10 rounded-lg hover:bg-[#4D9F95]/20 focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:ring-offset-2"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                View Resume
              </a>
            </div>
            <div v-else class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-500">Resume</label>
              <p class="mt-1 text-sm text-gray-500 italic">No resume uploaded</p>
            </div>
          </div>
        </div>

        <!-- Education Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#4D9F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
            </svg>
            Education
          </h3>
          <div v-if="application.educations && application.educations.length > 0" class="space-y-4">
            <div v-for="(education, index) in application.educations" :key="education.id" class="border border-gray-200 rounded-lg p-4">
              <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-medium text-gray-900">{{ getEducationDisplay(education.level) }}</h4>
                <span v-if="education.is_current" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  Current
                </span>
              </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-500">School/University</label>
                  <p class="mt-1 text-sm text-gray-900">{{ education.school_name || 'Not provided' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Faculty</label>
                  <p class="mt-1 text-sm text-gray-900">{{ education.faculty || 'Not provided' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Major</label>
                  <p class="mt-1 text-sm text-gray-900">{{ education.major || 'Not provided' }}</p>
                </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Start Year</label>
                  <p class="mt-1 text-sm text-gray-900">{{ education.start_year || 'Not provided' }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-500">End Year</label>
                  <p class="mt-1 text-sm text-gray-900">{{ education.end_year || 'Not provided' }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Graduate Year</label>
                  <p class="mt-1 text-sm text-gray-900">{{ education.graduate_year || 'Not provided' }}</p>
                </div>
              </div>
              <div v-if="education.description" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Description</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ education.description }}</p>
              </div>
              <div v-if="education.certificate_path" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Certificate</label>
                <button 
                  @click="viewCertificate(education.certificate_path)"
                  class="inline-flex items-center px-3 py-2 text-sm font-medium text-[#4D9F95] bg-[#4D9F95]/10 rounded-lg hover:bg-[#4D9F95]/20 focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:ring-offset-2"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  View Certificate
                </button>
              </div>
            </div>
          </div>
          <div v-else class="text-sm text-gray-500 italic">
            No education information provided
          </div>
        </div>

        <!-- Work Experience -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#4D9F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6" />
            </svg>
            Work Experience
          </h3>
          <div v-if="application.experiences && application.experiences.length > 0" class="space-y-4">
            <div v-for="(experience, index) in application.experiences" :key="experience.id" class="border border-gray-200 rounded-lg p-4">
              <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-medium text-gray-900">{{ experience.position }}</h4>
                <div class="flex items-center space-x-2">
                  <span v-if="experience.is_current" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Current
                  </span>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-500">Company Name</label>
                  <p class="mt-1 text-sm text-gray-900">{{ experience.company_name }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-500">Position</label>
                  <p class="mt-1 text-sm text-gray-900">{{ experience.position }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-500">Start Year</label>
                  <p class="mt-1 text-sm text-gray-900">{{ experience.start_year || 'Not provided' }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-500">End Year</label>
                  <p class="mt-1 text-sm text-gray-900">{{ experience.is_current ? 'Present' : (experience.end_year || 'Not provided') }}</p>
                </div>
              </div>
              <div v-if="experience.job_description" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Job Description</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ experience.job_description }}</p>
              </div>
              <div v-if="experience.responsibilities" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Responsibilities</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ experience.responsibilities }}</p>
              </div>
              <div v-if="experience.achievements" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Achievements</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ experience.achievements }}</p>
              </div>
              <div v-if="experience.reasons_for_leaving && !experience.is_current" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Reasons for Leaving</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ experience.reasons_for_leaving }}</p>
              </div>
              <div v-if="experience.supervisor_name" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Supervisor</label>
                <p class="mt-1 text-sm text-gray-900">{{ experience.supervisor_name }} {{ experience.supervisor_contact ? `(${experience.supervisor_contact})` : '' }}</p>
              </div>
              </div>
            </div>
            <div v-else class="text-sm text-gray-500 italic">
              No work experience provided
            </div>
        </div>

        <!-- Languages -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#4D9F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
            </svg>
            Languages
          </h3>
          <div v-if="application.languages && application.languages.length > 0" class="space-y-3">
            <div v-for="language in application.languages" :key="language.id" class="border border-gray-200 rounded-lg p-3">
              <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm font-medium text-gray-900">{{ language.language_name }}</h4>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  {{ getProficiencyDisplay(language.proficiency_level) }}
                </span>
              </div>
              <div v-if="language.certificate_name" class="mt-2 text-xs text-gray-600">
                <span class="font-medium">Certificate:</span> {{ language.certificate_name }}
                <span v-if="language.certificate_date"> ({{ formatDate(language.certificate_date) }})</span>
              </div>
              <div v-if="language.notes" class="mt-2 text-xs text-gray-600">
                {{ language.notes }}
              </div>
            </div>
          </div>
          <div v-else class="text-sm text-gray-500 italic">
            No language information provided
          </div>
        </div>

        <!-- Skills -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#4D9F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
            Skills
          </h3>
          <div v-if="application.skills && application.skills.length > 0" class="space-y-3">
            <div v-for="skill in application.skills" :key="skill.id" class="border border-gray-200 rounded-lg p-3">
              <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm font-medium text-gray-900">{{ skill.skill_name }}</h4>
                <div class="flex items-center space-x-2">
                  <span v-if="skill.category && skill.category !== 'intermediate' && skill.category !== 'general'" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    {{ skill.category }}
                </span>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs">
                <div v-if="skill.years_experience">
                  <span class="text-gray-500">Experience:</span>
                  <span class="text-gray-900">{{ skill.years_experience }} years</span>
                </div>
                <div v-if="skill.certification_name">
                  <span class="text-gray-500">Certification:</span>
                  <span class="text-gray-900">{{ skill.certification_name }}</span>
                </div>
              </div>
              <div v-if="skill.description" class="mt-2 text-xs text-gray-600">
                {{ skill.description }}
              </div>
              <div v-if="skill.notes" class="mt-2 text-xs text-gray-600">
                {{ skill.notes }}
              </div>
            </div>
          </div>
          <div v-else class="text-sm text-gray-500 italic">
            No skills information provided
          </div>
        </div>

        <!-- Certifications -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#4D9F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
            Certifications
          </h3>
          <div v-if="application.certifications && application.certifications.length > 0" class="space-y-4">
            <div v-for="certification in application.certifications" :key="certification.id" class="border border-gray-200 rounded-lg p-4">
              <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-medium text-gray-900">{{ certification.certification_name }}</h4>
                <div class="flex items-center space-x-2">
                  <span v-if="certification.certification_type && certification.certification_type !== 'professional'" :class="getCertificationTypeBadgeClass(certification.certification_type)" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium">
                    {{ getCertificationTypeDisplay(certification.certification_type) }}
                  </span>
                  <span v-if="certification.status && certification.status !== 'active'" :class="getCertificationStatusBadgeClass(certification.status)" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium">
                    {{ getCertificationStatusDisplay(certification.status) }}
                  </span>
                  <span v-if="certification.is_verified" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Verified
                  </span>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-500">Issuing Organization</label>
                  <p class="mt-1 text-sm text-gray-900">{{ certification.issuing_organization }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-500">Issue Date</label>
                  <p class="mt-1 text-sm text-gray-900">{{ formatDate(certification.issue_date) }}</p>
                </div>
                <div v-if="certification.expiry_date">
                  <label class="block text-sm font-medium text-gray-500">Expiry Date</label>
                  <p class="mt-1 text-sm text-gray-900">{{ formatDate(certification.expiry_date) }}</p>
                </div>
                <div v-if="certification.certification_number">
                  <label class="block text-sm font-medium text-gray-500">Certification Number</label>
                  <p class="mt-1 text-sm text-gray-900">{{ certification.certification_number }}</p>
                </div>
                <div v-if="certification.credential_id">
                  <label class="block text-sm font-medium text-gray-500">Credential ID</label>
                  <p class="mt-1 text-sm text-gray-900 font-mono text-xs">{{ certification.credential_id }}</p>
                </div>
              </div>
              <div v-if="certification.description" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Description</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ certification.description }}</p>
              </div>
              <div v-if="certification.notes" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Notes</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ certification.notes }}</p>
              </div>
              <div v-if="certification.certificate_path" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Certificate</label>
                <button 
                  @click="viewCertificate(certification.certificate_path)"
                  class="inline-flex items-center px-3 py-2 text-sm font-medium text-[#4D9F95] bg-[#4D9F95]/10 rounded-lg hover:bg-[#4D9F95]/20 focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:ring-offset-2"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  View Certificate
                </button>
              </div>
            </div>
          </div>
          <div v-else class="text-sm text-gray-500 italic">
            No certifications provided
          </div>
        </div>

        <!-- Reference -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#4D9F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            References
          </h3>
          <div v-if="application.references && application.references.length > 0" class="space-y-4">
            <div v-for="reference in application.references" :key="reference.id" class="border border-gray-200 rounded-lg p-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-500">Reference Name</label>
                  <p class="mt-1 text-sm text-gray-900">{{ reference.name || 'Not provided' }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-500">Organization</label>
                  <p class="mt-1 text-sm text-gray-900">{{ reference.organization || 'Not provided' }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-500">Phone Number</label>
                  <p class="mt-1 text-sm text-gray-900">{{ reference.phone || 'Not provided' }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-500">Relationship</label>
                  <p class="mt-1 text-sm text-gray-900">{{ reference.relationship || 'Not provided' }}</p>
                </div>
              </div>
              <div v-if="reference.notes" class="mt-4">
                <label class="block text-sm font-medium text-gray-500">Notes</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ reference.notes }}</p>
              </div>
            </div>
          </div>
          <div v-else class="text-sm text-gray-500 italic">
            No reference information provided
          </div>
        </div>

        <!-- Achievements -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#4D9F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
            Achievements & Awards
          </h3>
          <div v-if="application.achievements && application.achievements.length > 0" class="space-y-4">
            <div v-for="achievement in application.achievements" :key="achievement.id" class="border border-gray-200 rounded-lg p-4">
              <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-medium text-gray-900">{{ achievement.title }}</h4>
                <div class="flex items-center space-x-2">
                  <span v-if="achievement.category" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    {{ achievement.category }}
                  </span>
                  <span v-if="achievement.year" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ achievement.year }}
                  </span>
                  <span v-if="achievement.achievement_date" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    {{ formatDate(achievement.achievement_date) }}
                  </span>
                </div>
              </div>
              <div v-if="achievement.organization" class="mb-2">
                <span class="text-sm font-medium text-gray-500">Organization:</span>
                <span class="text-sm text-gray-900 ml-1">{{ achievement.organization }}</span>
              </div>
              <div v-if="achievement.description" class="mb-2">
                <label class="block text-sm font-medium text-gray-500">Description</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ achievement.description }}</p>
              </div>
              <div v-if="achievement.impact" class="mb-2">
                <label class="block text-sm font-medium text-gray-500">Impact</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ achievement.impact }}</p>
              </div>
              <div v-if="achievement.certificate_path" class="mb-2">
                <label class="block text-sm font-medium text-gray-500">Certificate</label>
                <a :href="achievement.certificate_path" target="_blank" class="text-sm text-[#4D9F95] hover:text-[#3d7f75] underline">
                  View Certificate
                </a>
              </div>
            </div>
          </div>
          <div v-else class="text-sm text-gray-500 italic">
            No achievements provided
          </div>
        </div>
      </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Application</h3>
          <p class="text-sm text-gray-600 mb-4">
            Are you sure you want to delete the application from <strong>{{ application.full_name }}</strong>? 
            This action cannot be undone.
          </p>
          <div class="flex justify-end space-x-3">
            <button
              @click="closeDeleteModal"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
            >
              Cancel
            </button>
            <button
              @click="deleteApplication"
              class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  application: Object,
  user: Object
})

// Reactive data
const showDeleteModal = ref(false)

// Helper function to get initial status (convert unread/read to empty or suitable default)
const getInitialStatus = (status) => {
  if (!status || status === 'unread' || status === 'read') {
    return '' // return empty string to show placeholder
  }
  // Only return status if it's one of the valid statuses
  if (['shortlisted', 'interview', 'not_suitable'].includes(status)) {
    return status
  }
  return '' // return empty for any other status
}

const statusUpdateForm = ref({
  status: getInitialStatus(props.application.status),
  talent_pool: props.application.talent_pool || false,
  notes: props.application.notes || '',
  processing: false
})

// Methods

const updateStatus = () => {
  // Validate that a status is selected
  if (!statusUpdateForm.value.status || statusUpdateForm.value.status === '') {
    alert('Please select a status before updating.')
    return
  }
  
  statusUpdateForm.value.processing = true
  
  router.post(`/hli-admin/career-applications/${props.application.id}/update-status`, {
    status: statusUpdateForm.value.status,
    talent_pool: statusUpdateForm.value.talent_pool,
    notes: statusUpdateForm.value.notes
  }, {
    onSuccess: () => {
      statusUpdateForm.value.processing = false
      // Update the local application object
      props.application.status = statusUpdateForm.value.status
      props.application.talent_pool = statusUpdateForm.value.talent_pool
      props.application.notes = statusUpdateForm.value.notes
      // Mark as read since user has seen and reviewed it
      props.application.read_status = true
      props.application.read_at = new Date()
    },
    onError: (errors) => {
      statusUpdateForm.value.processing = false
      console.error('Update failed:', errors)
    }
  })
}
const viewCertificate = (certificatePath) => {
  // Check if the path is a full URL or a relative path
  if (certificatePath.startsWith('http')) {
    window.open(certificatePath, '_blank')
  } else {
    // Construct the full URL for storage files
    const fullUrl = `/storage/${certificatePath.replace('storage/', '')}`
    window.open(fullUrl, '_blank')
  }
}

const downloadPDF = () => {
  window.open(`/hli-admin/career-applications/${props.application.id}/download-pdf`, '_blank')
}

const confirmDelete = () => {
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
}

const deleteApplication = () => {
  router.delete(`/hli-admin/career-applications/${props.application.id}`, {
    onSuccess: () => {
      router.visit('/hli-admin/career-applications')
    }
  })
}

// Utility functions
const getEducationDisplay = (education) => {
  const educationMap = {
    'smk1': 'SMK 1',
    'smk2': 'SMK 2', 
    'd3-1': 'D3 1',
    'd3-2': 'D3 2',
    's1': 'S1',
    's2': 'S2',
    's3': 'S3'
  }
  return educationMap[education] || 'Not specified'
}

const getLanguageDisplay = (language) => {
  const languageMap = {
    'indonesia': 'Bahasa Indonesia',
    'english': 'English',
    'korean': 'Korean',
    'japanese': 'Japanese',
    'chinese': 'Chinese'
  }
  return languageMap[language] || language
}

const getProficiencyDisplay = (level) => {
  const proficiencyMap = {
    'basic': 'Basic',
    'conversational': 'Conversational',
    'fluent': 'Fluent',
    'native': 'Native',
    'beginner': 'Beginner',
    'intermediate': 'Intermediate',
    'advanced': 'Advanced',
    'expert': 'Expert'
  }
  return proficiencyMap[level] || level || 'Not specified'
}

const getCertificationTypeDisplay = (type) => {
  const typeMap = {
    'professional': 'Professional',
    'technical': 'Technical',
    'language': 'Language',
    'academic': 'Academic',
    'industry': 'Industry',
    'software': 'Software',
    'safety': 'Safety',
    'management': 'Management',
    'other': 'Other'
  }
  return typeMap[type] || type || 'Unknown'
}

const getCertificationStatusDisplay = (status) => {
  const statusMap = {
    'active': 'Active',
    'expired': 'Expired',
    'suspended': 'Suspended',
    'revoked': 'Revoked'
  }
  return statusMap[status] || status || 'Unknown'
}

const getCertificationTypeBadgeClass = (type) => {
  const typeClasses = {
    'professional': 'bg-blue-100 text-blue-800',
    'technical': 'bg-green-100 text-green-800',
    'language': 'bg-purple-100 text-purple-800',
    'academic': 'bg-yellow-100 text-yellow-800',
    'industry': 'bg-indigo-100 text-indigo-800',
    'software': 'bg-pink-100 text-pink-800',
    'safety': 'bg-red-100 text-red-800',
    'management': 'bg-orange-100 text-orange-800',
    'other': 'bg-gray-100 text-gray-800'
  }
  return typeClasses[type] || 'bg-gray-100 text-gray-800'
}

const getCertificationStatusBadgeClass = (status) => {
  const statusClasses = {
    'active': 'bg-green-100 text-green-800',
    'expired': 'bg-red-100 text-red-800',
    'suspended': 'bg-yellow-100 text-yellow-800',
    'revoked': 'bg-gray-100 text-gray-800'
  }
  return statusClasses[status] || 'bg-gray-100 text-gray-800'
}

const getStatusBadgeClass = (status) => {
  const statusClasses = {
    unread: 'bg-yellow-100 text-yellow-800',
    read: 'bg-gray-100 text-gray-800',
    shortlisted: 'bg-blue-100 text-blue-800',
    interview: 'bg-purple-100 text-purple-800',
    not_suitable: 'bg-red-100 text-red-800'
  }
  return statusClasses[status] || 'bg-gray-100 text-gray-800'
}

const formatStatus = (status) => {
  const statusMap = {
    unread: 'Unread',
    read: 'Read',
    shortlisted: 'Shortlisted',
    interview: 'Interview',
    not_suitable: 'Not Suitable'
  }
  return statusMap[status] || status
}

const formatDate = (date) => {
  if (!date) return 'Not provided'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>
