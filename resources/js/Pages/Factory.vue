<template>
  <Head title="Factory - HLI Green Power" />
  <div>
    <section id="overview" class="container mx-auto max-w-7xl px-4 pt-32 md:pt-40 pb-16">
      <div>
        <div class="flex items-center gap-x-4">
          <div class="w-11 h-px bg-[#4D9F95]"></div>
          <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
            {{ t.sections.facilityOverview }}
          </h2>
        </div>
      </div>
    </section>

    <div class="relative w-full bg-white overflow-hidden h-[250px] sm:h-[350px] md:h-[472px]">
      <div class="absolute inset-0">
        <img :src="factoryBanner" alt="HLI Factory" class="w-full h-full object-cover object-center" />
      </div>
    </div>

    <section class="bg-[#4D9F95] text-white py-16 md:py-24" ref="statsSection">
      <div class="container mx-auto md:mx-4 xl:mx-auto px-4 md:px-2 lg:px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-16 text-center md:text-left">
          <div>
            <div class="border border-white rounded-md px-4 py-1 inline-block mb-4 text-xs md:text-sm font-medium">{{ t.stats.established }}</div>
            <p class="text-6xl lg:text-8xl xl:text-9xl font-bold tracking-tighter">
              <span ref="yearCounter" class="counter">0</span>
            </p>
            <p class="mt-4 mr-0 md:mr-10 text-white text-sm md:text-base">{{ t.stats.establishedDescription }}</p>
          </div>
          <div>
            <div class="border border-white rounded-md px-4 py-1 inline-block mb-4 text-xs md:text-sm font-medium">{{ t.stats.capability }}</div>
            <p class="text-6xl lg:text-8xl xl:text-9xl font-bold tracking-tighter">
              <span ref="capacityCounter" class="counter">0</span><span class="text-4xl md:text-5xl lg:text-6xl align-baseline">GWh</span>
            </p>
            <p class="mt-4 text-white text-sm md:text-base">{{ t.stats.capabilityDescription }}</p>
          </div>
          <div>
            <div class="border border-white rounded-md px-4 py-1 inline-block mb-4 text-xs md:text-sm font-medium">{{ t.stats.productionCapacity }}</div>
            <p class="text-6xl lg:text-8xl xl:text-9xl font-bold tracking-tighter">
              <span ref="productionCounter" class="counter">0</span><span class="text-4xl md:text-5xl lg:text-6xl align-baseline">m</span>
            </p>
            <p class="mt-4 text-white text-sm md:text-base">{{ t.stats.productionCapacityDescription }}</p>
          </div>
        </div>
      </div>
    </section>

    <section id="capability" class="bg-white py-16 md:py-24">
      <div class="container mx-auto max-w-7xl px-4">
        <div class="flex items-center gap-x-4 mb-6 md:mb-10">
          <div class="w-11 h-px bg-[#4D9F95]"></div> 
          <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-tight">
            {{ t.sections.nickelDownstream }}
          </h2>
        </div>
        
        <div class="hidden sm:block">
          <img 
            :src="hardware" 
            alt="Overview EV Ecosystem"
            class="w-full h-auto rounded-xl"
          />
        </div>
        <div class="block sm:hidden">
          <img 
            :src="hardwareMobile" 
            alt="Overview EV Ecosystem"
            class="w-full h-auto rounded-xl"
          />
        </div>

        <div class="mt-8 sm:mt-12 space-y-6 sm:space-y-8 text-gray-700 text-base sm:text-lg leading-relaxed">
          <div>
            <p>
              {{ t.ecosystem.paragraph1 }}
            </p>
            <hr class="mt-8 border-t border-[#4D9F95]">
          </div>

          <div>
            <p>
              {{ t.ecosystem.paragraph2 }}
            </p>
            <hr class="mt-8 border-t border-[#4D9F95]">
          </div>

          <div>
            <p>
              {{ t.ecosystem.paragraph3 }}
            </p>
          </div>

        </div>
      </div>
    </section>
    
    <section class="bg-white py-16 md:py-24 relative overflow-visible">
      <div class="container mx-auto max-w-7xl px-4">
        <div class="flex items-center gap-x-4 mb-10">
          <div class="w-11 h-px bg-[#4D9F95]"></div> 
          <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
            {{ t.sections.manufacturingProcess }}
          </h2>
        </div>
        
        <div class="mb-2">
          <img 
            :src="manufacturing" 
            alt="Overview Manufacturing Process"
            class="w-full h-auto rounded-xl"
          />
        </div>
      </div>
      
      <!-- Decorative image at right edge -->
      <img 
        :src="hseImage" 
        alt="Manufacturing Process Decoration" 
        class="hidden md:block absolute top-20 right-0 w-28 h-auto z-10"
        style="margin-right: calc(-100vw + 100% + (100vw - 100%) / 2);"
      />
    </section>

    <section class="container mx-auto max-w-7xl px-4 pt-4 md:pt-8 pb-16 md:pb-24 relative overflow-visible">
      <div class="flex items-center gap-x-4 mb-10">
        <div class="w-11 h-px bg-[#4D9F95]"></div>
        <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
          {{ t.sections.gallery }}
        </h2>
      </div>
        
      <!-- Left side decorative image -->
      <img 
        :src="hseImage2" 
        alt="Gallery Decoration" 
        class="hidden md:block absolute top-20 left-0 w-24 h-auto opacity-80 z-10"
        style="margin-left: calc(-100vw + 100% + (100vw - 100%) / 2);"
      />
      <div class="relative mb-6 overflow-hidden rounded-xl aspect-video md:aspect-[2.4/1]">
        <Transition 
          name="slide"
          @enter="onEnter"
          @leave="onLeave"
        >
          <img 
            :key="currentIndex"
            :src="currentFacility.src" 
            :alt="currentFacility.name"
            class="absolute inset-0 w-full h-full object-cover shadow-lg"
          >
        </Transition>
        <button 
          @click="prevImage" 
          class="carousel-arrow-btn absolute cursor-pointer left-4 top-1/2 -translate-y-1/2 text-white rounded-full p-2.5 z-10"
        >
          <Icon icon="gg:arrow-left" class="h-5 w-5 sm:h-7 sm:w-7 text-white" />
        </button>
        <button 
          @click="nextImage" 
          class="carousel-arrow-btn absolute cursor-pointer right-4 top-1/2 -translate-y-1/2 text-white rounded-full p-2.5 flex items-center justify-center z-10"
        >
          <Icon icon="gg:arrow-right" class="h-5 w-5 sm:h-7 sm:w-7 text-white" />
        </button>
      </div>
      <div class="relative">
        <!-- Panah kiri -->
        <button
          @click="scrollThumbnailsLeft"
          class="carousel-arrow-btn absolute cursor-pointer left-0 top-1/2 -translate-y-1/2 z-10 text-white rounded-full p-2.5 ml-2"
          aria-label="Scroll thumbnails left"
        >
          <Icon icon="gg:arrow-left" class="h-5 w-5 sm:h-7 sm:w-7 text-white" />
        </button>
        <!-- Gradient masking kiri -->
        <div class="pointer-events-none absolute left-0 top-0 h-full w-12 z-10"
            style="background: linear-gradient(to right, white 0%, transparent 100%);"></div>
        <!-- Thumbnail wrapper -->
        <div class="overflow-hidden px-2 pl-16 pr-16" ref="thumbnailsWrapperRef">
          <div ref="thumbnailsRef" class="flex gap-3 md:gap-4 min-w-max flex-nowrap items-center" style="width:100%;">
            <!-- Looping thumbnails: tampilkan 3x array -->
            <div 
              v-for="(facility, i) in facilities.concat(facilities).concat(facilities)" 
              :key="i"
              @click="selectImage(i % facilities.length)"
              :class="[
                'thumb-item relative cursor-pointer group rounded-2xl flex-shrink-0 transition-all duration-300 ease-in-out',
                // Hapus margin khusus di awal/akhir agar tidak ada gap
              ]"
              style="width: 90px; height: 90px;"
            >
              <img :src="facility.src" :alt="facility.name" class="w-full h-full object-cover rounded-2xl transition-all duration-300 group-hover:brightness-110">
              <div 
                class="absolute inset-0 bg-black/50 rounded-2xl transition-all duration-300"
                :class="{ 
                  'opacity-0': currentIndex === (i % facilities.length),
                  'group-hover:opacity-30': currentIndex !== (i % facilities.length)
                }"
              ></div>
              <!-- Facility name label - visible on active or hover -->
              <div 
                class="absolute bottom-0 left-0 right-0 bg-teal-500/30 backdrop-blur-md border border-teal-300/50 flex items-center justify-center p-1 rounded-2xl transition-all duration-300 shadow-lg"
                :class="currentIndex === (i % facilities.length) ? 'opacity-100' : 'opacity-0 group-hover:opacity-100'"
              >
                <span class="text-white font-medium text-[8px] sm:text-[9px] md:text-[10px] text-center leading-tight drop-shadow-md">{{ facility.name }}</span>
              </div>
              <!-- Hover effect glow -->
              <div class="absolute inset-0 rounded-2xl transition-all duration-300 group-hover:shadow-[0_0_20px_rgba(122,202,179,0.6)]"></div>
            </div>
          </div>
        </div>
        <!-- Gradient masking kanan -->
        <div class="pointer-events-none absolute right-0 top-0 h-full w-12 z-10"
            style="background: linear-gradient(to left, white 0%, transparent 100%);"></div>
        <!-- Panah kanan -->
        <button
          @click="scrollThumbnailsRight"
          class="carousel-arrow-btn absolute cursor-pointer right-0 top-1/2 -translate-y-1/2 z-10 text-white rounded-full p-2.5 mr-2"
          aria-label="Scroll thumbnails right"
        >
          <Icon icon="gg:arrow-right" class="h-5 w-5 sm:h-7 sm:w-7 text-white" />
        </button>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useLocalization } from '@/composables/useLocalization'
