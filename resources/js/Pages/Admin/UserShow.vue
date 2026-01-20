<template>
  <Head title="User Details - HLI Admin" />
  <AdminLayout 
    current-page="users" 
    title="User Details" 
    search-placeholder="Search..." 
    :user="currentUser"
  >
    <div class="max-w-4xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <Link
              href="/hli-admin/users"
              class="text-gray-500 hover:text-gray-700"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </Link>
            <div>
              <h2 class="text-xl font-semibold text-gray-800">User Details</h2>
              <p class="text-gray-600">View user information and account details</p>
            </div>
          </div>
          <div class="flex space-x-3">
            <Link
              :href="`/hli-admin/users/${user.id}/edit`"
              class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
            >
              <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              Edit User
            </Link>
            <button
              @click="deleteUser"
              :disabled="user.id === currentUser.id"
              class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Delete User
            </button>
          </div>
        </div>
      </div>

      <!-- Success/Error Messages -->
      <div v-if="$page.props.flash && $page.props.flash.success" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg relative">
        <button @click="closeFlashMessage" class="absolute top-2 right-2 text-green-600 hover:text-green-800">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        {{ $page.props.flash.success }}
      </div>
      <div v-if="$page.props.flash && $page.props.flash.error" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg relative">
        <button @click="closeFlashMessage" class="absolute top-2 right-2 text-red-600 hover:text-red-800">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        {{ $page.props.flash.error }}
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Information -->
        <div class="lg:col-span-2">
          <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">User Information</h3>
            
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
              <!-- Name -->
              <div>
                <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ user.name || 'N/A' }}</dd>
              </div>

              <!-- Email -->
              <div>
                <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ user.email || 'N/A' }}</dd>
              </div>

              <!-- Phone -->
              <div>
                <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ user.phone || 'N/A' }}</dd>
              </div>

              <!-- Position -->
              <div>
                <dt class="text-sm font-medium text-gray-500">Position</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ user.position || 'N/A' }}</dd>
              </div>

              <!-- Created Date -->
              <div>
                <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ formatDate(user.created_at) }}</dd>
              </div>
            </dl>

            <!-- Bio -->
            <div v-if="user.bio" class="mt-6">
              <dt class="text-sm font-medium text-gray-500">Bio</dt>
              <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ user.bio }}</dd>
            </div>
          </div>
        </div>

        <!-- User Summary -->
        <div class="space-y-6">
          <!-- User Avatar -->
          <div class="bg-white shadow-sm rounded-lg p-6 text-center">
            <div class="w-24 h-24 bg-[#4D9F95] rounded-full flex items-center justify-center mx-auto mb-4">
              <span class="text-white font-bold text-2xl">{{ user.name?.charAt(0)?.toUpperCase() || 'U' }}</span>
            </div>
            <h3 class="text-lg font-medium text-gray-900">{{ user.name || 'Unknown User' }}</h3>
            <p class="text-sm text-gray-500">{{ user.email || 'No email' }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ user.position || 'No position' }}</p>
          </div>

          <!-- Account Information -->
          <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Details</h3>
            <dl class="space-y-3">
              <div class="flex justify-between">
                <dt class="text-sm font-medium text-gray-500">User ID</dt>
                <dd class="text-sm text-gray-900 font-mono">#{{ user.id }}</dd>
              </div>
              <div class="flex justify-between">
                <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                <dd class="text-sm text-gray-900">{{ formatDate(user.created_at) }}</dd>
              </div>
              <div class="flex justify-between">
                <dt class="text-sm font-medium text-gray-500">Last Modified</dt>
                <dd class="text-sm text-gray-900">{{ formatDate(user.updated_at) }}</dd>
              </div>
            </dl>
          </div>

          <!-- Quick Actions -->
          <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
              <Link
                :href="`/hli-admin/users/${user.id}/edit`"
                class="flex items-center px-4 py-2 text-sm text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
              >
                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit User
              </Link>
              <button
                @click="deleteUser"
                :disabled="user.id === currentUser.id"
                class="flex items-center w-full px-4 py-2 text-sm text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <svg class="w-4 h-4 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete User
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  user: Object,
  currentUser: Object
})

const showFlashMessage = ref(true)

// Auto-close flash messages after 10 seconds
onMounted(() => {
  setTimeout(() => {
    showFlashMessage.value = false
  }, 10000)
})

const deleteUser = () => {
  if (props.user.id === props.currentUser.id) {
    alert('You cannot delete your own account.')
    return
  }
  
  if (confirm(`Are you sure you want to delete "${props.user.name}"? This action cannot be undone.`)) {
    router.delete(`/hli-admin/users/${props.user.id}`, {
      onSuccess: () => {
        router.visit('/hli-admin/users')
      }
    })
  }
}

const closeFlashMessage = () => {
  showFlashMessage.value = false
}

const formatDate = (date) => {
  if (!date) return 'N/A'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>
