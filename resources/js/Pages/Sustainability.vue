<template>
  <Head title="Sustainability - HLI Green Power" />
  <div class="bg-white text-black antialiased">
    <section id="she-policy" class="relative min-h-screen container mx-auto max-w-7xl px-4 sm:px-6 md:px-8 lg:px-6 pt-32 md:pt-40 pb-16 md:pb-0 overflow-visible">
      <div>
        <div class="flex flex-row items-center gap-x-4">
          <div class="w-11 h-px bg-[#4D9F95]"></div>
          <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
            {{ t.sections.shePolicy }}
          </h2>
        </div>
        <div class="mt-8 sm:mt-12 md:mt-15 relative">
          <p class="text-base sm:text-lg md:text-xl lg:text-2xl leading-relaxed text-center pr-0 px-0 md:px-4">
            {{ t.shePolicy.introduction }}
          </p>
        </div>
      </div>
      
      <!-- Image positioned at screen right edge -->
      <img 
        :src="hseImage" 
        alt="SHE Policy" 
        class="hidden lg:block absolute top-40 right-0 w-28 h-auto opacity-80 z-10"
        style="margin-right: calc(-100vw + 100% + (100vw - 100%) / 2);"
      />

      <!-- Card Rows -->
      <div
        v-for="(row, rowIdx) in cardRows"
        :key="rowIdx"
        class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 md:gap-8 lg:gap-6 gap-y-10 sm:gap-y-8 mt-6 sm:mt-8 md:mt-12 lg:mt-16 items-stretch"
      >
        <div
          v-for="(card, idx) in row"
          :key="idx"
          class="relative h-auto sm:h-[330px] lg:h-[300px] xl:h-[360px] bg-transparent"
        >
          <div class="absolute bottom-0 left-0 w-full h-full bg-[#4D9E95]/50 rounded-3xl translate-y-3"></div>
          <div class="relative bg-white drop-shadow-xl rounded-3xl p-4 sm:p-8 px-auto sm:px-6 h-full flex flex-col text-left overflow-hidden">
            <img :src="card.icon" :alt="'Icon'" class="w-20 h-20 sm:w-32 sm:h-32 mb-1 sm:mb-2 mx-auto" />
            <p class="text-stone-600 leading-relaxed mt-2 sm:mt-4 text-xs sm:text-sm">
              {{ card.desc }}
            </p>
          </div>
        </div>
      </div>

      <!-- Last Centered Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 md:gap-8 lg:gap-6 gap-y-10 sm:gap-y-8 mt-6 sm:mt-8 md:mt-12 lg:mt-16 items-stretch">
        <div class="xl:col-start-2 col-span-1 sm:col-span-1">
          <div
            v-for="(card, idx) in lastCards.slice(0,1)"
            :key="'last-'+idx"
            class="relative h-auto sm:h-[330px] lg:h-[300px] xl:h-[360px] bg-transparent"
          >
            <div class="absolute bottom-0 left-0 w-full h-full bg-[#4D9E95]/50 rounded-3xl translate-y-3"></div>
            <div class="relative bg-white drop-shadow-xl rounded-3xl p-4 sm:p-8 px-auto sm:px-6 h-full flex flex-col text-left overflow-hidden">
              <img :src="card.icon" :alt="'Icon'" class="w-20 h-20 sm:w-32 sm:h-32 mb-1 sm:mb-2 mx-auto" />
              <p class="text-stone-600 leading-relaxed mt-2 sm:mt-4 text-xs sm:text-sm">
                {{ card.desc }}
              </p>
            </div>
          </div>
        </div>
        <div class="xl:col-span-1">
          <div
            v-for="(card, idx) in lastCards.slice(1)"
            :key="'last-'+idx"
            class="relative h-auto sm:h-[400px] md:h-[420px] lg:h-[360px] bg-transparent"
          >
            <div class="absolute bottom-0 left-0 w-full h-full bg-[#4D9E95]/50 rounded-3xl translate-y-3"></div>
            <div class="relative bg-white drop-shadow-xl rounded-3xl p-4 sm:p-8 px-auto sm:px-6 h-full flex flex-col text-left overflow-hidden">
              <img :src="card.icon" :alt="'Icon'" class="w-20 h-20 sm:w-32 sm:h-32 mb-1 sm:mb-2 mx-auto" />
              <p class="text-stone-600 leading-relaxed mt-2 sm:mt-4 text-xs sm:text-sm">
                {{ card.desc }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-16 sm:mt-20 md:mt-32 text-center relative px-4">
        <img 
          :src="hseImage2" 
          alt="SHE Policy Decoration" 
          class="hidden lg:block absolute top-1/2 -translate-y-1/2 left-0 w-28 h-auto z-10"
          style="margin-left: calc(-100vw + 100% + (100vw - 100%) / 2);"
        />
        <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-stone-90">{{ t.shePolicy.complianceText }}</p>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-medium mt-4 sm:mt-6 mb-0 sm:mb-20 md:mb-32">{{ t.shePolicy.complianceTitle }}</h2>
      </div>
    </section>

    <!-- Section List Artikel -->
    <div id="commitment" class="relative container mx-auto max-w-7xl px-4 pt-2 md:pt-0 pb-16 md:pb-24 mt-0">
      <div class="flex flex-row items-center gap-x-4 mb-8 sm:mb-16 md:mb-20">
        <div class="w-11 h-px bg-[#4D9F95]"></div>
        <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
          {{ t.sections.sustainabilityCommitment }}
        </h2>
      </div>
      <div class="flow-root">
        <div class="-my-6 divide-y-2 divide-[#4D9F95]/50">
          <article
            v-for="(article, idx) in articleCards"
            :key="'article-'+idx"
            class="py-6 md:py-8 lg:py-10"
          >
            <div class="grid grid-cols-12 gap-x-2 sm:gap-x-4 md:gap-x-8 lg:gap-x-10 gap-y-2 items-center">
              <div class="col-span-12 lg:col-span-2 flex justify-center">
                  <div 
                      class="w-24 sm:w-28 md:w-32 lg:w-36 h-24 sm:h-28 md:h-32 lg:h-36 mb-4 md:mb-0 rounded-lg bg-cover bg-center"
                      :style="{ backgroundImage: `url(${article.icon})` }">
                  </div>
                  </div>
              <div class="col-span-12 sm:col-span-9 lg:col-span-2">
                <h3 class="text-base md:text-lg font-medium leading-6 text-gray-900 text-center md:text-right">
                  {{ article.title }}
                </h3>
              </div>
              <div class="col-span-12 lg:col-span-8">
                <p class="text-xs md:text-sm leading-6 text-gray-600 whitespace-pre-line" v-html="article.desc"></p>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useLocalization } from '@/composables/useLocalization'
