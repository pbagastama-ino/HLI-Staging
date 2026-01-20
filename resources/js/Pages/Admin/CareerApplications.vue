<template>
  <Head :title="`${pageTitle} - HLI Admin`" />
  <AdminLayout 
    :current-page="isTalentPool ? 'talent-pool' : 'career-applications'" 
    :title="pageTitle" 
    search-placeholder="Search applicants..." 
    :user="user"
  >
    <!-- Bulk Actions Bar -->
    <div v-if="selectedApplications.length > 0" class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg sticky top-0 z-40 shadow">
      <div class="flex items-center justify-between">
        <div class="text-sm font-medium text-blue-900">
          {{ selectedApplications.length }} application(s) selected
        </div>
        <div class="flex items-center gap-3">
          <select
            v-model="bulkStatus"
            class="px-3 py-2 text-sm border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="">Change Status To...</option>
            <option value="shortlisted">Shortlisted</option>
            <option value="interview">Interview</option>
            <option value="not_suitable">Not Suitable</option>
          </select>
          
          <label class="flex items-center text-sm text-blue-900">
            <input
              type="checkbox"
              v-model="bulkTalentPool"
              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2"
            />
            Add to Talent Pool
          </label>
          
          <button
            @click="applyBulkUpdate"
            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Update Selected
          </button>
          
          <button
            @click="showBulkDeleteModal = true"
            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
          >
            Delete Selected
          </button>
          
          <button
            @click="clearSelection"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
          >
            Clear Selection
          </button>
        </div>
      </div>
    </div>

    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">{{ isTalentPool ? 'Talent Pool' : 'Applicants List' }}</h2>
          <p class="text-sm text-gray-600 mt-1">{{ isTalentPool ? 'Manage and review talent pool candidates' : 'Manage and review job applications' }}</p>
        </div>
        <!-- <div class="flex space-x-3">
          <button
            @click="exportApplications"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
          >
            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Export
          </button>
        </div> -->
      </div>
    </div>

    <!-- Success/Error Messages -->
    <div v-if="$page.props.flash?.success" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
      {{ $page.props.flash.success }}
    </div>
    <div v-if="$page.props.flash?.error" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
      {{ $page.props.flash.error }}
    </div>

    <!-- Bulk Update Guide -->
    <div v-if="showBulkGuide" class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
      <div class="flex items-start justify-between">
        <div class="flex-1">
          <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <div>
              <h4 class="text-sm font-semibold text-blue-900 mb-1">Bulk Update Available</h4>
              <p class="text-sm text-blue-800">
                Select multiple applications using checkboxes to update their status or add to talent pool. You can also delete multiple applications at once.
              </p>
              <ul class="mt-2 text-xs text-blue-700 space-y-1 list-disc list-inside">
                <li>Check the boxes next to applications you want to update</li>
                <li>Choose a status (Shortlisted, Interview, or Not Suitable) and/or enable Talent Pool</li>
                <li>Click "Update Selected" to apply changes</li>
                <li>Click "Delete Selected" to remove multiple applications</li>
              </ul>
            </div>
          </div>
        </div>
        <button
          @click="showBulkGuide = false"
          class="ml-4 text-blue-600 hover:text-blue-800 flex-shrink-0"
        >
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
      <div :class="['grid grid-cols-1 sm:grid-cols-2 gap-3', isTalentPool ? 'lg:grid-cols-4' : 'lg:grid-cols-5']">
        <!-- Search -->
        <div class="sm:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search by name, email, phone, campus, position, company, school..."
            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            @input="debouncedSearch"
          />
        </div>

        <!-- Read Status Filter -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Read / Unread</label>
          <select
            v-model="readStatusFilter"
            @change="applyFilters"
            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          >
            <option value="">All</option>
            <option value="unread">Unread</option>
            <option value="read">Read</option>
          </select>
        </div>

        <!-- Status Filter -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select
            v-model="statusFilter"
            @change="applyFilters"
            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          >
            <option value="">All</option>
            <option value="shortlisted">Shortlisted</option>
            <option value="interview">Interview</option>
            <option value="not_suitable">Not Suitable</option>
          </select>
        </div>

        <!-- Talent Pool Filter (hidden on talent pool page) -->
        <div v-if="!isTalentPool">
          <label class="block text-sm font-medium text-gray-700 mb-1">Talent Pool</label>
          <select
            v-model="talentPoolFilter"
            @change="applyFilters"
            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          >
            <option value="">All</option>
            <option value="true">Talent Pool</option>
            <option value="false">Not Talent Pool</option>
          </select>
        </div>
      </div>

      <!-- Date Range Row -->
      <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
        <!-- Date From -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
          <input
            v-model="dateFrom"
            type="date"
            @change="applyFilters"
            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          />
        </div>

        <!-- Date To -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
          <input
            v-model="dateTo"
            type="date"
            @change="applyFilters"
            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          />
        </div>
      </div>

      <!-- Clear Filters -->
      <div class="mt-3 flex justify-between items-center">
        <button
          @click="clearFilters"
          class="text-sm text-gray-600 hover:text-gray-800 underline"
        >
          Clear Filters
        </button>
        <div class="text-sm text-gray-500">
          {{ pagination?.total || 0 }} applications
        </div>
      </div>
    </div>


    <!-- Applications List -->
    <div class="space-y-4">
      <!-- Sort Controls -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-2 text-sm">
          <span class="text-gray-500">Sort by:</span>
          <button
            @click="sortBy('full_name')"
            :class="sortField === 'full_name' ? 'text-[#4D9F95] font-medium' : 'text-gray-600 hover:text-gray-800'"
            class="flex items-center gap-1"
          >
            Name
            <svg v-if="sortField === 'full_name'" class="w-3 h-3" :class="sortDirection === 'asc' ? 'transform rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                  </svg>
          </button>
          <span class="text-gray-300">|</span>
          <button
            @click="sortBy('created_at')"
            :class="sortField === 'created_at' ? 'text-[#4D9F95] font-medium' : 'text-gray-600 hover:text-gray-800'"
            class="flex items-center gap-1"
          >
            Date
            <svg v-if="sortField === 'created_at'" class="w-3 h-3" :class="sortDirection === 'asc' ? 'transform rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                  </svg>
          </button>
          <span class="text-gray-300">|</span>
                </div>
                </div>

      <!-- Application Cards -->
      <div v-for="application in paginatedApplications" :key="application.id" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
          <!-- Checkbox for selection -->
          <input
            type="checkbox"
            :value="application.id"
            v-model="selectedApplications"
            class="h-4 w-4 text-[#4D9F95] focus:ring-[#4D9F95] border-gray-300 rounded mr-3 flex-shrink-0 mt-3"
          />
          <div class="flex items-start space-x-3 flex-1 min-w-0">
            <!-- Avatar -->
            <div class="flex-shrink-0">
              <div :class="[
                'h-10 w-10 rounded-full flex items-center justify-center',
                !application.read_status ? 'bg-yellow-500' : 'bg-[#4D9F95]'
              ]">
                <span class="text-sm font-medium text-white">
                  {{ getInitials(application.full_name) }}
                </span>
              </div>
            </div>
            
            <!-- Application Info -->
            <div class="flex-1 min-w-0">
              <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                  <div class="flex items-center gap-2 mb-1 flex-wrap">
                    <h3 class="text-sm font-medium text-gray-900 truncate">{{ application.full_name }}</h3>
                    <!-- Show Unread badge if not read -->
                    <span v-if="!application.read_status" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                      Unread
                    </span>
                    <!-- Show Read badge if read -->
                    <span v-else-if="application.read_status" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                      Read
                    </span>
                    <!-- Show status badge if there's a specific status (shortlisted, interview, etc) -->
                    <span v-if="application.status && application.status !== 'unread' && application.status !== 'read'" :class="getStatusBadgeClasses(application.status)">
                      {{ formatStatus(application.status) }}
                    </span>
                    <!-- Talent Pool badge -->
                    <span v-if="application.talent_pool" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                      Talent Pool
                    </span>
                  </div>
                  <p class="text-sm text-gray-500 truncate">{{ application.email }}</p>
                  <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                    <span>{{ application.phone_number || 'No phone' }}</span>
                    <span v-if="application.phone_number">•</span>
                    <span>{{ formatDate(application.created_at) }}</span>
                  </div>
                </div>
                
              </div>
              
              <!-- Position & Education -->
              <div class="mt-2 space-y-1">
                <div class="text-sm text-gray-900">
                  <span class="font-medium">Position:</span> {{ application.applied_position || 'Not specified' }}
                </div>
                <div v-if="application.campus" class="text-sm text-gray-600">
                  <span class="font-medium">Campus:</span> {{ application.campus }}
                </div>
                <div class="text-sm text-gray-600">
                  <span class="font-medium">Education:</span> {{ getHighestEducation(application) }}
                </div>
                <div class="text-sm text-gray-600">
                  <span class="font-medium">Experience:</span> {{ getCurrentExperience(application) }}
                </div>
                <div v-if="application.notes" class="text-xs text-gray-500 mt-1 line-clamp-2">
                  {{ application.notes }}
                </div>
              </div>
            </div>
          </div>
          
          <!-- Actions -->
          <div class="ml-4 flex-shrink-0 flex flex-col space-y-2">
            <Link
              :href="`/hli-admin/career-applications/${application.id}`"
              class="px-3 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95] transition-colors duration-200"
            >
              View Details
            </Link>
            <button
              @click="openQuickUpdate(application)"
              class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
            >
              Update
            </button>
            <button
              @click="confirmDelete(application)"
              class="px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
            >
              Delete
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <!-- Mobile Pagination -->
          <div class="flex justify-between sm:hidden">
            <Link
              v-if="pagination?.prev_page_url"
              :href="pagination.prev_page_url"
              class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
            >
              Previous
            </Link>
            <button
              v-else
              disabled
              class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md opacity-50 cursor-not-allowed"
            >
              Previous
            </button>
            <span class="px-3 py-2 text-sm text-gray-700">
              {{ currentPage }} of {{ totalPages }}
            </span>
            <Link
              v-if="pagination?.next_page_url"
              :href="pagination.next_page_url"
              class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
            >
              Next
            </Link>
            <button
              v-else
              disabled
              class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md opacity-50 cursor-not-allowed"
            >
              Next
            </button>
          </div>
          
          <!-- Desktop Pagination -->
          <div class="hidden sm:flex sm:items-center sm:justify-between w-full">
            <div class="text-sm text-gray-700">
              Showing
              <span class="font-medium">{{ pagination?.from || 0 }}</span>
              to
              <span class="font-medium">{{ pagination?.to || 0 }}</span>
              of
              <span class="font-medium">{{ pagination?.total || 0 }}</span>
              results
            </div>
            <nav class="flex items-center space-x-1">
              <Link
                v-if="pagination?.prev_page_url"
                :href="pagination.prev_page_url"
                class="p-2 text-gray-400 hover:text-gray-600"
              >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </Link>
              <button
                v-else
                disabled
                class="p-2 text-gray-400 opacity-50 cursor-not-allowed"
              >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </button>
              <template v-if="pagination?.links">
                <Link
                  v-for="(link, index) in pagination.links.slice(1, -1)"
                  :key="index"
                  :href="link.url || '#'"
                  :class="[
                    'px-3 py-1 text-sm font-medium rounded-md',
                    link.active
                      ? 'bg-[#4D9F95] text-white'
                      : 'text-gray-700 hover:bg-gray-100'
                  ]"
                  v-html="link.label"
                />
              </template>
              <Link
                v-if="pagination?.next_page_url"
                :href="pagination.next_page_url"
                class="p-2 text-gray-400 hover:text-gray-600"
              >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
              </Link>
              <button
                v-else
                disabled
                class="p-2 text-gray-400 opacity-50 cursor-not-allowed"
              >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
              </button>
            </nav>
          </div>
        </div>
      </div>
    </div>


    <!-- Bulk Delete Confirmation Modal -->
    <div v-if="showBulkDeleteModal" class="fixed inset-0 bg-[#4D9F95]/70 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
      <div class="relative top-10 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white m-4">
        <div class="mt-3">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Selected Applications</h3>
          <p class="text-sm text-gray-600 mb-4">
            Are you sure you want to delete <strong>{{ selectedApplications.length }}</strong> application(s)? 
            This action cannot be undone.
          </p>
          <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
            <button
              @click="showBulkDeleteModal = false"
              class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
            >
              Cancel
            </button>
            <button
              @click="deleteSelectedApplications"
              class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
            >
              Delete {{ selectedApplications.length }} Application(s)
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Update Modal -->
    <div v-if="showQuickUpdateModal" class="fixed inset-0 bg-[#4D9F95]/70 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
      <div class="relative top-10 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white m-4">
        <div class="mt-3">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Update Application</h3>
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
              <select
                v-model="quickUpdateForm.status"
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              >
                <option value="" disabled>- Select Status -</option>
                <option value="shortlisted">Shortlisted</option>
                <option value="interview">Interview</option>
                <option value="not_suitable">Not Suitable</option>
              </select>
            </div>
            
            <div>
              <label class="flex items-center text-sm text-gray-700">
                <input
                  type="checkbox"
                  v-model="quickUpdateForm.talent_pool"
                  class="h-4 w-4 text-[#4D9F95] focus:ring-[#4D9F95] border-gray-300 rounded mr-2"
                />
                Add to Talent Pool
              </label>
            </div>
          </div>
          
          <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3 mt-6">
            <button
              @click="closeQuickUpdate"
              class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
            >
              Cancel
            </button>
            <button
              @click="applyQuickUpdate"
              class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75]"
            >
              Update
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-[#4D9F95]/70 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
      <div class="relative top-10 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white m-4">
        <div class="mt-3">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Application</h3>
          <p class="text-sm text-gray-600 mb-4">
            Are you sure you want to delete the application from <strong>{{ selectedApplication?.full_name }}</strong>? 
            This action cannot be undone.
          </p>
          <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
            <button
              @click="closeDeleteModal"
              class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200"
            >
              Cancel
            </button>
            <button
              @click="deleteApplication"
              class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
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
import { ref, computed, onMounted, watch } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  applications: Object,
  filters: Object,
  user: Object,
  pageTitle: {
    type: String,
    default: 'Applicants List Management'
  },
  isTalentPool: {
    type: Boolean,
    default: false
  }
})

