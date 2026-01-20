<template>
  <Head title="Publication - HLI Green Power" />
  <div class="container mx-auto max-w-6xl px-4 pt-24 sm:pt-32 md:pt-40 pb-12 sm:pb-16 md:pb-24">
    <!-- Press Release Section -->
    <div v-if="pressReleases.length > 0">
      <div id="press-release" class="flex flex-row items-center mb-6 sm:mb-8">
        <div class="w-11 h-px bg-[#4D9F95] mr-4"></div>
        <h2 class="text-stone-500 text-xs font-medium uppercase tracking-widest whitespace-nowrap">
          PRESS RELEASE
        </h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 sm:gap-x-6 md:gap-x-8 gap-y-12 sm:gap-y-16 md:gap-y-20 mb-12 sm:mb-16 md:mb-20">
        <div v-for="(item, index) in paginatedPressReleases" :key="'pr-' + index" class="group">
          <div @click="viewArticle(item)" class="block cursor-pointer">
            <div class="overflow-hidden rounded-lg shadow-lg">
              <img :src="item.image_url" :alt="item.title" class="w-full h-64 sm:h-72 object-cover transform transition-transform duration-300 ease-in-out group-hover:scale-105">
            </div>
            <div class="relative z-10 w-11/12 -mt-12 sm:-mt-16 rounded-lg bg-[#4D9F95]/70 backdrop-blur-sm shadow-xl p-4 sm:p-6 transition-all duration-300 group-hover:shadow-2xl ml-auto md:ml-16">
              <div class="flex justify-between items-start gap-2">
                <h3 class="text-lg sm:text-xl md:text-2xl font-semibold text-white flex-1">{{ item.title }}</h3>
                <span class="text-2xl sm:text-3xl font-light text-white transition-transform duration-300 group-hover:translate-x-2 flex-shrink-0">&rarr;</span>
              </div>
              <p class="text-xs sm:text-sm mt-1 uppercase tracking-wider text-white">{{ formatDate(item.published_date) }}</p>
              <p class="mt-3 sm:mt-4 text-xs sm:text-sm font-light text-white leading-relaxed h-16 sm:h-20 overflow-hidden">
                {{ truncateWords(item.text, 18) }}
              </p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Press Release Pagination -->
      <div v-if="pressReleaseTotalPages > 1" class="mb-12 sm:mb-16 md:mb-20">
        <div class="flex items-center justify-between">
          <div class="flex-1 flex justify-between sm:hidden">
            <button
              @click="pressReleasePage = Math.max(1, pressReleasePage - 1)"
              :disabled="pressReleasePage === 1"
              :class="[
                'relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md',
                pressReleasePage === 1
                  ? 'bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed'
                  : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'
              ]"
            >
              Previous
            </button>
            <span class="px-3 py-2 text-sm text-gray-700">
              {{ pressReleasePage }} of {{ pressReleaseTotalPages }}
            </span>
            <button
              @click="pressReleasePage = Math.min(pressReleaseTotalPages, pressReleasePage + 1)"
              :disabled="pressReleasePage === pressReleaseTotalPages"
              :class="[
                'relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md',
                pressReleasePage === pressReleaseTotalPages
                  ? 'bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed'
                  : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'
              ]"
            >
              Next
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ (pressReleasePage - 1) * itemsPerPage + 1 }}</span>
                to
                <span class="font-medium">{{ Math.min(pressReleasePage * itemsPerPage, pressReleases.length) }}</span>
                of
                <span class="font-medium">{{ pressReleases.length }}</span>
                results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <button
                  @click="pressReleasePage = Math.max(1, pressReleasePage - 1)"
                  :disabled="pressReleasePage === 1"
                  :class="[
                    'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 text-sm font-medium',
                    pressReleasePage === 1
                      ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                      : 'bg-white text-gray-500 hover:bg-gray-50'
                  ]"
                >
                  <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                </button>
                
                <template v-for="page in getVisiblePages(pressReleasePage, pressReleaseTotalPages)" :key="page">
                  <button
                    v-if="page !== '...'"
                    @click="pressReleasePage = page"
                    :class="[
                      'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                      page === pressReleasePage
                        ? 'z-10 bg-[#4D9F95] border-[#4D9F95] text-white'
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                    ]"
                  >
                    {{ page }}
                  </button>
                  <span
                    v-else
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"
                  >
                    ...
                  </span>
                </template>
                
                <button
                  @click="pressReleasePage = Math.min(pressReleaseTotalPages, pressReleasePage + 1)"
                  :disabled="pressReleasePage === pressReleaseTotalPages"
                  :class="[
                    'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 text-sm font-medium',
                    pressReleasePage === pressReleaseTotalPages
                      ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                      : 'bg-white text-gray-500 hover:bg-gray-50'
                  ]"
                >
                  <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Articles Section -->
    <div v-if="articles.length > 0">
      <div id="articles" class="flex flex-row items-center mb-8">
        <div class="w-11 h-px bg-[#4D9F95] mr-4"></div>
        <h2 class="text-stone-500 text-xs font-medium uppercase tracking-widest whitespace-nowrap">
          ARTICLES
        </h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 sm:gap-x-6 md:gap-x-8 gap-y-12 sm:gap-y-16 md:gap-y-20 mb-12 sm:mb-16 md:mb-20">
        <div v-for="(item, index) in paginatedArticles" :key="'art-' + index" class="group">
          <div @click="viewArticle(item)" class="block cursor-pointer">
            <div class="overflow-hidden rounded-lg shadow-lg">
              <img :src="item.image_url" :alt="item.title" class="w-full h-64 sm:h-72 object-cover transform transition-transform duration-300 ease-in-out group-hover:scale-105">
            </div>
            <div class="relative z-10 w-11/12 -mt-12 sm:-mt-16 rounded-lg bg-[#4D9F95]/70 backdrop-blur-sm shadow-xl p-4 sm:p-6 transition-all duration-300 group-hover:shadow-2xl ml-auto md:ml-16">
              <div class="flex justify-between items-start gap-2">
                <h3 class="text-lg sm:text-xl md:text-2xl font-semibold text-white flex-1">{{ item.title }}</h3>
                <span class="text-2xl sm:text-3xl font-light text-white transition-transform duration-300 group-hover:translate-x-2 flex-shrink-0">&rarr;</span>
              </div>
              <p class="text-xs sm:text-sm mt-1 uppercase tracking-wider text-white">{{ formatDate(item.published_date) }}</p>
              <p class="mt-3 sm:mt-4 text-xs sm:text-sm font-light text-white leading-relaxed h-16 sm:h-20 overflow-hidden">
                {{ truncateWords(item.text, 18) }}
              </p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Articles Pagination -->
      <div v-if="articlesTotalPages > 1" class="mb-12 sm:mb-16 md:mb-20">
        <div class="flex items-center justify-between">
          <div class="flex-1 flex justify-between sm:hidden">
            <button
              @click="articlesPage = Math.max(1, articlesPage - 1)"
              :disabled="articlesPage === 1"
              :class="[
                'relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md',
                articlesPage === 1
                  ? 'bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed'
                  : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'
              ]"
            >
              Previous
            </button>
            <span class="px-3 py-2 text-sm text-gray-700">
              {{ articlesPage }} of {{ articlesTotalPages }}
            </span>
            <button
              @click="articlesPage = Math.min(articlesTotalPages, articlesPage + 1)"
              :disabled="articlesPage === articlesTotalPages"
              :class="[
                'relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md',
                articlesPage === articlesTotalPages
                  ? 'bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed'
                  : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'
              ]"
            >
              Next
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ (articlesPage - 1) * itemsPerPage + 1 }}</span>
                to
                <span class="font-medium">{{ Math.min(articlesPage * itemsPerPage, articles.length) }}</span>
                of
                <span class="font-medium">{{ articles.length }}</span>
                results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <button
                  @click="articlesPage = Math.max(1, articlesPage - 1)"
                  :disabled="articlesPage === 1"
                  :class="[
                    'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 text-sm font-medium',
                    articlesPage === 1
                      ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                      : 'bg-white text-gray-500 hover:bg-gray-50'
                  ]"
                >
                  <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                </button>
                
                <template v-for="page in getVisiblePages(articlesPage, articlesTotalPages)" :key="page">
                  <button
                    v-if="page !== '...'"
                    @click="articlesPage = page"
                    :class="[
                      'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                      page === articlesPage
                        ? 'z-10 bg-[#4D9F95] border-[#4D9F95] text-white'
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                    ]"
                  >
                    {{ page }}
                  </button>
                  <span
                    v-else
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"
                  >
                    ...
                  </span>
                </template>
                
                <button
                  @click="articlesPage = Math.min(articlesTotalPages, articlesPage + 1)"
                  :disabled="articlesPage === articlesTotalPages"
                  :class="[
                    'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 text-sm font-medium',
                    articlesPage === articlesTotalPages
                      ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                      : 'bg-white text-gray-500 hover:bg-gray-50'
                  ]"
                >
                  <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Company Activities Section -->
    <div v-if="companyActivities.length > 0">
      <div id="activities" class="flex flex-row items-center mb-8">
        <div class="w-11 h-px bg-[#4D9F95] mr-4"></div>
        <h2 class="text-stone-500 text-xs font-medium uppercase tracking-widest whitespace-nowrap">
          COMPANY ACTIVITIES
        </h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 sm:gap-x-6 md:gap-x-8 gap-y-12 sm:gap-y-16 md:gap-y-20">
        <div v-for="(item, index) in paginatedCompanyActivities" :key="'ca-' + index" class="group">
          <div @click="viewArticle(item)" class="block cursor-pointer">
            <div class="overflow-hidden rounded-lg shadow-lg">
              <img :src="item.image_url" :alt="item.title" class="w-full h-64 sm:h-72 object-cover transform transition-transform duration-300 ease-in-out group-hover:scale-105">
            </div>
            <div class="relative z-10 w-11/12 -mt-12 sm:-mt-16 rounded-lg bg-[#4D9F95]/70 backdrop-blur-sm shadow-xl p-4 sm:p-6 transition-all duration-300 group-hover:shadow-2xl ml-auto md:ml-16">
              <div class="flex justify-between items-start gap-2">
                <h3 class="text-lg sm:text-xl md:text-2xl font-semibold text-white flex-1">{{ item.title }}</h3>
                <span class="text-2xl sm:text-3xl font-light text-white transition-transform duration-300 group-hover:translate-x-2 flex-shrink-0">&rarr;</span>
              </div>
              <p class="text-xs sm:text-sm mt-1 uppercase tracking-wider text-white">{{ formatDate(item.published_date) }}</p>
              <p class="mt-3 sm:mt-4 text-xs sm:text-sm font-light text-white leading-relaxed h-16 sm:h-20 overflow-hidden">
                {{ truncateWords(item.text, 18) }}
              </p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Company Activities Pagination -->
      <div v-if="activitiesTotalPages > 1" class="mt-12 sm:mt-16 md:mt-20">
        <div class="flex items-center justify-between">
          <div class="flex-1 flex justify-between sm:hidden">
            <button
              @click="activitiesPage = Math.max(1, activitiesPage - 1)"
              :disabled="activitiesPage === 1"
              :class="[
                'relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md',
                activitiesPage === 1
                  ? 'bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed'
                  : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'
              ]"
            >
              Previous
            </button>
            <span class="px-3 py-2 text-sm text-gray-700">
              {{ activitiesPage }} of {{ activitiesTotalPages }}
            </span>
            <button
              @click="activitiesPage = Math.min(activitiesTotalPages, activitiesPage + 1)"
              :disabled="activitiesPage === activitiesTotalPages"
              :class="[
                'relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md',
                activitiesPage === activitiesTotalPages
                  ? 'bg-gray-100 border-gray-300 text-gray-400 cursor-not-allowed'
                  : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'
              ]"
            >
              Next
            </button>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ (activitiesPage - 1) * itemsPerPage + 1 }}</span>
                to
                <span class="font-medium">{{ Math.min(activitiesPage * itemsPerPage, companyActivities.length) }}</span>
                of
                <span class="font-medium">{{ companyActivities.length }}</span>
                results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <button
                  @click="activitiesPage = Math.max(1, activitiesPage - 1)"
                  :disabled="activitiesPage === 1"
                  :class="[
                    'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 text-sm font-medium',
                    activitiesPage === 1
                      ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                      : 'bg-white text-gray-500 hover:bg-gray-50'
                  ]"
                >
                  <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                </button>
                
                <template v-for="page in getVisiblePages(activitiesPage, activitiesTotalPages)" :key="page">
                  <button
                    v-if="page !== '...'"
                    @click="activitiesPage = page"
                    :class="[
                      'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                      page === activitiesPage
                        ? 'z-10 bg-[#4D9F95] border-[#4D9F95] text-white'
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                    ]"
                  >
                    {{ page }}
                  </button>
                  <span
                    v-else
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"
                  >
                    ...
                  </span>
                </template>
                
                <button
                  @click="activitiesPage = Math.min(activitiesTotalPages, activitiesPage + 1)"
                  :disabled="activitiesPage === activitiesTotalPages"
                  :class="[
                    'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 text-sm font-medium',
                    activitiesPage === activitiesTotalPages
                      ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                      : 'bg-white text-gray-500 hover:bg-gray-50'
                  ]"
                >
                  <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';

