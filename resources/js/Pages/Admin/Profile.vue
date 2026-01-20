<template>
  <Head title="My Profile - HLI Admin" />
  <AdminLayout 
    current-page="profile" 
    title="My Profile" 
    search-placeholder="Search..." 
    :user="user"
  >
    <div class="max-w-4xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">My Profile</h2>
        <p class="text-gray-600">Manage your personal information</p>
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
        <!-- Profile Information -->
        <div class="lg:col-span-2">
          <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Information</h3>
            
            <form @submit.prevent="updateProfile" class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                  </label>
                  <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                    :class="{ 'border-red-500': errors.name }"
                    placeholder="Enter your full name"
                  />
                  <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                </div>

                <!-- Email -->
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                  </label>
                  <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                    :class="{ 'border-red-500': errors.email }"
                    placeholder="Enter your email"
                  />
                  <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phone -->
                <div>
                  <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Phone Number
                  </label>
                  <input
                    id="phone"
                    v-model="form.phone"
                    type="tel"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                    :class="{ 'border-red-500': errors.phone }"
                    placeholder="Enter your phone number"
                  />
                  <p v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ errors.phone }}</p>
                </div>

                <!-- Position -->
                <div>
                  <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                    Position
                  </label>
                  <input
                    id="position"
                    v-model="form.position"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                    :class="{ 'border-red-500': errors.position }"
                    placeholder="Enter your position"
                  />
                  <p v-if="errors.position" class="mt-1 text-sm text-red-600">{{ errors.position }}</p>
                </div>
              </div>

              <!-- Bio -->
              <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                  Bio
                </label>
                <textarea
                  id="bio"
                  v-model="form.bio"
                  rows="4"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                  :class="{ 'border-red-500': errors.bio }"
                  placeholder="Tell us about yourself"
                ></textarea>
                <p v-if="errors.bio" class="mt-1 text-sm text-red-600">{{ errors.bio }}</p>
              </div>

              <!-- Form Actions -->
              <div class="flex justify-end space-x-3">
                <button
                  type="button"
                  @click="resetForm"
                  class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
                >
                  Reset
                </button>
                <button
                  type="submit"
                  :disabled="processing"
                  class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95] disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="processing" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Updating...
                  </span>
                  <span v-else>Update Profile</span>
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Profile Summary -->
        <div class="space-y-6">
          <!-- Profile Avatar -->
          <div class="bg-white shadow-sm rounded-lg p-6 text-center">
            <div class="w-24 h-24 bg-[#4D9F95] rounded-full flex items-center justify-center mx-auto mb-4">
              <span class="text-white font-bold text-2xl">{{ user?.name?.charAt(0)?.toUpperCase() || 'A' }}</span>
            </div>
            <h3 class="text-lg font-medium text-gray-900">{{ user?.name || 'Admin User' }}</h3>
            <p class="text-sm text-gray-500">{{ user?.email || 'admin@hligreenpower.com' }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ user?.position || 'Administrator' }}</p>
          </div>

          <!-- Account Information -->
          <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
            <dl class="space-y-3">
              <div class="flex justify-between">
                <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                <dd class="text-sm text-gray-900">{{ formatDate(user?.created_at) }}</dd>
              </div>
              <div class="flex justify-between">
                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                <dd class="text-sm text-gray-900">{{ formatDate(user?.updated_at) }}</dd>
              </div>
              <div class="flex justify-between">
                <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
                <dd class="text-sm text-gray-900">
                  <span :class="user?.email_verified_at ? 'text-green-600' : 'text-red-600'">
                    {{ user?.email_verified_at ? 'Verified' : 'Not Verified' }}
                  </span>
                </dd>
              </div>
            </dl>
          </div>

          <!-- Quick Actions -->
          <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
              <Link
                href="/hli-admin/change-password"
                class="flex items-center px-4 py-2 text-sm text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
              >
                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
                Change Password
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  user: Object
})

const form = useForm({
  name: props.user?.name || '',
  email: props.user?.email || '',
  phone: props.user?.phone || '',
  position: props.user?.position || '',
  bio: props.user?.bio || ''
})

const processing = form.processing
const errors = form.errors
const showFlashMessage = ref(true)

// Auto-close flash messages after 10 seconds
onMounted(() => {
  setTimeout(() => {
    showFlashMessage.value = false
  }, 10000)
})

const updateProfile = () => {
  form.put('/hli-admin/profile')
}

const resetForm = () => {
  form.reset()
}

const closeFlashMessage = () => {
  showFlashMessage.value = false
}

const formatDate = (date) => {
  if (!date) return 'N/A'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>