// Reactive data
const searchQuery = ref(props.filters?.search || '')
const readStatusFilter = ref(props.filters?.read_status || '')
const statusFilter = ref(props.filters?.status || '')
const talentPoolFilter = ref(props.filters?.talent_pool || '')
const dateFrom = ref(props.filters?.date_from || '')
const dateTo = ref(props.filters?.date_to || '')
const sortField = ref('created_at')
const sortDirection = ref('desc')
const showDeleteModal = ref(false)
const selectedApplication = ref(null)
const selectedApplications = ref([])
const showBulkDeleteModal = ref(false)
const bulkStatus = ref('')
const bulkTalentPool = ref(false)
const isProcessingBulk = ref(false)
const showBulkGuide = ref(true)
const showQuickUpdateModal = ref(false)
const quickUpdateForm = ref({
  applicationId: null,
  status: 'shortlisted',
  talent_pool: false,
  processing: false
})


// Computed properties - Use server-side pagination directly
const applications = computed(() => props.applications.data || [])
const pagination = computed(() => props.applications)

// Use server pagination directly - no client-side filtering needed
const paginatedApplications = computed(() => applications.value)

const totalPages = computed(() => pagination.value?.last_page || 1)
const currentPage = computed(() => pagination.value?.current_page || 1)


// Methods
let searchTimeout = null

