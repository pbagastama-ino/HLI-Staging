<template>
  <nav 
    class="w-full fixed top-0 z-50 transition-all duration-200 ease-out"
    :class="{ 
      'bg-transparent': isNavTransparent && !isMenuOpen, 
      'bg-white/95 backdrop-blur-sm shadow-lg': !isNavTransparent && !isMenuOpen,
      'bg-[#4D9F95]/70 backdrop-blur-sm': !isNavTransparent && isMenuOpen,
      'bg-[#4D9F95]/70 backdrop-blur-sm': !isNavTransparent && !isMenuOpen
    }"
  >
    <div class="max-w-full h-20 md:h-24 relative mx-auto px-4 sm:px-6 lg:px-2 xl:px-32 flex justify-between items-center">
      <Link :href="getLocalizedUrl('/')" class="flex-shrink-0" @click="closeMenu">
        <img v-if="!isNavTransparent && !isMenuOpen" class="w-36 lg:w-52" :src="logoColor" alt="HLI Green Power Logo" />
        <img v-else class="w-36 lg:w-52" :src="logoWhite" alt="HLI Green Power Logo White" />
      </Link>

      <ul v-if="!isMenuOpen" class="hidden lg:flex gap-8 text-lg font-normal flex-1 justify-center transition-colors duration-200" :class="isNavTransparent ? 'text-white' : 'text-black'">
        <li v-for="link in navLinks" :key="link.name" class="relative" @mouseenter="handleMouseEnter(link.name)" @mouseleave="handleMouseLeave">
          <Link 
            :href="getLocalizedUrl(link.href)" 
            class="block py-2 border-b-4 transition-all duration-200"
            :class="{ 
              'gradient-border': isLinkActive(link.href), 
              'border-transparent hover:border-gray-300': !isLinkActive(link.href) && !isNavTransparent,
              'border-transparent hover:border-white/50': !isLinkActive(link.href) && isNavTransparent
            }">
            {{ link.name }}
          </Link>
          
          <!-- Dropdown submenu for Career -->
          <Transition name="dropdown">
            <div v-if="link.name === 'Career' && activeDropdown === 'Career'" 
                 @mouseenter="activeDropdown = 'Career'"
                 @mouseleave="activeDropdown = null"
                 class="absolute top-full left-1/2 -translate-x-1/2 mt-2 bg-gray-900/30 backdrop-blur-md rounded-lg shadow-xl py-2 min-w-[240px] z-[100] border border-white/20">
              <Link v-for="sublink in careerSublinks" :key="sublink.name"
                    :href="getLocalizedUrl(sublink.href)"
                    class="block px-6 py-3 text-sm text-white hover:bg-white/10 hover:text-white font-medium transition-all duration-200">
                {{ sublink.name }}
              </Link>
            </div>
          </Transition>
        </li>
      </ul>
      
      <!-- Spacer to maintain layout when menu is open -->
      <div v-if="isMenuOpen" class="hidden lg:block flex-1"></div>
      
      <div class="flex items-center gap-1 lg:gap-2 flex-shrink-0">
        <div 
          class="relative -mb-1" 
          @mouseenter="handleLanguageHover(true)" 
          @mouseleave="handleLanguageHover(false)"
        >
          <!-- Custom Language Icon with Hover Gradient Effect -->
          <div class="group inline-flex cursor-pointer">
            <svg
              width="36"
              height="36"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              class="w-8 h-8 lg:w-9 lg:h-9"
            >
              <defs>
                <linearGradient id="language-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#A0AFF6" />
                  <stop offset="100%" stop-color="#7ACAB3" />
                </linearGradient>
              </defs>
              <circle
                cx="12"
                cy="12"
                r="9"
                fill="url(#language-gradient)"
                class="opacity-0 group-hover:opacity-100 transition-opacity duration-300"
              />
              <path
                :fill="globePathColor"
                class="transition-all duration-300"
                d="M12 21q-1.858 0-3.5-.71q-1.642-.711-2.86-1.93T3.71 15.5T3 12q0-1.864.71-3.503q.711-1.64 1.93-2.857T8.5 3.71Q10.142 3 12 3q1.864 0 3.503.71q1.64.711 2.858 1.93t1.929 2.857Q21 10.137 21 12q0 1.858-.71 3.5q-.711 1.642-1.93 2.86t-2.857 1.93T12 21m0-.992q.88-1.131 1.452-2.221q.571-1.09.929-2.44H9.619q.397 1.426.948 2.516q.552 1.09 1.433 2.145m-1.273-.15q-.7-.825-1.278-2.04q-.578-1.214-.86-2.472H4.754q.86 1.865 2.437 3.06q1.578 1.194 3.536 1.452m2.546 0q1.958-.258 3.536-1.452q1.577-1.195 2.437-3.06h-3.834q-.38 1.277-.957 2.491q-.578 1.215-1.182 2.02m-8.927-5.51h4.035q-.114-.616-.16-1.2q-.048-.583-.048-1.147t.047-1.147t.16-1.2H4.347q-.163.52-.255 1.133Q4 11.398 4 12t.091 1.215t.255 1.131m5.035 0h5.238q.114-.615.16-1.18q.048-.564.048-1.166t-.047-1.166t-.16-1.18H9.38q-.113.615-.16 1.18q-.047.564-.047 1.166t.047 1.166t.16 1.18m6.24 0h4.034q.163-.519.255-1.131Q20 12.602 20 12t-.091-1.215t-.255-1.131h-4.035q.114.615.16 1.199q.048.584.048 1.147t-.047 1.147t-.16 1.2m-.208-5.693h3.834q-.879-1.904-2.408-3.06t-3.565-1.471q.7.921 1.259 2.107q.559 1.185.88 2.424m-5.793 0h4.762q-.396-1.408-.977-2.546T12 3.992q-.823.977-1.404 2.116T9.62 8.654m-4.865 0h3.834q.321-1.238.88-2.424t1.259-2.107q-2.054.316-3.574 1.48q-1.52 1.166-2.4 3.05"
              />
            </svg>
          </div>
          
          <!-- Language Dropdown -->
          <Transition name="dropdown">
            <div v-if="isLanguageDropdownOpen" 
                 @mouseenter="isLanguageDropdownOpen = true"
                 @mouseleave="isLanguageDropdownOpen = false"
                 class="absolute top-full left-1/2 -translate-x-1/2 mt-2 bg-gray-900/30 backdrop-blur-md rounded-lg shadow-xl py-2 min-w-[160px] z-[100] border border-white/20">
              <button 
                @click="switchLanguage('id')"
                :class="[
                  'cursor-pointer block w-full text-left px-6 py-3 text-sm text-white hover:bg-white/10 hover:text-white font-medium transition-all duration-200',
                  currentLocale === 'id' ? 'bg-white/10' : ''
                ]">
                Indonesia
              </button>
              <button 
                @click="switchLanguage('en')"
                :class="[
                  'cursor-pointer block w-full text-left px-6 py-3 text-sm text-white hover:bg-white/10 hover:text-white font-medium transition-all duration-200',
                  currentLocale === 'en' ? 'bg-white/10' : ''
                ]">
                English
              </button>
            </div>
          </Transition>
        </div>

        <button @click="toggleMenu" 
          @mouseenter="isBurgerHovered = true"
          @mouseleave="isBurgerHovered = false"
          class="flex items-center justify-center w-8 h-8 z-50 cursor-pointer"
          :class="isMenuOpen ? 'outline outline-2 outline-[#4D9F95]' : ''"
        >
          <!-- Burger Menu (when closed) -->
          <div v-if="!isMenuOpen" class="flex flex-col gap-[4px]">
            <div class="w-7.5 h-[3.5px] transition-all duration-300" :class="burgerLineClass"></div>
            <div class="w-7.5 h-[3.5px] transition-all duration-300" :class="burgerLineClass"></div>
          </div>
          <!-- X Icon (when open) -->
          <div v-else class="w-8 h-8 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </div>
        </button>
      </div>
    </div>
  </nav>

  <Transition name="menu">
    <div v-if="isMenuOpen" class="fixed top-0 left-0 w-full h-screen bg-[#4D9F95]/70 backdrop-blur-sm text-white z-40 pt-32 lg:pt-40 px-4 lg:px-32 pb-8 lg:pb-16 overflow-y-auto">
      <div class="max-w-[1440px] mx-auto relative">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-8 md:gap-y-12">
          <div class="flex flex-col group">
            <h2 class="text-2xl lg:text-4xl font-medium mb-4 w-fit">
              <span class="relative font-medium">
                Company
                <span class="absolute bottom-0 left-0 w-0 h-[3px] bg-white transition-all duration-300 group-hover:w-full"></span>
              </span>
            </h2>
            <ul class="space-y-3">
              <li v-for="link in menuItems[0].links" :key="link.name">
                <Link :href="getLocalizedUrl(link.href)" class="text-base md:text-lg text-white/80 hover:text-white transition-all duration-300 ease-in-out block hover:translate-x-1" @click="closeMenu">{{ link.name }}</Link>
              </li>
            </ul>
          </div>
          
          <div class="flex flex-col group">
            <h2 class="text-2xl lg:text-4xl mb-4 w-fit">
              <span class="relative font-medium">
                Our Factory
                <span class="absolute bottom-0 left-0 w-0 h-[3px] bg-white transition-all duration-300 group-hover:w-full"></span>
              </span>
            </h2>
            <ul class="space-y-3">
              <li v-for="link in menuItems[1].links" :key="link.name">
                <Link :href="getLocalizedUrl(link.href)" class="text-base md:text-lg text-white/80 hover:text-white transition-all duration-300 ease-in-out block hover:translate-x-1" @click="closeMenu">{{ link.name }}</Link>
              </li>
            </ul>
          </div>
          
          <div class="flex flex-col group">
            <h2 class="text-2xl lg:text-4xl mb-4 w-fit">
              <span class="relative font-medium ">
                Sustainability
                <span class="absolute bottom-0 left-0 w-0 h-[3px] bg-white transition-all duration-300 group-hover:w-full"></span>
              </span>
            </h2>
            <ul class="space-y-3">
              <li v-for="link in menuItems[2].links" :key="link.name">
                <Link :href="getLocalizedUrl(link.href)" class="text-base md:text-lg text-white/80 hover:text-white transition-all duration-300 ease-in-out block hover:translate-x-1" @click="closeMenu">{{ link.name }}</Link>
              </li>
            </ul>
          </div>
          
          <div v-for="section in menuItems.slice(3)" :key="section.title" class="flex flex-col group">
            <h2 class="text-2xl lg:text-4xl mb-4 w-fit">
              <span class="relative font-medium">
                {{ section.title }}
                <span class="absolute bottom-0 left-0 w-0 h-[3px] bg-white transition-all duration-300 group-hover:w-full"></span>
              </span>
            </h2>
            <ul class="space-y-3">
              <li v-for="link in section.links" :key="link.name">
                <Link :href="getLocalizedUrl(link.href)" class="text-base md:text-lg text-white/80 hover:text-white transition-all duration-300 ease-in-out block hover:translate-x-1" @click="closeMenu">{{ link.name }}</Link>
              </li>
            </ul>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-[100px_auto] gap-y-2 items-start">
            <!-- <div class="font-bold">Telephone</div>
            <div>+62-21-39709290</div> -->
            <div class="font-bold text-base md:text-lg">Email</div>
            <div class="text-base md:text-lg">hligrievance@hligreenpower.com</div>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue' 
