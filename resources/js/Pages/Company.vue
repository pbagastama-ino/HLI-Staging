<template>
  <Head title="Company - HLI Green Power" />
  <div class="bg-white text-black antialiased">
    <!-- Decorative image at right edge -->
    <img 
      :src="hseImage" 
      alt="Company Overview Decoration" 
      class="hidden lg:block absolute top-[580px] right-0 w-32 h-auto z-10 mr-0 ml-auto"
    />
    <div id="overview" class="relative min-h-screen container mx-auto max-w-7xl px-4 pt-32 md:pt-40 pb-16 md:pb-24 overflow-visible">

      <div class="flex flex-col md:flex-row gap-8 lg:gap-x-24">
        <div class="flex-shrink-0 md:pt-2">
          <div class="flex flex-row items-center gap-x-4">
            <div class="w-11 h-px bg-[#4D9F95]"></div>
            <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
              {{ t.sections.companyOverview }}
            </h2>
          </div>
        </div>
        <div class="flex flex-col w-full items-center mr-0 md:mr-12 lg:mr-20">
          <div class="w-full mr">
            <p class="text-sm sm:text-base md:text-lg lg:text-2xl leading-relaxed text-left tracking-[0%]">
              {{ t.overview.paragraph1 }}
            </p>
            <p class="mt-6 sm:mt-8 text-sm sm:text-base md:text-lg lg:text-2xl leading-relaxed text-left">
              {{ t.overview.paragraph2 }}
            </p>
            <p class="mt-6 sm:mt-8 text-sm sm:text-base md:text-lg lg:text-2xl leading-relaxed text-left">
              {{ t.overview.paragraph3 }}
            </p>
            <p class="mt-6 sm:mt-8 text-sm sm:text-base md:text-lg lg:text-2xl font-bold leading-relaxed text-left">
              {{ t.overview.paragraph4 }}<br/>{{ t.overview.paragraph5 }}
            </p>
          </div>
        </div>
      </div>    
      <div 
        ref="parallaxSection"
        class="relative mt-8 md:mt-24 h-[360px] sm:h-[500px] md:h-[600px] w-full max-w-7xl mx-auto overflow-hidden"
      >
        <img 
          ref="factoryImage"
          class="parallax-image absolute top-0 left-0 w-[80%] md:w-[60%] lg:w-[640px] h-auto object-cover z-10 rounded-2xl shadow-lg transition-all duration-1000 ease-out transform" 
          :class="factoryImageVisible ? 'opacity-100 translate-x-0 translate-y-0' : 'opacity-0 -translate-x-8 -translate-y-8'"
          :src="factory" 
          alt="Aerial view of HLI Green Power factory" 
        />
        <img 
          ref="facilityImage"
          class="parallax-image absolute bottom-0 right-0 w-[80%] md:w-[60%] lg:w-[640px] h-auto object-cover z-20 rounded-2xl shadow-lg transition-all duration-1000 ease-out transform delay-500" 
          :class="facilityImageVisible ? 'opacity-100 translate-x-0 translate-y-0' : 'opacity-0 translate-x-8 translate-y-8'"
          :src="facility" 
          alt="Industrial facility pipes and towers" 
        />
      </div>
      
      <div id="vision" class="mt-20 md:mt-32">
        <div>
          <div class="flex flex-row items-center gap-x-4">
            <div class="w-11 h-px bg-[#4D9F95]"></div>
            <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
              {{ t.sections.brandVision }}
            </h2>
          </div>
          <div class="mt-6 sm:mt-8">
            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-medium leading-tight" v-html="t.vision.title">
            </h2>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 md:gap-8 lg:gap-6 gap-y-10 sm:gap-y-8 mt-12 sm:mt-16 items-stretch">
          <div class="relative h-full">
            <div class="absolute bottom-0 left-0 w-full h-full bg-[#4D9E95]/50 rounded-3xl translate-y-3"></div>
            <div class="relative bg-white drop-shadow-xl rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 h-full flex flex-col text-left overflow-hidden">
              <img :src="iconCare" alt="We Build with Care Icon" class="w-36 h-36 sm:w-40 sm:h-40 mb-4 sm:mb-6 mx-auto flex-shrink-0" />
              <h3 class="font-bold text-lg sm:text-xl mb-2 sm:mb-3 flex-shrink-0">{{ t.vision.buildWithCare.title }}</h3>
              <p class="text-stone-600 leading-relaxed mt-2 sm:mt-4 text-sm sm:text-base flex-grow h-">
                {{ t.vision.buildWithCare.description }}
              </p>
            </div>
          </div>
          <div class="relative h-full">
            <div class="absolute bottom-0 left-0 w-full h-full bg-[#4D9E95]/50 rounded-3xl translate-y-3"></div>
            <div class="relative bg-white drop-shadow-xl rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 h-full flex flex-col text-left overflow-hidden">
              <img :src="iconDiversity" alt="We Grow Through Diversity Icon" class="w-36 h-36 sm:w-40 sm:h-40 mb-4 sm:mb-6 mx-auto flex-shrink-0" />
              <h3 class="font-bold text-lg sm:text-xl mb-2 sm:mb-3 flex-shrink-0">{{ t.vision.growThroughDiversity.title }}</h3>
              <p class="text-stone-600 leading-relaxed mt-2 sm:mt-4 text-sm sm:text-base flex-grow">
                {{ t.vision.growThroughDiversity.description }}
              </p>
            </div>
          </div>
          <div class="relative h-full">
            <div class="absolute bottom-0 left-0 w-full h-full bg-[#4D9E95]/50 rounded-3xl translate-y-3"></div>
            <div class="relative bg-white drop-shadow-xl rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 h-full flex flex-col text-left overflow-hidden">
              <img :src="iconIntegrity" alt="We Lead with Integrity Icon" class="w-36 h-36 sm:w-40 sm:h-40 mb-4 sm:mb-6 mx-auto flex-shrink-0" />
              <h3 class="font-bold text-lg sm:text-xl mb-2 sm:mb-3 flex-shrink-0">{{ t.vision.leadWithIntegrity.title }}</h3>
              <p class="text-stone-600 leading-relaxed mt-2 sm:mt-4 text-sm sm:text-base flex-grow">
                {{ t.vision.leadWithIntegrity.description }}
              </p>
            </div>
          </div>
          <div class="relative h-full">
            <div class="absolute bottom-0 left-0 w-full h-full bg-[#4D9E95]/50 rounded-3xl translate-y-3"></div>
            <div class="relative bg-white drop-shadow-xl rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 h-full flex flex-col text-left overflow-hidden">
              <img :src="iconAsOne" alt="We Move as One Icon" class="w-36 h-36 sm:w-40 sm:h-40 mb-4 sm:mb-6 mx-auto flex-shrink-0" />
              <h3 class="font-bold text-lg sm:text-xl mb-2 sm:mb-3 flex-shrink-0">{{ t.vision.moveAsOne.title }}</h3>
              <p class="text-stone-600 leading-relaxed mt-2 sm:mt-4 text-sm sm:text-base flex-grow">
                {{ t.vision.moveAsOne.description }}
              </p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="mt-20 md:mt-32 relative overflow-visible">
        <div class="relative z-10">
          <div class="flex flex-row items-center gap-x-4">
            <div class="w-11 h-px bg-[#4D9F95]"></div>
            <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-tight">
              {{ t.sections.brandMission }}
            </h2>
          </div>
          <div class="mt-6 sm:mt-8">
            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-medium leading-tight" v-html="t.mission.title">
            </h2>
          </div>
        </div>

        <!-- Left side decorative image -->
        <img 
          :src="hseImage3" 
          alt="Brand Mission Decoration" 
          class="hidden md:block absolute top-0 -right-32 w-28 h-auto opacity-80 z-20"
        />

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 md:gap-8 gap-y-10 sm:gap-y-20 mt-12 sm:mt-16 relative z-10 items-stretch">
          <div class="relative min-h-auto md:min-h-[600px] lg:min-h-[450px]">
            <div class="absolute bottom-0 left-0 w-full h-full md:h-[400px] lg:h-full bg-[#4D9E95]/50 rounded-3xl translate-y-3"></div>
            <div class="relative bg-white drop-shadow-xl rounded-3xl p-6 md:p-8 h-auto sm:h-[425px] md:h-[590px] lg:h-[450px] flex flex-col overflow-hidden">
              <img :src="iconStrengthen" alt="Enable Cleaner Mobility Icon" class="w-36 h-36 sm:w-40 sm:h-40 mb-4 md:mb-6 mx-auto flex-shrink-0" />
              <h3 class="font-bold text-xl mb-3 md:mb-4 flex-shrink-0">{{ t.mission.strengthenIndustry.title }}</h3>
              <p class="text-stone-600 leading-relaxed flex-grow text-sm md:text-base">
                {{ t.mission.strengthenIndustry.description }}
              </p>
            </div>
          </div>
          <div class="relative min-h-auto md:min-h-[600px] lg:min-h-[450px]">
            <div class="absolute bottom-0 left-0 w-full h-full md:h-[400px] lg:h-full bg-[#4D9E95]/50 rounded-3xl translate-y-3"></div>
            <div class="relative bg-white drop-shadow-xl rounded-3xl p-6 md:p-8 h-auto sm:h-[425px] md:h-[590px] lg:h-[450px] flex flex-col overflow-hidden">
              <img :src="iconMobility" alt="Enable Cleaner Mobility Icon" class="w-36 h-36 sm:w-40 sm:h-40 mb-4 md:mb-6 mx-auto flex-shrink-0" />
              <h3 class="font-bold text-xl mb-3 md:mb-4 flex-shrink-0">{{ t.mission.enableCleanerMobility.title }}</h3>
              <p class="text-stone-600 leading-relaxed flex-grow text-sm md:text-base">
                {{ t.mission.enableCleanerMobility.description }}
              </p>
            </div>
          </div>
          <div class="relative min-h-auto md:min-h-[600px] lg:min-h-[450px]">
            <div class="absolute bottom-0 left-0 w-full h-full md:h-[400px] lg:h-full bg-[#4D9E95]/50 rounded-3xl translate-y-3"></div>
            <div class="relative bg-white drop-shadow-xl rounded-3xl p-6 md:p-8 h-auto sm:h-[425px] md:h-[590px] lg:h-[450px] flex flex-col overflow-hidden">
              <img :src="iconWorkIntegrity" alt="Work with Integrity Icon" class="w-36 h-36 sm:w-40 sm:h-40 mb-4 md:mb-6 mx-auto flex-shrink-0" />
              <h3 class="font-bold text-xl mb-3 md:mb-4 flex-shrink-0">{{ t.mission.workWithIntegrity.title }}</h3>
              <p class="text-stone-600 leading-relaxed flex-grow text-sm md:text-base">
                {{ t.mission.workWithIntegrity.description }}
              </p>
            </div>
          </div>

        </div>
      </div>

      <div id="history" class="flex flex-col md:flex-row gap-8 md:gap-x-16 mt-20 md:mt-32">
        <div class="flex-shrink-0 md:pt-2">
          <div class="flex flex-row items-center gap-x-4">
            <div class="w-11 h-px bg-[#4D9F95]"></div>
            <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
              {{ t.sections.historyMilestones }}
            </h2>
          </div>
        </div>
        <div class="flex flex-col w-full items-center">
          <div class="max-w-[1100px]">
            <p class="text-sm sm:text-base md:text-lg lg:text-2xl leading-relaxed text-justify">
              {{ t.history.paragraph1 }}
            </p>
            <p class="mt-4 md:mt-8 text-sm sm:text-base md:text-lg lg:text-2xl leading-relaxed text-justify">
              {{ t.history.paragraph2 }}
            </p>
             <p class="mt-2 text-sm sm:text-base md:text-lg lg:text-2xl leading-relaxed font-bold text-justify">
              {{ t.history.paragraph3 }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <div id="leadership" class="container mx-auto max-w-7xl px-4 py-4 md:py-12 relative overflow-visible">
      <div class="flex flex-col md:flex-row gap-8 md:gap-x-16">
        <div class="flex-shrink-0 md:pt-2">
          <div class="flex flex-row items-center gap-x-4">
            <div class="w-11 h-px bg-[#4D9F95]"></div>
            <h2 class="text-stone-500 text-xs font-medium uppercase tracking-tight">
              {{ t.sections.leadingWithPurpose }}
            </h2>
          </div>
        </div>
        <div class="flex flex-col w-full items-center mr-0 md:mr-12 lg:mr-28">
          <div class="w-full">
             <p class="text-sm sm:text-base md:text-lg lg:text-2xl leading-relaxed text-justify">
              {{ t.leadership.paragraph1 }}
            </p>
            <p class="mt-6 sm:mt-8 text-sm sm:text-base md:text-lg lg:text-2xl leading-relaxed text-justify">
              {{ t.leadership.paragraph2 }}
            </p>
          </div>
        </div>
      </div>
      
      <!-- Right side decorative image -->
      <img 
        :src="hseImage" 
        alt="Leadership Decoration" 
        class="hidden xl:block absolute -top-8 -right-28 w-32 h-auto opacity-80 z-10"
      />
      
      <div class="mt-12 sm:mt-16 flex flex-col md:flex-row justify-center items-center gap-6 sm:gap-8 relative z-10">
        <div class="rounded-xl sm:rounded-2xl overflow-hidden w-full max-w-sm shadow-lg bg-white">
            <div class="relative">
                <img :src="leader1" alt="Portrait of Hong Ki Chul" class="w-full h-auto object-cover block">
                <div class="absolute bottom-0 left-0 right-0">
                    <div class="bg-gradient-to-t from-[#4D9F95]/90 to-[#4D9F95]/30 backdrop-blur-sm text-white p-4 rounded-b-2xl text-center">
                        <h3 class="font-bold text-xl">Hong Ki Chul</h3>
                        <p class="text-white/90 mt-1 text-sm">{{ t.leadership.ceo }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl sm:rounded-2xl overflow-hidden w-full max-w-sm shadow-lg bg-white">
            <div class="relative">
                <img :src="leader2" alt="Portrait of Shin Dong Whan" class="w-full h-auto object-cover block">
                <div class="absolute bottom-0 left-0 right-0">
                    <div class="bg-gradient-to-t from-[#4D9F95]/90 to-[#4D9F95]/30 backdrop-blur-sm text-white p-4 rounded-b-2xl text-center">
                        <h3 class="font-bold text-xl">Shin Dong Whan</h3>
                        <p class="text-white/90 mt-1 text-sm">{{ t.leadership.cfo }}</p>
                    </div>
                </div>
            </div>
        </div>
      </div>
      
    </div>
    <div class="bg-[#D9D9D9] py-16 md:py-24">
      <div class="container mx-auto max-w-7xl px-4">
        <div class="flex flex-row items-center gap-x-4 mb-8 md:mb-16">
          <div class="w-11 h-px bg-[#4D9F95]"></div>
          <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
            {{ t.sections.supergraphicStory }}
          </h2>
        </div>
        
        <div class="relative bg-black rounded-2xl sm:rounded-3xl overflow-hidden h-[190px] sm:h-[360px] md:h-[420px] lg:h-[520px] xl:h-[600px] shadow-2xl">
          <button 
            @click="previousSlide" 
            class="absolute left-2 sm:left-4 md:left-8 top-1/2 transform -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-full flex items-center justify-center cursor-pointer hover:bg-gray-200 transition-all duration-200 shadow-lg hover:scale-105"
          >
            <Icon icon="gg:arrow-left" class="h-5 w-5 sm:h-7 sm:w-7 text-gray-700" />
          </button> 
          <button 
            @click="nextSlide"
            class="absolute right-2 sm:right-4 md:right-8 top-1/2 transform -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-full flex items-center justify-center cursor-pointer hover:bg-gray-200 transition-all duration-200 shadow-lg hover:scale-105"
          >
            <Icon icon="gg:arrow-right" class="h-5 w-5 sm:h-7 sm:w-7 text-gray-700" />
          </button>

          <div class="relative w-full h-full">
            <div
              v-for="(image, index) in supergraphicImages"
              :key="index"
              v-show="currentSlide === index"
              class="absolute inset-0 sm:inset-auto transition-opacity duration-500 ease-in-out"
            >
              <img :src="image" alt="Supergraphic Story" class="w-full h-[200px] sm:h-full object-cover sm:object-contain">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useLocalization } from '@/composables/useLocalization'
import { Icon } from '@iconify/vue';
import factory from '@/assets/hli-green-power-factory.png'
import facility from '@/assets/facility-pipes-and-towers.png'
// import dotsPattern from '@/assets/dots-pattern.svg' 

// Ikon Brand
import iconCare from '@/assets/company-icon-care.png'
import iconDiversity from '@/assets/company-icon-diversity.png'
import iconIntegrity from '@/assets/company-icon-integrity.png'
import iconAsOne from '@/assets/company-icon-one.png'
import iconStrengthen from '@/assets/company-icon-strength.png'
import iconMobility from '@/assets/company-icon-cleaner.png'
import iconWorkIntegrity from '@/assets/company-icon-integrity2.png'

// Gambar Pimpinan
import leader1 from '@/assets/leader1.png'
import leader2 from '@/assets/leader2.png'
import hseImage from '@/assets/supergraphic-dots.png'
import hseImage3 from '@/assets/supergraphic-half-circle-2.png'

// --- Bagian Supergraphic Story dari update sebelumnya ---
import supergraphic1 from '@/assets/carousel-1.png'
import supergraphic2 from '@/assets/carousel-2.png'
import supergraphic3 from '@/assets/carousel-3.png'
import supergraphic4 from '@/assets/carousel-4.png'
import supergraphic5 from '@/assets/carousel-5.png'
import supergraphic6 from '@/assets/carousel-6.png'

const { currentLocale } = useLocalization()

// Translations object
const translations = {
  en: {
    sections: {
      companyOverview: "COMPANY OVERVIEW",
      brandVision: "BRAND VISION",
      brandMission: "BRAND MISSION",
      historyMilestones: "HISTORY & MILESTONES",
      leadingWithPurpose: "LEADING WITH PURPOSE",
      supergraphicStory: "SUPERGRAPHIC STORY"
    },
    overview: {
      paragraph1: "HLI Green Power is a collaborative force in the future of mobility, where progress is built by people working together across roles, cultures, and perspectives.",
      paragraph2: "Formed by LG Energy Solution and Hyundai Motor Group, we combine global expertise with local strength to create high quality battery systems that support smarter, cleaner movement.",
      paragraph3: "We believe that progress is shared. Every role matters, and every detail counts. What we create together moves more than just vehicles it moves careers, communities, and the future forward.",
      paragraph4: "At HLI Green Power, we grow stronger together.",
      paragraph5: "Because lasting progress starts with people."
    },
    vision: {
      title: "Together,<br/>We Power the Future.",
      buildWithCare: {
        title: "We Build with Care",
        description: "Real power doesn't come from machines alone. It comes from people, working with care, skill, and shared goals rooted in something greater than themselves."
      },
      growThroughDiversity: {
        title: "We Grow Through Diversity",
        description: "At HLI Green Power, we bring together diverse strengths across roles, backgrounds, and perspectives to shape a future that respects both people and nature, supports progress, and delivers real impact."
      },
      leadWithIntegrity: {
        title: "We Lead with Integrity",
        description: "We combine expertise, experience, and shared values to grow stronger as one. We work with pride, with respect, and with a clear focus on what truly matters."
      },
      moveAsOne: {
        title: "We Move as One",
        description: "Because progress happens when we move forward together, guided by shared purpose and strengthened by diverse thinking."
      }
    },
    mission: {
      title: "Built for Impact,<br />Powered by People.",
      strengthenIndustry: {
        title: "We Strengthen Industry",
        description: "At HLI Green Power, we build high-quality battery systems with a focus on what truly matters: strengthening industry, enabling cleaner mobility, and creating long-term value for people and the world around us."
      },
      enableCleanerMobility: {
        title: "We Enable Cleaner Mobility",
        description: "Progress is not only about innovation. It is also about how we work—with integrity, precision, and a shared sense of responsibility. Our strength comes from people, united across roles and backgrounds, working with care, skill, and purpose."
      },
      workWithIntegrity: {
        title: "We Work with Integrity",
        description: "Together, we move forward with clarity and commitment, delivering results that serve something greater than ourselves."
      }
    },
    history: {
      paragraph1: "Driving the Future of Green Transportation At HLI Green Power, we are committed to building a cleaner, more sustainable future through world class EV battery technology.",
      paragraph2: "Our journey is guided by a clear purpose:",
      paragraph3: "We provide mobility solutions with future energy for a better world."
    },
    leadership: {
      paragraph1: "Our leadership team brings together global experience, deep industry insight, and a shared commitment to responsible progress.",
      paragraph2: "With collaboration at the core, they guide our journey toward cleaner mobility, stronger industry, and long-term value.",
      ceo: "Chief Executive Officer (CEO)",
      cfo: "Chief Financial Officer (CFO)"
    }
  },
  id: {
    sections: {
      companyOverview: "MENGENAI PERUSAHAAN",
      brandVision: "BRAND VISION",
      brandMission: "BRAND MISSION",
      historyMilestones: "SEJARAH & PENCAPAIAN",
      leadingWithPurpose: "MEMIMPIN DENGAN TUJUAN",
      supergraphicStory: "MENGENAI SUPERGRAFIS"
    },
    overview: {
      paragraph1: "HLI Green Power adalah kekuatan kolaboratif dalam masa depan mobilitas, di mana kemajuan tercipta melalui kerja sama antara individu dari berbagai peran, budaya, dan sudut pandang.",
      paragraph2: "Dibentuk oleh LG Energy Solution dan Hyundai Motor Group, kami memadukan keahlian global dengan kekuatan lokal untuk menghadirkan sistem baterai berkualitas tinggi yang mendukung pergerakan yang lebih cerdas dan lebih ramah lingkungan.",
      paragraph3: "Kami percaya bahwa kemajuan sejati adalah kemajuan yang dibagikan. Setiap peran memiliki arti, dan setiap detail memiliki makna. Apa yang kami ciptakan bersama menggerakkan lebih dari sekadar kendaraan, namun turut menggerakkan karier, komunitas, dan masa depan menuju kemajuan.",
      paragraph4: "Di HLI Green Power, kami tumbuh semakin kuat bersama.",
      paragraph5: "Karena kemajuan yang berkelanjutan selalu berawal dari kita semua."
    },
    vision: {
      title: "Bersama,<br/>Kita Gerakkan Masa Depan",
      buildWithCare: {
        title: "Membangun dengan Kepedulian",
        description: "Kekuatan sejati tidak hanya berasal dari mesin. Ia tumbuh dari manusia yang bekerja dengan kepedulian, keterampilan, dan tujuan bersama yang lebih besar dari diri sendiri."
      },
      growThroughDiversity: {
        title: "Bertumbuh melalui Keberagaman",
        description: "Di HLI Green Power, beragam kekuatan disatukan dari berbagai peran, latar belakang, dan sudut pandang. Bersama-sama membentuk masa depan yang menghargai manusia dan alam, mendorong kemajuan, dan membawa dampak nyata."
      },
      leadWithIntegrity: {
        title: "Memimpin dengan Integritas",
        description: "Keahlian, pengalaman, dan nilai bersama menjadi fondasi untuk tumbuh sebagai satu kesatuan. Setiap langkah dijalankan dengan rasa bangga, saling menghormati, dan fokus pada hal-hal yang benar-benar penting."
      },
      moveAsOne: {
        title: "Bergerak sebagai Satu",
        description: "Karena kemajuan tidak dicapai sendirian—melainkan bersama, dengan tujuan yang sama dan kekuatan dari cara pikir yang beragam."
      }
    },
    mission: {
      title: "Dibangun untuk Industri dan Dampak Nyata,<br />Digerakkan oleh Kebersamaan.",
      strengthenIndustry: {
        title: "Memperkuat Industri",
        description: "Di HLI Green Power, kami membangun sistem baterai berkualitas tinggi dengan fokus pada hal-hal yang benar-benar penting: memperkuat industri, mendukung mobilitas yang lebih bersih, dan menciptakan nilai jangka panjang bagi manusia dan lingkungan sekitar."
      },
      enableCleanerMobility: {
        title: "Mendukung Mobilitas yang Lebih Ramah Lingkungan",
        description: "Kemajuan bukan hanya tentang inovasi, tetapi juga tentang cara bekerja, dengan integritas, ketelitian, dan rasa tanggung jawab bersama. Kekuatan kami berasal dari orang-orang di dalamnya yang bersatu lintas peran dan latar belakang, bekerja dengan kepedulian, keterampilan, dan tujuan yang sama."
      },
      workWithIntegrity: {
        title: "Bekerja dengan Integritas",
        description: "Bersama, kami melangkah maju dengan kejelasan dan komitmen, menghadirkan hasil yang memberi arti lebih besar dari sekadar pekerjaan itu sendiri."
      }
    },
    history: {
      paragraph1: "Mendorong masa depan transportasi ramah lingkungan di HLI Green Power, kami berkomitmen untuk membangun masa depan yang lebih bersih dan berkelanjutan melalui teknologi baterai kendaraan listrik berkelas dunia.",
      paragraph2: "Perjalanan kami dipandu oleh tujuan yang jelas:",
      paragraph3: "Kami menghadirkan solusi mobilitas dengan energi masa depan demi dunia yang lebih baik."
    },
    leadership: {
      paragraph1: "Tim kepemimpinan kami menyatukan pengalaman global, wawasan mendalam tentang industri, serta komitmen bersama terhadap kemajuan yang bertanggung jawab.",
      paragraph2: "Dengan kolaborasi sebagai landasan, mereka menuntun perjalanan kami menuju mobilitas yang lebih ramah lingkungan, industri yang lebih kuat, dan nilai jangka panjang yang berkelanjutan.",
      ceo: "Chief Executive Officer (CEO)",
      cfo: "Chief Financial Officer (CFO)"
    }
  }
}

// Get current translations based on locale
const t = computed(() => {
  return translations[currentLocale.value] || translations.en
})

const supergraphicImages = ref([
  supergraphic1,
  supergraphic2,
  supergraphic3,
  supergraphic4,
  supergraphic5,
  supergraphic6,
])

const currentSlide = ref(0)
const totalSlides = supergraphicImages.value.length

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % totalSlides
}

