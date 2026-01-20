<template>
  <Head title="Vacancy Management - HLI Admin" />
  <AdminLayout 
    current-page="vacancies" 
    title="Vacancy Management" 
    search-placeholder="Search vacancies..." 
    :user="user"
  >
    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">Vacancies</h2>
          <p class="text-sm text-gray-600 mt-1">Manage job postings and career opportunities</p>
        </div>
        <div class="flex space-x-3">
          <Link
            href="/hli-admin/vacancies/create"
            class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
          >
            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Vacancy
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

    <!-- Search Bar -->
    <div class="mb-6">
      <div class="max-w-md">
        <input
          v-model="searchQuery"
          @input="debouncedSearch"
          type="text"
          placeholder="Search vacancies..."
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
        />
      </div>
    </div>

    <!-- Vacancies Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Name
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Department
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Applications
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Created By
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Created At
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="vacancy in vacancies.data" :key="vacancy.id" class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <div class="text-sm font-medium text-gray-900">{{ vacancy.title }}</div>
                <div class="text-sm text-gray-500 max-w-xs html-snippet" v-html="truncateHtml(vacancy.description)"></div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                  {{ vacancy.department_name }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ vacancy.application_count }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ vacancy.creator?.name || 'Unknown' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(vacancy.created_at) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <button
                  @click="toggleStatus(vacancy)"
                  :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full transition-colors',
                    vacancy.is_active === 1
                      ? 'bg-green-100 text-green-800 hover:bg-green-200'
                      : 'bg-gray-100 text-gray-800 hover:bg-gray-200'
                  ]"
                >
                  {{ vacancy.is_active === 1 ? 'Active' : 'Inactive' }}
                </button>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                  <Link
                    :href="`/hli-admin/vacancies/${vacancy.id}`"
                    class="text-[#4D9F95] hover:text-[#3d7f75]"
                  >
                    View
                  </Link>
                  <Link
                    :href="`/hli-admin/vacancies/${vacancy.id}/edit`"
                    class="text-indigo-600 hover:text-indigo-900"
                  >
                    Edit
                  </Link>
                  <button
                    @click="deleteVacancy(vacancy)"
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
      <div v-if="vacancies.last_page > 1" class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
          <div class="flex-1 flex justify-between sm:hidden">
            <Link
              v-if="vacancies.prev_page_url"
              :href="vacancies.prev_page_url"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Previous
            </Link>
            <Link
              v-if="vacancies.next_page_url"
              :href="vacancies.next_page_url"
              class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Next
            </Link>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ vacancies.from }}</span>
                to
                <span class="font-medium">{{ vacancies.to }}</span>
                of
                <span class="font-medium">{{ vacancies.total }}</span>
                results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <Link
                  v-if="vacancies.prev_page_url"
                  :href="vacancies.prev_page_url"
                  class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                >
                  <span class="sr-only">Previous</span>
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                </Link>
                <Link
                  v-for="page in getPageNumbers()"
                  :key="page"
                  :href="getPageUrl(page)"
                  :class="[
                    page === vacancies.current_page
                      ? 'z-10 bg-[#4D9F95] border-[#4D9F95] text-white'
                      : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                    'relative inline-flex items-center px-4 py-2 border text-sm font-medium'
                  ]"
                >
                  {{ page }}
                </Link>
                <Link
                  v-if="vacancies.next_page_url"
                  :href="vacancies.next_page_url"
                  class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                >
                  <span class="sr-only">Next</span>
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                </Link>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

// Simple debounce function
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
  vacancies: Object,
  filters: Object,
  user: Object
})

const searchQuery = ref(props.filters.search || '')
const showFlashMessage = ref(true)

const debouncedSearch = debounce(() => {
  router.get('/hli-admin/vacancies', { search: searchQuery.value }, {
    preserveState: true,
    replace: true
  })
}, 300)

