<template>
  <div class="min-h-screen flex flex-col bg-white">
    <Navbar />
    <Transition
      name="page"
      mode="out-in"
    >
      <main :key="$page.url" class="flex-1">
        <slot />
      </main>
    </Transition>
    <Footer />
    
    <!-- Global Scroll to Top Button -->
    <ScrollToTopButton />
  </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'
import ScrollToTopButton from '@/Components/ScrollToTopButton.vue'
</script>

<style scoped>
.page-enter-active,
.page-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.page-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.page-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>