import { Link, usePage, router } from '@inertiajs/vue3'
import { useLocalization } from '@/composables/useLocalization'

import logoColor from '@/assets/hligp-logo.png'
import logoWhite from '@/assets/hligp-logo-white.png'

const isScrolled = ref(false)
const isMenuOpen = ref(false)
const activeDropdown = ref(null)
const isLanguageDropdownOpen = ref(false)
const isLanguageHovered = ref(false)
const isBurgerHovered = ref(false)

const closeMenu = () => {
  isMenuOpen.value = false;
};

const handleLanguageHover = (isHovered) => {
  isLanguageHovered.value = isHovered;
  if (isHovered) {
    isLanguageDropdownOpen.value = true;
  }
};

const page = usePage();
const { currentLocale, getLocalizedUrl } = useLocalization();

// Function to switch language
const switchLanguage = (newLocale) => {
  const currentUrl = page.url;
  // Extract path without locale prefix
  const pathWithoutLocale = currentUrl.replace(/^\/(en|id)/, '') || '/';
  
  // Redirect to home if on article page
  if (pathWithoutLocale.startsWith('/article')) {
    router.visit(`/${newLocale}`, {
      preserveState: false,
      preserveScroll: false,
    });
    isLanguageDropdownOpen.value = false;
    return;
  }
  
  const newPath = pathWithoutLocale === '/' 
    ? `/${newLocale}` 
    : `/${newLocale}${pathWithoutLocale}`;
  
  router.visit(newPath, {
    preserveState: true,
    preserveScroll: true,
  });
  isLanguageDropdownOpen.value = false;
};