const debouncedSearch = () => {
  if (searchTimeout) {
    clearTimeout(searchTimeout)
  }
  searchTimeout = setTimeout(() => {
    applyFilters()
  }, 300)
}

const applyFilters = () => {
  const params = new URLSearchParams()
  
  if (searchQuery.value) params.append('search', searchQuery.value)
  if (readStatusFilter.value) params.append('read_status', readStatusFilter.value)
  if (statusFilter.value) params.append('status', statusFilter.value)
  if (talentPoolFilter.value) params.append('talent_pool', talentPoolFilter.value)
  if (dateFrom.value) params.append('date_from', dateFrom.value)
  if (dateTo.value) params.append('date_to', dateTo.value)
  
  // Reset to page 1 when filters change
  params.append('page', '1')
  
  const route = props.isTalentPool ? '/hli-admin/talent-pool' : '/hli-admin/career-applications'
  router.get(route, Object.fromEntries(params), {
    preserveState: false,
    replace: true
  })
}

const clearFilters = () => {
  searchQuery.value = ''
  readStatusFilter.value = ''
  statusFilter.value = ''
  talentPoolFilter.value = ''
  dateFrom.value = ''
  dateTo.value = ''
  applyFilters()
}

const sortBy = (field) => {
  // Sorting is handled server-side via the existing orderBy in controller
  // For now, we'll keep it simple - you can add server-side sorting later if needed
  if (sortField.value === field) {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortField.value = field
    sortDirection.value = 'asc'
  }
  // Note: To implement server-side sorting, add 'sort' and 'direction' params to applyFilters
}


