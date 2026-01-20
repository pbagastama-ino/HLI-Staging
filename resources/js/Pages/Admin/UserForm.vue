<template>
  <Head :title="`${mode === 'create' ? 'Add New User' : 'Edit User'} - HLI Admin`" />
  <AdminLayout 
    :current-page="mode === 'create' ? 'users' : 'users'" 
    :title="mode === 'create' ? 'Add New User' : 'Edit User'" 
    search-placeholder="Search..." 
    :user="currentUser"
  >
    <div class="max-w-4xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
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
            <h2 class="text-xl font-semibold text-gray-800">
              {{ mode === 'create' ? 'Add New User' : 'Edit User' }}
            </h2>
            <p class="text-gray-600">
              {{ mode === 'create' ? 'Create a new user account' : 'Update user information' }}
            </p>
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

      <!-- User Form -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <form @submit.prevent="submitForm" class="space-y-6">
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
                placeholder="Enter full name"
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
                placeholder="Enter email address"
              />
              <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
            </div>
          </div>

          <!-- Password (only for create mode) -->
          <div v-if="mode === 'create'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Password -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Password <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input
                  id="password"
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  required
                  class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                  :class="{ 'border-red-500': errors.password }"
                  placeholder="Enter password"
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
              <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</p>
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
                Confirm Password <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  required
                  class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                  :class="{ 'border-red-500': errors.password_confirmation }"
                  placeholder="Confirm password"
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
              <p v-if="errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ errors.password_confirmation }}</p>
              <p v-if="form.password && form.password_confirmation && form.password !== form.password_confirmation" class="mt-1 text-sm text-red-600">
                Passwords do not match
              </p>
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
                placeholder="Enter phone number"
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
                placeholder="Enter position"
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
              placeholder="Tell us about this user"
            ></textarea>
            <p v-if="errors.bio" class="mt-1 text-sm text-red-600">{{ errors.bio }}</p>
          </div>

          <!-- Form Actions -->
          <div class="flex justify-end space-x-3">
            <Link
              href="/hli-admin/users"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
            >
              Cancel
            </Link>
            <button
              type="submit"
              :disabled="processing || (mode === 'create' && !isFormValid)"
              class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95] disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span v-if="processing" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ mode === 'create' ? 'Creating...' : 'Updating...' }}
              </span>
              <span v-else>{{ mode === 'create' ? 'Create User' : 'Update User' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  user: Object,
  mode: String, // 'create' or 'edit'
  currentUser: Object
})

const form = useForm({
  name: props.user?.name || '',
  email: props.user?.email || '',
  password: '',
  password_confirmation: '',
  phone: props.user?.phone || '',
  position: props.user?.position || '',
  bio: props.user?.bio || ''
})

const processing = form.processing
const errors = form.errors
const showFlashMessage = ref(true)

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
  return form.name && 
         form.email && 
         form.password && 
         form.password_confirmation &&
         form.password === form.password_confirmation &&
         Object.values(passwordChecks.value).every(check => check)
})

const submitForm = () => {
  if (props.mode === 'create') {
    form.post('/hli-admin/users')
  } else {
    form.put(`/hli-admin/users/${props.user.id}`)
  }
}

const closeFlashMessage = () => {
  showFlashMessage.value = false
}
</script>
