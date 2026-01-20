<template>
  <Transition name="fade-slide">
    <button
      v-show="showScrollToTop"
      @click="scrollToTop"
      class="scroll-to-top-btn fixed z-50 bottom-4 right-4 sm:bottom-8 sm:right-8 h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 rounded-2xl flex items-center justify-center text-white transition-all duration-300 shadow-xl cursor-pointer hover:scale-[1.1] active:scale-95 hover:shadow-[0_0_35px_5px_rgba(77,158,149,0.5)]"
      aria-label="Scroll to top"
    >
      <Icon icon="basil:arrow-up-outline" class="h-7 w-7 sm:h-8 sm:w-8" />
    </button>
  </Transition>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Icon } from '@iconify/vue';

const showScrollToTop = ref(false);

const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

const checkScrollPosition = () => {
  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  showScrollToTop.value = scrollTop > 100;
};

onMounted(() => {
  window.addEventListener('scroll', checkScrollPosition);
  // Check initial position
  checkScrollPosition();
});

onUnmounted(() => {
  window.removeEventListener('scroll', checkScrollPosition);
});
</script>

<style scoped>
/* Scroll to Top Button - Dark Glassmorphism (works on all backgrounds) */
.scroll-to-top-btn {
  background: linear-gradient(
    -135deg,
    rgba(55, 55, 55, 0.9) 0%,
    rgba(40, 40, 40, 0.95) 50%,
    rgba(30, 30, 30, 0.9) 100%
  );
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 
    0 8px 32px rgba(0, 0, 0, 0.25),
    inset 0 1px 0 rgba(255, 255, 255, 0.1),
    inset 0 -1px 0 rgba(0, 0, 0, 0.2);
}

/* Hover - Gradient Lavender Purple to Glacial Minter with Glass effect */
.scroll-to-top-btn:hover {
  background: linear-gradient(
    135deg,
    rgba(160, 175, 246, 0.6) 0%,
    rgba(122, 202, 179, 0.6) 100%
  );
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 
    0 0 35px 5px rgba(77, 158, 149, 0.5),
    inset 0 1px 0 rgba(255, 255, 255, 0.4),
    inset 0 -1px 0 rgba(0, 0, 0, 0.1);
}

/* Transition animations */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(16px);
}
</style>
