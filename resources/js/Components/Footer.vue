<template>
  <footer class="w-full bg-black max-w- text-white">
    <div class="max-w-full mx-auto px-4 sm:px-6 md:px-8 lg:px-32 py-12 sm:py-20">

      <div class="flex flex-col lg:flex-row justify-between items-start gap-10 lg:gap-8 mb-12">
        <div>
          <img class="w-36 lg:w-52 mb-4" :src="logowhite" alt="HLI Green Power" />
          <p class="text-xl font-normal leading-normal" v-html="t.tagline">
          </p>
        </div>
        <!-- <div class="w-full max-w-sm bg-white rounded-[84px] flex items-center shrink-0">
          <input 
            type="text" 
            placeholder="SIGN UP FOR UPDATES" 
            class="flex-1 px-6 text-stone-900 text-xs font-normal bg-transparent border-none outline-none placeholder-stone-500"
          />
          <button class="w-28 h-16 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] rounded-[84px] text-white text-xs font-bold flex items-center justify-center hover:bg-slate-600 transition-colors">
            SUBMIT
          </button>
        </div> -->
      </div>

      <div class="block md:hidden mb-10">
        <h3 class="text-white text-sm font-medium leading-normal mb-2 mt-2">{{ t.social }}</h3>
        <div class="flex space-x-4">
          <a 
            href="https://www.linkedin.com/company/pt-hli-green-power" 
            target="_blank" 
            class="social-btn w-11 h-11 rounded-xl flex items-center justify-center transition-all duration-300 cursor-pointer hover:scale-[1] active:scale-95"
            aria-label="LinkedIn"
          >
            <Icon icon="ri:linkedin-fill" class="w-6 h-6 text-white" />
          </a>
          <!-- <a href="#" class="w-10 h-10 relative group rounded-lg overflow-hidden flex items-center justify-center">
            <img
              :src="igIcon"
              alt="Instagram"
              class="absolute left-0 top-0 w-10 h-10 object-contain transition-all duration-300 group-hover:opacity-0"
            />
            <img
              :src="igIconHover"
              alt="Instagram Hover"
              class="absolute left-0 top-0 w-10 h-10 object-contain opacity-0 transition-all duration-300 group-hover:opacity-100"
            />
          </a> -->
        </div>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-[1fr_1fr_1fr_1fr_1fr] gap-x-8 gap-y-12 md:gap-y-20">
        <div class="col-span-2 md:col-span-1">
          <h3 class="text-white text-sm font-medium leading-normal mb-4">{{ t.officeLocation }}</h3>
          <div class="text-stone-500 text-sm font-normal leading-tight mb-8">
            <p>Karawang New Industrial City (KNIC)</p>
            <p>Block C No. 1</p>
            <p>Jl Trans Heksa Karawang KM 7</p>
            <p>Wanajaya, Teluk Jambe</p>
            <p>Karawang - Indonesia - 41361</p>
          </div>
          <h3 class="text-white text-sm font-medium leading-normal mb-0">{{ t.email }}</h3>
          <a href="mailto:hligrievance@hligreenpower.com" class="text-stone-500 text-sm font-normal underline leading-none hover:text-white">
            hligrievance@hligreenpower.com
          </a>
          <div class="mt-2">
            <Link :href="getLocalizedUrl('/privacy-policy')" class="text-stone-500 text-sm font-normal hover:text-white">{{ t.privacyPolicy }}</Link>
          </div>
          <div class="mt-4">
            <div class="text-stone-500 text-sm font-normal">
              <a href="https://www.figma.com/community/file/1181982309997520430" class="underline hover:text-white">{{ t.iconSet }}</a>
              <span> {{ t.copyrightBy }} </span>
              <a href="https://www.figma.com/@brixtemplates?fuid=1551802135293092857" class="underline hover:text-white">BRIX</a>
              <span> {{ t.licensedUnder }} </span>
              <a href="https://creativecommons.org/licenses/by/4.0/" class="underline hover:text-white">CC BY 4.0</a>
              <span class="ml-2">
                <img :src="ccIcon1" alt="CC Icon" class="inline-block w-4 h-4 mr-1 brightness-0 saturate-100" style="filter: invert(60%) sepia(0%) saturate(750%) hue-rotate(25deg) brightness(95%) contrast(90%);" />
                <img :src="ccIcon2" alt="CC Icon" class="inline-block w-4 h-4 brightness-0 saturate-100" style="filter: invert(60%) sepia(0%) saturate(750%) hue-rotate(25deg) brightness(95%) contrast(90%);" />
              </span>
            </div>
          </div>
        </div>

        <div class="flex flex-col gap-y-10 lg:pl-12">
          <div>
            <h3 class="text-white text-sm font-medium leading-normal mb-4">{{ t.company }}</h3>
            <ul class="text-stone-500 text-sm font-normal space-y-3">
              <li><Link :href="getLocalizedUrl('/company#overview')" class="hover:text-white">{{ t.companyOverview }}</Link></li>
              <li><Link :href="getLocalizedUrl('/company#vision')" class="hover:text-white">{{ t.visionMission }}</Link></li>
              <li><Link :href="getLocalizedUrl('/company#history')" class="hover:text-white">{{ t.historyMilestone }}</Link></li>
              <li><Link :href="getLocalizedUrl('/company#leadership')" class="hover:text-white">{{ t.leadingWithPurpose }}</Link></li>
            </ul>
          </div>
          <div>
            <h3 class="text-white text-xs font-medium leading-normal mb-4">{{ t.career }}</h3>
            <ul class="text-stone-500 text-xs font-normal space-y-3">
              <li><Link :href="getLocalizedUrl('/career#development')" class="hover:text-white">{{ t.careerDevelopment }}</Link></li>
              <li><Link :href="getLocalizedUrl('/career#life-at-hli')" class="hover:text-white">{{ t.lifeAtHli }}</Link></li>
              <!-- <li><Link :href="getLocalizedUrl('/career#submission')" class="hover:text-white">Talent Submission Form</Link></li>
              <li><Link :href="getLocalizedUrl('/career#leadership')" class="hover:text-white">Leadership Team</Link></li> -->
            </ul>
          </div>
        </div>

        <div class="flex flex-col gap-y-10 lg:pl-8">
          <div>
            <h3 class="text-white text-sm font-medium leading-normal mb-4">{{ t.ourFactory }}</h3>
            <ul class="text-stone-500 text-sm font-normal space-y-3">
              <li><Link :href="getLocalizedUrl('/factory#overview')" class="hover:text-white">{{ t.facilityOverview }}</Link></li>
              <li><Link :href="getLocalizedUrl('/factory#capability')" class="hover:text-white">{{ t.capabilityCapacity }}</Link></li>
              <!-- <li><Link :href="getLocalizedUrl('/factory#certification')" class="hover:text-white">Certification</Link></li>
              <li><Link :href="getLocalizedUrl('/factory#safety')" class="hover:text-white">Safety Standard</Link></li> -->
            </ul>
          </div>
          <div>
            <h3 class="text-white text-sm font-medium leading-normal mb-4 mt-14">{{ t.contactUs }}</h3>
            <ul class="text-stone-500 text-sm font-normal space-y-3">
              <li><Link :href="getLocalizedUrl('/contact#inquiry')" class="hover:text-white">{{ t.inquiryForm }}</Link></li>
              <li><Link :href="getLocalizedUrl('/contact#email-phone')" class="hover:text-white">{{ t.contactEmailPhone }}</Link></li>
            </ul>
          </div>
        </div>

        <div class="flex flex-col gap-y-10 lg:pl-16">
          <div>
            <h3 class="text-white text-sm font-medium leading-normal mb-4">{{ t.sustainability }}</h3>
            <ul class="text-stone-500 text-sm font-normal space-y-3">
              <li><Link :href="getLocalizedUrl('/sustainability#hse-policy')" class="hover:text-white">{{ t.hsePolicy }}</Link></li>
              <li><Link :href="getLocalizedUrl('/sustainability#commitment')" class="hover:text-white">{{ t.sustainableCommitment }}</Link></li>
            </ul>
          </div>
          <div class="hidden md:block">
            <h3 class="text-white text-sm font-medium leading-normal mb-4 mt-12">{{ t.social }}</h3>
            <div class="flex space-x-4">
              <a 
                href="https://www.linkedin.com/company/pt-hli-green-power" 
                target="_blank" 
                class="social-btn w-11 h-11 rounded-xl flex items-center justify-center transition-all duration-300 cursor-pointer hover:scale-[1] active:scale-95"
                aria-label="LinkedIn"
              >
                <Icon icon="ri:linkedin-fill" class="w-6 h-6 text-white" />
              </a>
              <!-- <a href="#" class="w-10 h-10 relative group rounded-lg overflow-hidden flex items-center justify-center">
                <img
                  :src="igIcon"
                  alt="Instagram"
                  class="absolute left-0 top-0 w-10 h-10 object-contain transition-all duration-300 group-hover:opacity-0"
                />
                <img
                  :src="igIconHover"
                  alt="Instagram Hover"
                  class="absolute left-0 top-0 w-10 h-10 object-contain opacity-0 transition-all duration-300 group-hover:opacity-100"
                />
              </a> -->
            </div>
          </div>
        </div>

        <div class="lg:pl-12">
          <h3 class="text-white text-xs font-medium leading-normal mb-4">{{ t.publication }}</h3>
          <ul class="text-stone-500 text-sm font-normal space-y-3">
            <li><Link :href="getLocalizedUrl('/publication#article')" class="hover:text-white">{{ t.articles }}</Link></li>
            <li><Link :href="getLocalizedUrl('/publication#activities')" class="hover:text-white">{{ t.companyActivities }}</Link></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="w-full h-10 bg-stone-500 flex items-center justify-center">
      <p class="text-white text-xs font-normal">
        {{ t.copyright }}
      </p>
    </div>

  </footer>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { Icon } from '@iconify/vue'
