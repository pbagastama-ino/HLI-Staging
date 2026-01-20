<template>
  <header class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-6 py-4 flex items-center justify-between">
      <h1 class="text-2xl font-semibold text-gray-800">{{ title }}</h1>
      <div class="flex items-center space-x-4">
        <!-- Search -->
        <div class="relative">
          <input 
            type="search" 
            :placeholder="searchPlaceholder" 
            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-[#4D9F95]"
          />
          <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        
        <!-- User Profile Dropdown -->
        <div class="relative" ref="dropdownRef">
          <button 
            @click="toggleDropdown"
            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors"
          >
            <div class="w-8 h-8 bg-[#4D9F95] rounded-full flex items-center justify-center">
              <span class="text-white font-medium text-sm">{{ user?.name?.charAt(0)?.toUpperCase() || 'A' }}</span>
            </div>
            <div class="text-left">
              <p class="text-sm font-medium text-gray-700">{{ user?.name || 'Admin User' }}</p>
              <p class="text-xs text-gray-500">{{ user?.email || 'admin@hligreenpower.com' }}</p>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          
          <!-- Dropdown Menu -->
          <div 
            v-if="showDropdown"
            class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
          >
            <Link
              href="/hli-admin/profile"
              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
            >
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              My Profile
            </Link>
            
            <Link
              href="/hli-admin/users"
              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
            >
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
              </svg>
              Manage Users
            </Link>
            
            <Link
              href="/hli-admin/change-password"
              class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
            >
              <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
              </svg>
              Change Password
            </Link>
            
            <div class="border-t border-gray-100 my-1"></div>
            
            <a 
              href="/logout"
              class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50"
            >
              <svg class="w-4 h-4 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              Logout
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

defineProps({
  title: {
    type: String,
    required: true
  },
  searchPlaceholder: {
    type: String,
    default: 'Search...'
  },
  user: {
    type: Object,
    required: true
  }
})

const showDropdown = ref(false)
const dropdownRef = ref(null)

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value
}

const closeDropdown = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    showDropdown.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', closeDropdown)
})

onUnmounted(() => {
  document.removeEventListener('click', closeDropdown)
})

function logout() {
  // Use GET logout to avoid CSRF token issues
  window.location.href = '/logout';
}
</script>