import icon1 from '@/assets/sustainability-1.png'
import icon2 from '@/assets/sustainability-2.png'
import icon3 from '@/assets/sustainability-3.png'
import icon4 from '@/assets/sustainability-4.png'
import icon5 from '@/assets/sustainability-5.png'
import icon6 from '@/assets/sustainability-6.png'
import icon7 from '@/assets/sustainability-7.png'
import icon8 from '@/assets/sustainability-8.png'
import icon9 from '@/assets/sustainability-9.png'
import icon10 from '@/assets/sustainability-10.png'
import icon11 from '@/assets/sustainability-11.png'
import icon12 from '@/assets/sustainability-12.png'
import icon13 from '@/assets/sustainability-13.png'
import icon14 from '@/assets/sustainability-14.png'
import icon15 from '@/assets/sustainability-15.png'
import icon16 from '@/assets/sustainability-16.png'
import icon17 from '@/assets/sustainability-17.png'
import icon18 from '@/assets/sustainability-18.png'
import icon19 from '@/assets/sustainability-19.png'
import icon20 from '@/assets/sustainability-20.png'
import hseImage from '@/assets/supergraphic-dots.png' 
import hseImage2 from '@/assets/supergraphic-half-circle.png' 

defineOptions({
  layout: AppLayout,
})

const { currentLocale } = useLocalization()

