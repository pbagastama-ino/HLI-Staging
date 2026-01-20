<template>
  <Head :title="`${job ? 'Edit Vacancy' : 'Create New Vacancy'} - HLI Admin`" />
  <AdminLayout 
    :current-page="job ? 'career-jobs' : 'career-jobs'" 
    :title="job ? 'Edit Vacancy' : 'Create New Vacancy'" 
    :user="user"
  >
    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">
            {{ job ? 'Edit Vacancy' : 'Create New Vacancy' }}
          </h2>
          <p class="text-sm text-gray-600 mt-1">
            {{ job ? 'Update vacancy posting details' : 'Add a new career opportunity' }}
          </p>
        </div>
        <div class="flex space-x-3">
          <Link
            href="/hli-admin/career-jobs"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
          >
            Cancel
          </Link>
        </div>
      </div>
    </div>

    <!-- Success/Error Messages -->
    <div v-if="showFlashMessage && $page.props.flash && $page.props.flash.success" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg relative">
      <button @click="closeFlashMessage" class="absolute top-2 right-2 text-green-600 hover:text-green-800">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      {{ $page.props.flash.success }}
    </div>
    <div v-if="showFlashMessage && $page.props.flash && $page.props.flash.error" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg relative">
      <button @click="closeFlashMessage" class="absolute top-2 right-2 text-red-600 hover:text-red-800">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      {{ $page.props.flash.error }}
    </div>

    <form @submit.prevent="submitForm" class="space-y-6">
      <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Job Title -->
          <div class="md:col-span-2">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
              Job Title *
            </label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.title }"
            />
            <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
          </div>

          <!-- Department -->
          <div>
            <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">
              Department *
            </label>
            <select
              id="department_id"
              v-model="form.department_id"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.department_id }"
            >
              <option value="">Select Department</option>
              <option v-for="department in departments" :key="department.id" :value="department.id">
                {{ department.name }}
              </option>
            </select>
            <p v-if="errors.department_id" class="mt-1 text-sm text-red-600">{{ errors.department_id }}</p>
          </div>

          <!-- Employment Type -->
          <div>
            <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-1">
              Employment Type *
            </label>
            <select
              id="employment_type"
              v-model="form.employment_type"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.employment_type }"
            >
              <option value="">Select Type</option>
              <option value="full-time">Full Time</option>
              <option value="part-time">Part Time</option>
              <option value="contract">Contract</option>
              <option value="internship">Internship</option>
            </select>
            <p v-if="errors.employment_type" class="mt-1 text-sm text-red-600">{{ errors.employment_type }}</p>
          </div>

          <!-- Experience Level -->
          <div>
            <label for="experience_level" class="block text-sm font-medium text-gray-700 mb-1">
              Experience Level *
            </label>
            <select
              id="experience_level"
              v-model="form.experience_level"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.experience_level }"
            >
              <option value="">Select Level</option>
              <option value="entry">Entry Level</option>
              <option value="mid">Mid Level</option>
              <option value="senior">Senior Level</option>
              <option value="executive">Executive Level</option>
            </select>
            <p v-if="errors.experience_level" class="mt-1 text-sm text-red-600">{{ errors.experience_level }}</p>
          </div>

          <!-- Location -->
          <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
              Location *
            </label>
            <input
              id="location"
              v-model="form.location"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.location }"
            />
            <p v-if="errors.location" class="mt-1 text-sm text-red-600">{{ errors.location }}</p>
          </div>

          <!-- Salary Range -->
          <div>
            <label for="salary_range" class="block text-sm font-medium text-gray-700 mb-1">
              Salary Range
            </label>
            <input
              id="salary_range"
              v-model="form.salary_range"
              type="text"
              placeholder="e.g., $50,000 - $70,000"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            />
          </div>

          <!-- Remote Allowed -->
          <div class="md:col-span-2">
            <div class="flex items-center">
              <input
                id="remote_allowed"
                v-model="form.remote_allowed"
                type="checkbox"
                class="h-4 w-4 text-[#4D9F95] focus:ring-[#4D9F95] border-gray-300 rounded"
              />
              <label for="remote_allowed" class="ml-2 block text-sm text-gray-900">
                Remote work allowed
              </label>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Job Details</h3>
        
        <!-- Description -->
        <div class="mb-6">
          <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
            Job Description *
          </label>
          <textarea
            id="description"
            v-model="form.description"
            rows="6"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            :class="{ 'border-red-500': errors.description }"
          ></textarea>
          <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
        </div>

        <!-- Requirements -->
        <div class="mb-6">
          <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">
            Requirements
          </label>
          <textarea
            id="requirements"
            v-model="form.requirements"
            rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          ></textarea>
        </div>

        <!-- Responsibilities -->
        <div class="mb-6">
          <label for="responsibilities" class="block text-sm font-medium text-gray-700 mb-1">
            Responsibilities
          </label>
          <textarea
            id="responsibilities"
            v-model="form.responsibilities"
            rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          ></textarea>
        </div>

        <!-- Benefits -->
        <div class="mb-6">
          <label for="benefits" class="block text-sm font-medium text-gray-700 mb-1">
            Benefits
          </label>
          <textarea
            id="benefits"
            v-model="form.benefits"
            rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          ></textarea>
        </div>

        <!-- Application Instructions -->
        <div class="mb-6">
          <label for="application_instructions" class="block text-sm font-medium text-gray-700 mb-1">
            Application Instructions
          </label>
          <textarea
            id="application_instructions"
            v-model="form.application_instructions"
            rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          ></textarea>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Publishing Settings</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Status -->
          <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
              Status *
            </label>
            <select
              id="status"
              v-model="form.status"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.status }"
            >
              <option value="draft">Draft</option>
              <option value="published">Published</option>
              <option value="closed">Closed</option>
              <option value="archived">Archived</option>
            </select>
            <p v-if="errors.status" class="mt-1 text-sm text-red-600">{{ errors.status }}</p>
          </div>

          <!-- Application Deadline -->
          <div>
            <label for="application_deadline" class="block text-sm font-medium text-gray-700 mb-1">
              Application Deadline
            </label>
            <input
              id="application_deadline"
              v-model="form.application_deadline"
              type="date"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            />
          </div>

          <!-- Max Applications -->
          <div>
            <label for="max_applications" class="block text-sm font-medium text-gray-700 mb-1">
              Max Applications
            </label>
            <input
              id="max_applications"
              v-model="form.max_applications"
              type="number"
              min="1"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            />
          </div>

          <!-- Priority -->
          <div>
            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
              Priority (0-100)
            </label>
            <input
              id="priority"
              v-model="form.priority"
              type="number"
              min="0"
              max="100"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            />
          </div>

          <!-- Featured -->
          <div class="md:col-span-2">
            <div class="flex items-center">
              <input
                id="featured"
                v-model="form.featured"
                type="checkbox"
                class="h-4 w-4 text-[#4D9F95] focus:ring-[#4D9F95] border-gray-300 rounded"
              />
              <label for="featured" class="ml-2 block text-sm text-gray-900">
                Featured job (will be highlighted on career page)
              </label>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Settings</h3>
        
        <div class="space-y-6">
          <!-- Meta Title -->
          <div>
            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">
              Meta Title
            </label>
            <input
              id="meta_title"
              v-model="form.meta_title"
              type="text"
              maxlength="255"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            />
            <p class="mt-1 text-sm text-gray-500">{{ form.meta_title?.length || 0 }}/255 characters</p>
          </div>

          <!-- Meta Description -->
          <div>
            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">
              Meta Description
            </label>
            <textarea
              id="meta_description"
              v-model="form.meta_description"
              rows="3"
              maxlength="500"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            ></textarea>
            <p class="mt-1 text-sm text-gray-500">{{ form.meta_description?.length || 0 }}/500 characters</p>
          </div>

          <!-- Meta Keywords -->
          <div>
            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">
              Meta Keywords
            </label>
            <input
              id="meta_keywords"
              v-model="form.meta_keywords"
              type="text"
              placeholder="keyword1, keyword2, keyword3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            />
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end space-x-3">
        <Link
          href="/hli-admin/career-jobs"
          class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
        >
          Cancel
        </Link>
        <button
          type="submit"
          :disabled="isSubmitting"
          class="px-6 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95] disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="isSubmitting">Saving...</span>
          <span v-else>{{ job ? 'Update Job' : 'Create Job' }}</span>
        </button>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  job: Object,
  departments: Array,
  user: Object,
  errors: Object
})