import { Icon } from '@iconify/vue'

// Import gambar fasilitas (sudah ada)
import img1 from '@/assets/atm-facility.png'
import img2 from '@/assets/audit-facility.png'
import img3 from '@/assets/bus-facility.png'
import img4 from '@/assets/cafe-facility.png'
import img5 from '@/assets/clinic-facility.png'
import img6 from '@/assets/gym-facility.png'
import img7 from '@/assets/lounge-facility.png'
import img8 from '@/assets/lecture-facility.png'
import img9 from '@/assets/sport-facility.png'
import img10 from '@/assets/cafe2-facility.png'
import img11 from '@/assets/cafe-soul.png'
import img12 from '@/assets/minimarket.png'
import img13 from '@/assets/canteen.png'
import img14 from '@/assets/mosque.png'
import hardware from '@/assets/hli-hardware.png'
import hardwareMobile from '@/assets/hli-hardware-mobile.png'
import manufacturing from '@/assets/factory-manufacturing-process.png'
import factoryBanner from '@/assets/hli-our-factory.png'
import hseImage from '@/assets/supergraphic-dots.png'
import hseImage2 from '@/assets/supergraphic-half-circle.png'

gsap.registerPlugin(ScrollTrigger);

defineOptions({
  layout: AppLayout,
})

