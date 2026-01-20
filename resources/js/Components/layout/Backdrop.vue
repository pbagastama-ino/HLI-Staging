<template>
  <div
    v-if="isMobileOpen"
    @click="toggleMobileSidebar"
    class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
  ></div>
</template>

<script setup>
import { useSidebar } from '@/composables/useSidebar'

const { isMobileOpen, toggleMobileSidebar } = useSidebar()
</script>
