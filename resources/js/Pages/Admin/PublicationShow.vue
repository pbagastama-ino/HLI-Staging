<template>
  <Head title="Publication Details - HLI Admin" />
  <AdminLayout 
    current-page="publications" 
    title="Publication Details" 
    :user="user"
  >
    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">Publication Details</h2>
          <p class="text-sm text-gray-600 mt-1">View and manage publication information</p>
        </div>
        <div class="flex space-x-3">
          <Link
            :href="`/hli-admin/publications/${publication.id}/edit`"
            class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
          >
            Edit Publication
          </Link>
          <Link
            href="/hli-admin/publications"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
          >
            Back to List
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Main Content -->
      <div class="lg:col-span-2">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
          <!-- Image -->
          <div v-if="publication.image" class="aspect-w-16 aspect-h-9">
            <img
              :src="publication.image_url"
              :alt="publication.title"
              class="w-full h-64 object-cover"
            />
          </div>
          <div v-else class="w-full h-64 bg-gray-200 flex items-center justify-center">
            <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>

          <!-- Content -->
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h1 class="text-2xl font-bold text-gray-900">{{ publication.title }}</h1>
              <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="getStatusBadgeClass(publication.status)">
                  {{ publication.status.charAt(0).toUpperCase() + publication.status.slice(1) }}
                </span>
                <button
                  v-if="publication.featured"
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                >
                  <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  Featured
                </button>
              </div>
            </div>

            <div class="flex items-center text-sm text-gray-500 mb-6">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              {{ publication.formatted_published_date }}
            </div>

            <div class="prose prose-lg max-w-none">
              <div v-html="formattedText"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="space-y-6">
        <!-- Publication Info -->
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Publication Information</h3>
          
          <dl class="space-y-4">
            <div>
              <dt class="text-sm font-medium text-gray-500">Category</dt>
              <dd class="mt-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="getCategoryBadgeClass(publication.category)">
                  {{ getCategoryDisplay(publication.category) }}
                </span>
              </dd>
            </div>

            <div>
              <dt class="text-sm font-medium text-gray-500">Status</dt>
              <dd class="mt-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="getStatusBadgeClass(publication.status)">
                  {{ publication.status.charAt(0).toUpperCase() + publication.status.slice(1) }}
                </span>
              </dd>
            </div>

            <div>
              <dt class="text-sm font-medium text-gray-500">Featured</dt>
              <dd class="mt-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="publication.featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'">
                  {{ publication.featured ? 'Yes' : 'No' }}
                </span>
              </dd>
            </div>

            <div>
              <dt class="text-sm font-medium text-gray-500">Published Date</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ publication.formatted_published_date }}</dd>
            </div>

            <div>
              <dt class="text-sm font-medium text-gray-500">Created</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ formatDate(publication.created_at) }}</dd>
            </div>

            <div>
              <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ formatDate(publication.updated_at) }}</dd>
            </div>
          </dl>
        </div>

        <!-- Actions -->
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
          
          <div class="space-y-3">
            <button
              @click="toggleFeatured"
              class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg transition-colors"
              :class="publication.featured 
                ? 'text-yellow-700 bg-yellow-100 hover:bg-yellow-200' 
                : 'text-gray-700 bg-gray-100 hover:bg-gray-200'"
            >
              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
              </svg>
              {{ publication.featured ? 'Remove from Featured' : 'Mark as Featured' }}
            </button>

            <button
              @click="toggleStatus"
              class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg transition-colors"
              :class="getStatusButtonClass(publication.status)"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              {{ getStatusButtonText(publication.status) }}
            </button>

            <button
              @click="confirmDelete"
              class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Delete Publication
            </button>
          </div>
        </div>

        <!-- SEO Information -->
        <div v-if="publication.meta_title || publication.meta_description || publication.meta_keywords" class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>
          
          <dl class="space-y-4">
            <div v-if="publication.meta_title">
              <dt class="text-sm font-medium text-gray-500">Meta Title</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ publication.meta_title }}</dd>
            </div>

            <div v-if="publication.meta_description">
              <dt class="text-sm font-medium text-gray-500">Meta Description</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ publication.meta_description }}</dd>
            </div>

            <div v-if="publication.meta_keywords">
              <dt class="text-sm font-medium text-gray-500">Meta Keywords</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ publication.meta_keywords }}</dd>
            </div>
          </dl>
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
              Delete Publication
            </h3>
            <p class="text-sm text-gray-500 mb-6">
              Are you sure you want to delete "{{ publication.title }}"? This action cannot be undone.
            </p>
            <div class="flex space-x-3 justify-center">
              <button
                @click="deletePublication"
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
import { ref, computed, onMounted } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  publication: {
    type: Object,
    required: true
  },
  user: {
    type: Object,
    required: true
  }
})

const showFlashMessage = ref(true)
const showDeleteModal = ref(false)

const formattedText = computed(() => {
  if (!props.publication.text) return ''
  return props.publication.text.replace(/\n/g, '<br>')
})

const getStatusBadgeClass = (status) => {
  switch (status) {
    case 'draft':
      return 'bg-gray-100 text-gray-800'
    case 'published':
      return 'bg-green-100 text-green-800'
    case 'archived':
      return 'bg-red-100 text-red-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const getCategoryBadgeClass = (category) => {
  switch (category) {
    case 'press-release':
      return 'bg-purple-100 text-purple-800'
    case 'company-activities':
      return 'bg-blue-100 text-blue-800'
    case 'life-at-hli':
      return 'bg-green-100 text-green-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const getCategoryDisplay = (category) => {
  switch (category) {
    case 'press-release':
      return 'Press Release'
    case 'company-activities':
      return 'Company Activities'
    case 'life-at-hli':
      return 'Life at HLI'
    default:
      return category ? category.charAt(0).toUpperCase() + category.slice(1).replace('-', ' ') : 'N/A'
  }
}

const getStatusButtonClass = (status) => {
  switch (status) {
    case 'draft':
      return 'text-green-700 bg-green-100 hover:bg-green-200'
    case 'published':
      return 'text-gray-700 bg-gray-100 hover:bg-gray-200'
    case 'archived':
      return 'text-green-700 bg-green-100 hover:bg-green-200'
    default:
      return 'text-gray-700 bg-gray-100 hover:bg-gray-200'
  }
}

const getStatusButtonText = (status) => {
  switch (status) {
    case 'draft':
      return 'Publish'
    case 'published':
      return 'Archive'
    case 'archived':
      return 'Publish'
    default:
      return 'Change Status'
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const toggleFeatured = () => {
  router.patch(`/hli-admin/publications/${props.publication.id}/toggle-featured`, {}, {
    preserveState: true
  })
}

const toggleStatus = () => {
  const newStatus = props.publication.status === 'draft' ? 'published' : 
                   props.publication.status === 'published' ? 'archived' : 'published'
  
  router.patch(`/hli-admin/publications/${props.publication.id}/toggle-status`, {
    status: newStatus
  }, {
    preserveState: true
  })
}

const confirmDelete = () => {
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
}

const deletePublication = () => {
  router.delete(`/hli-admin/publications/${props.publication.id}`)
}

const closeFlashMessage = () => {
  showFlashMessage.value = false
}

onMounted(() => {
  // Auto-hide flash message after 10 seconds
  setTimeout(() => {
    showFlashMessage.value = false
  }, 10000)
})
</script>