import { useLocalization } from '@/composables/useLocalization'
import logowhite from '@/assets/hligp-logo-white.png'
import igIcon from '@/assets/ig-icon.png'
import igIconHover from '@/assets/ig-icon-gradient.png'
import ccIcon1 from '@/assets/image 132.png'
import ccIcon2 from '@/assets/image 133.png'

const { getLocalizedUrl, currentLocale } = useLocalization()

// Translations object
const translations = {
  en: {
    tagline: "Together<br/>Lead the Power",
    officeLocation: "Office Location",
    email: "Email",
    privacyPolicy: "Privacy Policy",
    iconSet: "3D Icon Set",
    copyrightBy: "© 2025 by",
    licensedUnder: "is licensed under",
    company: "Company",
    companyOverview: "Company Overview",
    visionMission: "Vision & Mission",
    historyMilestone: "History & Milestone",
    leadingWithPurpose: "Leading With Purpose",
    career: "Career",
    careerDevelopment: "Career Development",
    lifeAtHli: "Life At HLI",
    ourFactory: "Our Factory",
    facilityOverview: "Facility Overview",
    capabilityCapacity: "Capability & Capacity",
    contactUs: "Contact Us",
    inquiryForm: "Inquiry Form",
    contactEmailPhone: "Contact Email/Phone",
    sustainability: "Sustainability",
    hsePolicy: "HSE Policy",
    sustainableCommitment: "Sustainable commitment",
    social: "Social",
    publication: "Publication",
    articles: "Articles",
    companyActivities: "Company Activities",
    copyright: "©2025 PT. HLI Green Power. All Rights Reserved."
  },
  id: {
    tagline: "Together<br/>Lead the Power",
    officeLocation: "Lokasi Kantor",
    email: "Email",
    privacyPolicy: "Privacy Policy",
    iconSet: "3D Icon Set",
    copyrightBy: "© 2025 by",
    licensedUnder: "is licensed under",
    company: "Perusahaan",
    companyOverview: "Gambaran Umum Perusahaan",
    visionMission: "Visi & Misi",
    historyMilestone: "Sejarah & Tonggak Pencapaian",
    leadingWithPurpose: "Memimpin dengan Tujuan",
    career: "Karier",
    careerDevelopment: "Pengembangan Karier",
    lifeAtHli: "Kehidupan di HLI",
    ourFactory: "Pabrik Kami",
    facilityOverview: "Gambaran Umum Fasilitas",
    capabilityCapacity: "Kapabilitas & Kapasitas",
    contactUs: "Hubungi Kami",
    inquiryForm: "Formulir Pertanyaan",
    contactEmailPhone: "Email/Telepon Kontak",
    sustainability: "Keberlanjutan",
    hsePolicy: "Kebijakan HSE",
    sustainableCommitment: "Komitmen Keberlanjutan",
    social: "Media Sosial",
    publication: "Publikasi",
    articles: "Articles",
    companyActivities: "Kegiatan Perusahaan",
    copyright: "©2025 PT. HLI Green Power. All Rights Reserved."
  }
}

// Get current translations based on locale
const t = computed(() => {
  return translations[currentLocale.value] || translations.en
})
</script>

<style scoped>
/* Social Button - Dark Glassmorphism */
.social-btn {
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

/* Social Button Hover - Gradient Lavender Purple to Glacial Minter */
.social-btn:hover {
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
</style>
