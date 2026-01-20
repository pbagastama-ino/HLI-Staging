<template>
  <Head title="Change Password - HLI Admin" />
  <AdminLayout 
    current-page="change-password" 
    title="Change Password" 
    search-placeholder="Search..." 
    :user="user"
  >
    <div class="max-w-2xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
        <div class="flex items-center space-x-3">
          <Link
            href="/hli-admin/profile"
            class="text-gray-500 hover:text-gray-700"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </Link>
          <div>
            <h2 class="text-xl font-semibold text-gray-800">Change Password</h2>
            <p class="text-gray-600">Update your account password</p>
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

      <!-- Validation Error Messages -->
      <div v-if="hasErrors" class="mb-4 p-4 bg-red-50 border border-red-300 text-red-800 rounded-lg">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div class="flex-1">
            <h3 class="font-semibold mb-2">Please fix the following errors:</h3>
            <ul class="list-disc list-inside space-y-1 text-sm">
              <li v-for="(error, field) in form.errors" :key="field">
                <span v-if="Array.isArray(error)">{{ error[0] }}</span>
                <span v-else>{{ error }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Password Change Form -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <form @submit.prevent="changePassword" class="space-y-6">
          <!-- Current Password -->
          <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
              Current Password <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input
                id="current_password"
                v-model="form.current_password"
                :type="showCurrentPassword ? 'text' : 'password'"
                required
                class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                :class="{ 'border-red-500': form.errors.current_password }"
                placeholder="Enter your current password"
              />
              <button
                type="button"
                @click="showCurrentPassword = !showCurrentPassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center"
              >
                <svg v-if="showCurrentPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
                <svg v-else class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
            <p v-if="form.errors.current_password" class="mt-1 text-sm text-red-600">{{ form.errors.current_password }}</p>
          </div>

          <!-- New Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
              New Password <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input
                id="password"
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                required
                class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                :class="{ 'border-red-500': form.errors.password }"
                placeholder="Enter your new password"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center"
              >
                <svg v-if="showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
                <svg v-else class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
            <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
            <div class="mt-2">
              <div class="text-xs text-gray-500">
                Password must be at least 8 characters long and contain:
              </div>
              <ul class="text-xs text-gray-500 mt-1 space-y-1">
                <li :class="passwordChecks.length ? 'text-green-600' : 'text-gray-500'">
                  ✓ At least 8 characters
                </li>
                <li :class="passwordChecks.uppercase ? 'text-green-600' : 'text-gray-500'">
                  ✓ One uppercase letter
                </li>
                <li :class="passwordChecks.lowercase ? 'text-green-600' : 'text-gray-500'">
                  ✓ One lowercase letter
                </li>
                <li :class="passwordChecks.number ? 'text-green-600' : 'text-gray-500'">
                  ✓ One number
                </li>
              </ul>
            </div>
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
              Confirm New Password <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input
                id="password_confirmation"
                v-model="form.password_confirmation"
                :type="showConfirmPassword ? 'text' : 'password'"
                required
                class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                :class="{ 'border-red-500': form.errors.password_confirmation }"
                placeholder="Confirm your new password"
              />
              <button
                type="button"
                @click="showConfirmPassword = !showConfirmPassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center"
              >
                <svg v-if="showConfirmPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
                <svg v-else class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
            <p v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
            <p v-if="form.password && form.password_confirmation && form.password !== form.password_confirmation" class="mt-1 text-sm text-red-600">
              Passwords do not match
            </p>
          </div>

          <!-- Form Actions -->
          <div class="flex justify-end space-x-3">
            <Link
              href="/hli-admin/profile"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
            >
              Cancel
            </Link>
            <button
              type="submit"
              :disabled="processing || !isFormValid"
              class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95] disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span v-if="processing" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Changing...
              </span>
              <span v-else>Change Password</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  user: Object
})

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: ''
})

const processing = form.processing
const showFlashMessage = ref(true)

// Check if there are any validation errors - access form.errors directly to ensure reactivity
const hasErrors = computed(() => {
  const errorKeys = Object.keys(form.errors || {})
  console.log('hasErrors computed - errorKeys:', errorKeys, 'length:', errorKeys.length)
  return errorKeys.length > 0
})

const showCurrentPassword = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)

// Auto-close flash messages after 10 seconds
onMounted(() => {
  setTimeout(() => {
    showFlashMessage.value = false
  }, 10000)
})

const passwordChecks = computed(() => {
  const password = form.password
  return {
    length: password.length >= 8,
    uppercase: /[A-Z]/.test(password),
    lowercase: /[a-z]/.test(password),
    number: /\d/.test(password)
  }
})

const isFormValid = computed(() => {
  return form.current_password && 
         form.password && 
         form.password_confirmation &&
         form.password === form.password_confirmation &&
         Object.values(passwordChecks.value).every(check => check)
})

// Refresh CSRF token
const refreshCsrfToken = async () => {
  try {
    const response = await fetch('/csrf-token', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      }
    })
    if (response.ok) {
      const data = await response.json()
      // Update the meta tag
      const metaTag = document.querySelector('meta[name="csrf-token"]')
      if (metaTag) {
        metaTag.setAttribute('content', data.csrf_token)
      }
      return data.csrf_token
    }
  } catch (error) {
    console.error('Failed to refresh CSRF token:', error)
  }
  return null
}

const changePassword = async () => {
  // First, ensure we have a fresh CSRF token
  await refreshCsrfToken()
  
  form.post('/hli-admin/change-password', {
    preserveScroll: true,
    onError: (formErrors) => {
      console.log('Form errors:', formErrors)
      console.log('form.errors:', form.errors)
      console.log('hasErrors:', hasErrors.value)
      // The error object might contain different structures
      // Check various possible error formats
      const errorMessage = formErrors?.message || formErrors?.error || ''
      const statusCode = formErrors?.status || ''
      
      // If it's a CSRF token error, handle it separately
      if (statusCode === 419 || errorMessage.includes('419') || errorMessage.includes('CSRF')) {
        // Refresh CSRF token and retry
        refreshCsrfToken().then(() => {
          // Small delay to ensure token is updated
          setTimeout(() => {
            form.post('/hli-admin/change-password', {
              preserveScroll: true,
              onSuccess: () => {
                form.reset()
              },
              onError: (retryErrors) => {
                // If there are validation errors after retry, they will be displayed
                console.log('Retry errors:', retryErrors)
                console.log('form.errors after retry:', form.errors)
              }
            })
          }, 100)
        }).catch(() => {
          // If refresh fails, reload the page to get a fresh token
          alert('Your session has expired. Please refresh the page and try again.')
          window.location.reload()
        })
      }
      // Validation errors (like incorrect current password) will be automatically
      // displayed by Inertia through the form.errors object
    },
    onSuccess: () => {
      // Clear form on success
      form.reset()
    }
  })
}

const closeFlashMessage = () => {
  showFlashMessage.value = false
}
</script>
