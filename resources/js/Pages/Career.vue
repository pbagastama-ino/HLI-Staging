<template>
  <div class="relative bg-white text-black antialiased">
    <!-- Important Notice Modal -->
    <Teleport to="body">
      <div
        v-if="showNoticeModal"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm px-4"
      >
        <div
          role="dialog"
          aria-modal="true"
          class="relative w-full max-w-2xl overflow-hidden rounded-[28px] bg-white shadow-[0_20px_80px_rgba(0,0,0,0.35)]"
        >
          <!-- bottom gradient strip -->
          <div class="absolute inset-x-0 bottom-0 h-3 bg-gradient-to-r from-[#7ACAB3] to-[#A0AFF6]"></div>

          <div class="p-8 sm:p-10">
            <div class="flex flex-col sm:flex-row gap-8 items-center sm:items-center">
              <div class="flex-shrink-0 flex justify-center w-full sm:w-auto my-4 sm:my-0">
                <div class="w-36 h-36 sm:w-40 sm:h-40 flex items-center justify-center">
                  <img
                    :src="warningIcon"
                    alt="Warning"
                    class="w-36 h-36 sm:w-40 sm:h-40 object-contain"
                  />
                </div>
              </div>

              <div class="text-center sm:text-left">
                <h2 class="text-2xl sm:text-3xl font-semibold text-gray-900">
                  {{ t.noticeModal.title }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                  {{ t.noticeModal.subtitle }}
                </p>

                <div class="mt-6 space-y-4 text-sm text-gray-700 leading-relaxed">
                  <p>{{ t.noticeModal.line1 }}</p>
                  <p>
                    {{ t.noticeModal.line2Start }}
                    <span class="italic font-semibold" style="font-style: italic !important; font-weight: 600 !important;">{{ t.noticeModal.email }}</span>.
                  </p>
                  <p>
                    {{ t.noticeModal.line3Start }}
                    <em class="italic font-semibold" style="font-style: italic !important; font-weight: 600 !important;">{{ t.noticeModal.line3Emphasis }}</em>
                    {{ t.noticeModal.line3End }}
                  </p>
                </div>
              </div>
            </div>

            <div class="mt-8 flex justify-center">
              <button
                type="button"
                @click="closeNoticeModal"
                class="w-56 sm:w-64 rounded-full py-3 text-white font-medium tracking-widest bg-gradient-to-r from-[#7ACAB3] to-[#A0AFF6] shadow-lg hover:opacity-95 transition-opacity cursor-pointer"
              >
                {{ t.noticeModal.okay }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- Supergraphic Icon Right -->
    <img
      :src="supergraphicDots"
      alt="Supergraphic Dots"
      class="hidden lg:block absolute top-48 right-0 w-28 h-auto opacity-80 z-10 pointer-events-none"
      style="margin-right: calc(-100vw + 100% + (100vw - 100%) / 2);"
    />
    <!-- Supergraphic Icon Left -->
    <img
      :src="supergraphicHalfCircle"
      alt="Supergraphic Half Circle"
      class="hidden lg:block absolute top-[480px] left-0 w-28 h-auto opacity-80 z-10 pointer-events-none"
      style="margin-left: calc(-100vw + 100% + (100vw - 100%) / 2);"
    />

    <div class="container mx-auto max-w-7xl px-4 sm:px-6 md:px-8 xl:px-6 pt-32 md:pt-40 pb-16 md:pb-24">
      <div id="development" class="flex flex-row items-center mb-8">
        <div class="w-11 h-px bg-[#4D9F95] mr-4"></div>
        <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%] whitespace-nowrap">
          {{ t.sections.careerDevelopment }}
        </h2>
      </div>
      <h1 class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl xl:text-7xl font-medium tracking-[0%] leading-[120%] text-gray-900 mb-4">
        {{ t.sections.vacancy }}
      </h1>
      <div class="mb-12">
        <p class="text-sm text-gray-600">
          <span class="font-semibold">{{ t.disclaimer.title }}</span> {{ t.disclaimer.text }}
        </p>
      </div>
      <!-- Loading State for Vacancies -->
      <div v-if="vacanciesLoading" class="w-full mb-16 rounded-lg overflow-hidden shadow-lg">
          <div v-for="n in 3" :key="n" class="border-b border-gray-200 last:border-b-0">
              <div class="flex justify-between items-center p-6 bg-gray-200 animate-pulse">
                  <div class="h-8 w-64 bg-gray-300 rounded"></div>
                  <div class="h-6 w-6 bg-gray-300 rounded"></div>
              </div>
          </div>
      </div>
      <!-- Vacancies Content -->
      <div v-else-if="vacancies.length > 0" class="w-full mb-16 rounded-2xl md:rounded-3xl overflow-hidden shadow-lg bg-white">
        <div v-for="(item, index) in vacancies" :key="index">
          <div 
            @click="toggleItem(index)" 
            class="flex justify-between items-center p-4 md:p-6 bg-[#4D9F95] text-white cursor-pointer hover:bg-gradient-to-r from-[#7ACAB3]/70 to-[#A0AFF6]/70 transition-colors duration-200"
          >
            <div>
                <h2 class="text-xl xl:text-4xl font-medium tracking-[0%] leading-[120%] text-white">{{ item.title }}</h2>
                <p class="text-xs md:text-sm text-white/80 mt-1">{{ item.department_name }}</p>
            </div>
            <div class="transition-transform duration-300" :class="{ 'rotate-180': openItemIndex === index }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 9l7 7 7-7" />
                </svg>
            </div>
          </div>
          <div class="overflow-hidden transition-[max-height] duration-700 ease-in-out bg-white" :class="[openItemIndex === index ? 'max-h-none' : 'max-h-0']">
            <div class="p-4 md:p-6 lg:p-8">
              <!-- Requirements Section -->
              <div v-if="item.requirements" class="border-b border-[#4D9F95] pb-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-8">
                  <div class="md:col-span-1">
                      <div class="font-medium text-base uppercase tracking-[4%] text-[#4D9F95]">{{ t.vacancy.requirements }}</div>
                  </div>
                  <div class="md:col-span-3">
                      <div class="text-black text-sm md:text-base html-content" v-html="item.requirements"></div>
                  </div>
                </div>
              </div>
              <!-- Job Description Section -->
              <div v-if="item.description" class="pb-4 md:pb-8">
                  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-8">
                      <div class="md:col-span-1">
                          <h3 class="font-medium text-base uppercase tracking-[4%] text-[#4D9F95]">{{ t.vacancy.jobDescription }}</h3>
                      </div>
                      <div class="md:col-span-3">
                          <div class="text-black text-sm md:text-base html-content" v-html="item.description"></div>
                      </div>
                  </div>
              </div>
              <!-- Apply Button -->
              <div class="mt-8 pt-6 md:pt-8 pb-2 md:pb-3 border-t border-gray-200">
                <div class="flex justify-center">
                  <Link :href="getLocalizedUrl(`/submission-form?position=${encodeURIComponent(item.title)}&vacancy=${item.id}`)" class="flex items-center gap-x-4 px-8 py-3 rounded-full text-white font-semibold bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] hover:opacity-90 transition-opacity">
                    <span class="text-sm md:text-base tracking-[4%] font-medium">{{ t.vacancy.applyFor }} {{ item.title }}</span>
                    <div class="w-6 h-6 bg-white/80 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7l7 7-7 7" />
                        </svg>
                    </div>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Empty State for Vacancies -->
      <div v-else class="w-full mb-16 rounded-lg overflow-hidden shadow-lg bg-white p-8 text-center">
        <div class="text-gray-400 mb-4">
          <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ t.vacancy.emptyTitle }}</h3>
        <p class="text-gray-500">{{ t.vacancy.emptyDesc }}</p>
      </div>

      <section id="life-at-hli" class="mt-32 mb-24">
        <div class="flex flex-row items-center mb-8">
          <div class="w-11 h-px bg-[#4D9F95] mr-4"></div>
          <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%] whitespace-nowrap">
            {{ t.sections.lifeAtHli }}
          </h2>
        </div>
          
        <!-- Loading State -->
        <div v-if="isLoading" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-20">
          <div v-for="n in 4" :key="n" class="group">
            <div class="block">
              <div class="overflow-hidden rounded-lg shadow-lg">
                <div class="w-full h-72 bg-gray-200 animate-pulse"></div>
              </div>
              <div class="relative z-10 w-11/12 -mt-16 rounded-lg bg-gray-300/70 backdrop-blur-sm shadow-xl p-6 ml-auto md:ml-16">
                <div class="h-8 bg-gray-400 rounded animate-pulse mb-2"></div>
                <div class="h-4 bg-gray-400 rounded animate-pulse mb-4"></div>
                <div class="h-16 bg-gray-400 rounded animate-pulse"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Content -->
        <div v-else-if="lifeAtHli.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-20">
          <div v-for="(item, index) in lifeAtHli" :key="index" class="group">
            <div @click="viewArticle(item)" class="block cursor-pointer">
              <div class="overflow-hidden rounded-lg shadow-lg">
                <img :src="item.image_url" :alt="item.title" class="w-full h-72 object-cover transform transition-transform duration-300 ease-in-out group-hover:scale-105">
              </div>
                    
              <div class="relative z-10 w-11/12 -mt-16 rounded-lg bg-[#4D9F95]/70 backdrop-blur-sm shadow-xl p-4 md:p-6 transition-all duration-300 group-hover:shadow-2xl ml-auto md:ml-16">
                <div class="flex justify-between items-start">
                    <h3 class="text-xl md:text-2xl font-semibold text-white">{{ item.title }}</h3>
                    <span class="hidden md:block text-xl md:text-3xl font-light text-white transition-transform duration-300 group-hover:translate-x-2">&rarr;</span>
                </div>
                <p class="text-xs md:text-sm mt-1 uppercase tracking-[4%] md:tracking-wider text-white">{{ formatDate(item.published_date) }}</p>
                <p class="mt-4 text-xs md:text-sm font-light text-white leading-relaxed h-20 overflow-hidden">
                  {{ truncateWords(item.text, 18) }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-16">
          <div class="text-gray-400 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">{{ t.lifeAt.emptyTitle }}</h3>
          <p class="text-gray-500">{{ t.lifeAt.emptyDesc }}</p>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3';
import { useLocalization } from '@/composables/useLocalization';
import supergraphicDots from '@/assets/supergraphic-dots.png'
import supergraphicHalfCircle from '@/assets/supergraphic-half-circle.png'
import warningIcon from '@/assets/warning-icon.png'

defineOptions({
  layout: AppLayout,
})

const { currentLocale, getLocalizedUrl } = useLocalization()

// Translations object
const translations = {
  en: {
    sections: {
      careerDevelopment: 'CAREER DEVELOPMENT',
      vacancy: 'Vacancy',
      lifeAtHli: 'LIFE AT HLI'
    },
    noticeModal: {
      title: 'Important Notice',
      subtitle: 'Please beware of recruitment scams.',
      line1: 'This is the only official website of HLI Green Power.',
      line2Start: 'All official recruitment information and communication are conducted only via email at',
      email: 'hligreenpower.com',
      line3Start: 'HLI Green Power',
      line3Emphasis: 'does not',
      line3End: 'charge any fees at any stage of the recruitment process.',
      okay: 'OKAY'
    },
    disclaimer: {
      title: 'Disclaimer:',
      text: 'HLI recruitment does not take any fee from applicants. Be aware of fraud or scam.'
    },
    vacancy: {
      requirements: 'Requirements',
      jobDescription: 'Job Description',
      applyFor: 'Apply for',
      emptyTitle: 'No vacancies available',
      emptyDesc: 'Check back later for new career opportunities.'
    },
    lifeAt: {
      emptyTitle: 'No Life at HLI content available',
      emptyDesc: 'Check back later for updates about life at HLI Green Power.'
    },
    common: {
      dateNotSet: 'Date not set'
    }
  },
  id: {
    sections: {
      careerDevelopment: 'PENGEMBANGAN KARIR',
      vacancy: 'Lowongan',
      lifeAtHli: 'KEHIDUPAN DI HLI'
    },
    noticeModal: {
      title: 'Pemberitahuan Penting',
      subtitle: 'Mohon waspada terhadap penipuan rekrutmen.',
      line1: 'Ini merupakan satu-satunya situs web resmi HLI Green Power.',
      line2Start: 'Semua informasi dan komunikasi rekrutmen resmi hanya dilakukan melalui email',
      email: 'hligreenpower.com',
      line3Start: 'HLI Green Power',
      line3Emphasis: 'tidak',
      line3End: 'memungut biaya apapun di setiap tahap proses rekrutmen.',
      okay: 'MENGERTI'
    },
    disclaimer: {
      title: 'Catatan:',
      text: 'Rekrutmen HLI tidak memungut biaya apapun dari pelamar. Waspadai penipuan atau modus penipuan.'
    },
    vacancy: {
      requirements: 'Persyaratan',
      jobDescription: 'Deskripsi Pekerjaan',
      applyFor: 'Lamar untuk',
      emptyTitle: 'Saat ini belum ada lowongan yang tersedia.',
      emptyDesc: 'Silakan kunjungi kembali halaman ini untuk mendapatkan informasi terbaru mengenai peluang karier di HLI Green Power.'
    },
    lifeAt: {
      emptyTitle: 'Belum ada konten yang tersedia saat ini.',
      emptyDesc: 'Silakan kunjungi kembali untuk mengetahui cerita dan kegiatan terbaru seputar kehidupan di HLI Green Power.'
    },
    common: {
      dateNotSet: 'Tanggal belum ditentukan'
    }
  }
}

const t = computed(() => translations[currentLocale.value] || translations.en)

const openItemIndex = ref(null); 

// Always show on each Career page load (mount)
const showNoticeModal = ref(false)
const closeNoticeModal = () => {
  showNoticeModal.value = false
}

const vacancies = ref([]);
const vacanciesLoading = ref(true);

const lifeAtHli = ref([]);
const isLoading = ref(true);

// Pagination state for Life at HLI section
const itemsPerPage = 4; // Show 4 items per page (2 rows of 2 columns)
const lifeAtHliPage = ref(1);

// Computed properties for paginated data
const paginatedLifeAtHli = computed(() => {
  const start = (lifeAtHliPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return lifeAtHli.value.slice(start, end);
});

// Computed properties for pagination info
const lifeAtHliTotalPages = computed(() => Math.ceil(lifeAtHli.value.length / itemsPerPage));

// Pagination helper functions
const getVisiblePages = (currentPage, totalPages) => {
  const pages = [];
  const maxVisible = 5;
  
  if (totalPages <= maxVisible) {
    for (let i = 1; i <= totalPages; i++) {
      pages.push(i);
    }
  } else {
    if (currentPage <= 3) {
      for (let i = 1; i <= 4; i++) {
        pages.push(i);
      }
      pages.push('...');
      pages.push(totalPages);
    } else if (currentPage >= totalPages - 2) {
      pages.push(1);
      pages.push('...');
      for (let i = totalPages - 3; i <= totalPages; i++) {
        pages.push(i);
      }
    } else {
      pages.push(1);
      pages.push('...');
      for (let i = currentPage - 1; i <= currentPage + 1; i++) {
        pages.push(i);
      }
      pages.push('...');
      pages.push(totalPages);
    }
  }
  
  return pages;
};

// Fetch vacancy data
const fetchVacancyData = async () => {
  try {
    vacanciesLoading.value = true;
    const response = await fetch('/api/vacancies');
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    
    console.log('Vacancy API Response:', data);
    
    // Use vacancy data directly from API - data is already the paginated collection
    vacancies.value = data.data || data || [];
      
  } catch (error) {
    console.error('Error fetching vacancy data:', error);
    console.error('Error details:', {
      message: error.message,
      status: error.status,
      response: error.response
    });
    // Fallback to empty data
    vacancies.value = [];
  } finally {
    vacanciesLoading.value = false;
  }
};

// Fetch publication data (same as Publication page)
const fetchPublicationData = async () => {
  try {
    isLoading.value = true;
    const response = await fetch('/api/publication-data');
    const data = await response.json();
    
    console.log('API Response:', data);
    console.log('Life at HLI data:', data.life_at_hli);
    
    // Use life_at_hli data directly from API
    lifeAtHli.value = data.life_at_hli || [];
      
  } catch (error) {
    console.error('Error fetching publication data:', error);
    // Fallback to empty data
    lifeAtHli.value = [];
  } finally {
    isLoading.value = false;
  }
};

const toggleItem = async (index) => {
  if (openItemIndex.value === index) {
    openItemIndex.value = null;
  } else {
    openItemIndex.value = index;
    // Scroll to button on mobile after expansion animation
    await nextTick();
    setTimeout(() => {
      const buttonElement = document.querySelector(`[data-vacancy-index="${index}"]`);
      if (buttonElement && window.innerWidth < 768) {
        buttonElement.scrollIntoView({ behavior: 'smooth', block: 'end' });
      }
    }, 750); // Wait for expansion animation to complete
  }
};

// Navigate to article page
const viewArticle = (item) => {
  router.visit(`/article/${item.slug}`);
};

// Lifecycle hooks
onMounted(() => {
  // Re-open the notice modal every time this page is loaded
  showNoticeModal.value = true

  fetchVacancyData();
  fetchPublicationData();

  const onKeydown = (e) => {
    if (e.key === 'Escape' && showNoticeModal.value) {
      closeNoticeModal()
    }
  }
  window.addEventListener('keydown', onKeydown)
  onUnmounted(() => window.removeEventListener('keydown', onKeydown))
  
  // Handle hash navigation to scroll to specific section
  if (window.location.hash) {
    const hash = window.location.hash.substring(1);
    nextTick(() => {
      const element = document.getElementById(hash);
      if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  }
});

const truncateWords = (text, limit) => {
    if (!text) return '';
    const words = text.split(' ');
    if (words.length <= limit) {
        return text;
    }
    return words.slice(0, limit).join(' ') + '...';
}

// Format date function (same as Publication page)
const formatDate = (date) => {
  if (!date) return t.value.common.dateNotSet;
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  }).toUpperCase();
};
</script>

<style scoped>
.html-content :deep(ul) {
  list-style-type: disc;
  list-style-position: outside;
  margin-left: 1.5rem;
  margin-top: 0.5rem;
  margin-bottom: 0.5rem;
  padding-left: 1rem;
}

.html-content :deep(ol) {
  list-style-type: decimal;
  list-style-position: outside;
  margin-left: 1.5rem;
  margin-top: 0.5rem;
  margin-bottom: 0.5rem;
  padding-left: 1rem;
}

.html-content :deep(li) {
  margin-top: 0.25rem;
  margin-bottom: 0.25rem;
  padding-left: 0.25rem;
}

.html-content :deep(ul ul),
.html-content :deep(ol ul) {
  list-style-type: circle;
  margin-top: 0.25rem;
  margin-bottom: 0.25rem;
}

.html-content :deep(ol ol),
.html-content :deep(ul ol) {
  list-style-type: lower-alpha;
  margin-top: 0.25rem;
  margin-bottom: 0.25rem;
}

.html-content :deep(p) {
  margin-top: 0.5rem;
  margin-bottom: 0.5rem;
}

.html-content :deep(p:first-child) {
  margin-top: 0;
}

.html-content :deep(p:last-child) {
  margin-bottom: 0;
}

/* Bold and Italic styling - Override global font-weight restrictions with maximum specificity */
.html-content :deep(strong),
.html-content :deep(b),
.html-content :deep(p strong),
.html-content :deep(p b),
.html-content :deep(li strong),
.html-content :deep(li b),
.html-content :deep(div strong),
.html-content :deep(div b),
.html-content :deep(span strong),
.html-content :deep(span b),
.html-content :deep(ul strong),
.html-content :deep(ul b),
.html-content :deep(ol strong),
.html-content :deep(ol b),
.html-content :deep(h1 strong),
.html-content :deep(h1 b),
.html-content :deep(h2 strong),
.html-content :deep(h2 b),
.html-content :deep(h3 strong),
.html-content :deep(h3 b) {
  font-weight: 700 !important;
}

.html-content :deep(em),
.html-content :deep(i),
.html-content :deep(p em),
.html-content :deep(p i),
.html-content :deep(li em),
.html-content :deep(li i) {
  font-style: italic !important;
}

/* Headings */
.html-content :deep(h1) {
  font-size: 2em;
  font-weight: bold;
  margin: 1rem 0;
}

.html-content :deep(h2) {
  font-size: 1.5em;
  font-weight: bold;
  margin: 0.875rem 0;
}

.html-content :deep(h3) {
  font-size: 1.25em;
  font-weight: bold;
  margin: 0.75rem 0;
}

/* Blockquote */
.html-content :deep(blockquote) {
  border-left: 4px solid #4D9F95;
  padding-left: 1rem;
  margin: 1rem 0;
  font-style: italic;
  color: #6b7280;
}
</style>

<style>
/* Global styles for Career page HTML content - Not scoped to ensure maximum priority */
/* These rules override all global font-weight restrictions */
.html-content strong,
.html-content b,
.html-content p strong,
.html-content p b,
.html-content li strong,
.html-content li b,
.html-content div strong,
.html-content div b,
.html-content span strong,
.html-content span b,
.html-content ul strong,
.html-content ul b,
.html-content ol strong,
.html-content ol b {
  font-weight: 700 !important;
}

.html-content em,
.html-content i,
.html-content p em,
.html-content p i,
.html-content li em,
.html-content li i {
  font-style: italic !important;
}

/* Ensure paragraphs and other elements don't override bold */
.html-content p strong,
.html-content p b,
.html-content li strong,
.html-content li b {
  font-weight: 700 !important;
}
</style>