const { currentLocale } = useLocalization()

// Translations object
const translations = {
  en: {
    sections: {
      facilityOverview: "FACILITY OVERVIEW",
      nickelDownstream: "OVERVIEW NICKEL DOWNSTREAM AND EV ECOSYSTEM",
      manufacturingProcess: "OVERVIEW MANUFACTURING PROCESS",
      gallery: "GALLERY"
    },
    stats: {
      established: "Established",
      establishedDescription: "Driven by a strategic alliance between Hyundai Motor Group and LG Energy Solution to advance EV battery manufacturing.",
      capability: "Capability",
      capabilityDescription: "Built to power the global shift to electric mobility with high-efficiency battery production.",
      productionCapacity: "Production Capacity",
      productionCapacityDescription: "Annual production capacity of 32.6 million unit cells, powering thousands of electric vehicles worldwide."
    },
    ecosystem: {
      paragraph1: "As one of the countries that has the most nickel reserve in the world, Indonesia is a strategic country for EV Battery cells making which main content is nickel.",
      paragraph2: "Our company has been established on the concept of a Smart Factory and uses the most recent technology to produce 10 GWh of lithium-ion battery cells for electric vehicles.",
      paragraph3: "PT HLI Green Power applied latest stacking method technology in LGES called AZS that have better quality and increased safety of our cells."
    },
    facilities: {
      auditorium: "Auditorium",
      trainingRoom: "Training Room",
      clinic: "Clinic",
      bus: "Bus",
      gym: "Gym",
      sportCentre: "Sport Centre",
      lounge: "Lounge",
      cafeIn: "Cafe-in",
      cafeDua: "Cafe-Dua",
      cafeSoul: "Cafe-Soul",
      atmCenter: "ATM Center",
      minimarket: "Minimarket",
      canteen: "Canteen",
      mosque: "Mosque"
    }
  },
  id: {
    sections: {
      facilityOverview: "FASILITAS KAMI",
      nickelDownstream: "GAMBARAN UMUM HILIRISASI NIKEL DAN EKOSISTEM KENDARAAN LISTRIK",
      manufacturingProcess: "GAMBARAN UMUM PROSES MANUFAKTUR",
      gallery: "GALLERY"
    },
    stats: {
      established: "Didirikan",
      establishedDescription: "Digerakkan oleh aliansi strategis antara Hyundai Motor Group dan LG Energy Solution untuk memajukan manufaktur baterai kendaraan listrik.",
      capability: "Kapabilitas",
      capabilityDescription: "Dibangun untuk mendukung peralihan global menuju mobilitas listrik melalui produksi baterai berkeunggulan tinggi.",
      productionCapacity: "Kapasitas Produksi",
      productionCapacityDescription: "Memiliki kapasitas produksi tahunan sebesar 32,6 juta unit sel baterai yang memberi daya bagi ribuan kendaraan listrik di seluruh dunia."
    },
    ecosystem: {
      paragraph1: "Sebagai salah satu negara dengan cadangan nikel terbesar di dunia, Indonesia merupakan lokasi strategis untuk pembuatan sel baterai kendaraan listrik yang bahan utamanya adalah nikel.",
      paragraph2: "Perusahaan kami didirikan dengan konsep Smart Factory dan menggunakan teknologi terkini untuk memproduksi 10 GWh sel baterai lithium-ion untuk kendaraan listrik.",
      paragraph3: "HLI Green Power menerapkan teknologi metode stacking terbaru dari LGES yang disebut AZS, yang menghasilkan kualitas lebih baik serta meningkatkan keamanan pada setiap sel yang kami produksi."
    },
    facilities: {
      auditorium: "Auditorium",
      trainingRoom: "Training Room",
      clinic: "Clinic",
      bus: "Bus",
      gym: "Gym",
      sportCentre: "Sport Centre",
      lounge: "Lounge",
      cafeIn: "Cafe-in",
      cafeDua: "Cafe-Dua",
      cafeSoul: "Cafe-Soul",
      atmCenter: "ATM Center",
      minimarket: "Minimarket",
      canteen: "Canteen",
      mosque: "Mosque"
    }
  }
}