const showFlashMessage = ref(true)
const isSubmitting = ref(false)

const form = reactive({
  title: props.job?.title || '',
  description: props.job?.description || '',
  requirements: props.job?.requirements || '',
  responsibilities: props.job?.responsibilities || '',
  benefits: props.job?.benefits || '',
  department_id: props.job?.department_id || '',
  employment_type: props.job?.employment_type || '',
  experience_level: props.job?.experience_level || '',
  location: props.job?.location || '',
  remote_allowed: props.job?.remote_allowed || false,
  salary_range: props.job?.salary_range || '',
  application_deadline: props.job?.application_deadline || '',
  max_applications: props.job?.max_applications || '',
  application_instructions: props.job?.application_instructions || '',
  status: props.job?.status || 'draft',
  featured: props.job?.featured || false,
  priority: props.job?.priority || 0,
  meta_title: props.job?.meta_title || '',
  meta_description: props.job?.meta_description || '',
  meta_keywords: props.job?.meta_keywords || ''
})

const closeFlashMessage = () => {
  showFlashMessage.value = false
}

const submitForm = () => {
  isSubmitting.value = true
  
  const url = props.job 
    ? `/hli-admin/career-jobs/${props.job.id}`
    : '/hli-admin/career-jobs'
  
  const method = props.job ? 'put' : 'post'
  
  router[method](url, form, {
    onFinish: () => {
      isSubmitting.value = false
    }
  })
}
</script>