const confirmDelete = (application) => {
  selectedApplication.value = application
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  selectedApplication.value = null
}

const openQuickUpdate = (application) => {
  quickUpdateForm.value.applicationId = application.id
  quickUpdateForm.value.status = getInitialStatus(application.status)
  quickUpdateForm.value.talent_pool = application.talent_pool || false
  quickUpdateForm.value.processing = false
  showQuickUpdateModal.value = true
}

const closeQuickUpdate = () => {
  showQuickUpdateModal.value = false
  quickUpdateForm.value = {
    applicationId: null,
    status: '',
    talent_pool: false,
    processing: false
  }
}

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

const applyQuickUpdate = () => {
  if (!quickUpdateForm.value.applicationId) return
  
  // Validate that a status is selected
  if (!quickUpdateForm.value.status || quickUpdateForm.value.status === '') {
    alert('Please select a status before updating.')
    return
  }
  
  quickUpdateForm.value.processing = true
  
  const updateData = {
    status: quickUpdateForm.value.status,
    talent_pool: quickUpdateForm.value.talent_pool
  }
  
  router.post(`/hli-admin/career-applications/${quickUpdateForm.value.applicationId}/update-status`, updateData, {
    onSuccess: () => {
      quickUpdateForm.value.processing = false
      closeQuickUpdate()
      router.reload()
    },
    onError: (errors) => {
      quickUpdateForm.value.processing = false
      console.error('Quick update failed:', errors)
    }
  })
}

