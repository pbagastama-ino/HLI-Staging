<template>
  <div class="w-64 bg-white shadow-lg h-screen">
    <div class="p-4">
      <img :src="logoUrl" alt="HLI Logo" class="h-12 w-auto mb-6" />
      <nav class="space-y-2"> 
        <!-- Dashboard -->
        <a 
          href="/hli-admin/dashboard" 
          :class="[
            'flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors',
            currentPage === 'dashboard' 
              ? 'text-white bg-[#4D9F95]' 
              : 'text-gray-700 hover:bg-gray-100'
          ]"
        >
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6a2 2 0 01-2 2H10a2 2 0 01-2-2V5z" />
          </svg>
          Dashboard
        </a>

        <!-- Career Settings (Collapsible) -->
        <div>
          <button 
            @click="toggleCareerSettings"
            :class="[
              'flex items-center justify-between w-full px-3 py-2 text-sm font-medium rounded-lg transition-colors',
              isCareerSettingsOpen || isCareerSettingsActive
                ? 'text-white bg-[#4D9F95]' 
                : 'text-gray-700 hover:bg-gray-100'
            ]"
          >
            <div class="flex items-center">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              Career Settings
            </div>
            <svg 
              class="w-4 h-4 transition-transform duration-200"
              :class="{ 'rotate-180': isCareerSettingsOpen }"
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          
          <!-- Submenu -->
          <div 
            v-show="isCareerSettingsOpen"
            class="ml-6 mt-2 space-y-1"
          >
            <!-- Department Category -->
            <!-- <a 
              href="/hli-admin/departments" 
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors',
                currentPage === 'departments' 
                  ? 'text-white bg-[#4D9F95]' 
                  : 'text-gray-600 hover:bg-gray-100'
              ]"
            >
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
              Department Category
            </a> -->
            
            <!-- Vacancy -->
            <a 
              href="/hli-admin/vacancies" 
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors',
                currentPage === 'vacancies' 
                  ? 'text-white bg-[#4D9F95]' 
                  : 'text-gray-600 hover:bg-gray-100'
              ]"
            >
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6" />
              </svg>
              Vacancy
            </a>
            
            <!-- Applicants List -->
            <a 
              href="/hli-admin/career-applications" 
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors',
                currentPage === 'career-applications' 
                  ? 'text-white bg-[#4D9F95]' 
                  : 'text-gray-600 hover:bg-gray-100'
              ]"
            >
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              Applicants List
            </a>
            
            <!-- Talent Pool -->
            <a 
              href="/hli-admin/talent-pool" 
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors',
                currentPage === 'talent-pool' 
                  ? 'text-white bg-[#4D9F95]' 
                  : 'text-gray-600 hover:bg-gray-100'
              ]"
            >
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              Talent Pool
            </a>
          </div>
        </div>

        <!-- Publications -->
        <a 
          href="/hli-admin/publications" 
          :class="[
            'flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors',
            currentPage === 'publications' 
              ? 'text-white bg-[#4D9F95]' 
              : 'text-gray-700 hover:bg-gray-100'
          ]"
        >
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
          </svg>
          Publications
        </a>

        <!-- Page Settings (Collapsible) -->
        <div>
          <button 
            @click="togglePageSettings"
            :class="[
              'flex items-center justify-between w-full px-3 py-2 text-sm font-medium rounded-lg transition-colors',
              isPageSettingsOpen || isPageSettingsActive
                ? 'text-white bg-[#4D9F95]' 
                : 'text-gray-700 hover:bg-gray-100'
            ]"
          >
            <div class="flex items-center">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              Page Settings
            </div>
            <svg 
              class="w-4 h-4 transition-transform duration-200"
              :class="{ 'rotate-180': isPageSettingsOpen }"
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          
          <!-- Submenu -->
          <div 
            v-show="isPageSettingsOpen"
            class="ml-6 mt-2 space-y-1"
          >
            <!-- Contact Submissions -->
            <a 
              href="/hli-admin/contact-submissions" 
              :class="[
                'flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors',
                currentPage === 'contact-submissions' 
                  ? 'text-white bg-[#4D9F95]' 
                  : 'text-gray-600 hover:bg-gray-100'
              ]"
            >
              <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              Contact Submissions
            </a>
          </div>
        </div>

        <!-- Users -->
        <a 
          href="/hli-admin/users" 
          :class="[
            'flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors',
            currentPage === 'users' 
              ? 'text-white bg-[#4D9F95]' 
              : 'text-gray-700 hover:bg-gray-100'
          ]"
        >
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
          </svg>
          Users
        </a>
      </nav>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import logoUrl from '@/assets/hligp-logo.png'

const props = defineProps({
  currentPage: {
    type: String,
    default: 'dashboard'
  }
})

// Career Settings submenu state
const isCareerSettingsOpen = ref(false)

// Page Settings submenu state
const isPageSettingsOpen = ref(false)

// Check if any career settings page is active
const isCareerSettingsActive = computed(() => {
  return ['departments', 'vacancies', 'career-applications', 'talent-pool'].includes(props.currentPage)
})

// Check if any page settings page is active
const isPageSettingsActive = computed(() => {
  return ['contact-submissions'].includes(props.currentPage)
})

// Toggle career settings submenu
const toggleCareerSettings = () => {
  isCareerSettingsOpen.value = !isCareerSettingsOpen.value
}

// Toggle page settings submenu
const togglePageSettings = () => {
  isPageSettingsOpen.value = !isPageSettingsOpen.value
}

// Auto-open submenu if current page is in career settings
if (isCareerSettingsActive.value) {
  isCareerSettingsOpen.value = true
}

// Auto-open submenu if current page is in page settings
if (isPageSettingsActive.value) {
  isPageSettingsOpen.value = true
}
</script>