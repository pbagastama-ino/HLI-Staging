<template>
  <Head title="Publication Management - HLI Admin" />
  <AdminLayout 
    current-page="publications" 
    title="Publication Management" 
    search-placeholder="Search publications..." 
    :user="user"
  >
    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">Publications</h2>
          <p class="text-sm text-gray-600 mt-1">Manage company publications and activities</p>
        </div>
        <div class="flex space-x-3">
          <Link
            href="/hli-admin/publications/create"
            class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
          >
            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Publication
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

    <!-- Delete Success Message -->
    <div v-if="showDeleteSuccess" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg relative">
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        Publication deleted successfully!
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
            placeholder="Search publications..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          />
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap items-center space-x-4">
          <!-- Status Filter -->
          <select
            v-model="filters.status"
            @change="applyFilters"
            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          >
            <option value="">All Status</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
          </select>

          <!-- Category Filter -->
          <select
            v-model="filters.category"
            @change="applyFilters"
            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          >
            <option value="">All Categories</option>
            <option value="press-release">Press Release</option>
            <option value="company-activities">Company Activities</option>
            <option value="life-at-hli">Life at HLI</option>
          </select>

          <!-- Featured Filter -->
          <select
            v-model="filters.featured"
            @change="applyFilters"
            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          >
            <option value="">All</option>
            <option value="1">Featured</option>
            <option value="0">Not Featured</option>
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

    <!-- Publications Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Publication
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Category
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                Published Date
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                Featured
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="publication in publications.data" :key="publication.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-12 w-12">
                    <img
                      v-if="publication.image"
                      :src="publication.image_url"
                      :alt="publication.title"
                      class="h-12 w-12 rounded-lg object-cover"
                    />
                    <div
                      v-else
                      class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center"
                    >
                      <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ publication.title }}</div>
                    <div class="text-sm text-gray-500">{{ publication.excerpt }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="getCategoryBadgeClass(publication.category)">
                  {{ getCategoryDisplay(publication.category) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="getStatusBadgeClass(publication.status)">
                  {{ publication.status.charAt(0).toUpperCase() + publication.status.slice(1) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                {{ formatPublishedDate(publication.published_date) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                <button
                  @click="toggleFeatured(publication)"
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors"
                  :class="publication.featured ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                >
                  <svg v-if="publication.featured" class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <svg v-else class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                  </svg>
                  {{ publication.featured ? 'Featured' : 'Not Featured' }}
                </button>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex items-center space-x-2">
                  <Link
                    :href="`/hli-admin/publications/${publication.id}`"
                    class="text-[#4D9F95] hover:text-[#3d7f75]"
                  >
                    View
                  </Link>
                  <Link
                    :href="`/hli-admin/publications/${publication.id}/edit`"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    Edit
                  </Link>
                  <button
                    @click="confirmDelete(publication)"
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
      <div v-if="publications.links" class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
          <div class="flex-1 flex justify-between sm:hidden">
            <Link
              v-if="publications.prev_page_url"
              :href="publications.prev_page_url"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Previous
            </Link>
            <Link
              v-if="publications.next_page_url"
              :href="publications.next_page_url"
              class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Next
            </Link>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ publications.from }}</span>
                to
                <span class="font-medium">{{ publications.to }}</span>
                of
                <span class="font-medium">{{ publications.total }}</span>
                results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <Link
                  v-for="link in publications.links"
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
              Are you sure you want to delete "{{ publicationToDelete?.title }}"? This action cannot be undone.
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
  publications: {
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
  status: props.filters?.status || '',
  category: props.filters?.category || '',
  featured: props.filters?.featured || ''
})

const showFlashMessage = ref(true)
const showDeleteModal = ref(false)
const publicationToDelete = ref(null)
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
  
  router.get('/hli-admin/publications', params, {
    replace: true
  })
}

const clearFilters = () => {
  searchQuery.value = ''
  filters.status = ''
  filters.category = ''
  filters.featured = ''
  applyFilters()
}

const closeFlashMessage = () => {
  showFlashMessage.value = false
}

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

const formatPublishedDate = (date) => {
  if (!date) return 'Not set'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const toggleFeatured = (publication) => {
  router.patch(`/hli-admin/publications/${publication.id}/toggle-featured`, {}, {
    onSuccess: () => {
      // Force refresh the page to get updated data
      router.reload()
    }
  })
}

const confirmDelete = (publication) => {
  publicationToDelete.value = publication
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  publicationToDelete.value = null
}

const deletePublication = () => {
  if (publicationToDelete.value) {
    router.delete(`/hli-admin/publications/${publicationToDelete.value.id}`, {
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
