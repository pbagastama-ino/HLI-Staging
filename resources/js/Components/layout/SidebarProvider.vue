<template>
  <slot />
</template>

<script setup>
import { useSidebarProvider } from '@/composables/useSidebar'

// Provide sidebar context to all child components
useSidebarProvider()
</script>