const closeFlashMessage = () => {
  showFlashMessage.value = false
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const truncateHtml = (html) => {
  if (!html) return ''
  // Create a temporary div to parse HTML
  const tmp = document.createElement('div')
  tmp.innerHTML = html
  
  // Function to truncate HTML while preserving structure
  const truncateNode = (node, maxLength) => {
    let length = 0
    const walker = document.createTreeWalker(
      node,
      NodeFilter.SHOW_TEXT,
      null,
      false
    )
    
    const textNodes = []
    let textNode
    while ((textNode = walker.nextNode())) {
      textNodes.push(textNode)
      length += textNode.textContent.length
    }
    
    // If within limit, return original
    if (length <= maxLength) {
      return node.innerHTML
    }
    
    // Otherwise, truncate text nodes
    let currentLength = 0
    for (const textNode of textNodes) {
      const nodeLength = textNode.textContent.length
      if (currentLength + nodeLength > maxLength) {
        const remaining = maxLength - currentLength
        textNode.textContent = textNode.textContent.substring(0, remaining) + '...'
        // Remove all subsequent text nodes and their parents if they become empty
        let next = textNode.nextSibling
        while (next) {
          const toRemove = next
          next = next.nextSibling
          toRemove.parentNode?.removeChild(toRemove)
        }
        break
      }
      currentLength += nodeLength
    }
    
    return node.innerHTML
  }
  
  const truncated = truncateNode(tmp, 100)
  return truncated || ''
}

const toggleStatus = (vacancy) => {
  const newStatus = vacancy.is_active === 1 ? 0 : 1
  const statusText = newStatus === 1 ? 'activate' : 'deactivate'
  
  if (confirm(`Are you sure you want to ${statusText} "${vacancy.title}"?`)) {
    router.post(`/hli-admin/vacancies/${vacancy.id}/update-status`, {
      is_active: newStatus
    }, {
      preserveState: true,
      preserveScroll: true,
      onSuccess: () => {
        // Update the local state
        vacancy.is_active = newStatus
      },
      onError: (errors) => {
        console.error('Error updating status:', errors)
        alert('Failed to update vacancy status. Please try again.')
      }
    })
  }
}

const deleteVacancy = (vacancy) => {
  if (confirm(`Are you sure you want to delete "${vacancy.title}"?`)) {
    console.log('Attempting to delete vacancy:', vacancy.id, vacancy.title)
    
    router.delete(`/hli-admin/vacancies/${vacancy.id}`, {
      onBefore: () => {
        console.log('Delete request initiated')
      },
      onSuccess: (page) => {
        console.log('Delete successful:', page)
        // Success message will be handled by the backend flash message
      },
      onError: (errors) => {
        console.error('Delete error:', errors)
        
        // Handle JSON error response from backend
        if (errors && errors.error) {
          alert(errors.error)
        } else if (errors && typeof errors === 'object') {
          const errorMessage = Object.values(errors).flat().join(' ')
          if (errorMessage.includes('existing applications')) {
            alert(`Cannot delete vacancy "${vacancy.title}" because it has existing applications. Please remove all applications first.`)
          } else {
            alert(`Failed to delete vacancy: ${errorMessage}`)
          }
        } else {
          alert('Failed to delete vacancy. Please try again.')
        }
      },
      onFinish: (event) => {
        console.log('Delete request finished')
        
        // Check for flash error messages in the response
        if (event.detail?.page?.props?.flash?.error) {
          const errorMessage = event.detail.page.props.flash.error
          if (errorMessage.includes('existing applications')) {
            alert(`Cannot delete vacancy "${vacancy.title}" because it has existing applications. Please remove all applications first.`)
          } else {
            alert(`Error: ${errorMessage}`)
          }
        }
      }
    })
  }
}

const getPageNumbers = () => {
  const current = props.vacancies.current_page
  const last = props.vacancies.last_page
  const delta = 2
  const range = []
  const rangeWithDots = []

  for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
    range.push(i)
  }

  if (current - delta > 2) {
    rangeWithDots.push(1, '...')
  } else {
    rangeWithDots.push(1)
  }

  rangeWithDots.push(...range)

  if (current + delta < last - 1) {
    rangeWithDots.push('...', last)
  } else if (last > 1) {
    rangeWithDots.push(last)
  }

  return rangeWithDots
}

const getPageUrl = (page) => {
  if (page === '...') return '#'
  return `/hli-admin/vacancies?page=${page}${searchQuery.value ? `&search=${searchQuery.value}` : ''}`
}

onMounted(() => {
  setTimeout(() => {
    showFlashMessage.value = false
  }, 10000)
})

// Watch for flash error messages
const page = usePage()
let errorAlertShown = false

watch(() => page.props.flash?.error, (newError) => {
  if (newError && !errorAlertShown) {
    errorAlertShown = true
    
    // Use setTimeout to ensure the alert shows after the page update
    setTimeout(() => {
      if (newError.includes('existing applications')) {
        alert(`Cannot delete vacancy because it has existing applications. Please remove all applications first.`)
      } else {
        alert(`Error: ${newError}`)
      }
      
      // Reset the flag after showing the alert
      setTimeout(() => {
        errorAlertShown = false
      }, 1000)
    }, 100)
  }
}, { immediate: true })
</script>

<style scoped>
.html-snippet {
  max-height: 3rem;
  overflow: hidden;
  line-height: 1.5;
}

.html-snippet :deep(ul),
.html-snippet :deep(ol) {
  padding-left: 1.25rem;
  margin: 0.25rem 0;
  display: inline-block;
}

.html-snippet :deep(ul) {
  list-style-type: disc;
}

.html-snippet :deep(ol) {
  list-style-type: decimal;
}

.html-snippet :deep(li) {
  margin: 0.125rem 0;
  display: list-item;
}

.html-snippet :deep(strong),
.html-snippet :deep(b) {
  font-weight: 700;
}

.html-snippet :deep(em),
.html-snippet :deep(i) {
  font-style: italic;
}

.html-snippet :deep(p) {
  margin: 0.25rem 0;
  display: inline;
}

.html-snippet :deep(br) {
  display: none;
}
</style>
