<template>
  <Head title="Message Sent - HLI Green Power" />

  <div class="relative min-h-screen bg-white text-gray-900 pt-24 sm:pt-32 md:pt-40 lg:pt-[144px]">
    <div class="container mx-auto max-w-6xl px-4 sm:px-6 md:px-8">
      <div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-gray-900 mb-3 sm:mb-4 pt-8 sm:pt-12 md:pt-15">Message Sent!</h1>
        <p class="text-base sm:text-lg text-gray-600">
          We'll contact you soon.
        </p>
      </div>

      <div class="flex justify-end mt-8 sm:mt-12 md:mt-16">
        <Link
          href="/"
          class="inline-flex items-center gap-x-2 sm:gap-x-3 rounded-full px-6 sm:px-8 md:px-12 py-2.5 sm:py-3 text-sm sm:text-base font-semibold text-white shadow-sm transition-colors duration-300 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] hover:opacity-90"
        >
          HOME
          <span class="flex h-6 w-6 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-white sm:ml-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#8aa7a2" class="h-5 w-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
          </span>
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({
  layout: AppLayout,
})
</script>