defineOptions({
  layout: AppLayout,
})

const pressReleases = ref([]);
const articles = ref([]);
const companyActivities = ref([]);

// Pagination state for each section
const itemsPerPage = 4; // Show 4 items per page (2 rows of 2 columns)
const pressReleasePage = ref(1);
const articlesPage = ref(1);
const activitiesPage = ref(1);

// Computed properties for paginated data
const paginatedPressReleases = computed(() => {
  const start = (pressReleasePage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return pressReleases.value.slice(start, end);
});

const paginatedArticles = computed(() => {
  const start = (articlesPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return articles.value.slice(start, end);
});

const paginatedCompanyActivities = computed(() => {
  const start = (activitiesPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return companyActivities.value.slice(start, end);
});

// Computed properties for pagination info
const pressReleaseTotalPages = computed(() => Math.ceil(pressReleases.value.length / itemsPerPage));
const articlesTotalPages = computed(() => Math.ceil(articles.value.length / itemsPerPage));
const activitiesTotalPages = computed(() => Math.ceil(companyActivities.value.length / itemsPerPage));

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

// Fetch publication data
const fetchPublicationData = async () => {
  try {
    const response = await fetch('/api/publication-data');
    const data = await response.json();
    
    // Filter and categorize the data
    pressReleases.value = data.press_releases || [];
    articles.value = data.articles || [];
    companyActivities.value = data.activities || [];
  } catch (error) {
    console.error('Error fetching publication data:', error);
    // Fallback to empty data
    pressReleases.value = [];
    articles.value = [];
    companyActivities.value = [];
  }
};

// Navigate to article page
const viewArticle = (item) => {
  router.visit(`/article/${item.slug}`);
};

// Format date function
const formatDate = (date) => {
  if (!date) return 'Date not set';
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  }).toUpperCase();
};

// Lifecycle hooks
onMounted(() => {
  fetchPublicationData();
});

const truncateWords = (text, limit) => {
  if (!text) return '';
  const words = text.split(' ');
  if (words.length <= limit) {
    return text;
  }
  return words.slice(0, limit).join(' ') + '...';
}
</script>