const previousSlide = () => {
  currentSlide.value = currentSlide.value === 0 ? totalSlides - 1 : currentSlide.value - 1
}
// --- Akhir Bagian Supergraphic Story ---

// Parallax Animation
const parallaxSection = ref(null)
const factoryImage = ref(null)
const facilityImage = ref(null)
const factoryImageVisible = ref(false)
const facilityImageVisible = ref(false)
const isAnimating = ref(false)
const lastScrollY = ref(0)
const scrollDirection = ref('down')

// Counter Animation
const statsSection = ref(null)
const yearCounter = ref(null)
const capacityCounter = ref(null)
const productionCounter = ref(null)

const animateCounter = (element, targetValue, duration = 2000, decimal = false) => {
  const startValue = 0
  const increment = targetValue / (duration / 16) // 60fps
  let currentValue = startValue
  
  const timer = setInterval(() => {
    currentValue += increment
    if (currentValue >= targetValue) {
      currentValue = targetValue
      clearInterval(timer)
    }
    
    if (decimal) {
      element.textContent = currentValue.toFixed(1)
    } else {
      element.textContent = Math.floor(currentValue)
    }
  }, 16)
}

const handleIntersection = (entries) => {
  entries.forEach(entry => {
    if (entry.target === parallaxSection.value) {
      if (entry.isIntersecting && !isAnimating.value && scrollDirection.value === 'down') {
        isAnimating.value = true
        
        // Reset animation state first
        factoryImageVisible.value = false
        facilityImageVisible.value = false
        
        // Trigger parallax animation with a small delay to ensure reset is visible
        setTimeout(() => {
          factoryImageVisible.value = true
          setTimeout(() => {
            facilityImageVisible.value = true
            // Reset animation flag after animation completes
            setTimeout(() => {
              isAnimating.value = false
            }, 1000)
          }, 300)
        }, 50)
      } else if (entry.isIntersecting && scrollDirection.value === 'up') {
        // When scrolling up and section is visible, keep images visible without animation
        factoryImageVisible.value = true
        facilityImageVisible.value = true
        isAnimating.value = false
      } else if (!entry.isIntersecting && scrollDirection.value === 'down') {
        // Only reset when scrolling down and leaving view
        factoryImageVisible.value = false
        facilityImageVisible.value = false
        isAnimating.value = false
      }
    }
    
    if (entry.target === statsSection.value && entry.isIntersecting) {
      // Animate counters
      // Animate year counter (2021)
      if (yearCounter.value) {
        animateCounter(yearCounter.value, 2021, 2000)
      }
      
      // Animate capacity counter (10)
      if (capacityCounter.value) {
        animateCounter(capacityCounter.value, 10, 2000)
      }
      
      // Animate production counter (32.6)
      if (productionCounter.value) {
        animateCounter(productionCounter.value, 32.6, 2000, true)
      }
    }
  })
}