const isNavTransparent = computed(() => {
  const url = page.url.replace(/^\/(en|id)/, '') || '/';
  return url === '/' && !isScrolled.value;
});

  // Computed property for globe icon path color
  const globePathColor = computed(() => {
    if (isMenuOpen.value) {
      return isLanguageHovered.value ? '#4D9E95' : 'white';
    }
    return isNavTransparent.value ? 'white' : '#4D9E95';
  });

  // Computed property for burger menu line class
  const burgerLineClass = computed(() => {
    // When hovered: always gradient
    if (isBurgerHovered.value) {
      return 'bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3]';
    }
    // When not hovered:
    // - Transparent navbar: white
    // - Non-transparent navbar: green #4D9E95
    return isNavTransparent.value ? 'bg-white' : 'bg-[#4D9E95]';
  });

// Function to check if a link is active
const isLinkActive = (href) => {
  const currentUrl = page.url.replace(/^\/(en|id)/, '') || '/';
  const linkPath = href.replace(/^\//, '').split('#')[0]; // Remove hash and leading slash
  const currentPath = currentUrl.split('#')[0]; // Remove hash
  
  // Normalize: remove leading/trailing slashes for comparison
  const normalizedLinkPath = linkPath.replace(/^\/|\/$/g, '');
  const normalizedCurrentPath = currentPath.replace(/^\/|\/$/g, '') || '';
  
  // For home page
  if (normalizedLinkPath === '' && normalizedCurrentPath === '') {
    return true;
  }
  
  // Exact match
  if (normalizedCurrentPath === normalizedLinkPath) {
    return true;
  }
  
  // Current path starts with link path (for nested routes)
  if (normalizedLinkPath && normalizedCurrentPath.startsWith(normalizedLinkPath + '/')) {
    return true;
  }
  
  return false;
};

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50;
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
})

