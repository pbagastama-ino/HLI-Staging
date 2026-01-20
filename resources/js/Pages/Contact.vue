<template>
  <Head title="Contact - HLI Green Power" />
  <div class="bg-white pt-56 sm:pt-72 md:pt-80 lg:pt-96">
    <div id="inquiry" class="relative z-10 -mt-[100px] sm:-mt-[150px] md:-mt-[180px] lg:-mt-[220px] pb-12 sm:pb-16 md:pb-24 px-4 sm:px-6 md:px-8 xl:px-32">
      <div class="max-w-7xl mx-auto">
        <!-- Facility Overview Style Title -->
        <div class="flex items-center gap-x-4 mb-8 sm:mb-12 md:mb-15">
          <div class="w-11 h-px bg-[#4D9F95]"></div>
          <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
            {{ t.sections.contactUs }}
          </h2>
        </div>
        <div class="bg-white rounded-2xl md:rounded-3xl border border-[#E1E0E2] p-4 sm:p-6 md:p-8 lg:p-12">
          <div class="text-center mt-4 md:mt-0">
            <h2 class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl xl:text-7xl font-medium text-black tracking-[0%] leading-[120%]">
              {{ t.form.title }}
            </h2>
            <p class="mt-4 sm:mt-6 md:mt-9 text-xs sm:text-sm lg:text-base text-black">
              {{ t.form.subtitle }}
            </p>
            <p class="max-w-2xl mx-auto text-xs sm:text-sm lg:text-base text-black px-0 md:px-4">
              {{ t.form.description }}
            </p>
          </div>
          <!-- tambahkan mx-auto max-w-2xl agar field tidak terlalu lebar, border card tetap pada parent -->
          <form @submit.prevent="handleSubmit" class="mt-10 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8 mx-auto max-w-2xl">
            <div class="sm:col-span-2">
              <input type="text" v-model="form.fullname" name="full-name" id="full-name" autocomplete="name" :placeholder="t.form.fullName" class="py-3 px-4 block w-full border text-gray-900 placeholder:text-[#0000004D] rounded-xl" :class="errors.name ? 'border-red-500' : 'border-[#E1E0E2]'">
              <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
            </div>
            <div class="sm:col-span-2">
              <input type="email" v-model="form.email" name="email" id="email" autocomplete="email" :placeholder="t.form.email" required class="py-3 px-4 block w-full border text-gray-900 placeholder:text-[#0000004D] rounded-xl" :class="errors.email ? 'border-red-500' : 'border-[#E1E0E2]'">
              <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
            </div>
            <div class="sm:col-span-2">
              <input type="tel" v-model="form.phone" name="phone" id="phone" autocomplete="tel" :placeholder="t.form.phone" required class="py-3 px-4 block w-full border text-gray-900 placeholder:text-[#0000004D] rounded-xl" :class="errors.phone ? 'border-red-500' : 'border-[#E1E0E2]'">
              <p v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ errors.phone }}</p>
            </div>
              <div class="sm:col-span-2">
                <select v-model="form.subject" name="subject" id="subject" class="py-3 px-4 block w-full border text-[#0000004D] rounded-xl" :class="errors.subject ? 'border-red-500' : 'border-[#E1E0E2]'">
                  <option value="" disabled selected class="text-gray-900">{{ t.form.selectSubject }}</option>
                  <option :value="t.form.partnership">{{ t.form.partnership }}</option>
                  <option :value="t.form.generalInformation">{{ t.form.generalInformation }}</option>
                  <option :value="t.form.other">{{ t.form.other }}</option>
                </select>
                <p v-if="errors.subject" class="mt-1 text-sm text-red-600">{{ errors.subject }}</p>
              </div>
            <div class="sm:col-span-2">
              <textarea v-model="form.message" id="message" name="message" rows="4" :placeholder="t.form.message" class="py-3 px-4 block w-full border text-gray-900 placeholder:text-[#0000004D] rounded-xl" :class="errors.message ? 'border-red-500' : 'border-[#E1E0E2]'"></textarea>
              <p v-if="errors.message" class="mt-1 text-sm text-red-600">{{ errors.message }}</p>
            </div>
            <div class="sm:col-span-2">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <input id="agree" name="agree" v-model="form.agree" type="checkbox" class="h-4 w-4 text-[#4FB0A6] focus:ring-2 focus:ring-[#4FB0A6] border-2 border-[#D9D9D9] rounded accent-[#4FB0A6]">
                </div>
                <div class="ml-3">
                  <p class="text-sm text-black">
                    {{ t.form.privacyAgreement }} <a :href="getLocalizedUrl('/privacy-policy')" class="font-medium text-[#4D9F95] underline">{{ t.form.privacyPolicy }}</a> {{ t.form.pages }}
                  </p>
                </div>
              </div>
              <p v-if="errors.agree" class="mt-1 text-sm text-red-600">{{ errors.agree }}</p>
            </div>
            <div class="sm:col-span-2 flex justify-center">
              <button type="submit" class="cursor-pointer w-52 h-12 inline-flex items-center justify-center border border-transparent rounded-3xl shadow-sm text-base font-medium text-white bg-gradient-to-r from-[#7ACAB3] to-[#A0AFF6] transition-all ease-in-out duration-500 hover:scale-[1.1] hover:shadow-[0_0_35px_5px_rgba(77,158,149,0.5)] active:duration-200 active:brightness-125 active:saturate-50 active:scale-110 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0AFF6]">
                {{ t.form.submit }}
              </button>
            </div>
          </form>
        </div>

        <div class="w-full mb-8 sm:mb-12 mt-8 sm:mt-12">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.019993961764!2d107.2327959!3d-6.4044139!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e699f0427dd160b%3A0xe7856e8d8c6de3a5!2sPT%20HLI%20Green%20Power!5e0!3m2!1sen!2sid!4v1690000000000!5m2!1sen!2sid"
            width="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            class="rounded-2xl md:rounded-r-3xl border border-gray-400 h-[320px] sm:h-[360px] md:h-[400px] lg:h-[600px]"
          ></iframe>
        </div>

        <div id="email-phone" class="mt-8 sm:mt-12 grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 md:gap-8">
          <div class="bg-white rounded-2xl md:rounded-3xl border border-[#E1E0E2] p-4 sm:p-6 md:p-8 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 md:gap-8 w-full">
            <div class="flex-shrink-0 w-full sm:w-auto flex justify-center sm:justify-start items-center sm:items-start">
               <img src="@/assets/icon-address.png" alt="Address Icon" class="h-auto w-28 object-contain">
            </div>
            <div class="text-center sm:text-left flex-1 w-full flex flex-col items-center sm:items-start">
              <h3 class="text-base sm:text-md font-semibold text-black">{{ t.contact.address }}</h3>
              <p class="mt-2 text-xs sm:text-sm text-[#676767] leading-5">
                <p>Karawang New Industrial City (KNIC)</p>
                <p>Block C No. 1</p>
                <p>Jl Trans Heksa Karawang KM 7</p>
                <p>Wanajaya, Teluk Jambe</p>
                <p>Karawang - Indonesia - 41361</p>
              </p>
            </div>
          </div>
          <div class="bg-white rounded-2xl md:rounded-3xl border border-[#E1E0E2] p-4 sm:p-6 md:p-8 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 md:gap-8 w-full">
            <div class="flex-shrink-0 w-full sm:w-auto flex justify-center sm:justify-start items-center">
              <img src="@/assets/icon-email.png" alt="Email Icon" class="h-auto w-28 object-contain">
            </div>
            <div class="text-center sm:text-left flex-1 w-full flex flex-col items-center sm:items-start">
              <h3 class="text-base sm:text-md font-semibold text-black">{{ t.contact.email }}</h3>
              <p class="mt-2 text-xs sm:text-sm text-[#676767] leading-5 break-all">
                hligrievance@hligreenpower.com
              </p>
            </div>
          </div>
          
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue'
import map from '@/assets/peta-contact.png'
import { useLocalization } from '@/composables/useLocalization'

