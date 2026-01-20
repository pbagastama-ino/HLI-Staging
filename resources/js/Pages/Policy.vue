<template>
  <Head title="Privacy Policy - HLI Green Power" />
  <div class="bg-white font-sans text-black antialiased">
    <img 
      :src="hseImage" 
      alt="Company Overview Decoration" 
      class="hidden lg:block absolute top-[120px] xl:top-[240px] right-0 w-28 xl:w-32 h-auto z-10 mr-0 ml-auto"
    />
    <div class="relative min-h-screen container mx-auto max-w-7xl px-4 sm:px-6 md:px-8 xl:px-6 pt-32 md:pt-40 pb-16 md:pb-24">
      <!-- Header Legal & Privacy Policy -->
      <div class="flex flex-col gap-y-4 md:gap-y-10 mb-8">
        <div class="flex flex-row items-center gap-x-4">
          <div class="w-11 h-px bg-[#4D9F95]"></div>
          <h2 class="text-stone-500 text-[11px] sm:text-xs font-medium uppercase tracking-[4%]">
            LEGAL
          </h2>
        </div>
        <div class="flex flex-row items-center gap-x-4">
          <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-medium text-gray-900 mb-4 sm:mb-6 md:mb-8 leading-[120%] tracking-[0%]">Privacy Policy</h1>
        </div>
      </div>
      <div class="prose prose-sm sm:prose-base md:prose-lg max-w-none md:max-w-5xl text-left sm:text-justify text-sm sm:text-base leading-6 sm:leading-relaxed">
        <h2 class="text-base sm:text-lg font-medium">HLIGP Legal Disclaimer</h2>
        <p>
          Please read the following terms carefully.
        </p>
        <p>
          By using the www.hligreenpower.com site, You understand and agree that you have read the following terms, as well as the privacy policy contained in this site (the "Privacy Policy") and will be legally bound by them.
        </p>
        <p>
          The rights in the design, picture, logos, photograph, and content of this site are owned by or licensed to HLI Green Power (Herewith as "HLIGP"). You may not copy, reproduce, modify, republish, post or transmit any part of this site without written permission of HLIGP. You may view or print individuals pages only for your personal use.
        </p>
        <p>
          By disclosing your personal information to us or using our website, you understand and agree that HLIGP may collect, transfer, use, and disclose your personal information in accordance with this Privacy Policy. If required by applicable law, we will obtain your consent to our collection, use, transfer and disclosure of your personal information. 
          <strong class="uppercase">If you do not agree with any part of this Privacy Policy or our terms, then please do not disclose personal information to us or use the website.</strong>
        </p>


        <h2 class="text-base sm:text-lg font-medium mt-8">Privacy Policy</h2>
        <p class=" text-sm text-gray-500 !not-prose">Last Modified: July 2023</p>
        <p>
          Your privacy is important to HLIGP and We take your privacy and your personal data very seriously and thus comply with Regulations on Privacy as state on Republic of Indonesia Act Number 27 years 2022 about Personal Information Protection.
        </p>
        <p>
          This Privacy Policy describes where and how the personal information you have disclosed in this site is used and what measures we have in place to protect your personal data.
        </p>
        <p>
          This Privacy Policy only applies on the site and not to any others website or online service that not on behalf of HLIGP. It does not apply to any third-party website even though we may link to these site on our website.
        </p>

        <h2 class="text-base sm:text-lg font-medium mt-8">Article 1. Personal Information We Collect and How We Collect it.</h2>
        <p>
          We process personal information for the following purpose. Such personal information shall not be used for any purpose other than the purpose specified bellow, and if there are any changes in the purpose of use, We will obtaining additional consent from users.
        </p>
        <ol class="list-decimal ml-6">
          <li>Providing Information for Hiring process: If you choose to participate at HLIGP recruitment process, you will be asked to provide some personal information about you and also upload some resume or curriculum vitae in our website. This kind of information may be used by HLIGP service providers exclusively for the purpose of administrating service in HLIGP hiring process.</li>
          <li>Receiving Information for any reports: If you choose to participate at HLIGP reporting information, You may submit or not submit personal information. When you submit the personal information due to this reporting, we will keep the information as highly confidential information.</li>
        </ol>
        <p>
          Only personal data You provide on the website will be collected.
        </p>

        <h2 class="text-base sm:text-lg font-medium mt-8">Article 2. Measure to ensure the security of Personal Information</h2>
        <p>
          We takes the following measures to ensure the security personal information.
        </p>
        <ol class="list-decimal ml-6">
          <li><strong>Administrative Measures:</strong> We established and implemented an internal management plan for the Security management and also we tightly manage access right for employee that handle personal information.</li>
          <li><strong>Technical Measures:</strong> We have security applications in place and keep them checked and updated on a regular basis.</li>
          <li><strong>Encryption of Personal Data:</strong> We ensure that proper security measures have been applied, including encryption or locking. We will not be held liable for any breach of your personal data resulting from your carelessness or any problem with the Internet, provided the breach has not been caused by our willful conduct or negligence. You agree that you will keep your username and password strictly to yourself to ensure their security.</li>
        </ol>

        <p class="mt-8">
          If you have any question about HLIGP, you may contact as on the menu of Contact on this website.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import hseImage from '@/assets/supergraphic-dots.png'

defineOptions({
  layout: AppLayout,
});
</script>