// Get current translations based on locale
const t = computed(() => {
  return translations[currentLocale.value] || translations.en
})

// Counter animation refs
const statsSection = ref(null);
const yearCounter = ref(null);
const capacityCounter = ref(null);
const productionCounter = ref(null);

const facilities = computed(() => [
  { id: 1, name: t.value.facilities.auditorium, src: img2 },
  { id: 2, name: t.value.facilities.trainingRoom, src: img8 },
  { id: 3, name: t.value.facilities.clinic, src: img5 },
  { id: 4, name: t.value.facilities.bus, src: img3 },
  { id: 5, name: t.value.facilities.gym, src: img6 },
  { id: 6, name: t.value.facilities.sportCentre, src: img9 },
  { id: 7, name: t.value.facilities.lounge, src: img7 },
  { id: 8, name: t.value.facilities.cafeIn, src: img4 },
  { id: 9, name: t.value.facilities.cafeDua, src: img10 },
  { id: 10, name: t.value.facilities.cafeSoul, src: img11 },
  { id: 11, name: t.value.facilities.atmCenter, src: img1 },
  { id: 12, name: t.value.facilities.minimarket, src: img12 },
  { id: 13, name: t.value.facilities.canteen, src: img13 },
  { id: 14, name: t.value.facilities.mosque, src: img14 },
]);

const thumbnailsRef = ref(null);
const thumbnailsWrapperRef = ref(null);

// Fungsi scroll thumbnails strip ke kiri/kanan (tanpa mengubah currentIndex)
const scrollThumbnailsLeft = () => {
  const wrapper = thumbnailsWrapperRef.value;
  if (!wrapper) return;
  // Jika sudah hampir di ujung kiri, reset ke tengah
  if (wrapper.scrollLeft < 100) {
    checkAndResetLoopScroll();
    setTimeout(() => wrapper.scrollBy({ left: -200, behavior: 'smooth' }), 10);
  } else {
    wrapper.scrollBy({ left: -200, behavior: 'smooth' });
  }
};
const scrollThumbnailsRight = () => {
  const wrapper = thumbnailsWrapperRef.value;
  if (!wrapper) return;
  // Jika sudah hampir di ujung kanan, reset ke tengah
  if (wrapper.scrollWidth - wrapper.clientWidth - wrapper.scrollLeft < 300) {
    checkAndResetLoopScroll();
    setTimeout(() => wrapper.scrollBy({ left: 200, behavior: 'smooth' }), 10);
  } else {
    wrapper.scrollBy({ left: 200, behavior: 'smooth' });
  }
};

const THUMB_LOOP = 3; // jumlah pengulangan array

