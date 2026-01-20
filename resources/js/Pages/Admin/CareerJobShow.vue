<template>
  <Head title="Vacancy Details - HLI Admin" />
  <AdminLayout 
    current-page="career-jobs" 
    title="Vacancy Details" 
    :user="user"
  >
    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">{{ job.title }}</h2>
          <p class="text-sm text-gray-600 mt-1">{{ job.location }} • {{ job.employment_type_display }}</p>
        </div>
        <div class="flex space-x-3">
          <Link
            :href="`/hli-admin/career-jobs/${job.id}/edit`"
            class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
          >
            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Vacancy
          </Link>
          <Link
            href="/hli-admin/career-jobs"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
          >
            Back to Vacancies
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Main Content -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Job Overview -->
        <div class="bg-white shadow-sm rounded-lg p-6">
          <div class="flex items-start justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Job Overview</h3>
            <div class="flex items-center space-x-2">
              <span :class="getStatusBadgeClass(job.status)" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                {{ job.status.charAt(0).toUpperCase() + job.status.slice(1) }}
              </span>
              <span v-if="job.featured" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                Featured
              </span>
            </div>
          </div>
          
          <div class="prose max-w-none">
            <div v-html="formatText(job.description)"></div>
          </div>
        </div>

        <!-- Requirements -->
        <div v-if="job.requirements" class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Requirements</h3>
          <div class="prose max-w-none">
            <div v-html="formatText(job.requirements)"></div>
          </div>
        </div>

        <!-- Responsibilities -->
        <div v-if="job.responsibilities" class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Responsibilities</h3>
          <div class="prose max-w-none">
            <div v-html="formatText(job.responsibilities)"></div>
          </div>
        </div>

        <!-- Benefits -->
        <div v-if="job.benefits" class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Benefits</h3>
          <div class="prose max-w-none">
            <div v-html="formatText(job.benefits)"></div>
          </div>
        </div>

        <!-- Application Instructions -->
        <div v-if="job.application_instructions" class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Application Instructions</h3>
          <div class="prose max-w-none">
            <div v-html="formatText(job.application_instructions)"></div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="space-y-6">
        <!-- Job Details -->
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Job Details</h3>
          <dl class="space-y-3">
            <div>
              <dt class="text-sm font-medium text-gray-500">Department</dt>
              <dd class="text-sm text-gray-900">{{ job.department?.name || 'N/A' }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Employment Type</dt>
              <dd class="text-sm text-gray-900">{{ job.employment_type_display }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Experience Level</dt>
              <dd class="text-sm text-gray-900">{{ job.experience_level_display }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Location</dt>
              <dd class="text-sm text-gray-900">{{ job.location }}</dd>
            </div>
            <div v-if="job.salary_range">
              <dt class="text-sm font-medium text-gray-500">Salary Range</dt>
              <dd class="text-sm text-gray-900">{{ job.salary_range }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Remote Work</dt>
              <dd class="text-sm text-gray-900">{{ job.remote_allowed ? 'Allowed' : 'Not Allowed' }}</dd>
            </div>
            <div v-if="job.application_deadline">
              <dt class="text-sm font-medium text-gray-500">Application Deadline</dt>
              <dd class="text-sm text-gray-900">{{ formatDate(job.application_deadline) }}</dd>
            </div>
            <div v-if="job.max_applications">
              <dt class="text-sm font-medium text-gray-500">Max Applications</dt>
              <dd class="text-sm text-gray-900">{{ job.max_applications }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Priority</dt>
              <dd class="text-sm text-gray-900">{{ job.priority || 0 }}</dd>
            </div>
          </dl>
        </div>

        <!-- Statistics -->
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Statistics</h3>
          <dl class="space-y-3">
            <div>
              <dt class="text-sm font-medium text-gray-500">Total Applications</dt>
              <dd class="text-sm text-gray-900">{{ job.application_count }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Created</dt>
              <dd class="text-sm text-gray-900">{{ formatDate(job.created_at) }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
              <dd class="text-sm text-gray-900">{{ formatDate(job.updated_at) }}</dd>
            </div>
            <div v-if="job.published_at">
              <dt class="text-sm font-medium text-gray-500">Published</dt>
              <dd class="text-sm text-gray-900">{{ formatDate(job.published_at) }}</dd>
            </div>
          </dl>
        </div>

        <!-- Actions -->
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
          <div class="space-y-3">
            <button
              @click="toggleStatus"
              :class="getToggleStatusClass(job.status)"
              class="w-full text-left px-3 py-2 rounded-md text-sm font-medium"
            >
              {{ getToggleStatusText(job.status) }}
            </button>
            <button
              @click="toggleFeatured"
              :class="job.featured ? 'text-yellow-600 hover:text-yellow-900' : 'text-gray-600 hover:text-gray-900'"
              class="w-full text-left px-3 py-2 rounded-md text-sm font-medium"
            >
              {{ job.featured ? 'Remove from Featured' : 'Mark as Featured' }}
            </button>
            <Link
              :href="`/hli-admin/career-applications?job=${job.id}`"
              class="w-full text-left px-3 py-2 rounded-md text-sm font-medium text-blue-600 hover:text-blue-900 hover:bg-blue-50"
            >
              View Applications ({{ job.application_count }})
            </Link>
            <button
              @click="deleteJob"
              class="w-full text-left px-3 py-2 rounded-md text-sm font-medium text-red-600 hover:text-red-900 hover:bg-red-50"
            >
              Delete Job
            </button>
          </div>
        </div>

        <!-- SEO Information -->
        <div v-if="job.meta_title || job.meta_description" class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>
          <dl class="space-y-3">
            <div v-if="job.meta_title">
              <dt class="text-sm font-medium text-gray-500">Meta Title</dt>
              <dd class="text-sm text-gray-900">{{ job.meta_title }}</dd>
            </div>
            <div v-if="job.meta_description">
              <dt class="text-sm font-medium text-gray-500">Meta Description</dt>
              <dd class="text-sm text-gray-900">{{ job.meta_description }}</dd>
            </div>
            <div v-if="job.meta_keywords">
              <dt class="text-sm font-medium text-gray-500">Meta Keywords</dt>
              <dd class="text-sm text-gray-900">{{ job.meta_keywords }}</dd>
            </div>
          </dl>
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
  job: Object,
  user: Object
})

const showFlashMessage = ref(true)

const closeFlashMessage = () => {
  showFlashMessage.value = false
}

const getStatusBadgeClass = (status) => {
  const classes = {
    draft: 'bg-gray-100 text-gray-800',
    published: 'bg-green-100 text-green-800',
    closed: 'bg-yellow-100 text-yellow-800',
    archived: 'bg-red-100 text-red-800'
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getToggleStatusClass = (status) => {
  const classes = {
    draft: 'bg-green-100 text-green-800 hover:bg-green-200',
    published: 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200',
    closed: 'bg-red-100 text-red-800 hover:bg-red-200',
    archived: 'bg-gray-100 text-gray-800 hover:bg-gray-200'
  }
  return classes[status] || 'bg-gray-100 text-gray-800 hover:bg-gray-200'
}

const getToggleStatusText = (status) => {
  const texts = {
    draft: 'Publish Job',
    published: 'Close Job',
    closed: 'Archive Job',
    archived: 'Restore to Draft'
  }
  return texts[status] || 'Toggle Status'
}

const toggleStatus = () => {
  router.patch(`/hli-admin/career-jobs/${props.job.id}/toggle-status`, {}, {
    preserveState: true
  })
}

const toggleFeatured = () => {
  router.patch(`/hli-admin/career-jobs/${props.job.id}/toggle-featured`, {}, {
    preserveState: true
  })
}

const deleteJob = () => {
  if (confirm(`Are you sure you want to delete "${props.job.title}"? This action cannot be undone.`)) {
    router.delete(`/hli-admin/career-jobs/${props.job.id}`, {
      onSuccess: () => {
        router.visit('/hli-admin/career-jobs')
      }
    })
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatText = (text) => {
  if (!text) return ''
  return text.replace(/\n/g, '<br>')
}
</script>