// Translations object
const translations = {
  en: {
    sections: {
      shePolicy: "SHE POLICY",
      sustainabilityCommitment: "SUSTAINABILITY COMMITMENT"
    },
    shePolicy: {
      introduction: "Here at HLI Green Power, we recognize that SHE is the fundamental element for securing differentiated competitiveness. For continuous improvement on SHE performance, HLI Green Power will be committed to implementing the following guiding principles:",
      complianceText: "To ensure compliance with this policy, we will consider",
      complianceTitle: "EH&S as the top priority in all our business activities."
    },
    cards: {
      card1: "We will provide a safe and healthy work environment and ensure the principle-adhering corporate culture.",
      card2: "We are committed to protecting the environment and preventing pollution.",
      card3: "We will comply with all applicable EH&S legal requirements and other stakeholders' requirements.",
      card4: "We will drive continuous innovation throughout the entire life cycle of operation to supply environmentally-friendly products and services.",
      card5: "We are committed to ensuring continual improvement through the identification andelimination of hazards, improvement of the EH&S Management System, and the implementation of risk mitigation.",
      card6: "We are committed to the consultation and participation of workers and other internal and external stakeholders to improve the EH&S implementation.",
      card7: "We will support business partners and local communities to improve their EH&S practices as our social responsibility.",
      card8: "We will communicate our EH&S policies and programs with stakeholders.",
      card9: "We are committed to building awareness around health, safety, fire, and environmental care, aiming to foster a strong safety culture. Achieving this is a shared responsibility belongs to us all",
      card10: "We are committed to optimizing energy use, improving efficiency, and reducing greenhouse gas emissions.",
      card11: "We ensure responsible management of waste and materials, applying circular economy principles and ensuring compliant handling of hazardous and non-hazardous waste.",
      card12: "We ensure the safe handling, storage, and disposal of chemicals to safeguard people and the environment.",
      card13: "We are committed to preventing pollution and minimizing environmental impacts from our operations, including emissions and waste discharge.",
      card14: "We support sustainable water management in cooperation with the industrial estate."
    },
    articles: {
      overview: {
        title: "Overview",
        description: "At HLI Green Power, we are driving the future of green transportation through our state-of-the-art electric vehicle (EV) battery manufacturing facility. This innovative initiative underscores our commitment to sustainability and eco-friendly technology, contributing to the global transition toward clean energy solutions. Our mission is to produce high-performance, environmentally friendly batteries that meet the growing demand for sustainable transportation."
      },
      sustainableProduction: {
        title: "Sustainable EV Battery Production",
        description: "Our facility utilizes cutting-edge processes and advanced materials to create top-quality batteries that not only meet but exceed industry standards. These batteries will power various EV models with enhanced efficiency, reliability, and an extended lifespan. Through our dedication to green technology, HLI Green Power is ensuring that our products play a key role in the future of sustainable transportation."
      },
      environmentalStewardship: {
        title: "Environmental Stewardship",
        description: "Sustainability is at the core of our operations. We are minimizing resource consumption, reducing waste, and investing in renewable energy to power our facility, significantly lowering our carbon footprint. Our batteries will enable mass adoption of electric vehicles, contributing to cleaner air and a healthier environment for communities worldwide."
      },
      communityEngagement: {
        title: "Community Engagement and Economic Benefits",
        description: "HLI Green Power is dedicated to fostering strong relationships with local communities and stakeholders. We prioritize transparency, collaboration, and addressing concerns to ensure our operations align with community expectations. Our project will create local employment opportunities, boost the economy, and promote skill development, ensuring the benefits of this initiative extend beyond our factory walls."
      },
      lowCarbonEconomy: {
        title: "Transitioning to a Low-Carbon Economy",
        description: "As part of our broader commitment to sustainability, HLI Green Power is actively addressing greenhouse gas (GHG) risks associated with the global energy transition. Our approach includes reducing supply chain emissions through life cycle assessments, ensuring compliance with global emission standards, and investing in renewable energy infrastructure like on-site solar installations. We also prioritize technological innovation, ESG (Environmental, Social, and Governance) factors, and transparent investor relations.\n\nBy combining sustainable manufacturing practices, community partnerships, and advanced technology, HLI Green Power is paving the way for a cleaner, greener future. Together, we are driving positive change towards a low-carbon economy for generations to come."
      },
      ghgQuantification: {
        title: "Greenhouse Gas (GHG) Quantification 2024",
        description: "In 2024, HLI Green Power reported total greenhouse gas (GHG) emissions under Scope 1 and Scope 2 amounting to approximately 175,000 tons of CO₂e (carbon dioxide equivalent).\n\n<ul class=\"list-disc list-outside pl-5 mt-2 space-y-1\"><li>Scope 1: Direct GHG emissions from owned or controlled sources (e.g., fuel combustion, company vehicles, on-site manufacturing).</li><li>Scope 2: Indirect GHG emissions from the generation of purchased electricity, steam, heating, and cooling consumed by the company.</li></ul>"
      }
    }
  },
  id: {
    sections: {
      shePolicy: "SHE POLICY",
      sustainabilityCommitment: "KOMITMEN BERKELANJUTAN"
    },
    shePolicy: {
      introduction: "Di HLI Green Power, kami menyadari bahwa Kesehatan, Keselamatan, dan Lingkungan (K3L) merupakan elemen mendasar dalam menjaga daya saing yang berkelanjutan. Untuk memastikan peningkatan berkelanjutan dalam kinerja K3L, HLI Green Power berkomitmen untuk menerapkan prinsip-prinsip sebagai berikut:",
      complianceText: "Untuk memastikan kepatuhan terhadap kebijakan ini, kami akan menjadikan K3L sebagai prioritas utama dalam seluruh kegiatan bisnis kami.",
      complianceTitle: "K3L sebagai prioritas utama dalam seluruh kegiatan bisnis kami."
    },
    cards: {
      card1: "Kami akan menyediakan lingkungan kerja yang aman dan sehat serta memastikan terciptanya budaya perusahaan yang berlandaskan prinsip kepatuhan.",
      card2: "Kami berkomitmen untuk melindungi lingkungan dan mencegah pencemaran.",
      card3: "Kami akan mematuhi seluruh peraturan perundang-undangan K3L yang berlaku serta persyaratan dari para pemangku kepentingan lainnya.",
      card4: "Kami akan mendorong inovasi berkelanjutan di seluruh siklus hidup operasional untuk menyediakan produk dan layanan yang ramah lingkungan.",
      card5: "Kami berkomitmen untuk melakukan perbaikan berkelanjutan melalui identifikasi dan penghapusan bahaya, peningkatan Sistem Manajemen K3L, serta penerapan langkah mitigasi risiko.",
      card6: "Kami berkomitmen untuk melibatkan dan berkonsultasi dengan pekerja serta para pemangku kepentingan internal maupun eksternal guna meningkatkan penerapan K3L.",
      card7: "Kami akan mendukung mitra usaha dan masyarakat sekitar dalam meningkatkan praktik K3L sebagai bagian dari tanggung jawab sosial kami.",
      card8: "Kami akan menyampaikan kebijakan dan program K3L kami kepada para pemangku kepentingan.",
      card9: "Kami berkomitmen untuk membangun kesadaran tentang kesehatan, keselamatan, pencegahan kebakaran, dan kepedulian terhadap lingkungan, guna menumbuhkan budaya keselamatan yang kuat. Pencapaian ini adalah tanggung jawab bersama kita semua.",
      card10: "Kami berkomitmen untuk mengoptimalkan penggunaan energi, meningkatkan efisiensi, dan mengurangi emisi gas rumah kaca.",
      card11: "Kami memastikan pengelolaan limbah dan material yang bertanggung jawab, dengan menerapkan prinsip ekonomi sirkular serta memastikan penanganan limbah B3 dan non-B3 sesuai ketentuan.",
      card12: "Kami memastikan penanganan, penyimpanan, dan pembuangan bahan kimia yang aman untuk melindungi manusia dan lingkungan.",
      card13: "Kami berkomitmen untuk mencegah pencemaran dan meminimalkan dampak lingkungan dari kegiatan operasional kami, termasuk emisi dan pembuangan limbah.",
      card14: "Kami mendukung pengelolaan air yang berkelanjutan bekerja sama dengan pengelola kawasan industri."
    },
    articles: {
      overview: {
        title: "Gambaran Umum",
        description: "Di HLI Green Power, kami mendorong masa depan transportasi ramah lingkungan melalui fasilitas manufaktur baterai kendaraan listrik (EV) berteknologi tinggi. Inisiatif inovatif ini menegaskan komitmen kami terhadap keberlanjutan dan teknologi ramah lingkungan, sekaligus berkontribusi pada transisi global menuju solusi energi bersih. Misi kami adalah memproduksi baterai berperforma tinggi yang ramah lingkungan untuk memenuhi kebutuhan transportasi berkelanjutan yang terus berkembang."
      },
      sustainableProduction: {
        title: "Produksi Baterai EV yang Berkelanjutan",
        description: "Fasilitas kami menggunakan proses mutakhir dan material canggih untuk menghasilkan baterai berkualitas tinggi yang tidak hanya memenuhi, tetapi juga melampaui standar industri. Baterai ini akan memberi daya pada berbagai model kendaraan listrik dengan efisiensi, keandalan, dan masa pakai yang lebih panjang. Melalui dedikasi kami terhadap teknologi hijau, HLI Green Power memastikan bahwa produk kami memainkan peran penting dalam masa depan transportasi berkelanjutan."
      },
      environmentalStewardship: {
        title: "Pengelolaan Lingkungan",
        description: "Keberlanjutan adalah inti dari setiap operasi kami. Kami meminimalkan penggunaan sumber daya, mengurangi limbah, dan berinvestasi dalam energi terbarukan untuk menggerakkan fasilitas kami, sehingga secara signifikan menurunkan jejak karbon. Baterai kami akan mendorong adopsi kendaraan listrik secara massal, berkontribusi pada udara yang lebih bersih dan lingkungan yang lebih sehat bagi masyarakat di seluruh dunia."
      },
      communityEngagement: {
        title: "Keterlibatan Komunitas dan Manfaat Ekonomi",
        description: "HLI Green Power berkomitmen untuk membangun hubungan yang kuat dengan komunitas lokal dan para pemangku kepentingan. Kami mengutamakan transparansi, kolaborasi, dan tanggapan terhadap setiap masukan untuk memastikan bahwa kegiatan kami selaras dengan harapan masyarakat. Proyek ini akan membuka peluang kerja lokal, mendorong pertumbuhan ekonomi, dan meningkatkan pengembangan keterampilan, memastikan manfaat inisiatif ini meluas hingga ke luar dinding pabrik kami."
      },
      lowCarbonEconomy: {
        title: "Transisi Menuju Ekonomi Rendah Karbon",
        description: "Sebagai bagian dari komitmen kami terhadap keberlanjutan, HLI Green Power secara aktif mengatasi risiko gas rumah kaca (GRK) yang terkait dengan transisi energi global. Pendekatan kami mencakup pengurangan emisi dalam rantai pasok melalui life cycle assessment, memastikan kepatuhan terhadap standar emisi global, serta investasi dalam infrastruktur energi terbarukan seperti instalasi tenaga surya di lokasi pabrik. Kami juga memprioritaskan inovasi teknologi, penerapan prinsip ESG (Lingkungan, Sosial, dan Tata Kelola), serta hubungan yang transparan dengan para investor.\n\nDengan menggabungkan praktik manufaktur berkelanjutan, kemitraan komunitas, dan teknologi maju, HLI Green Power menapaki jalan menuju masa depan yang lebih bersih dan hijau. Bersama, kita mendorong perubahan positif menuju ekonomi rendah karbon bagi generasi mendatang."
      },
      ghgQuantification: {
        title: "Kuantifikasi Gas Rumah Kaca (GRK) – 2024",
        description: "Pada tahun 2024, HLI Green Power melaporkan total emisi gas rumah kaca (GRK) untuk Scope 1 dan Scope 2 sebesar sekitar 175.000 ton CO₂e (karbon dioksida ekuivalen).\n\n<ul class=\"list-disc list-outside pl-5 mt-2 space-y-1\"><li>Scope 1: Emisi GRK langsung dari sumber yang dimiliki atau dikendalikan perusahaan (misalnya, pembakaran bahan bakar, kendaraan operasional, proses manufaktur di lokasi).</li><li>Scope 2: Emisi GRK tidak langsung dari pembangkitan listrik, uap, pemanas, dan pendingin yang digunakan oleh perusahaan.</li></ul>"
      }
    }
  }
}

