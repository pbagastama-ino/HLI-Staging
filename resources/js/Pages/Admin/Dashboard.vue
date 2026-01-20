<template>
  <Head title="Dashboard - HLI Admin" />
  <AdminLayout 
    current-page="dashboard" 
    title="Dashboard" 
    search-placeholder="Search..." 
    :user="user"
  >
    <div class="mb-6">
      <h2 class="text-xl font-semibold text-gray-800">Welcome to HLI Green Power Admin Dashboard</h2>
      <p class="text-gray-600">Manage your green energy</p>
    </div>
    
  </AdminLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

defineProps({
  user: Object
})
</script>

