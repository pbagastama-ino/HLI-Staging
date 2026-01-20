<template>
  <Head title="Contact Submissions - HLI Admin" />
  <AdminLayout 
    current-page="contact-submissions" 
    title="Contact Submissions" 
    search-placeholder="Search contact submissions..." 
    :user="user"
  >
    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">Contact Submissions</h2>
          <p class="text-sm text-gray-600 mt-1">Manage contact form submissions</p>
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

    <!-- Delete Success Message -->
    <div v-if="showDeleteSuccess" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg relative">
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        Submission deleted successfully!
      </div>
    </div>

    <!-- Search and Filters -->
    <div class="mb-6">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-4">
        <!-- Search Bar -->
        <div class="max-w-md">
          <input
            v-model="searchQuery"
            @input="debouncedSearch"
            type="text"
            placeholder="Search contact submissions..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          />
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap items-center space-x-4">
          <!-- Subject Filter -->
          <select
            v-model="filters.subject"
            @change="applyFilters"
            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          >
            <option value="">All Subjects</option>
            <option value="Partnership">Partnership</option>
            <option value="Media Request">Media Request</option>
            <option value="General Information">General Information</option>
            <option value="Other">Other</option>
          </select>

          <!-- Clear Filters -->
          <button
            @click="clearFilters"
            class="px-3 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50"
          >
            Clear Filters
          </button>
        </div>
      </div>
    </div>

    <!-- Contact Submissions Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Name / Email
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                Phone
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Subject
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                Date
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="submission in submissions.data" :key="submission.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ submission.fullname }}</div>
                <div class="text-sm text-gray-500">{{ submission.email }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                {{ submission.phone || 'N/A' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  {{ submission.subject || 'Not specified' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                {{ formatDate(submission.created_at) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex items-center space-x-2">
                  <button
                    @click="openDetailModal(submission)"
                    class="text-[#4D9F95] hover:text-[#3d7f75]"
                  >
                    View
                  </button>
                  <button
                    @click="confirmDelete(submission)"
                    class="text-red-600 hover:text-red-900"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="submissions.links" class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
          <div class="flex-1 flex justify-between sm:hidden">
            <Link
              v-if="submissions.prev_page_url"
              :href="submissions.prev_page_url"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Previous
            </Link>
            <Link
              v-if="submissions.next_page_url"
              :href="submissions.next_page_url"
              class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Next
            </Link>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ submissions.from }}</span>
                to
                <span class="font-medium">{{ submissions.to }}</span>
                of
                <span class="font-medium">{{ submissions.total }}</span>
                results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <Link
                  v-for="link in submissions.links"
                  :key="link.label"
                  :href="link.url || '#'"
                  v-html="link.label"
                  class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  :class="[
                    link.active
                      ? 'z-10 bg-[#4D9F95] border-[#4D9F95] text-white'
                      : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                    link.url === null ? 'cursor-not-allowed opacity-50' : 'cursor-pointer'
                  ]"
                />
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div v-if="showDetailModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
      <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <div class="p-6 overflow-y-auto max-h-[90vh]">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Contact Submission Details</h3>
            <button @click="closeDetailModal" class="text-gray-400 hover:text-gray-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          
          <div class="space-y-4">
            <div>
              <label class="text-sm font-medium text-gray-700">Full Name</label>
              <p class="mt-1 text-sm text-gray-900">{{ selectedSubmission?.fullname }}</p>
            </div>
            
            <div>
              <label class="text-sm font-medium text-gray-700">Email</label>
              <p class="mt-1 text-sm text-gray-900">{{ selectedSubmission?.email }}</p>
            </div>
            
            <div>
              <label class="text-sm font-medium text-gray-700">Phone</label>
              <p class="mt-1 text-sm text-gray-900">{{ selectedSubmission?.phone || 'N/A' }}</p>
            </div>
            
            <div>
              <label class="text-sm font-medium text-gray-700">Subject</label>
              <p class="mt-1 text-sm text-gray-900">{{ selectedSubmission?.subject || 'Not specified' }}</p>
            </div>
            
            <div>
              <label class="text-sm font-medium text-gray-700">Message</label>
              <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ selectedSubmission?.message }}</p>
            </div>
            
            <div>
              <label class="text-sm font-medium text-gray-700">Submitted Date</label>
              <p class="mt-1 text-sm text-gray-900">{{ formatDate(selectedSubmission?.created_at) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-[#4D9F95]/70 backdrop-blur-sm">
      <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
          <div class="flex items-center mb-4">
            <div class="flex-shrink-0 w-10 h-10 mx-auto bg-red-100 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
              </svg>
            </div>
          </div>
          <div class="text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-2">
              Delete Contact Submission
            </h3>
            <p class="text-sm text-gray-500 mb-6">
              Are you sure you want to delete the submission from "{{ submissionToDelete?.fullname }}"? This action cannot be undone.
            </p>
            <div class="flex space-x-3 justify-center">
              <button
                @click="deleteSubmission"
                type="button"
                class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
              >
                Delete
              </button>
              <button
                @click="closeDeleteModal"
                type="button"
                class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
              >
                Cancel
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

// Simple debounce implementation
const debounce = (func, wait) => {
  let timeout
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout)
      func(...args)
    }
    clearTimeout(timeout)
    timeout = setTimeout(later, wait)
  }
}

const props = defineProps({
  submissions: {
    type: Object,
    default: () => ({ data: [], links: null, from: 0, to: 0, total: 0 })
  },
  filters: {
    type: Object,
    default: () => ({})
  },
  user: {
    type: Object,
    required: true
  }
})

const searchQuery = ref(props.filters?.search || '')
const filters = reactive({
  subject: props.filters?.subject || ''
})

const showFlashMessage = ref(true)
const showDetailModal = ref(false)
const showDeleteModal = ref(false)
const submissionToDelete = ref(null)
const selectedSubmission = ref(null)
const showDeleteSuccess = ref(false)

const debouncedSearch = debounce(() => {
  applyFilters()
}, 300)

const applyFilters = () => {
  const params = {
    search: searchQuery.value,
    ...filters
  }
  
  // Remove empty values
  Object.keys(params).forEach(key => {
    if (params[key] === '' || params[key] === null) {
      delete params[key]
    }
  })
  
  router.get('/hli-admin/contact-submissions', params, {
    replace: true
  })
}

const clearFilters = () => {
  searchQuery.value = ''
  filters.subject = ''
  applyFilters()
}

const closeFlashMessage = () => {
  showFlashMessage.value = false
}

const formatDate = (date) => {
  if (!date) return 'N/A'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const openDetailModal = (submission) => {
  selectedSubmission.value = submission
  showDetailModal.value = true
}

const closeDetailModal = () => {
  showDetailModal.value = false
  selectedSubmission.value = null
}

const confirmDelete = (submission) => {
  submissionToDelete.value = submission
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  submissionToDelete.value = null
}

const deleteSubmission = () => {
  if (submissionToDelete.value) {
    router.delete(`/hli-admin/contact-submissions/${submissionToDelete.value.id}`, {
      onSuccess: () => {
        closeDeleteModal()
        showDeleteSuccess.value = true
        // Auto-hide success message after 3 seconds
        setTimeout(() => {
          showDeleteSuccess.value = false
        }, 3000)
        // Force refresh the page to get updated data
        router.reload()
      }
    })
  }
}

onMounted(() => {
  // Auto-hide flash message after 10 seconds
  setTimeout(() => {
    showFlashMessage.value = false
  }, 10000)
})
</script>