// Track scroll direction and reset at top
const handleScroll = () => {
  const currentScrollY = window.scrollY
  scrollDirection.value = currentScrollY > lastScrollY.value ? 'down' : 'up'
  
  // Reset animation when reaching the top of the page
  // This ensures fresh animation every time user scrolls down from top
  if (currentScrollY <= 10) { // Small threshold for "at top"
    // Force reset with a small delay to ensure smooth transition
    setTimeout(() => {
      factoryImageVisible.value = false
      facilityImageVisible.value = false
      isAnimating.value = false
    }, 100)
  }
  
  lastScrollY.value = currentScrollY
}

onMounted(() => {
  // Initialize scroll position
  lastScrollY.value = window.scrollY
  
  // Add scroll event listener
  window.addEventListener('scroll', handleScroll, { passive: true })
  
  const observer = new IntersectionObserver(handleIntersection, {
    threshold: [0.1, 0.3, 0.5, 0.7],
    rootMargin: '0px 0px -10% 0px'
  })
  
  if (parallaxSection.value) {
    observer.observe(parallaxSection.value)
  }
  
  if (statsSection.value) {
    observer.observe(statsSection.value)
  }
})

onUnmounted(() => {
  // Clean up scroll event listener
  window.removeEventListener('scroll', handleScroll)
})

defineOptions({
  layout: AppLayout,
})
</script>

<style scoped>
/* Enhanced parallax animation styles */
.parallax-image {
  will-change: transform, opacity;
  backface-visibility: hidden;
  transform-style: preserve-3d;
}

/* Smooth transitions for better performance */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom animation delays for staggered effect */
.delay-300 {
  transition-delay: 300ms;
}

.delay-500 {
  transition-delay: 500ms;
}

.delay-700 {
  transition-delay: 700ms;
}

/* Hover effects for interactive feel */
img:hover {
  transform: scale(1.02);
  transition: transform 0.3s ease;
}
</style>