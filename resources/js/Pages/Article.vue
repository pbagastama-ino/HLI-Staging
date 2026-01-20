<template>
  <Head :title="publication ? `${publication.title} - HLI Green Power` : 'Article - HLI Green Power'" />
  <div class="pt-28">
    <div v-if="loading" class="container mx-auto max-w-6xl px-4 md:px-6 lg:px-8 py-10">
      <div class="flex items-center justify-center h-64">
        <div class="text-gray-500">Loading...</div>
      </div>
    </div>

    <div v-else-if="error" class="container mx-auto max-w-6xl px-4 md:px-6 lg:px-8 py-10">
      <div class="flex flex-col items-center justify-center h-64">
        <div class="text-red-500 mb-4">{{ error }}</div>
        <button
          @click="goBack"
          class="px-4 py-2 bg-[#4D9F95] text-white rounded-lg hover:bg-[#45a189]"
        >
          Go Back
        </button>
      </div>
    </div>

    <div v-else-if="publication" class="container mx-auto max-w-6xl px-4 md:px-6 lg:px-8 py-6 sm:py-8 md:py-10">
      <!-- changed: gunakan 2 kolom untuk rasio 50:50 -->
      <div class="grid lg:grid-cols-2 gap-6 sm:gap-8 md:gap-12">
        <!-- Main article (left, 50%) -->
        <article>
          <div class="flex items-center gap-4 mb-6">
            <button
              @click="goBack"
              aria-label="Back"
              class="w-10 h-10 rounded-full flex items-center justify-center border border-gray-200 bg-white shadow-sm hover:shadow-md transition-all"
            >
              <!-- simple left arrow -->
              <svg class="w-4 h-4 text-[#4D9F95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </button>
            <div class="text-sm uppercase text-gray-500">{{ getCategoryLabel(publication.category) }}</div>
          </div>

          <header class="mb-4 sm:mb-6">
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight mb-2 sm:mb-3">{{ publication.title }}</h1>
            <div class="text-xs sm:text-sm text-gray-500">Posted on {{ formatDate(publication.published_date) }}</div>
          </header>

          <!-- Article Image (mobile/tablet only) -->
          <div v-if="publication.image_url" class="mb-6 lg:hidden">
            <img :src="publication.image_url" :alt="publication.title" class="w-full h-64 object-cover rounded-lg shadow-sm" />
          </div>

          <!-- Article Content -->
          <div class="prose prose-slate max-w-none">
            <div class="whitespace-pre-wrap text-gray-700 leading-relaxed">{{ publication.text }}</div>
          </div>
        </article>

        <!-- Sidebar (right, 50%) -->
        <aside class="bg-white">
          <div>
            <!-- Article Image (desktop only) -->
            <div v-if="publication.image_url" class="mb-6 hidden lg:block">
              <img :src="publication.image_url" :alt="publication.title" class="w-full h-64 object-cover rounded-lg shadow-sm" />
            </div>

            <h3 class="text-xl sm:text-2xl font-bold mb-2 sm:mb-3">{{ getRelatedSectionTitle() }}</h3>
            <p class="text-xs sm:text-sm text-gray-600 mb-4 sm:mb-6">
              {{ getRelatedSectionDescription() }}
            </p>

            <!-- Divider after the intro paragraph -->
            <div class="mb-6">
              <div class="h-px w-full bg-[#4D9F95]/30"></div>
            </div>

            <div v-if="relatedPublications.length > 0" class="-my-3 divide-y divide-[#4D9F95]/50">
              <div
                v-for="(item, idx) in relatedPublications"
                :key="idx"
                class="py-3 flex gap-4 items-start cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors"
                @click="viewArticle(item)"
              >
                <img
                  v-if="item.image_url"
                  :src="item.image_url"
                  :alt="item.title"
                  class="w-20 h-16 object-cover rounded-md flex-shrink-0"
                />
                <div class="flex-1">
                  <div class="text-[#4D9F95] font-semibold block hover:underline">{{ item.title }}</div>
                  <p class="text-sm text-gray-500 mt-1">{{ truncateWords(item.text, 15) }}</p>
                </div>
              </div>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, router, usePage } from '@inertiajs/vue3'