const deleteApplication = () => {
  if (selectedApplication.value) {
    router.delete(`/hli-admin/career-applications/${selectedApplication.value.id}`, {
      onSuccess: () => {
        closeDeleteModal()
      }
    })
  }
}

const clearSelection = () => {
  selectedApplications.value = []
  bulkStatus.value = ''
  bulkTalentPool.value = false
}

const applyBulkUpdate = () => {
  if (selectedApplications.value.length === 0) {
    return
  }

  if (!bulkStatus.value && !bulkTalentPool.value) {
    alert('Please select a status change or talent pool option')
    return
  }

  isProcessingBulk.value = true

  const updateData = {
    application_ids: selectedApplications.value,
    status: bulkStatus.value || null,
    talent_pool: bulkTalentPool.value
  }

  router.post('/hli-admin/career-applications/bulk-update', updateData, {
    onSuccess: () => {
      isProcessingBulk.value = false
      selectedApplications.value = []
      bulkStatus.value = ''
      bulkTalentPool.value = false
      router.reload()
    },
    onError: (errors) => {
      isProcessingBulk.value = false
      console.error('Bulk update failed:', errors)
    }
  })
}

const deleteSelectedApplications = () => {
  if (selectedApplications.value.length === 0) return

  isProcessingBulk.value = true

  router.post('/hli-admin/career-applications/bulk-delete', {
    application_ids: selectedApplications.value
  }, {
    onSuccess: () => {
      isProcessingBulk.value = false
      showBulkDeleteModal.value = false
      selectedApplications.value = []
      router.reload()
    },
    onError: (errors) => {
      isProcessingBulk.value = false
      console.error('Bulk delete failed:', errors)
    }
  })
}