const form = ref({
  fullname: '',
  email: '',
  phone: '',
  subject: '',
  message: '',
  agree: false,
});

const errors = ref({});

defineOptions({
  layout: AppLayout,
})

const { currentLocale, getLocalizedUrl } = useLocalization()

// Translations object
const translations = {
  en: {
    sections: {
      contactUs: "CONTACT US"
    },
    form: {
      title: "Get in Touch",
      subtitle: "We're here to connect.",
      description: "For partnership inquiries, media requests, or general information about HLI Green Power, reach out to our team and we'll respond with care and clarity.",
      fullName: "Your Full Name",
      email: "Your Email*",
      phone: "Your Phone*",
      selectSubject: "Select Subject",
      partnership: "Partnership",
      generalInformation: "General Information",
      other: "Other",
      message: "Your Message*",
      privacyAgreement: "I agree with submitting the form after reading the",
      privacyPolicy: "Privacy Policy",
      pages: "pages.",
      submit: "SUBMIT"
    },
    contact: {
      address: "Address",
      email: "Email"
    },
    errors: {
      emailRequired: "Email is required",
      emailInvalid: "Please enter a valid email address",
      phoneRequired: "Phone number is required",
      phoneInvalid: "Please enter a valid phone number",
      agreeRequired: "You must agree to the privacy policy"
    }
  },
  id: {
    sections: {
      contactUs: "HUBUNGI KAMI"
    },
    form: {
      title: "Hubungi Kami",
      subtitle: "Kami siap untuk terhubung.",
      description: "Untuk pertanyaan seputar kerja sama, permintaan media, atau informasi umum tentang HLI Green Power, silakan hubungi tim kami. Kami akan merespons dengan perhatian dan kejelasan.",
      fullName: "Masukkan nama lengkap Anda",
      email: "Email aktif untuk korespondensi",
      phone: "Cantumkan kode negara (mis. +62)",
      selectSubject: "Apa yang ingin Anda diskusikan?",
      partnership: "Partnership",
      generalInformation: "General Information",
      other: "Other",
      message: "Tulis pesan atau pertanyaan Anda di sini",
      privacyAgreement: "Saya menyetujui pengiriman formulir ini setelah membaca halaman Kebijakan Privasi.",
      privacyPolicy: "Kebijakan Privasi",
      pages: "pages.",
      submit: "KIRIM"
    },
    contact: {
      address: "Alamat",
      email: "Email"
    },
    errors: {
      emailRequired: "Email wajib diisi",
      emailInvalid: "Silakan masukkan alamat email yang valid",
      phoneRequired: "Nomor telepon wajib diisi",
      phoneInvalid: "Silakan masukkan nomor telepon yang valid",
      agreeRequired: "Anda harus menyetujui kebijakan privasi"
    }
  }
}

// Get current translations based on locale
const t = computed(() => {
  return translations[currentLocale.value] || translations.en
})

const validateForm = () => {
  errors.value = {};
  
  if (!form.value.email) {
    errors.value.email = t.value.errors.emailRequired;
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email)) {
    errors.value.email = t.value.errors.emailInvalid;
  }
  
  if (!form.value.phone) {
    errors.value.phone = t.value.errors.phoneRequired;
  } else if (!/^\+?[\d\s\-()]+$/.test(form.value.phone)) {
    errors.value.phone = t.value.errors.phoneInvalid;
  }
  
  if (!form.value.agree) {
    errors.value.agree = t.value.errors.agreeRequired;
  }
  
  return Object.keys(errors.value).length === 0;
};

const handleSubmit = () => {
  if (!validateForm()) return;
  router.post('/contact', {
    fullname: form.value.fullname,
    email: form.value.email,
    phone: form.value.phone,
    subject: form.value.subject,
    message: form.value.message,
    agree: form.value.agree ? 1 : 0 // Matches backend 'accepted' rule
  }, {
    onSuccess: () => router.visit('/contact/success'),
    onError: err => { errors.value = err; }
  });
};
</script>