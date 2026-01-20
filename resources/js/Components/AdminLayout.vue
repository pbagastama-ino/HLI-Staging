<template>
  <div class="min-h-screen bg-gray-50 admin-layout">
    <!-- Admin Layout -->
    <div class="flex">
      <!-- Sidebar -->
      <AdminSidebar :current-page="currentPage" />
      
      <!-- Main Content -->
      <div class="flex-1">
        <!-- Header -->
        <AdminHeader 
          :title="title" 
          :search-placeholder="searchPlaceholder"
          :user="user" 
        />
        
        <!-- Content -->
        <main class="p-6">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import AdminSidebar from './AdminSidebar.vue'
import AdminHeader from './AdminHeader.vue'

defineProps({
  currentPage: {
    type: String,
    default: 'dashboard'
  },
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
</script>

<style scoped>
/* Use system fonts in admin layout for better compatibility with rich text editors */
.admin-layout :deep(*) {
  font-family: system-ui, -apple-system, 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif !important;
}

/* Ensure bold text works properly in admin pages */
.admin-layout :deep(strong),
.admin-layout :deep(b),
.admin-layout :deep(.font-bold) {
  font-weight: 700 !important;
}
</style>