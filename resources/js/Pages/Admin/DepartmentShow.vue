<template>
  <Head title="Department Details - HLI Admin" />
  <AdminLayout 
    current-page="departments" 
    title="Department Details" 
    search-placeholder="Search..." 
    :user="user"
  >
    <div class="max-w-4xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
          <Link
            href="/hli-admin/departments"
            class="text-gray-500 hover:text-gray-700"
          >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </Link>
            <div>
              <h2 class="text-xl font-semibold text-gray-800">{{ department.name }}</h2>
              <p class="text-gray-600">Department Details</p>
            </div>
          </div>
          <div class="flex space-x-3">
            <Link
              :href="`/hli-admin/departments/${department.id}/edit`"
              class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
            >
              <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Edit Department
            </Link>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Department Information -->
        <div class="lg:col-span-2">
          <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Department Information</h3>
            
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <div>
                <dt class="text-sm font-medium text-gray-500">Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ department.name }}</dd>
              </div>
              
              <div>
                <dt class="text-sm font-medium text-gray-500">Code</dt>
                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ department.code }}</dd>
              </div>
              
              <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-gray-500">Description</dt>
                <dd class="mt-1 text-sm text-gray-900">
                  {{ department.description || 'No description provided' }}
                </dd>
              </div>
              
              <div>
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1">
                  <span
                    :class="[
                      'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                      department.is_active
                        ? 'bg-green-100 text-green-800'
                        : 'bg-red-100 text-red-800'
                    ]"
                  >
                    {{ department.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </dd>
              </div>
              
              <div>
                <dt class="text-sm font-medium text-gray-500">Sort Order</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ department.sort_order }}</dd>
              </div>
              
              <div>
                <dt class="text-sm font-medium text-gray-500">Created</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ formatDate(department.created_at) }}</dd>
              </div>
              
              <div>
                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ formatDate(department.updated_at) }}</dd>
              </div>
            </dl>
          </div>

          <!-- Associated Jobs -->
          <div v-if="department.jobs && department.jobs.length > 0" class="mt-6 bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Associated Jobs</h3>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="job in department.jobs" :key="job.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900">{{ job.title }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        :class="[
                          'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                          job.status === 'published'
                            ? 'bg-green-100 text-green-800'
                            : job.status === 'draft'
                            ? 'bg-yellow-100 text-yellow-800'
                            : 'bg-gray-100 text-gray-800'
                        ]"
                      >
                        {{ job.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ formatDate(job.created_at) }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
          <!-- Quick Actions -->
          <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
              <button
                @click="toggleStatus"
                :class="[
                  'w-full px-4 py-2 text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2',
                  department.is_active
                    ? 'text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:ring-yellow-500'
                    : 'text-green-700 bg-green-100 hover:bg-green-200 focus:ring-green-500'
                ]"
              >
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path v-if="department.is_active" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                  <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ department.is_active ? 'Deactivate' : 'Activate' }} Department
              </button>
              
              <button
                @click="deleteDepartment"
                class="w-full px-4 py-2 text-sm font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                :disabled="department.job_count > 0"
              >
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Department
              </button>
            </div>
          </div>

          <!-- Statistics -->
          <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistics</h3>
            <dl class="space-y-3">
              <div class="flex justify-between">
                <dt class="text-sm font-medium text-gray-500">Total Jobs</dt>
                <dd class="text-sm text-gray-900">{{ department.job_count || 0 }}</dd>
              </div>
              <div class="flex justify-between">
                <dt class="text-sm font-medium text-gray-500">Active Jobs</dt>
                <dd class="text-sm text-gray-900">{{ department.active_job_count || 0 }}</dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  department: Object,
  user: Object
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const toggleStatus = () => {
  if (confirm(`Are you sure you want to ${props.department.is_active ? 'deactivate' : 'activate'} this department?`)) {
    router.patch(`/hli-admin/departments/${props.department.id}/toggle-status`, {}, {
      onSuccess: () => {
        // The page will refresh with updated data
      }
    })
  }
}

const deleteDepartment = () => {
  if (props.department.job_count > 0) {
    alert('Cannot delete department that has associated jobs.')
    return
  }
  
  if (confirm(`Are you sure you want to delete "${props.department.name}"? This action cannot be undone.`)) {
    router.delete(`/hli-admin/departments/${props.department.id}`, {
      onSuccess: () => {
        router.visit('/hli-admin/departments')
      }
    })
  }
}
</script>