import { useLocalization } from '@/composables/useLocalization'

defineOptions({
  layout: AppLayout,
})

const { getLocalizedUrl } = useLocalization()

const props = defineProps({
  publicationSlug: {
    type: String,
    required: true
  }
})

const loading = ref(true)
const error = ref(null)
const publication = ref(null)
const relatedPublications = ref([])

// Fetch publication data
const fetchPublication = async () => {
  try {
    loading.value = true
    const response = await fetch(`/api/publications/${props.publicationSlug}`)
    
    if (!response.ok) {
      throw new Error('Failed to fetch publication')
    }
    
    publication.value = await response.json()
    
    // Fetch related publications
    await fetchRelatedPublications()
  } catch (err) {
    console.error('Error fetching publication:', err)
    error.value = 'Failed to load article. Please try again.'
  } finally {
    loading.value = false
  }
}

// Fetch related publications based on current article's category
const fetchRelatedPublications = async () => {
  try {
    if (!publication.value?.category) return
    
    const response = await fetch('/api/publication-data')
    const data = await response.json()
    
    // Map category to the corresponding data array key
    const categoryMap = {
      'press-release': 'press_releases',
      'company-activities': 'activities',
      'life-at-hli': 'life_at_hli',
      'article': 'articles'
    }
    
    const categoryKey = categoryMap[publication.value.category]
    
    if (!categoryKey || !data[categoryKey]) {
      relatedPublications.value = []
      return
    }
    
    // Get publications from the same category, exclude current one, limit to 3
    relatedPublications.value = (data[categoryKey] || [])
      .filter(item => item.id !== publication.value?.id)
      .slice(0, 3)
  } catch (err) {
    console.error('Error fetching related publications:', err)
  }
}

// Navigate to article
const viewArticle = (item) => {
  router.visit(`/article/${item.slug}`)
}

// Go back to appropriate page based on category
const goBack = () => {
  if (publication.value?.category === 'life-at-hli') {
    const careerUrl = getLocalizedUrl('/career#lifeathli')
    router.visit(careerUrl)
  } else {
    const publicationUrl = getLocalizedUrl('/publication')
    router.visit(publicationUrl)
  }
}

// Format date
const formatDate = (date) => {
  if (!date) return 'Date not set'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

// Get category label
const getCategoryLabel = (category) => {
  const labels = {
    'press-release': 'Press Release',
    'company-activities': 'Company Activities',
    'life-at-hli': 'Life at HLI',
    'article': 'Article'
  }
  return labels[category] || category
}

// Get related section title based on category
const getRelatedSectionTitle = () => {
  if (!publication.value?.category) return 'Latest Articles'
  
  const titles = {
    'press-release': 'Latest Press Releases',
    'company-activities': 'Latest Company Activities',
    'life-at-hli': 'Latest Life at HLI',
    'article': 'Latest Articles'
  }
  return titles[publication.value.category] || 'Latest Articles'
}

// Get related section description based on category
const getRelatedSectionDescription = () => {
  if (!publication.value?.category) {
    return 'Stay updated with our latest stories on technology, sustainability, and the people driving progress.'
  }
  
  const descriptions = {
    'press-release': 'Stay informed with our latest press releases and official announcements.',
    'company-activities': 'Explore our recent company activities, events, and initiatives.',
    'life-at-hli': 'Discover what life is like at HLI Green Power and meet our team.',
    'article': 'Stay updated with our latest articles on technology, sustainability, and the people driving progress.'
  }
  return descriptions[publication.value.category] || 'Stay updated with our latest stories on technology, sustainability, and the people driving progress.'
}

// Truncate words
const truncateWords = (text, limit) => {
  if (!text) return ''
  const words = text.split(' ')
  if (words.length <= limit) {
    return text
  }
  return words.slice(0, limit).join(' ') + '...'
}

onMounted(() => {
  fetchPublication()
})
</script>