const exportApplications = () => {
  // Create CSV content - note: this only exports current page
  // For full export, you'd need a separate endpoint
  const headers = ['Name', 'Email', 'Phone', 'Position', 'Education', 'Experience', 'Status', 'Applied Date', 'Notes']
  const csvContent = [
    headers.join(','),
    ...applications.value.map(app => [
      `"${app.full_name || ''}"`,
      `"${app.email || ''}"`,
      `"${app.phone_number || ''}"`,
      `"${app.applied_position || ''}"`,
      `"${getHighestEducation(app)}"`,
      `"${getCurrentExperience(app)}"`,
      `"${app.status || ''}"`,
      `"${formatDate(app.created_at)}"`,
      `"${app.notes || ''}"`
    ].join(','))
  ].join('\n')

  // Download CSV
  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' })
  const link = document.createElement('a')
  const url = URL.createObjectURL(blob)
  link.setAttribute('href', url)
  link.setAttribute('download', `career-applications-${new Date().toISOString().split('T')[0]}.csv`)
  link.style.visibility = 'hidden'
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}

// Utility functions
const getInitials = (name) => {
  if (!name) return '??'
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
}

const getHighestEducation = (application) => {
  if (!application.educations || application.educations.length === 0) {
    return 'Not specified'
  }
  
  // Sort by education level priority
  const sortedEducations = application.educations.sort((a, b) => {
    const levelOrder = { 's3': 7, 's2': 6, 's1': 5, 'd3-2': 4, 'd3-1': 3, 'smk2': 2, 'smk1': 1 }
    return (levelOrder[b.level] || 0) - (levelOrder[a.level] || 0)
  })
  
  const highest = sortedEducations[0]
  const levelDisplay = getEducationDisplay(highest.level)
  return `${levelDisplay}${highest.school_name ? ` - ${highest.school_name}` : ''}`
}

const getCurrentExperience = (application) => {
  if (!application.experiences || application.experiences.length === 0) {
    return 'No experience'
  }
  
  // Find current experience first, then most recent
  const currentExp = application.experiences.find(exp => exp.is_current)
  if (currentExp) {
    return `${currentExp.position} at ${currentExp.company_name}`
  }
  
  // If no current experience, get the most recent one
  const sortedExperiences = application.experiences.sort((a, b) => {
    const dateA = new Date(a.start_date || a.start_year || 0)
    const dateB = new Date(b.start_date || b.start_year || 0)
    return dateB - dateA
  })
  
  const recent = sortedExperiences[0]
  return `${recent.position} at ${recent.company_name}`
}

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


const formatDate = (date) => {
  if (!date) return 'N/A'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const formatStatus = (status) => {
  const statusMap = {
    'unread': 'Unread',
    'read': 'Read',
    'shortlisted': 'Shortlisted',
    'interview': 'Interview',
    'not_suitable': 'Not Suitable'
  }
  return statusMap[status] || status
}

const getStatusBadgeClasses = (status) => {
  const classes = {
    'unread': 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800',
    'read': 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800',
    'shortlisted': 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800',
    'interview': 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800',
    'not_suitable': 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800'
  }
  return classes[status] || 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800'
}

</script>
