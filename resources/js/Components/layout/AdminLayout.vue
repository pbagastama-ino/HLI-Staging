<template>
  <SidebarProvider>
    <AdminLayoutContent>
      <slot></slot>
    </AdminLayoutContent>
  </SidebarProvider>
</template>

<script setup>
import { defineComponent } from 'vue'
import AppSidebar from './AppSidebar.vue'
import AppHeader from './AppHeader.vue'
import Backdrop from './Backdrop.vue'
import SidebarProvider from './SidebarProvider.vue'
import { useSidebar } from '@/composables/useSidebar'

const AdminLayoutContent = defineComponent({
  components: {
    AppSidebar,
    AppHeader,
    Backdrop
  },
  setup(_, { slots }) {
    const { isExpanded, isHovered } = useSidebar()
    return { isExpanded, isHovered, slots }
  },
  template: `
    <div class="min-h-screen flex">
      <app-sidebar />
      <Backdrop />
      <div
        class="flex-1 transition-all duration-300 ease-in-out"
        :class="[isExpanded || isHovered ? 'lg:ml-[290px]' : 'lg:ml-[90px]']"
      >
        <app-header />
        <div class="p-4 mx-auto max-w-7xl md:p-6">
          <slot></slot>
        </div>
      </div>
    </div>
  `
})
</script>
