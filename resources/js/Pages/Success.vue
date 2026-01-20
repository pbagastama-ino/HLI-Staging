<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-8 sm:py-12">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-6 sm:p-8 text-center">
      <div class="mb-4 sm:mb-6">
        <div class="mx-auto flex items-center justify-center h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-green-100">
          <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
      </div>
      
      <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 sm:mb-4">Application Submitted!</h1>
      
      <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6 px-2">
        Thank you for your interest in joining HLI Green Power. We have received your application and will review it carefully.
      </p>
      
      <div class="space-y-2 sm:space-y-3">
        <a 
          href="/" 
          class="w-full bg-[#59C3B4] text-white py-2.5 sm:py-3 px-4 rounded-md hover:bg-[#4a9d8f] transition-colors duration-200 inline-block text-sm sm:text-base"
        >
          Return to Homepage
        </a>
        
        <a 
          href="/career" 
          class="w-full bg-gray-200 text-gray-800 py-2.5 sm:py-3 px-4 rounded-md hover:bg-gray-300 transition-colors duration-200 inline-block text-sm sm:text-base"
        >
          View Other Positions
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'

Head({
  title: 'Application Submitted - HLI Green Power'
})
</script>