const navLinks = ref([
    { name: 'Company', href: '/company' },
    { name: 'Our Factory', href: '/factory' },
    { name: 'Sustainability', href: '/sustainability' },
    { name: 'Publication', href: '/publication' },
    { name: 'Career', href: '/career' },
    { name: 'Contact Us', href: '/contact' },
]);

const menuItems = ref([
  {
    title: 'Company',
    links: [
      { name: 'Company Overview', href: '/company#overview' },
      { name: 'Vision & Mission', href: '/company#vision' },
      { name: 'History & Milestone', href: '/company#history' },
      { name: 'Leadership Team', href: '/company#leadership' },
    ]
  },
  {
    title: 'Our Factory',
    links: [
      { name: 'Facility Overview', href: '/factory#overview' },
      { name: 'Capability & Capacity', href: '/factory#capability' },
      // { name: 'Certification', href: '/factory#certification' },
      // { name: 'Safety Standard', href: '/factory#safety' },
    ]
  },
  {
    title: 'Sustainability',
    links: [
      { name: 'SHE Policy', href: '/sustainability#she-policy' },
      { name: 'Sustainable commitment', href: '/sustainability#commitment' },
    ]
  },
  {
    title: 'Publication',
    links: [
      { name: 'Articles', href: '/publication#articles' },
      { name: 'Company Activities', href: '/publication#activities' },
    ]
  },
  {
    title: 'Career',
    links: [
      { name: 'Career Development', href: '/career#development' },
      { name: 'Life At HLI', href: '/career#lifeathli' },
      // { name: 'Talent Submission Form', href: '/career#submission' },
      // { name: 'Leadership Team', href: '/career#leadership' },
    ]
  },
  {
    title: 'Contact Us',
    links: [
      { name: 'Inquiry Form', href: '/contact#inquiry' },
      { name: 'Contact Email/Phone', href: '/contact#email-phone' },
    ]
  },
]);

const handleMouseEnter = (linkName) => {
  if (linkName === 'Career') {
    activeDropdown.value = linkName;
  }
};

const handleMouseLeave = () => {
  activeDropdown.value = null;
}

const careerSublinks = ref([
  { name: 'Career Development', href: '/career#development' },
  { name: 'Life at HLI', href: '/career#lifeathli' },
]);
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.15s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.gradient-border {
  position: relative;
  border-bottom: 4px solid transparent;
}

.gradient-border::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(to right, #A0AFF6, #7ACAB3);
}

.menu-enter-active,
.menu-leave-active {
  transition: all 0.3s ease-out;
}

.menu-enter-from {
  opacity: 0;
  transform: translateY(-10px);
}

.menu-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

.menu-enter-to,
.menu-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.2s ease-out;
}

.dropdown-enter-from {
  opacity: 0;
  transform: translateY(-10px);
}

.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-5px);
}

.dropdown-enter-to,
.dropdown-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.group:hover .group-hover\:w-full {
  width: 100%;
}
</style>