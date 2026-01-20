<template>
  <Head title="Home - HLI Green Power" />
  <div>
    <section class="relative w-full h-screen bg-white overflow-hidden">
      <div class="absolute inset-0">
        <img :src="homebanner" alt="HLI Factory" class="w-full h-full object-cover object-center brightness-[.85]" style="min-height:950px; max-height:100vh;" />
      </div>
      <div class="relative z-10 h-full flex flex-col justify-start lg:justify-center mt-56 lg:mt-0">
        <div class="container mx-auto max-w-full px-4 sm:px-6 lg:px-32 mt-[-50px] sm:mt-[-80px] md:mt-[-120px] lg:mt-[-200px]">
          <h1 class="w-full max-w-3xl text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight mb-2 sm:mb-4" v-html="t.hero.title">
          </h1>
          <p class="w-full max-w-6xl text-white text-sm sm:text-base md:text-lg lg:text-xl font-normal leading-relaxed" v-html="heroDescription">
          </p>
          <Link :href="getLocalizedUrl('/company')" 
            class="learn-more-btn inline-flex items-center justify-center mt-4 sm:mt-6 px-6 sm:px-8 md:px-12 py-2.5 sm:py-3 rounded-full text-white text-sm sm:text-base lg:text-lg font-medium bg-[rgba(140,140,140,0.25)]s transition-all ease-in-out duration-500 hover:scale-[1.1] hover:shadow-[0_0_35px_5px_rgba(77,158,149,0.5)] cursor-pointer active:duration-200 active:brightness-125 active:saturate-50 active:scale-110 uppercase"
          >
            {{ t.hero.learnMore }}
          </Link>
        </div>
      </div>
    </section>

    <!-- Core Values Section -->
    <section class="relative bg-white py-12 md:py-20 overflow-hidden">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 items-start gap-x-12 gap-y-16 lg:grid-cols-6">         
          <div class="lg:col-span-2">
            <div class="text-2xl sm:text-3xl md:text-[36px] lg:text-[42px] leading-[1.5] md:leading-[1.25] text-left sm:text-center lg:text-left font-medium tracking-normal text-gray-900" v-html="t.coreValues.title">
            </div>
            <p class="mt-4 sm:mt-6 text-xs sm:text-sm md:text-base leading-5 sm:leading-6 md:leading-7 text-gray-600">
              {{ t.coreValues.description }}
            </p>
          </div>

          <div class="lg:col-span-4">
            <div class="grid grid-cols-1 gap-12 md:grid-cols-3">
              <div class="text-center">
                <div class="flex justify-center mb-4">
                  <img :src="icon1" alt="Grow as One Icon" class="h-[150px] w-auto object-contain" />
                </div>
                <div class="text-lg font-medium leading-7 text-gray-900">{{ t.coreValues.growAsOne.title }}</div>
                <p class="mt-2 text-base leading-7 text-gray-600">{{ t.coreValues.growAsOne.description }}</p>
              </div>
              
              <div class="text-center">
                <div class="flex justify-center mb-4">
                  <img :src="icon2" alt="Every Voice Matters Icon" class="h-[150px] w-auto object-contain" />
                </div>
                <div class="text-lg font-medium leading-7 text-gray-900">{{ t.coreValues.everyVoiceMatters.title }}</div>
                <p class="mt-2 text-base leading-7 text-gray-600">{{ t.coreValues.everyVoiceMatters.description }}</p>
              </div>

              <div class="text-center">
                <div class="flex justify-center mb-4">
                  <img :src="icon3" alt="Own Excellence Icon" class="h-[150px] w-auto object-contain" />
                </div>
                <div class="text-lg font-medium leading-7 text-gray-900">{{ t.coreValues.ownExcellence.title }}</div>
                <p class="mt-2 text-base leading-7 text-gray-600">{{ t.coreValues.ownExcellence.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section class="relative min-h-auto md:min-h-screen pb-16 sm:pb-24 md:pb-32 px-4 sm:px-6 md:px-0 xl:px-24 bg-black overflow-hidden scroll-section">
      <div class="absolute inset-0">
        <img :src="factoryRobots" alt="Factory Robots" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-black/60"></div>
      </div>
      <div class="relative z-10 h-auto md:h-full flex flex-col justify-between p-0 sm:p-2 md:p-4 lg:p-2">
        <div class="pt-36 md:pt-45">
          <h2 class="max-w-4xl text-[28px] sm:text-4xl xl:text-6xl font-medium leading-tight text-white word-container text-center md:text-left" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);" v-html="factoryTitleHtml">
          </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 pb-8 mt-16 md:mt-20">
          <Link :href="getLocalizedUrl('/factory')" class="glass-btn group flex items-center justify-between px-4 sm:px-6 py-4 sm:py-5 rounded-xl sm:rounded-2xl text-white transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">
            <span class="text-base sm:text-lg md:text-xl lg:text-2xl">{{ t.factory.insideFactory }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 transform transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] group-hover:translate-x-1"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
          </Link>
          <Link :href="getLocalizedUrl('/sustainability')" class="glass-btn group flex items-center justify-between px-4 sm:px-6 py-4 sm:py-5 rounded-xl sm:rounded-2xl text-white transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">
            <span class="text-base sm:text-lg md:text-xl lg:text-2xl">{{ t.factory.sustainabilityGoals }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 transform transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] group-hover:translate-x-1"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
          </Link>
          <Link :href="getLocalizedUrl('/career')" class="glass-btn group flex items-center justify-between px-4 sm:px-6 py-4 sm:py-5 md:py-7 rounded-xl sm:rounded-2xl text-white transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">
            <span class="text-base sm:text-lg md:text-xl lg:text-2xl">{{ t.factory.careers }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 transform transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] group-hover:translate-x-1"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
          </Link>
        </div>
      </div>
    </section>

    <section class="bg-white py-10 sm:py-16 relative" ref="statsSection">
      <img
        :src="statsDecoration"
        alt="Decoration"
        class="hidden md:block pointer-events-none select-none absolute right-0 bottom-0 h-full max-h-full z-0"
        style="height:100%; width:auto; max-width:451px;"
      />
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-4 relative">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-28 text-center md:text-left">
          <div>
            <div class="border border-black rounded-md px-4 py-1 inline-block mb-4 text-xs md:text-sm">
              {{ t.stats.established }}
            </div>
            <p class="text-6xl lg:text-8xl xl:text-9xl font-bold tracking-tighter text-black">
              <span ref="yearCounter" class="counter">0</span>
            </p>
            <p class="mt-4 max-w-full mx-auto text-black text-sm md:text-base">
              {{ t.stats.establishedDescription }}
            </p>
          </div>
          <div>
            <div class="border border-black rounded-md px-4 py-1 inline-block mb-4 text-xs md:text-sm">
              {{ t.stats.capability }}
            </div>
            <p class="text-6xl lg:text-8xl xl:text-9xl font-bold tracking-tighter text-black">
              <span ref="capacityCounter" class="counter">0</span><span class="text-4xl md:text-5xl lg:text-6xl align-baseline">GWh</span>
            </p>
            <p class="mt-4 max-w-full mx-auto text-black text-sm md:text-base">
              {{ t.stats.capabilityDescription }}
            </p>
          </div>
          <div>
            <div class="border border-black rounded-md px-4 py-1 inline-block mb-4 text-xs md:text-sm">
              {{ t.stats.productionCapacity }}
            </div>
              <p class="text-6xl lg:text-8xl xl:text-9xl font-bold tracking-tighter text-black">
              <span ref="productionCounter" class="counter">0</span><span class="text-4xl md:text-5xl lg:text-6xl align-baseline">m</span>
            </p>
            <p class="mt-4 max-w-full mx-auto text-black text-sm md:text-base">
              {{ t.stats.productionCapacityDescription }}
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="relative bg-white pt-0 pb-10 md:pb-14 overflow-visible">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-4 relative">
        <div>
          <div class="flex items-center gap-x-4 mb-6 md:mb-10">
            <div class="flex-1 h-px bg-[#4D9F95]"></div>
          </div>
          <h2 class="text-2xl sm:text-3xl md:text-4xl font-medium tracking-tight text-gray-900">
            {{ t.articles.title }}
          </h2>
          <p class="mt-4 max-w-3xl text-sm md:text-base leading-7 sm:leading-8 text-gray-600">
            {{ t.articles.description }}
          </p>
          <div class="flex items-center gap-x-4 mt-6 md:mt-10 mb-8 md:mb-12">
            <div class="flex-1 h-px bg-[#4D9F95]"></div>
          </div>
        </div>
        
        <!-- Left side decorative image -->
        <img 
          :src="hseImage2" 
          alt="Latest Articles Decoration" 
          class="hidden md:block absolute top-20 left-0 w-24 h-auto opacity-80 z-10"
          style="margin-left: calc(-100vw + 100% + (100vw - 100%) / 2);"
        />
        
        <!-- ARTICLE LIST SECTION - UPDATED -->
        <div class="flow-root">
          <div class="-my-6 divide-y-2 divide-[#4D9F95]/50">
            <article
              v-for="(article, index) in articles"
              :key="article.id"
              class="py-4"
            >
              <div class="group grid grid-cols-12 gap-x-4 gap-y-2 items-center">
                <div class="col-span-12 lg:col-span-2">
                  <div 
                    class="aspect-[16/9] rounded-lg bg-cover bg-center" 
                    :style="{ backgroundImage: `url(${article.image_url})` }">
                  </div>
                </div>
                <!-- Title, Description, Arrow: align in a row and right-align description/arrow -->
                <div class="col-span-12 lg:col-span-10 flex flex-col md:flex-row md:items-center">
                  <div class="basis-full md:basis-2/5 md:max-w-[40%] px-4">
                    <div class="text-[10px] font-medium tracking-widest text-stone-500 uppercase">{{ formatCategory(article.category) }}</div>
                    <h3 class="text-base md:text-lg font-medium leading-6 text-[#4D9F95] group-hover:text-[#1C3767] transition-colors mb-4 md:mb-0">
                      <Link :href="`/article/${article.slug}`">
                        <span class="absolute inset-0 lg:hidden" aria-hidden="true"></span>
                        {{ article.title }}
                      </Link>
                    </h3>
                  </div>
                  <div class="basis-full md:basis-2/5 md:max-w-[40%] px-4">
                    <p class="text-sm leading-5 text-gray-600 line-clamp-2 mt-2 md:mt-0 md:mb-0 md:text-left">
                      {{ truncateWords(article.text, 60) }}
                    </p>
                  </div>
                  <div class="hidden md:flex items-center basis-full md:basis-1/5 md:max-w-[20%] justify-end">
                    <Link :href="`/article/${article.slug}`" class="relative z-10 flex-shrink-0">
                      <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-400/70 relative">
                        <!-- Main arrow -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="h-4 w-4 relative z-10">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                      </span>
                    </Link>
                  </div>
                </div>
              </div>
            </article>
          </div>
        </div>
        <!-- END OF ARTICLE LIST SECTION -->
        
        <div class="mt-12 md:mt-8 flex items-center justify-center md:justify-end">
          <a href="/publication" class="inline-flex items-center gap-x-3 rounded-full px-7 py-3 text-sm font-semibold text-white shadow-sm transition-colors duration-300 bg-gradient-to-r from-[#7ACAB3] to-[#A0AFF6] hover:opacity-90 mr-4 hover:scale-105">
            {{ t.articles.viewMore }}
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#a7b9b6" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
              </svg>
            </span>
          </a>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { Head, Link } from '@inertiajs/vue3';
import { useLocalization } from '@/composables/useLocalization';

import AppLayout from '@/Layouts/AppLayout.vue'
import homebanner from '@/assets/hli-homebanner.png'
import factoryRobots from '@/assets/machine-home-bg.png'
// Assuming you have these icons in your assets
import icon1 from '@/assets/grow-as-one.png' 
import icon2 from '@/assets/voice-matters.png'
import icon3 from '@/assets/own-excellence.png'
// Tambahkan import gambar dekorasi
import statsDecoration from '@/assets/supegraphic.png'
import hseImage2 from '@/assets/supergraphic-half-circle.png'

gsap.registerPlugin(ScrollTrigger);

defineOptions({
  layout: AppLayout,
})

const { getLocalizedUrl, currentLocale } = useLocalization();

// Translations object
const translations = {
  en: {
    hero: {
      title: "Together,<br/>Lead with Power",
      description: "Power begins when people come together with purpose. At HLI Green Power, we lead through unity, bringing together diverse minds, skilled hands, and dedicated hearts to build something greater than ourselves. Each step we take strengthens the path toward a future shaped by collaboration, responsibility, and sustainable progress.",
      learnMore: "LEARN MORE"
    },
    coreValues: {
      title: "Together,<br>We Power the Future",
      description: "The strength of HLI Green Power lies in how we work together. Our values reflect the spirit that drives us forward. Growing as one team, listening to every voice, and taking pride in every step we take. Together, we create the energy that powers progress for all.",
      growAsOne: {
        title: "Grow as One",
        description: "We move forward together. Progress happens when we support each other, solve problems as a team, and celebrate every win."
      },
      everyVoiceMatters: {
        title: "Every Voice Matters",
        description: "We listen with respect, speak honestly, and learn from every perspective."
      },
      ownExcellence: {
        title: "Own Excellence",
        description: "Every step has an impact. That is why we work with precision, focus, and accountability to ensure the best quality in every process and every result."
      }
    },
    factory: {
      title: "At HLI Green Power,<br>we build battery systems that<br>move more than<br>just vehicles.<br>They move industries,<br>careers, and communities toward a smarter, cleaner future.",
      insideFactory: "Inside Our Factory",
      sustainabilityGoals: "Sustainability Goals",
      careers: "Careers"
    },
    stats: {
      established: "Established",
      establishedDescription: "Driven by a strategic alliance between Hyundai Motor Group and LG Energy Solution to advance EV battery manufacturing.",
      capability: "Capability",
      capabilityDescription: "Built to power the global shift to electric mobility with high-efficiency battery production.",
      productionCapacity: "Production Capacity",
      productionCapacityDescription: "Annual production capacity of 32.6 million unit cells, powering thousands of electric vehicles worldwide."
    },
    articles: {
      title: "Latest Articles",
      description: "Stay updated with our latest stories on technology, sustainability, and the people driving progress in EV battery manufacturing.",
      viewMore: "VIEW MORE"
    },
    categories: {
      'press-release': 'PRESS RELEASE',
      'company-activities': 'COMPANY ACTIVITIES',
      'life-at-hli': 'LIFE AT HLI',
      'article': 'ARTICLES'
    }
  },
  id: {
    hero: {
      title: "Together,<br/>Lead with Power",
      description: "Kekuatan lahir ketika kita bersatu dengan tujuan yang sama. Di HLI Green Power, kami percaya pada kekuatan kebersamaan, menyatukan beragam pemikiran, ketelitian tangan, dan ketulusan hati untuk membangun sesuatu yang melampaui diri kami sendiri. Setiap langkah yang kami ambil memperkuat jalan menuju masa depan yang tumbuh dari kolaborasi, dijaga oleh tanggung jawab, dan digerakkan oleh kemajuan yang berkelanjutan.",
      learnMore: "PELAJARI LEBIH LANJUT"
    },
    coreValues: {
      title: "Bersama,<br/>Kita Gerakkan Masa Depan",
      description: "Kekuatan HLI Green Power terletak pada cara kami bekerja bersama. Nilai-nilai kami mencerminkan semangat yang mendorong kami untuk terus maju. Tumbuh sebagai satu tim, mendengarkan setiap suara, dan bangga atas setiap langkah yang kami ambil. Bersama, kami menciptakan energi yang menggerakkan kemajuan bagi semua.",
      growAsOne: {
        title: "Tumbuh Sebagai Satu",
        description: "Kemajuan terjadi ketika kita melangkah bersama. Dengan saling mendukung, menyelesaikan tantangan sebagai tim, dan merayakan setiap pencapaian."
      },
      everyVoiceMatters: {
        title: "Setiap Suara Berarti",
        description: "Saling mendengarkan, berbicara dengan jujur, dan terbuka pada pandangan berbeda."
      },
      ownExcellence: {
        title: "Keunggulan dalam Tiap Langkah",
        description: "Setiap langkah memiliki dampak. Karena itu, setiap pekerjaan kami lakukan dengan ketelitian, kepedulian, dan tanggung jawab, untuk memastikan kualitas terbaik dalam setiap proses dan hasil."
      }
    },
    factory: {
      title: "Di HLI Green Power,<br>kami membangun sistem baterai berkualitas tinggi<br>dengan fokus pada hal-hal yang benar-benar penting,<br>memperkuat industri, mendukung mobilitas<br>yang lebih bersih,<br>dan menciptakan nilai jangka panjang bagi manusia <br> dan lingkungan sekitar.",
      insideFactory: "Di Dalam Pabrik Kami",
      sustainabilityGoals: "Tujuan Keberlanjutan",
      careers: "Karier"
    },
    stats: {
      established: "Didirikan ",
      establishedDescription: "Digerakkan oleh aliansi strategis antara Hyundai Motor Group dan LG Energy Solution untuk memajukan manufaktur baterai kendaraan listrik.",
      capability: "Kapabilitas",
      capabilityDescription: "Dibangun untuk mendukung peralihan global menuju mobilitas listrik melalui produksi baterai berkeunggulan tinggi.",
      productionCapacity: "Kapasitas Produksi",
      productionCapacityDescription: "Memiliki kapasitas produksi tahunan sebesar 32,6 juta unit sel baterai yang memberi daya bagi ribuan kendaraan listrik di seluruh dunia."
    },
    articles: {
      title: "Artikel Terbaru",
      description: "Tetap terhubung dengan berbagai cerita terbaru  kami tentang teknologi, keberlanjutan, dan orang-orang yang mendorong kemajuan dalam industri manufaktur baterai kendaraan listrik.",
      viewMore: "Lihat selengkapnya"
    },
    categories: {
      'press-release': 'PRESS RELEASE',
      'company-activities': 'COMPANY ACTIVITIES',
      'life-at-hli': 'LIFE AT HLI',
      'article': 'ARTICLES'
    }
  }
};

// Get current translations based on locale
const t = computed(() => {
  return translations[currentLocale.value] || translations.en;
});

// Computed property for hero description with proper HTML breaks
const heroDescription = computed(() => {
  const desc = t.value.hero.description;
  return desc.replace(/\n/g, '<br class="hidden sm:block">');
});

// Computed property for factory title with word spans for animation
const factoryTitleHtml = computed(() => {
  const title = t.value.factory.title;
  // Split by spaces and create word spans, preserving line breaks
  const words = title.split(/(\s+|<br>|<br\/>)/);
  return words.map(word => {
    if (word.match(/<br\/?>/)) {
      return word; // Keep <br> tags as is
    }
    if (word.trim() === '') {
      return word; // Keep whitespace
    }
    return `<span class="word">${word}</span>`;
  }).join('');
});

// Counter animation refs
const statsSection = ref(null);
const yearCounter = ref(null);
const capacityCounter = ref(null);
const productionCounter = ref(null);

const articles = ref([]);

const truncateWords = (text, limit) => {
  if (!text) return '';
  const words = text.split(' ');
  if (words.length <= limit) return text;
  return words.slice(0, limit).join(' ') + '...';
};

const formatCategory = (category) => {
  if (!category) return '';
  return t.value.categories[category] || String(category).toUpperCase();
};

const fetchHomeArticles = async () => {
  try {
    const response = await fetch('/api/publication-data');
    const data = await response.json();
    articles.value = (data.articles || []).slice(0, 3);
  } catch (e) {
    console.error('Failed to load articles for home:', e);
    articles.value = [];
  }
};

// Counter animation function
const animateCounter = (element, targetValue, duration = 2, suffix = '') => {
  const obj = { value: 0 };
  gsap.to(obj, {
    value: targetValue,
    duration: duration,
    ease: "power2.out",
    onUpdate: () => {
      if (suffix === '') {
        // Show decimal places if the target value has decimals
        if (targetValue % 1 !== 0) {
          element.textContent = obj.value.toFixed(1);
        } else {
          element.textContent = Math.round(obj.value);
        }
      } else {
        element.textContent = obj.value.toFixed(1) + suffix;
      }
    }
  });
};

onMounted(() => {
  const words = gsap.utils.toArray('.word');
  gsap.set(words, { opacity: 0.2 });
  const timeline = gsap.timeline();
  words.forEach(word => {
    timeline.to(word, {
      opacity: 1,
      stagger: 0.1
    });
  });

  ScrollTrigger.create({
    trigger: ".scroll-section",
    start: "top top",
    end: "+=1200",
    pin: true,
    scrub: 1,
    animation: timeline,
  });

  // Counter animation trigger
  ScrollTrigger.create({
    trigger: statsSection.value,
    start: "top 80%",
    onEnter: () => {
      animateCounter(yearCounter.value, 2021, 2);
      animateCounter(capacityCounter.value, 10, 2);
      animateCounter(productionCounter.value, 32.6, 2, '');
    }
  });

  // Load latest articles
  fetchHomeArticles();
});
</script>

<style scoped>
/* Learn More Button with gradient background */
.learn-more-btn {
  background-image: linear-gradient(255.44deg, rgba(160, 175, 246, 0.7) 11.31%, rgba(122, 202, 179, 0.7) 90.76%);
  background-color: rgba(140, 140, 140, 0.25);
}

/* Glass Button - True Glassmorphism Effect */
.glass-btn {
  background: linear-gradient(
    -135deg,
    rgba(255, 255, 255, 0.15) 0%,
    rgba(255, 255, 255, 0.08) 50%,
    rgba(255, 255, 255, 0.12) 100%
  );
  backdrop-filter: blur(24px) saturate(180%);
  -webkit-backdrop-filter: blur(24px) saturate(180%);
  border: 1px solid rgba(255, 255, 255, 0.25);
  box-shadow: 
    0 8px 32px rgba(0, 0, 0, 0.15),
    inset 0 1px 1px rgba(255, 255, 255, 0.3),
    inset 0 -1px 1px rgba(255, 255, 255, 0.1);
}

/* Glass Button Hover - Gradient Lavender Purple to Glacial Minter */
.glass-btn:hover {
  background: linear-gradient(
    135deg,
    rgba(160, 175, 246, 0.5) 0%,
    rgba(122, 202, 179, 0.5) 100%
  );
  border: 1px solid rgba(255, 255, 255, 0.4);
  box-shadow: 
    0 0 35px 5px rgba(77, 158, 149, 0.5),
    inset 0 1px 1px rgba(255, 255, 255, 0.5),
    inset 0 -1px 1px rgba(255, 255, 255, 0.2);
}
</style>