// Get current translations based on locale
const t = computed(() => {
  return translations[currentLocale.value] || translations.en
})

const cardRows = computed(() => [
  [
    {
      icon: icon1,
      desc: t.value.cards.card1
    },
    {
      icon: icon2,
      desc: t.value.cards.card2
    },
    {
      icon: icon3,
      desc: t.value.cards.card3
    },
    {
      icon: icon4,
      desc: t.value.cards.card4
    }
  ],
  [
    {
      icon: icon5,
      desc: t.value.cards.card5
    },
    {
      icon: icon6,
      desc: t.value.cards.card6
    },
    {
      icon: icon7,
      desc: t.value.cards.card7
    },
    {
      icon: icon8,
      desc: t.value.cards.card8
    }
  ],
  [
    {
      icon: icon9,
      desc: t.value.cards.card9
    },
    {
      icon: icon10,
      desc: t.value.cards.card10
    },
    {
      icon: icon11,
      desc: t.value.cards.card11
    },
    {
      icon: icon12,
      desc: t.value.cards.card12
    }
  ]
])

const lastCards = computed(() => [
  {
    icon: icon13,
    desc: t.value.cards.card13
  },
  {
    icon: icon14,
    desc: t.value.cards.card14
  }
])

const articleCards = computed(() => [
  {
    icon: icon15,
    title: t.value.articles.overview.title,
    desc: t.value.articles.overview.description
  },
  {
    icon: icon16,
    title: t.value.articles.sustainableProduction.title,
    desc: t.value.articles.sustainableProduction.description
  },
  {
    icon: icon17,
    title: t.value.articles.environmentalStewardship.title,
    desc: t.value.articles.environmentalStewardship.description
  },
  {
    icon: icon18,
    title: t.value.articles.communityEngagement.title,
    desc: t.value.articles.communityEngagement.description
  },
  {
    icon: icon19,
    title: t.value.articles.lowCarbonEconomy.title,
    desc: t.value.articles.lowCarbonEconomy.description
  },
  {
    icon: icon20,
    title: t.value.articles.ghgQuantification.title,
    desc: t.value.articles.ghgQuantification.description
  },
])
</script>