// Fungsi untuk reset scroll ke tengah strip jika sudah di ujung
const checkAndResetLoopScroll = () => {
  const wrapper = thumbnailsWrapperRef.value;
  const container = thumbnailsRef.value;
  if (!wrapper || !container) return;
  const base = facilities.value.length;
  const thumbnails = container.querySelectorAll('.thumb-item');
  // thumbnail tengah
  const middleStart = base;
  const thumbnail = thumbnails[middleStart];
  if (!thumbnail) return;
  const wrapperWidth = wrapper.offsetWidth;
  const scrollPosition = thumbnail.offsetLeft - (wrapperWidth / 2) + (thumbnail.offsetWidth / 2);
  wrapper.scrollTo({ left: scrollPosition, behavior: 'auto' });
};

// Fungsi untuk scroll thumbnail wrapper agar active thumbnail terlihat di tengah
const scrollToActiveThumbnail = (index) => {
  const wrapper = thumbnailsWrapperRef.value;
  const container = thumbnailsRef.value;
  if (!wrapper || !container) return;
  
  const base = facilities.value.length;
  const thumbnails = container.querySelectorAll('.thumb-item');
  
  // Gunakan thumbnail dari grup tengah (index + base) untuk posisi yang konsisten
  const targetThumbnailIndex = index + base;
  const thumbnail = thumbnails[targetThumbnailIndex];
  if (!thumbnail) return;
  
  const wrapperWidth = wrapper.offsetWidth;
  const wrapperScrollLeft = wrapper.scrollLeft;
  const thumbnailLeft = thumbnail.offsetLeft;
  const thumbnailWidth = thumbnail.offsetWidth;
  
  // Hitung posisi thumbnail relatif terhadap viewport wrapper
  const thumbnailRelativeLeft = thumbnailLeft - wrapperScrollLeft;
  const thumbnailRelativeRight = thumbnailRelativeLeft + thumbnailWidth;
  
  // Cek apakah thumbnail berada di area tengah yang terlihat (dengan margin)
  const visibleMargin = 100; // margin dari tepi
  const isVisible = thumbnailRelativeLeft >= visibleMargin && 
                    thumbnailRelativeRight <= (wrapperWidth - visibleMargin);
  
  // Jika tidak terlihat di tengah, scroll ke posisi tengah
  if (!isVisible) {
    const scrollPosition = thumbnailLeft - (wrapperWidth / 2) + (thumbnailWidth / 2);
    wrapper.scrollTo({ left: scrollPosition, behavior: 'smooth' });
  }
};

const currentIndex = ref(0);
const currentFacility = computed(() => facilities.value[currentIndex.value]);

// Add animation direction tracking
const slideDirection = ref('next');

const nextImage = () => { 
  slideDirection.value = 'next';
  currentIndex.value = (currentIndex.value + 1) % facilities.value.length;
  // Sync thumbnail wrapper dengan main image
  setTimeout(() => scrollToActiveThumbnail(currentIndex.value), 50);
};

const prevImage = () => { 
  slideDirection.value = 'prev';
  currentIndex.value = (currentIndex.value - 1 + facilities.value.length) % facilities.value.length;
  // Sync thumbnail wrapper dengan main image
  setTimeout(() => scrollToActiveThumbnail(currentIndex.value), 50);
};

const selectImage = (index) => {
  slideDirection.value = index > currentIndex.value ? 'next' : 'prev';
  currentIndex.value = index;
  // Sync thumbnail wrapper dengan selected image
  setTimeout(() => scrollToActiveThumbnail(index), 50);
};

// Animation handlers
const onEnter = (el) => {
  gsap.fromTo(el, 
    { 
      x: slideDirection.value === 'next' ? '100%' : '-100%',
      opacity: 0 
    },
    { 
      x: '0%',
      opacity: 1,
      duration: 0.5,
      ease: "power2.out"
    }
  );
};

const onLeave = (el, done) => {
  gsap.to(el, {
    x: slideDirection.value === 'next' ? '-100%' : '100%',
    opacity: 0,
    duration: 0.5,
    ease: "power2.out",
    onComplete: done
  });
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
        // Check if target value has decimal places, if so show 1 decimal place
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
  
  // Set posisi scroll ke tengah strip saat load dan center pada active thumbnail
  setTimeout(() => scrollToActiveThumbnail(currentIndex.value), 100);
});
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: all 0.5s ease-out;
}

.slide-enter-from {
  transform: translateX(100%);
  opacity: 0;
}

.slide-leave-to {
  transform: translateX(-100%);
  opacity: 0;
}

/* Carousel Arrow Button - Dark Glassmorphism (same as ScrollToTopButton) */
.carousel-arrow-btn {
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
  transition: all 0.3s ease;
}

/* Hover - Gradient Lavender Purple to Glacial Minter with Glass effect */
.carousel-arrow-btn:hover {
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
  transform: scale(1.1);
}

.carousel-arrow-btn:active {
  transform: scale(0.95);
}
</style>