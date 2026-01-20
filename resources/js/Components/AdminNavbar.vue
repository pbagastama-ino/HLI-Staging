<template>
  <header class="bg-white shadow-sm border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
      <!-- Left side - Mobile menu button and search -->
      <div class="flex items-center">
        <!-- Mobile menu button -->
        <button
          @click="toggleSidebar"
          class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#4D9F95] lg:hidden"
        >
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        
        <!-- Search bar -->
        <div class="relative ml-4 hidden md:block">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <input
            type="search"
            placeholder="Search..."
            class="block w-80 pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#4D9F95] focus:border-[#4D9F95] text-sm"
          />
        </div>
      </div>

      <!-- Right side - Notifications and user menu -->
      <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95]">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM11.613 15.932c-.967-.967-.967-2.533 0-3.5l.707-.707c.967-.967 2.533-.967 3.5 0l.707.707c.967.967.967 2.533 0 3.5l-.707.707c-.967.967-2.533.967-3.5 0l-.707-.707z" />
          </svg>
          <!-- Notification badge -->
          <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-400"></span>
        </button>

        <!-- User menu -->
        <div class="relative">
          <button
            @click="toggleUserMenu"
            class="flex items-center space-x-3 p-2 text-sm rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#4D9F95]"
          >
            <div class="w-8 h-8 bg-[#4D9F95] rounded-full flex items-center justify-center">
              <span class="text-white font-medium text-sm">A</span>
            </div>
            <div class="hidden md:block text-left">
              <p class="text-sm font-medium text-gray-700">Admin User</p>
              <p class="text-xs text-gray-500">admin@hligreenpower.com</p>
            </div>
            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- User dropdown menu -->
          <div
            v-show="showUserMenu"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
            @click.away="showUserMenu = false"
          >
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
            <div class="border-t border-gray-100"></div>
            <button
              @click="logout"
              class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            >
              Sign out
            </button>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const showUserMenu = ref(false)

const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value
}

const toggleSidebar = () => {
  // Emit event for parent component to handle sidebar toggle
  // This will be handled by the parent component
}

const logout = () => {
  router.post('/logout')
}
</script>
</template>

