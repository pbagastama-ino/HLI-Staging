<template>
  <div class="relative min-h-screen">
    <div class="absolute top-8 -left-24 grid grid-cols-5 gap-4 opacity-30 z-0 pointer-events-none">
      <template v-for="i in 50" :key="i">
        <div class="w-1.5 h-1.5 bg-teal-200 rounded-full"></div>
      </template>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 pt-40 sm:pt-48 pb-16 sm:pb-24">
      <div class="max-w-5xl mx-auto">
        <div class="text-center md:text-left mb-12">
          <div class="flex flex-row items-center justify-center md:justify-start mb-4">
            <div class="h-px bg-[#59C3B4] w-16 mr-6"></div>
            <h2 class="text-stone-500 text-xs font-medium uppercase tracking-widest whitespace-nowrap">
              {{ t.sections.careerDevelopment }}
            </h2>
          </div>
        </div>

        <div class="mb-12">
          <div v-if="currentStep <= steps.length && currentStep < 9" class="block md:hidden text-center mb-4">
            <p class="text-sm font-semibold text-gray-600">
              {{ t.steps.step }} {{ currentStep }} {{ t.steps.of }} {{ steps.length }}: 
              <span class="font-bold text-teal-600">{{ steps[currentStep - 1].name }}</span>
            </p>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
              <div class="bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] h-2.5 rounded-full" :style="{ width: (currentStep / steps.length) * 100 + '%' }"></div>
            </div>
          </div>

          <!-- Desktop Progress Bar -->
          <div v-if="currentStep <= steps.length && currentStep < 9" class="hidden md:block">
            <div class="relative mb-5">
              <!-- Progress Bar Background -->
              <div class="w-full h-3 bg-gray-300 rounded-full"></div>
              
              <!-- Progress Bar Fill with Gradient -->
              <div 
                class="absolute top-0 h-3 rounded-full transition-all duration-500 ease-out"
                :style="{ 
                  width: ((currentStep - 1) / (steps.length - 1)) * 100 + '%',
                  background: 'linear-gradient(to right, #A0AFF6, #7ACAB3)'
                }"
              ></div>
              
              <!-- Single Moving Circle -->
              <div 
                class="absolute top-1/2 transform -translate-y-1/2 w-4 h-4 bg-white rounded-full shadow-lg transition-all duration-500 ease-out z-10"
                :style="{ 
                  left: `calc(${(currentStep - 1) * (100 / (steps.length - 1))}% - 8px)`,
                  boxShadow: '0 0 0 4px rgba(122, 202, 179, 0.3)'
                }"
              ></div>
            </div>
            
            <!-- Step Labels -->
            <div class="relative w-full mb-8 pb-2">
              <template v-for="(step, index) in steps" :key="step.id">
                <button 
                  @click="goToStep(index + 1)" 
                  class="absolute text-sm font-medium uppercase tracking-wide transition-colors duration-300 focus:outline-none whitespace-nowrap transform -translate-x-1/2"
                  :class="currentStep === index + 1 ? 'text-[#7ACAB3]' : 'text-gray-500'"
                  :style="{ 
                    left: `${index * (100 / (steps.length - 1))}%`
                  }"
                >
                  {{ step.name.toUpperCase() }}
                </button>
              </template>
            </div>
          </div>
        </div>

        <form @submit.prevent="submitForm" class="p-6 sm:p-12">
          <!-- Step Title -->
          <div v-if="currentStep <= steps.length && currentStep < 9" class="flex items-center justify-between mb-8">
            <h1 class="text-5xl font-medium text-gray-900">{{ steps[currentStep - 1].name }}</h1>
            <span v-if="currentStep !== 8" class="text-sm text-gray-500">{{ t.common.requiredField }}</span>
          </div>
          
          <!-- Biography Step -->
          <div v-if="currentStep === 1" class="space-y-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.biography.fullName }}</label>
              <input 
                v-model="formData.personal.fullName" 
                type="text" 
                :placeholder="t.biography.fullNamePlaceholder"
                :class="[
                  'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                  validationErrors.fullName ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                ]"
                @input="clearValidationErrors"
              >
              <p v-if="validationErrors.fullName" class="mt-1 text-sm text-red-600">{{ validationErrors.fullName }}</p>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.biography.nationality }}</label>
              <select 
                v-model="formData.personal.nationality" 
                :class="[
                  'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                  validationErrors.nationality ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                ]"
                @change="clearValidationErrors"
              >
                <option value="" disabled>{{ t.biography.nationalityPlaceholder }}</option>
                <option value="Indonesian">Indonesian</option>
                <option value="Malaysian">Malaysian</option>
                <option value="Singaporean">Singaporean</option>
                <option value="Thai">Thai</option>
                <option value="Filipino">Filipino</option>
                <option value="Vietnamese">Vietnamese</option>
                <option value="Cambodian">Cambodian</option>
                <option value="Laotian">Laotian</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Bruneian">Bruneian</option>
                <option value="Chinese">Chinese</option>
                <option value="Japanese">Japanese</option>
                <option value="Korean">Korean</option>
                <option value="American">American</option>
                <option value="British">British</option>
                <option value="Australian">Australian</option>
                <option value="Canadian">Canadian</option>
                <option value="German">German</option>
                <option value="French">French</option>
                <option value="Italian">Italian</option>
                <option value="Spanish">Spanish</option>
                <option value="Dutch">Dutch</option>
                <option value="Swiss">Swiss</option>
                <option value="Swedish">Swedish</option>
                <option value="Norwegian">Norwegian</option>
                <option value="Danish">Danish</option>
                <option value="Finnish">Finnish</option>
                <option value="Russian">Russian</option>
                <option value="Indian">Indian</option>
                <option value="Pakistani">Pakistani</option>
                <option value="Bangladeshi">Bangladeshi</option>
                <option value="Sri Lankan">Sri Lankan</option>
                <option value="Nepalese">Nepalese</option>
                <option value="Afghan">Afghan</option>
                <option value="Iranian">Iranian</option>
                <option value="Iraqi">Iraqi</option>
                <option value="Turkish">Turkish</option>
                <option value="Egyptian">Egyptian</option>
                <option value="South African">South African</option>
                <option value="Nigerian">Nigerian</option>
                <option value="Kenyan">Kenyan</option>
                <option value="Ethiopian">Ethiopian</option>
                <option value="Brazilian">Brazilian</option>
                <option value="Argentinian">Argentinian</option>
                <option value="Chilean">Chilean</option>
                <option value="Mexican">Mexican</option>
                <option value="Other">Other</option>
              </select>
              <p v-if="validationErrors.nationality" class="mt-1 text-sm text-red-600">{{ validationErrors.nationality }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.biography.dob }}</label>
                <div class="relative">
                  <input 
                    v-model="formData.personal.dob" 
                    type="text" 
                    readonly
                    :placeholder="t.biography.dobPlaceholder"
                    @click="showDatePicker = !showDatePicker"
                    :class="[
                      'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 cursor-pointer',
                      validationErrors.dob ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                    ]"
                  >
                  <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                  
                  <!-- Compact Date Picker Dropdown -->
                  <div v-if="showDatePicker" class="absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg">
                    <div class="p-4">
                      <!-- Year and Month Selectors -->
                      <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">{{ t.biography.year }}</label>
                          <select 
                            v-model="selectedYear" 
                            @change="updateDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                          >
                            <option v-for="year in availableYears" :key="year" :value="year">{{ year }}</option>
                          </select>
                        </div>
                        <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">{{ t.biography.month }}</label>
                          <select 
                            v-model="selectedMonth" 
                            @change="updateDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                          >
                            <option v-for="(month, index) in months" :key="index" :value="index">{{ month }}</option>
                          </select>
                        </div>
                      </div>
                      
                      <!-- Day Selector -->
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ t.biography.day }}</label>
                        <select 
                          v-model="selectedDay" 
                          @change="updateDate"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                          <option v-for="day in availableDays" :key="day" :value="day">{{ day }}</option>
                        </select>
                      </div>
                      
                      <!-- Action Buttons -->
                      <div class="flex justify-end gap-2 mt-4 pt-4 border-t border-gray-200">
                        <button 
                          @click="showDatePicker = false" 
                          type="button"
                          class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800"
                        >
                          {{ t.common.cancel }}
                        </button>
                        <button 
                          @click="confirmDate" 
                          type="button"
                          class="px-4 py-2 text-sm bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white border-transparent rounded-md hover:opacity-90 transition-opacity"
                        >
                          {{ t.common.confirm }}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <p v-if="validationErrors.dob" class="mt-1 text-sm text-red-600">{{ validationErrors.dob }}</p>
                <!-- <p class="mt-1 text-xs text-gray-500">Minimum age: 18 years old</p> -->
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.biography.pob }}</label>
                <input 
                  v-model="formData.personal.pob" 
                  type="text" 
                  :placeholder="t.biography.pobPlaceholder"
                  :class="[
                    'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                    validationErrors.pob ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                  ]"
                  @input="clearValidationErrors"
                >
                <p v-if="validationErrors.pob" class="mt-1 text-sm text-red-600">{{ validationErrors.pob }}</p>
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.biography.maritalStatus }}</label>
              <select 
                v-model="formData.personal.maritalStatus" 
                :class="[
                  'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                  validationErrors.maritalStatus ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                ]"
                @change="clearValidationErrors"
              >
                <option value="" disabled>{{ t.biography.maritalStatusPlaceholder }}</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
              </select>
              <p v-if="validationErrors.maritalStatus" class="mt-1 text-sm text-red-600">{{ validationErrors.maritalStatus }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.biography.idAddress }}</label>
                <textarea 
                  v-model="formData.personal.idaddress" 
                  rows="3"
                  :placeholder="t.biography.idAddressPlaceholder"
                  :class="[
                    'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                    validationErrors.idaddress ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                  ]"
                  @input="clearValidationErrors"
                ></textarea>
                <p v-if="validationErrors.idaddress" class="mt-1 text-sm text-red-600">{{ validationErrors.idaddress }}</p>
              </div>
              
              <div>
                <div class="flex items-center justify-between mb-2">
                  <label class="block text-sm font-medium text-gray-700">{{ t.biography.currentAddress }}</label>
                  <label class="flex items-center gap-2 cursor-pointer">
                    <input 
                      type="checkbox" 
                      v-model="formData.personal.sameAsIdAddress"
                      @change="toggleSameAsIdAddress"
                      class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                    >
                    <span class="text-sm text-gray-700">{{ t.biography.sameAsIdAddress }}</span>
                  </label>
                </div>
                <textarea 
                  v-model="formData.personal.currentaddress" 
                  rows="3"
                  :disabled="formData.personal.sameAsIdAddress"
                  :placeholder="t.biography.currentAddressPlaceholder"
                  :class="[
                    'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                    validationErrors.currentaddress ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500',
                    formData.personal.sameAsIdAddress ? 'disabled:bg-gray-100 disabled:cursor-not-allowed' : ''
                  ]"
                  @input="clearValidationErrors"
                ></textarea>
                <p v-if="validationErrors.currentaddress" class="mt-1 text-sm text-red-600">{{ validationErrors.currentaddress }}</p>
              </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.biography.phoneNumber }}</label>
              <div class="flex gap-2">
                <select 
                  v-model="formData.personal.countryCode" 
                  class="w-32 px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white"
                >
                  <option value="" disabled>{{ t.biography.countryCode }}</option>
                  <option value="+62">🇮🇩 +62</option>
                  <option value="+60">🇲🇾 +60</option>
                  <option value="+65">🇸🇬 +65</option>
                  <option value="+66">🇹🇭 +66</option>
                  <option value="+63">🇵🇭 +63</option>
                  <option value="+84">🇻🇳 +84</option>
                  <option value="+855">🇰🇭 +855</option>
                  <option value="+856">🇱🇦 +856</option>
                  <option value="+95">🇲🇲 +95</option>
                  <option value="+673">🇧🇳 +673</option>
                  <option value="+86">🇨🇳 +86</option>
                  <option value="+81">🇯🇵 +81</option>
                  <option value="+82">🇰🇷 +82</option>
                  <option value="+1">🇺🇸 +1</option>
                  <option value="+44">🇬🇧 +44</option>
                  <option value="+61">🇦🇺 +61</option>
                  <option value="+1">🇨🇦 +1</option>
                  <option value="+49">🇩🇪 +49</option>
                  <option value="+33">🇫🇷 +33</option>
                  <option value="+39">🇮🇹 +39</option>
                  <option value="+34">🇪🇸 +34</option>
                  <option value="+31">🇳🇱 +31</option>
                  <option value="+41">🇨🇭 +41</option>
                  <option value="+46">🇸🇪 +46</option>
                  <option value="+47">🇳🇴 +47</option>
                  <option value="+45">🇩🇰 +45</option>
                  <option value="+358">🇫🇮 +358</option>
                  <option value="+7">🇷🇺 +7</option>
                  <option value="+91">🇮🇳 +91</option>
                  <option value="+92">🇵🇰 +92</option>
                  <option value="+880">🇧🇩 +880</option>
                  <option value="+94">🇱🇰 +94</option>
                  <option value="+977">🇳🇵 +977</option>
                  <option value="+93">🇦🇫 +93</option>
                  <option value="+98">🇮🇷 +98</option>
                  <option value="+964">🇮🇶 +964</option>
                  <option value="+90">🇹🇷 +90</option>
                  <option value="+20">🇪🇬 +20</option>
                  <option value="+27">🇿🇦 +27</option>
                  <option value="+234">🇳🇬 +234</option>
                  <option value="+254">🇰🇪 +254</option>
                  <option value="+251">🇪🇹 +251</option>
                  <option value="+55">🇧🇷 +55</option>
                  <option value="+54">🇦🇷 +54</option>
                  <option value="+56">🇨🇱 +56</option>
                  <option value="+52">🇲🇽 +52</option>
                </select>
                <input 
                  v-model="formData.personal.phone" 
                  type="number" 
                  :placeholder="t.biography.phonePlaceholder"
                  :class="[
                    'flex-1 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                    validationErrors.phone ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                  ]"
                  @input="handlePhoneInput"
                  @keypress="preventZeroStart"
                >
              </div>
              <p v-if="validationErrors.phone" class="mt-1 text-sm text-red-600">{{ validationErrors.phone }}</p>
              <p v-if="validationErrors.countryCode" class="mt-1 text-sm text-red-600">{{ validationErrors.countryCode }}</p>
            </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.biography.emailAddress }}</label>
                <input 
                  v-model="formData.personal.email" 
                  type="email" 
                  :placeholder="t.biography.emailPlaceholder"
                  :class="[
                    'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                    validationErrors.email ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                  ]"
                  @input="handleEmailInput"
                >
                <p v-if="validationErrors.email" class="mt-1 text-sm text-red-600">{{ validationErrors.email }}</p>
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.biography.linkedin }}</label>
              <input 
                v-model="formData.personal.linkedin" 
                type="text" 
                :placeholder="t.biography.linkedinPlaceholder"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
              >
            </div>
          </div>
          
          <!-- Education Step -->
          <div v-if="currentStep === 2" class="space-y-6">
            <!-- Last Education Section -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-4">{{ t.education.lastEducation }}</label>
              <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                <button 
                  v-for="level in educationLevels" 
                  :key="level"
                  @click="formData.education.level = level; clearValidationErrors()"
                  type="button"
                  class="px-6 py-3 border border-gray-300 rounded-lg font-medium transition-colors w-full"
                  :class="formData.education.level === level ? 'bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white border-transparent' : 'text-gray-700 hover:bg-gray-50'"
                >
                  {{ level }}
                </button>
              </div>
              <p v-if="validationErrors.educationLevel" class="mt-1 text-sm text-red-600">{{ validationErrors.educationLevel }}</p>
            </div>

            <!-- Education History Section -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-4">{{ t.education.educationHistory }}</label>
              
              <!-- Display existing education history -->
              <div v-if="formData.education.history.length > 0" class="space-y-2 mb-4">
                <div v-for="(edu, index) in formData.education.history" :key="index" class="flex items-center justify-between text-gray-800">
                  <span>{{ edu.startDate }}-{{ edu.endDate }} — {{ edu.schoolName }}</span>
                  <button 
                    @click="removeEducation(index)" 
                    type="button"
                    class="text-red-500 hover:text-red-700 transition-colors ml-4"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </div>
              </div>
              
              <!-- ADD MORE Button (only shown when form is not visible) -->
              <button 
                v-if="!showEducationForm"
                @click="addEducation" 
                type="button"
                class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-all duration-300 mb-6"
              >
                {{ t.common.addMore }}
              </button>
              <p v-if="validationErrors.educationHistory" class="mt-1 text-sm text-red-600">{{ validationErrors.educationHistory }}</p>
            </div>

            <!-- Education Form Fields (shown when adding new education) -->
            <div v-if="showEducationForm" class="space-y-6 border-t border-b border-gray-200 pt-6 pb-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.education.schoolName }}</label>
                  <input 
                    v-model="newEducation.schoolName" 
                    type="text" 
                    :placeholder="t.education.schoolNamePlaceholder"
                    :class="[
                      'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                      validationErrors.schoolName ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                    ]"
                    @input="clearValidationErrors"
                  >
                  <p v-if="validationErrors.schoolName" class="mt-1 text-sm text-red-600">{{ validationErrors.schoolName }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.education.faculty }}</label>
                  <input 
                    v-model="newEducation.faculty" 
                    type="text" 
                    :placeholder="t.education.facultyPlaceholder"
                    :class="[
                      'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                      validationErrors.faculty ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                    ]"
                    @input="clearValidationErrors"
                  >
                  <p v-if="validationErrors.faculty" class="mt-1 text-sm text-red-600">{{ validationErrors.faculty }}</p>
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.education.major }}</label>
                  <input 
                    v-model="newEducation.major" 
                    type="text" 
                    :placeholder="t.education.majorPlaceholder"
                    :class="[
                      'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                      validationErrors.major ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                    ]"
                    @input="clearValidationErrors"
                  >
                  <p v-if="validationErrors.major" class="mt-1 text-sm text-red-600">{{ validationErrors.major }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.education.from }}</label>
                  <select 
                    v-model="newEducation.startDate" 
                    @change="clearValidationErrors"
                    :class="[
                      'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                      validationErrors.startDate ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                    ]"
                  >
                    <option value="" disabled>{{ t.education.selectStartYear }}</option>
                    <option v-for="year in availableEducationYears" :key="year" :value="year">{{ year }}</option>
                  </select>
                  <p v-if="validationErrors.startDate" class="mt-1 text-sm text-red-600">{{ validationErrors.startDate }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.education.to }}</label>
                  <select 
                    v-model="newEducation.endDate" 
                    @change="clearValidationErrors"
                    :class="[
                      'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                      validationErrors.endDate ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                    ]"
                  >
                    <option value="" disabled>{{ t.education.selectEndYear }}</option>
                    <option v-for="year in availableEducationYears" :key="year" :value="year">{{ year }}</option>
                  </select>
                  <p v-if="validationErrors.endDate" class="mt-1 text-sm text-red-600">{{ validationErrors.endDate }}</p>
                </div>
              </div>
              
              <div class="pb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.education.certificate }}</label>
                <div class="flex items-center gap-4">
                  <input 
                    ref="certificateInput"
                    type="file" 
                    accept=".pdf"
                    @change="handleCertificateUpload"
                    class="hidden"
                  >
                  <button 
                    @click="$refs.certificateInput.click()"
                    type="button"
                    class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90"
                  >
                    {{ t.common.upload }}
                  </button>
                  <span v-if="newEducation.certificate" class="text-sm text-gray-600">
                    {{ newEducation.certificate.name }}
                  </span>
                </div>
              </div>
              
              <!-- Save and Cancel buttons -->
              <div class="flex gap-4 pb-6 border-b border-gray-200">
                <button 
                  @click="saveEducation" 
                  type="button"
                  class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90"
                >
                  {{ t.education.saveEducation }}
                </button>
                <button 
                  @click="cancelEducation" 
                  type="button"
                  class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50"
                >
                  {{ t.common.cancel }}
                </button>
              </div>
            </div>
          </div>

          <!-- Language Step -->
          <div v-if="currentStep === 3" class="space-y-6">
            <p class="text-gray-700 mb-6 font-bold">{{ t.language.proficient }}</p>
            <p v-if="validationErrors.languages" class="mb-4 text-sm text-red-600">{{ validationErrors.languages }}</p>
            
            <!-- Language Selection Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
              <!-- Predefined Languages -->
              <button 
                v-for="language in languages" 
                :key="language.name"
                @click="handleLanguageClick(language)"
                type="button"
                class="p-6 border border-gray-300 rounded-lg text-center transition-all duration-300"
                :class="isLanguageSelected(language.name) ? 'bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white border-transparent' : 'text-gray-700 hover:bg-gray-50'"
              >
                <div class="font-medium text-lg">{{ language.name }}</div>
                <div v-if="isLanguageSelected(language.name) && getLanguageProficiency(language.name)" class="text-sm mt-1">{{ getTranslatedProficiency(getLanguageProficiency(language.name)) }}</div>
              </button>
              
              <!-- Custom Languages -->
              <button 
                v-for="customLang in formData.languages.filter(lang => !languages.some(predefined => predefined.name === lang.name))" 
                :key="'custom-' + customLang.name"
                @click="removeCustomLanguage(customLang.name)"
                type="button"
                class="p-6 border border-gray-300 rounded-lg text-center transition-all duration-300 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white border-transparent"
              >
                <div class="font-medium text-lg">{{ customLang.name }}</div>
                <div class="text-sm mt-1">{{ getTranslatedProficiency(customLang.proficiency) }}</div>
              </button>
            </div>
            
            <!-- Custom Language Input (for "Other" option) -->
            <div v-if="showCustomLanguageInput" class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.language.enterLanguageName }}</label>
              <div class="flex gap-3">
                <input 
                  v-model="customLanguage" 
                  type="text" 
                  :placeholder="t.language.enterLanguagePlaceholder"
                  class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  @keyup.enter="addCustomLanguage"
                >
                <button 
                  @click="addCustomLanguage" 
                  type="button"
                  class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90"
                >
                  {{ t.common.add }}
                </button>
              </div>
            </div>
            
            <p class="text-sm text-gray-500">{{ t.language.moreThanOneApplicable }}</p>
            
            <!-- Proficiency Selection Modal -->
            <div v-if="showProficiencyModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
              <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4">{{ t.language.selectProficiencyLevel }} {{ selectedLanguage }}</h3>
                <div class="space-y-3">
                  <button 
                    v-for="level in proficiencyLevels" 
                    :key="level"
                    @click="selectProficiency(level)"
                    type="button"
                    class="w-full p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-50 transition-colors"
                  >
                    {{ getTranslatedProficiency(level) }}
                  </button>
                </div>
                <div class="mt-4 flex justify-end">
                  <button 
                    @click="closeProficiencyModal" 
                    type="button"
                    class="px-6 py-3 border border-gray-300 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200"
                  >
                    {{ t.common.cancel }}
                  </button>
                </div>
              </div>
            </div>
          </div>


          <!-- Experience Step -->
          <div v-if="currentStep === 4" class="space-y-6">
            <!-- Experience History Section -->
            <div>
              <h3 class="text-xl font-bold text-gray-900 mb-4">{{ t.experience.experienceHistory }}</h3>
              <div class="border-t border-green-200 mb-4"></div>
              
              <!-- Existing Experience Entries -->
              <div class="space-y-2 mb-4">
                <div v-if="formData.experience.history.length === 0" class="text-gray-500 italic">
                  {{ t.experience.noExperienceEntries }}
                </div>
                <div v-for="(exp, index) in formData.experience.history" :key="index" class="flex items-center justify-between text-gray-800">
                  <span>{{ exp.startDate }}-{{ exp.endDate }} — {{ exp.position }} at {{ exp.companyName }}</span>
                  <button 
                    @click="removeExperience(index)" 
                    type="button"
                    class="text-red-500 hover:text-red-700 transition-colors ml-4"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </div>
              </div>
              
              <!-- ADD MORE Button (only shown when form is not visible) -->
              <button 
                v-if="!showExperienceForm"
                @click="addExperience" 
                type="button"
                class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-all duration-300 mb-6"
              >
                {{ t.common.addMore }}
              </button>
            </div>

            <!-- Experience Form (shown when adding new experience) -->
            <div v-if="showExperienceForm" class="space-y-6 border-t border-gray-200 pt-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.experience.companyName }}</label>
                  <input 
                    v-model="newExperience.companyName" 
                    type="text" 
                    :placeholder="t.experience.companyNamePlaceholder"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.experience.position }}</label>
                  <input 
                    v-model="newExperience.position" 
                    type="text" 
                    :placeholder="t.experience.positionPlaceholder"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.experience.from }}</label>
                  <select 
                    v-model="newExperience.startDate" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                    <option value="" disabled>{{ t.experience.selectStartYear }}</option>
                    <option v-for="year in availableExperienceYears" :key="year" :value="year">{{ year }}</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.experience.to }}</label>
                  <select 
                    v-model="newExperience.endDate" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                    <option value="" disabled>{{ t.experience.selectEndYear }}</option>
                    <option value="Present">{{ t.experience.present }}</option>
                    <option v-for="year in availableExperienceYears" :key="year" :value="year">{{ year }}</option>
                  </select>
                </div>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.experience.jobDescription }}</label>
                <textarea 
                  v-model="newExperience.jobDesc" 
                  rows="4"
                  :placeholder="t.experience.jobDescriptionPlaceholder"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                ></textarea>
              </div>
              
              <div class="flex gap-4 pb-6 border-b border-gray-200">
                <button 
                  @click="saveExperience" 
                  type="button"
                  class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-all duration-300"
                >
                  ADD
                </button>
                <button 
                  @click="cancelExperience" 
                  type="button"
                  class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-300"
                >
                  Cancel
                </button>
              </div>
            </div>

            <!-- Current Salary Section -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.experience.currentMonthlySalary }}</label>
              <div class="flex gap-2">
                <select 
                  v-model="formData.experience.currency" 
                  class="w-24 px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white"
                >
                  <option value="" disabled>{{ t.experience.currency }}</option>
                  <option value="IDR">IDR</option>
                  <option value="USD">USD</option>
                  <option value="SGD">SGD</option>
                  <option value="MYR">MYR</option>
                  <option value="THB">THB</option>
                  <option value="PHP">PHP</option>
                  <option value="VND">VND</option>
                  <option value="KHR">KHR</option>
                  <option value="LAK">LAK</option>
                  <option value="MMK">MMK</option>
                  <option value="BND">BND</option>
                  <option value="CNY">CNY</option>
                  <option value="JPY">JPY</option>
                  <option value="KRW">KRW</option>
                  <option value="EUR">EUR</option>
                  <option value="GBP">GBP</option>
                  <option value="AUD">AUD</option>
                  <option value="CAD">CAD</option>
                </select>
                <input 
                  v-model="formData.experience.currentSalary" 
                  type="text" 
                  :placeholder="t.experience.salaryPlaceholder"
                  :class="[
                    'flex-1 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                    validationErrors.currentSalary ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                  ]"
                  @input="handleSalaryInput"
                  @keypress="preventNonNumeric"
                >
              </div>
              <p v-if="validationErrors.currentSalary" class="mt-1 text-sm text-red-600">{{ validationErrors.currentSalary }}</p>
              <p v-if="validationErrors.currency" class="mt-1 text-sm text-red-600">{{ validationErrors.currency }}</p>
            </div>
            
            <!-- Reasons For Leaving Section -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.experience.reasonsForLeaving }}</label>
              <textarea 
                v-model="formData.experience.reasonsForLeaving" 
                rows="4"
                :placeholder="t.experience.reasonsForLeavingPlaceholder"
                :class="[
                  'w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2',
                  validationErrors.reasonsForLeaving ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-green-500'
                ]"
                @input="clearValidationErrors"
              ></textarea>
              <p v-if="validationErrors.reasonsForLeaving" class="mt-1 text-sm text-red-600">{{ validationErrors.reasonsForLeaving }}</p>
            </div>
          </div>
          
          <!-- Achievements Step -->
          <div v-if="currentStep === 5" class="space-y-6">
            <!-- List of Achievements/Awards Section -->
            <div>
              <h3 class="text-xl font-bold text-gray-900 mb-4">{{ t.achievements.listOfAchievements }}</h3>
              <div class="border-t border-green-200 mb-4"></div>
              
              <!-- Existing Achievement Entries -->
              <div class="space-y-2 mb-4">
                <div v-if="formData.achievements.history.length === 0" class="text-gray-500 italic">
                  {{ t.achievements.noAchievements }}
                </div>
                <div v-for="(achievement, index) in formData.achievements.history" :key="index" class="flex items-center justify-between text-gray-800">
                  <span><strong>{{ achievement.year }}</strong> – {{ achievement.title }}</span>
                  <button 
                    @click="removeAchievement(index)" 
                    type="button"
                    class="text-red-500 hover:text-red-700 transition-colors ml-4"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </div>
              </div>
              
              <!-- ADD MORE Button (only shown when form is not visible) -->
              <button 
                v-if="!showAchievementForm"
                @click="addAchievement" 
                type="button"
                class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-all duration-300 mb-6"
              >
                {{ t.common.addMore }}
              </button>
            </div>

            <!-- Achievement Form (shown when adding new achievement) -->
            <div v-if="showAchievementForm" class="space-y-6 border-t border-gray-200 pt-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.achievements.achievementAward }}</label>
                <input 
                  v-model="newAchievement.title" 
                  type="text" 
                  :placeholder="t.achievements.achievementPlaceholder"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                >
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.achievements.description }}</label>
                <input 
                  v-model="newAchievement.description" 
                  type="text" 
                  :placeholder="t.achievements.descriptionPlaceholder"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                >
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.achievements.yearObtained }}</label>
                <select 
                  v-model="newAchievement.year" 
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                  <option value="" disabled>{{ t.achievements.selectAchievementYear }}</option>
                  <option v-for="year in availableEducationYears" :key="year" :value="year">{{ year }}</option>
                </select>
              </div>
              
              <div class="flex gap-4 pb-6 border-b border-gray-200">
                <button 
                  @click="saveAchievement" 
                  type="button"
                  class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-all duration-300"
                >
                  ADD
                </button>
                <button 
                  @click="cancelAchievement" 
                  type="button"
                  class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-300"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>

          <!-- References Step -->
          <div v-if="currentStep === 6" class="space-y-6">
            <!-- List of References Section -->
            <div>
              <h3 class="text-xl font-bold text-gray-900 mb-4">{{ t.references.listOfReferences }}</h3>
              <div class="border-t border-green-200 mb-4"></div>
              
              <!-- Existing Reference Entries -->
              <div class="space-y-2 mb-4">
                <div v-if="formData.references.history.length === 0" class="text-gray-500 italic">
                  {{ t.references.noReferences }}
                </div>
                <div v-for="(ref, index) in formData.references.history" :key="index" class="flex items-center justify-between text-gray-800">
                  <span><strong>{{ ref.name }}</strong> — {{ ref.relationship }}</span>
                  <button 
                    @click="removeReference(index)" 
                    type="button"
                    class="text-red-500 hover:text-red-700 transition-colors ml-4"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </div>
              </div>
              
              <!-- ADD MORE Button (only shown when form is not visible) -->
              <button 
                v-if="!showReferenceForm"
                @click="addReference" 
                type="button"
                class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-all duration-300 mb-6"
              >
                {{ t.common.addMore }}
              </button>
            </div>

            <!-- Reference Form (shown when adding new reference) -->
            <div v-if="showReferenceForm" class="space-y-6 border-t border-gray-200 pt-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.references.referenceName }}</label>
                  <input 
                    v-model="newReference.name" 
                    type="text" 
                    :placeholder="t.references.referenceNamePlaceholder"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.references.organization }}</label>
                  <input 
                    v-model="newReference.organization" 
                    type="text" 
                    :placeholder="t.references.organizationPlaceholder"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.references.phoneNumber }}</label>
                  <div class="flex gap-2">
                    <select 
                      v-model="newReference.countryCode" 
                      class="w-32 px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white"
                    >
                      <option value="" disabled>{{ t.references.code }}</option>
                      <option value="+62">🇮🇩 +62</option>
                      <option value="+60">🇲🇾 +60</option>
                      <option value="+65">🇸🇬 +65</option>
                      <option value="+66">🇹🇭 +66</option>
                      <option value="+63">🇵🇭 +63</option>
                      <option value="+84">🇻🇳 +84</option>
                      <option value="+855">🇰🇭 +855</option>
                      <option value="+856">🇱🇦 +856</option>
                      <option value="+95">🇲🇲 +95</option>
                      <option value="+673">🇧🇳 +673</option>
                      <option value="+86">🇨🇳 +86</option>
                      <option value="+81">🇯🇵 +81</option>
                      <option value="+82">🇰🇷 +82</option>
                      <option value="+1">🇺🇸 +1</option>
                      <option value="+44">🇬🇧 +44</option>
                      <option value="+61">🇦🇺 +61</option>
                      <option value="+1">🇨🇦 +1</option>
                      <option value="+49">🇩🇪 +49</option>
                      <option value="+33">🇫🇷 +33</option>
                      <option value="+39">🇮🇹 +39</option>
                      <option value="+34">🇪🇸 +34</option>
                      <option value="+31">🇳🇱 +31</option>
                      <option value="+41">🇨🇭 +41</option>
                      <option value="+46">🇸🇪 +46</option>
                      <option value="+47">🇳🇴 +47</option>
                      <option value="+45">🇩🇰 +45</option>
                      <option value="+358">🇫🇮 +358</option>
                      <option value="+7">🇷🇺 +7</option>
                      <option value="+91">🇮🇳 +91</option>
                      <option value="+92">🇵🇰 +92</option>
                      <option value="+880">🇧🇩 +880</option>
                      <option value="+94">🇱🇰 +94</option>
                      <option value="+977">🇳🇵 +977</option>
                      <option value="+93">🇦🇫 +93</option>
                      <option value="+98">🇮🇷 +98</option>
                      <option value="+964">🇮🇶 +964</option>
                      <option value="+90">🇹🇷 +90</option>
                      <option value="+20">🇪🇬 +20</option>
                      <option value="+27">🇿🇦 +27</option>
                      <option value="+234">🇳🇬 +234</option>
                      <option value="+254">🇰🇪 +254</option>
                      <option value="+251">🇪🇹 +251</option>
                      <option value="+55">🇧🇷 +55</option>
                      <option value="+54">🇦🇷 +54</option>
                      <option value="+56">🇨🇱 +56</option>
                      <option value="+52">🇲🇽 +52</option>
                    </select>
                    <input 
                      v-model="newReference.phone" 
                      type="number" 
                      :placeholder="t.references.phonePlaceholder"
                      class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                      @input="handleReferencePhoneInput"
                      @keypress="preventZeroStart"
                    >
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.references.relationship }}</label>
                  <input 
                    v-model="newReference.relationship" 
                    type="text" 
                    :placeholder="t.references.relationshipPlaceholder"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                </div>
              </div>
              
              <!-- Validation error messages -->
              <div v-if="validationErrors.referencePhone" class="text-sm text-red-600">{{ validationErrors.referencePhone }}</div>
              <div v-if="validationErrors.referenceCountryCode" class="text-sm text-red-600">{{ validationErrors.referenceCountryCode }}</div>
              
              <div class="flex gap-4 pb-6 border-b border-gray-200">
                <button 
                  @click="saveReference" 
                  type="button"
                  class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-all duration-300"
                >
                  ADD
                </button>
                <button 
                  @click="cancelReference" 
                  type="button"
                  class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-300"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>

          <!-- Others Step -->
          <div v-if="currentStep === 7" class="space-y-8">
            <!-- List of Skills Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">List of Skills</h3>
              <div class="border-t border-gray-200 mb-4"></div>
              
              <!-- Existing Skills -->
              <div class="space-y-2 mb-4">
                <div v-if="formData.others.skills.length === 0" class="text-gray-500 italic">
                  {{ t.others.noSkills }}
                </div>
                <div v-for="(skill, index) in formData.others.skills" :key="index" class="flex items-center justify-between text-gray-800">
                  <span>{{ skill }}</span>
                  <button 
                    @click="removeSkill(index)" 
                    type="button"
                    class="text-red-500 hover:text-red-700 transition-colors ml-4"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </div>
              </div>
              
              <!-- ADD MORE Button (only shown when form is not visible) -->
              <button 
                v-if="!showSkillForm"
                @click="addSkill" 
                type="button"
                class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-opacity"
              >
                ADD MORE
              </button>
              
              <!-- Skill Form (appears when ADD MORE is clicked) -->
              <div v-if="showSkillForm" class="mt-4 space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.others.skill }}</label>
                  <input 
                    v-model="newSkill" 
                    type="text" 
                    :placeholder="t.others.skillPlaceholder"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                </div>
                <div class="flex gap-4 pb-6 border-b border-gray-200">
                  <button 
                    @click="saveSkill" 
                    type="button"
                    class="px-6 py-2 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-opacity"
                  >
                    ADD
                  </button>
                  <button 
                    @click="cancelSkill" 
                    type="button"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-300"
                  >
                    Cancel
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Separator -->
            <div class="border-t border-gray-200"></div>
            
            <!-- List of Certifications Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">List of Certifications</h3>
              <div class="border-t border-gray-200 mb-4"></div>
              
              <!-- Existing Certifications -->
              <div class="space-y-2 mb-4">
                <div v-if="formData.others.certifications.length === 0" class="text-gray-500 italic">
                  {{ t.others.noCertifications }}
                </div>
                <div v-for="(cert, index) in formData.others.certifications" :key="index" class="flex items-center justify-between text-gray-800">
                  <span>{{ cert.year }} - {{ cert.title }}</span>
                  <button 
                    @click="removeCertification(index)" 
                    type="button"
                    class="text-red-500 hover:text-red-700 transition-colors ml-4"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </div>
              </div>
              
              <!-- ADD MORE Button (only shown when form is not visible) -->
              <button 
                v-if="!showCertificationForm"
                @click="addCertification" 
                type="button"
                class="px-6 py-3 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-opacity"
              >
                ADD MORE
              </button>
              
              <!-- Certification Form (appears when ADD MORE is clicked) -->
              <div v-if="showCertificationForm" class="mt-4 space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.others.certification }}</label>
                  <input 
                    v-model="newCertification.title" 
                    type="text" 
                    :placeholder="t.others.certificationPlaceholder"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.others.yearIssued }}</label>
                  <select 
                    v-model="newCertification.year" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                    <option value="" disabled>{{ t.others.selectCertificationYear }}</option>
                    <option v-for="year in availableEducationYears" :key="year" :value="year">{{ year }}</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.others.issuer }}</label>
                  <input 
                    v-model="newCertification.issuer" 
                    type="text" 
                    :placeholder="t.others.issuerPlaceholder"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">{{ t.others.certificate }}</label>
                  <div class="flex items-center gap-3">
                    <input 
                      ref="certificateFileInput"
                      type="file" 
                      accept=".pdf,.jpg,.jpeg,.png"
                      @change="handleCertificationFileUpload"
                      class="hidden"
                    >
                    <button 
                      @click="$refs.certificateFileInput.click()"
                      type="button"
                      class="px-4 py-2 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-opacity"
                    >
                      {{ newCertification.certificate ? t.common.changeFile : t.common.upload }}
                    </button>
                    <span v-if="newCertification.certificate" class="text-sm text-gray-600">
                      {{ newCertification.certificate.name }}
                    </span>
                  </div>
                </div>
                <div class="flex gap-4 pb-6 border-b border-gray-200 mt-10">
                  <button 
                    @click="saveCertification" 
                    type="button"
                    class="px-6 py-2 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-opacity"
                  >
                    ADD
                  </button>
                  <button 
                    @click="cancelCertification" 
                    type="button"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-300"
                  >
                    Cancel
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Separator -->
            <div class="border-t border-gray-200"></div>
            
            <!-- Resume Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.others.resume }}</h3>
              <div class="border-t border-gray-200 mb-4"></div>
              <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  {{ t.others.uploadResume }}
                </label>
                <div class="flex items-center gap-3">
                  <input 
                    ref="resumeFileInput"
                    type="file" 
                    accept=".pdf,.doc,.docx"
                    @change="(e) => { resumeFile = e.target.files[0] }"
                    class="hidden"
                  >
                  <button 
                    @click="$refs.resumeFileInput.click()"
                    type="button"
                    class="px-4 py-2 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white rounded-lg hover:opacity-90 transition-opacity"
                  >
                    {{ resumeFile ? t.common.changeFile : t.common.upload }}
                  </button>
                  <span v-if="resumeFile" class="text-sm text-gray-600">
                    {{ resumeFile.name }}
                  </span>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                  {{ t.others.acceptedFormats }}
                </p>
              </div>
            </div>

            <!-- Separator -->
            <div class="border-t border-gray-200"></div>

            <!-- Additional Comments Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.others.additionalComments }}</h3>
              <div class="border-t border-gray-200 mb-4"></div>
              <textarea 
                v-model="formData.others.comments" 
                rows="4"
                :placeholder="t.others.commentsPlaceholder"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
              ></textarea>
            </div>
          </div>

          <!-- Summary Step -->
          <div v-if="currentStep === 8" class="space-y-8">
            <!-- Header -->
            <div class="mb-8">
              <h1 class="text-3xl font-bold text-gray-900">{{ formData.personal.fullName }}</h1>
            </div>

            <!-- Personal Information Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.summary.personalInformation }}</h3>
              <div class="border-t border-[#7ACAB3] mb-4"></div>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left: table-like labels/values -->
                <div class="grid grid-cols-2 gap-y-3">
                  <div class="font-medium text-gray-800">{{ t.summary.nationality }}</div>
                  <div>{{ formData.personal.nationality }}</div>
                  <div class="font-medium text-gray-800">{{ t.summary.dateOfBirth }}</div>
                  <div>{{ formData.personal.dob }}</div>
                  <div class="font-medium text-gray-800">{{ t.summary.placeOfBirth }}</div>
                  <div>{{ formData.personal.pob }}</div>
                  <div class="font-medium text-gray-800">{{ t.summary.maritalStatus }}</div>
                  <div>{{ formData.personal.maritalStatus }}</div>
                </div>
                
                <!-- Middle: stacked label then multiline value -->
                <div>
                  <div class="mb-4">
                    <div class="font-medium text-gray-800">{{ t.summary.idAddress }}</div>
                    <div class="text-sm leading-snug">{{ formData.personal.idaddress }}</div>
                  </div>
                  <div>
                    <div class="font-medium text-gray-800">{{ t.summary.currentAddress }}</div>
                    <div class="text-sm leading-snug">{{ formData.personal.currentaddress }}</div>
                  </div>
                </div>
                
                <!-- Right: table-like labels/values -->
                <div class="grid grid-cols-2 gap-y-3">
                  <div class="font-medium text-gray-800">{{ t.summary.phoneNumber }}</div>
                  <div>{{ formData.personal.countryCode }} {{ formData.personal.phone }}</div>
                  <div class="font-medium text-gray-800">{{ t.summary.emailAddress }}</div>
                  <div>{{ formData.personal.email }}</div>
                  <div class="font-medium text-gray-800">{{ t.summary.linkedin }}</div>
                  <div>{{ formData.personal.linkedin || '—' }}</div>
                </div>
              </div>
            </div>

            <!-- Education Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.summary.education }}</h3>
              <div class="border-t border-[#7ACAB3] mb-4"></div>
              <div class="space-y-2">
                <div v-for="(edu, index) in formData.education.history" :key="index" class="text-gray-900">
                  <span class="font-bold">{{ edu.startDate }}-{{ edu.endDate }}</span> - {{ edu.schoolName }}
                </div>
                <div v-if="formData.education.history.length === 0" class="text-gray-500 italic">
                  {{ t.summary.noEducationEntries }}
                </div>
              </div>
            </div>

            <!-- Language Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.summary.language }}</h3>
              <div class="border-t border-[#7ACAB3] mb-4"></div>
              <div class="space-y-2">
                <div v-for="language in formData.languages" :key="language.name" class="text-gray-900">
                  <span class="font-medium">{{ language.name }}:</span> {{ getTranslatedProficiency(language.proficiency) }}
                </div>
                <div v-if="formData.languages.length === 0" class="text-gray-500 italic">
                  {{ t.summary.noLanguagesAdded }}
                </div>
              </div>
            </div>

            <!-- Experience Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.summary.experience }}</h3>
              <div class="border-t border-[#7ACAB3] mb-4"></div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <div v-for="(exp, index) in formData.experience.history" :key="index" class="text-gray-900">
                    <span class="font-bold">{{ exp.startDate }}-{{ exp.endDate }}</span> - {{ exp.position }} at {{ exp.companyName }}
                  </div>
                  <div v-if="formData.experience.history.length === 0" class="text-gray-500 italic">
                    {{ t.summary.noExperienceEntries }}
                  </div>
                </div>
                <div class="space-y-2">
                  <div><span class="font-medium">{{ t.summary.currentSalary }}</span> {{ formData.experience.currentSalary || '—' }}</div>
                  <div><span class="font-medium">{{ t.summary.reasonsForLeaving }}</span> {{ formData.experience.reasonsForLeaving || '—' }}</div>
                </div>
              </div>
            </div>

            <!-- Achievements Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.summary.achievements }}</h3>
              <div class="border-t border-[#7ACAB3] mb-4"></div>
              <div class="space-y-2">
                <div v-for="(achievement, index) in formData.achievements.history" :key="index" class="text-gray-900">
                  <span class="font-bold">{{ achievement.year }}</span> - {{ achievement.title }}
                </div>
                <div v-if="formData.achievements.history.length === 0" class="text-gray-500 italic">
                  {{ t.summary.noAchievementsAdded }}
                </div>
              </div>
            </div>

            <!-- References Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.summary.references }}</h3>
              <div class="border-t border-[#7ACAB3] mb-4"></div>
              <div class="space-y-2">
                <div v-for="(ref, index) in formData.references.history" :key="index" class="text-gray-900">
                  <span class="font-medium">{{ ref.name }}:</span> {{ ref.relationship }} at {{ ref.organization }}
                </div>
                <div v-if="formData.references.history.length === 0" class="text-gray-500 italic">
                  {{ t.summary.noReferencesAdded }}
                </div>
              </div>
            </div>

            <!-- List of Skills Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.summary.listOfSkills }}</h3>
              <div class="border-t border-[#7ACAB3] mb-4"></div>
              <div class="space-y-2">
                <div v-for="(skill, index) in formData.others.skills" :key="index" class="text-gray-900">
                  {{ skill }}
                </div>
                <div v-if="formData.others.skills.length === 0" class="text-gray-500 italic">
                  {{ t.summary.noSkillsAdded }}
                </div>
              </div>
            </div>
            
            <!-- List of Certifications Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.summary.listOfCertifications }}</h3>
              <div class="border-t border-[#7ACAB3] mb-4"></div>
              <div class="space-y-2">
                <div v-for="(cert, index) in formData.others.certifications" :key="index" class="text-gray-900">
                  <span class="font-bold">{{ cert.year }}</span> - {{ cert.title }}
                </div>
                <div v-if="formData.others.certifications.length === 0" class="text-gray-500 italic">
                  {{ t.summary.noCertificationsAdded }}
                </div>
              </div>
            </div>
            
            <!-- Others Section -->
            <div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.summary.others }}</h3>
              <div class="border-t border-[#7ACAB3] mb-4"></div>
              <div class="space-y-4">
                <div class="text-gray-900">
                  <span class="font-medium">{{ t.summary.additionalComments }}</span> {{ formData.others.comments || '—' }}
                </div>
                
                <div class="text-gray-900">
                  <span class="font-medium">{{ t.summary.resume }}</span> {{ resumeFile ? resumeFile.name : t.summary.notUploaded }}
                </div>
                
                <!-- Privacy Policy Agreement -->
                <div class="flex items-start gap-3 mt-8">
                  <input 
                    v-model="privacyPolicyAgreed" 
                    type="checkbox" 
                    id="privacy-policy"
                    @change="clearValidationErrors"
                    :class="[
                      'mt-1 w-4 h-4 text-gray-500 border-gray-400 rounded focus:ring-gray-500 focus:ring-2',
                      validationErrors.privacyPolicy ? 'border-red-500' : ''
                    ]"
                  >
                  <label for="privacy-policy" class="text-sm text-gray-600 leading-relaxed">
                    {{ t.summary.privacyAgreement }} 
                    <a :href="getLocalizedUrl('/privacy-policy')" target="_blank" class="text-gray-700 underline hover:text-gray-900 transition-colors">
                      {{ t.summary.privacyPolicy }}
                    </a> 
                    {{ t.summary.pages }}
                  </label>
                </div>
                <p v-if="validationErrors.privacyPolicy" class="mt-2 text-sm text-red-600">{{ validationErrors.privacyPolicy }}</p>
              </div>
            </div>
          </div>

          <!-- Completion Step -->
          <div v-if="currentStep === 9" class="text-center py-16">
            
            <!-- Main Content -->
            <h1 class="text-5xl font-bold text-gray-900 mb-6" v-html="t.completion.applicationSubmitted">
            </h1>
            <p class="text-xl text-gray-600 mb-12">{{ t.completion.contactMessage }}</p>
            
            <!-- HOME Button -->
            <a 
              href="/" 
              class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#A0AFF6] to-[#7ACAB3] text-white text-lg font-semibold rounded-lg hover:opacity-90 transition-opacity"
            >
              {{ t.common.home }}
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>

          <!-- Navigation Buttons -->
          <div v-if="currentStep < 9" class="flex justify-between items-center mt-12 pt-8 border-t border-gray-200">
            <button 
              @click="prevStep" 
              v-if="currentStep > 1" 
              type="button" 
              class="flex items-center justify-center w-12 h-12 bg-gray-200 rounded-full hover:bg-gray-300 transition-colors"
            >
              <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
            </button>
            <div v-else></div>
            
            <button 
              @click="nextStep" 
              v-if="currentStep < steps.length" 
              type="button" 
              class="flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
            >
              {{ t.common.next }}: {{ steps[currentStep].name }}
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </button>
            
            <button 
              v-if="currentStep === 8" 
              @click="submitForm"
              type="button" 
              class="flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
            >
              Submit
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>

<style lang="postcss">
  .form-label-aligned {
    @apply text-sm font-medium text-gray-700 md:text-right;
  }
  .form-input-custom {
    @apply w-full px-4 py-3 sm:px-8 sm:py-5 focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-gray-800 text-base sm:text-lg;
    width: 100%;
    max-width: 600px;
    height: 60px;
    border: 1px solid #000000; /* Hitam */
    border-radius: 9px;
  }

  /* Hide number input spinners across browsers for this form */
  input[type='number']::-webkit-outer-spin-button,
  input[type='number']::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  input[type='number'] {
    -moz-appearance: textfield;
  }
</style>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, reactive, computed, onMounted } from 'vue';
import { useLocalization } from '@/composables/useLocalization'

defineOptions({
  layout: AppLayout,
})

const { currentLocale, getLocalizedUrl } = useLocalization()

// Translations object
const translations = {
  en: {
    sections: {
      careerDevelopment: "Career Development"
    },
    steps: {
      step: "Step",
      of: "of",
      biography: "Biography",
      education: "Education",
      language: "Language",
      experience: "Experience",
      achievements: "Achievements",
      references: "References",
      others: "Others",
      summary: "Summary"
    },
    common: {
      requiredField: "*Required field",
      cancel: "Cancel",
      confirm: "Confirm",
      add: "Add",
      addMore: "ADD MORE",
      save: "Save",
      upload: "Upload",
      changeFile: "Change File",
      home: "HOME",
      next: "Next",
      previous: "Previous"
    },
    biography: {
      fullName: "Full Name*",
      fullNamePlaceholder: "Enter your full legal name",
      nationality: "Nationality*",
      nationalityPlaceholder: "Please specify your nationality",
      dob: "Date of Birth*",
      dobPlaceholder: "Select your date of birth",
      year: "Year",
      month: "Month",
      day: "Day",
      pob: "Place of Birth*",
      pobPlaceholder: "City and country of birth",
      maritalStatus: "Marital Status*",
      maritalStatusPlaceholder: "Select status",
      idAddress: "ID Address*",
      idAddressPlaceholder: "As stated on your ID card",
      currentAddress: "Current Address*",
      currentAddressPlaceholder: "Where you currently reside",
      sameAsIdAddress: "Same as ID Address",
      phoneNumber: "Phone Number*",
      phonePlaceholder: "Include country code (e.g. +62)",
      countryCode: "Country Code",
      emailAddress: "Email Address*",
      emailPlaceholder: "Your active email for correspondence",
      linkedin: "LinkedIn",
      linkedinPlaceholder: "Paste your LinkedIn profile URL"
    },
    education: {
      lastEducation: "Last Education*",
      educationHistory: "Education History*",
      schoolName: "School Name*",
      schoolNamePlaceholder: "Enter the name of your school or university",
      faculty: "Faculty*",
      facultyPlaceholder: "Enter your faculty or department name",
      major: "Major*",
      majorPlaceholder: "Enter your field of study or major",
      from: "From*",
      to: "To*",
      selectStartYear: "Select start year",
      selectEndYear: "Select end year",
      certificate: "Certificate",
      saveEducation: "Save Education",
      noEducationEntries: "No education entries yet"
    },
    language: {
      proficient: "Proficient in speaking, reading, listening, and writing*",
      enterLanguageName: "Enter Language Name",
      enterLanguagePlaceholder: "Enter language name...",
      moreThanOneApplicable: "More than 1 is applicable",
      selectProficiencyLevel: "Select Proficiency Level for",
      noLanguagesAdded: "No languages added",
      proficiencyLevels: {
        Native: "Native",
        Fluent: "Fluent",
        Proficient: "Proficient"
      }
    },
    experience: {
      experienceHistory: "Experience History",
      companyName: "Company Name*",
      companyNamePlaceholder: "Enter the company name",
      position: "Position*",
      positionPlaceholder: "Enter your job position or title",
      selectStartYear: "Select start year",
      selectEndYear: "Select end year",
      present: "Present",
      jobDescription: "Job Description*",
      jobDescriptionPlaceholder: "Describe your main responsibilities and achievements in this role",
      currentMonthlySalary: "Current Monthly Salary*",
      currency: "Currency",
      salaryPlaceholder: "Enter amount (e.g. 8,000,000)",
      reasonsForLeaving: "Reasons For Leaving*",
      reasonsForLeavingPlaceholder: "Tell us why you left or want to leave your current/previous position",
      noExperienceEntries: "No experience entries yet"
    },
    achievements: {
      listOfAchievements: "List of Achievements/Awards",
      achievementAward: "Achievement/Award*",
      achievementPlaceholder: "Enter the achievement or award title",
      description: "Description*",
      descriptionPlaceholder: "Describe the achievement or award",
      yearObtained: "Year Obtained*",
      selectAchievementYear: "Select achievement year",
      noAchievements: "No achievements yet"
    },
    references: {
      listOfReferences: "List of References",
      referenceName: "Reference Name*",
      referenceNamePlaceholder: "Enter the reference person's full name",
      organization: "Organization*",
      organizationPlaceholder: "Enter the organization name",
      phoneNumber: "Phone Number*",
      code: "Code",
      phonePlaceholder: "Enter phone number",
      relationship: "Relationship*",
      relationshipPlaceholder: "Enter your relationship with this person",
      noReferences: "No references yet"
    },
    others: {
      listOfSkills: "List of Skills",
      skill: "Skill*",
      skillPlaceholder: "Enter a skill or competency",
      listOfCertifications: "List of Certifications",
      certification: "Certification*",
      certificationPlaceholder: "Enter the certification title",
      yearIssued: "Year Issued*",
      selectCertificationYear: "Select certification year",
      issuer: "Issuer",
      issuerPlaceholder: "Enter the certification issuer",
      certificate: "Certificate*",
      resume: "Resume",
      uploadResume: "Upload Resume (Optional)",
      acceptedFormats: "Accepted formats: PDF, DOC, DOCX (Max 5MB)",
      additionalComments: "Additional Comments",
      commentsPlaceholder: "Share anything else you'd like us to know (e.g., career goals, availability, or personal motivation)",
      noSkills: "No skills yet",
      noCertifications: "No certifications yet"
    },
    summary: {
      personalInformation: "Personal Information",
      nationality: "Nationality",
      dateOfBirth: "Date of Birth",
      placeOfBirth: "Place of Birth",
      maritalStatus: "Marital Status",
      idAddress: "ID Address",
      currentAddress: "Current Address",
      phoneNumber: "Phone Number",
      emailAddress: "Email Address",
      linkedin: "LinkedIn",
      education: "Education",
      language: "Language",
      experience: "Experience",
      currentSalary: "Current Salary:",
      reasonsForLeaving: "Reasons for Leaving:",
      achievements: "Achievements",
      references: "References",
      listOfSkills: "List of Skills",
      listOfCertifications: "List of Certifications",
      others: "Others",
      additionalComments: "Additional Comments:",
      resume: "Resume:",
      notUploaded: "Not uploaded",
      privacyAgreement: "I agree with submitting the form, after reading the",
      privacyPolicy: "Privacy Policy",
      pages: "pages.",
      noEducationEntries: "No education entries",
      noLanguagesAdded: "No languages added",
      noExperienceEntries: "No experience entries",
      noAchievementsAdded: "No achievements added",
      noReferencesAdded: "No references added",
      noSkillsAdded: "No skills added",
      noCertificationsAdded: "No certifications added"
    },
    completion: {
      applicationSubmitted: "Application<br>Submitted",
      contactMessage: "We'll contact you if you are applicable for interview."
    },
    errors: {
      fullNameRequired: "Full Name is required",
      nationalityRequired: "Nationality is required",
      dobRequired: "Date of Birth is required",
      dobMinimumAge: "You must be at least 18 years old to apply. Current age:",
      dobFuture: "Date of birth cannot be in the future",
      pobRequired: "Place of Birth is required",
      maritalStatusRequired: "Marital Status is required",
      idAddressRequired: "ID Address is required",
      currentAddressRequired: "Current Address is required",
      phoneRequired: "Phone Number is required",
      countryCodeRequired: "Country Code is required",
      emailRequired: "Email Address is required",
      emailInvalid: "Please enter a valid email address (e.g. yourname@email.com)",
      educationLevelRequired: "Please select your education level",
      educationHistoryRequired: "Please add at least one education entry",
      languagesRequired: "Please select at least one language",
      experienceHistoryRequired: "Please add at least one experience entry",
      currentSalaryRequired: "Current Monthly Salary is required",
      currencyRequired: "Currency is required",
      reasonsForLeavingRequired: "Reasons For Leaving is required",
      achievementsRequired: "Please add at least one achievement",
      referencesRequired: "Please add at least one reference",
      privacyPolicyRequired: "You must agree to the privacy policy",
      fillRequiredFields: "Please fill in all required fields"
    }
  },
  id: {
    sections: {
      careerDevelopment: "Pengembangan Karier"
    },
    steps: {
      step: "Step",
      of: "of",
      biography: "Biodata",
      education: "Pendidikan",
      language: "Bahasa",
      experience: "Pengalaman",
      achievements: "Pencapaian",
      references: "Referensi",
      others: "Lainnya",
      summary: "Ringkasan"
    },
    common: {
      requiredField: "*Wajib Diisi",
      cancel: "Cancel",
      confirm: "Confirm",
      add: "Tambahkan",
      addMore: "TAMBAHKAN LAGI",
      save: "Save",
      upload: "Unggah",
      changeFile: "Change File",
      home: "BERANDA",
      next: "Next",
      previous: "Previous"
    },
    biography: {
      fullName: "Nama Lengkap*",
      fullNamePlaceholder: "Masukkan nama lengkap sesuai identitas resmi",
      nationality: "Kewarganegaraan*",
      nationalityPlaceholder: "Tuliskan kewarganegaraan Anda",
      dob: "Tanggal Lahir*",
      dobPlaceholder: "Pilih tanggal lahir (HH/BB/TTTT)",
      year: "Tahun",
      month: "Bulan",
      day: "Hari",
      pob: "Tempat Lahir*",
      pobPlaceholder: "Kota dan negara tempat lahir",
      maritalStatus: "Status Pernikahan*",
      maritalStatusPlaceholder: "Pilih status",
      idAddress: "Alamat KTP*",
      idAddressPlaceholder: "Sesuai dengan yang tertera pada KTP",
      currentAddress: "Alamat Saat Ini*",
      currentAddressPlaceholder: "Alamat tempat tinggal Anda saat ini",
      sameAsIdAddress: "Sama dengan alamat KTP",
      phoneNumber: "Nomor Telepon*",
      phonePlaceholder: "Cantumkan kode negara (contoh: +62)",
      countryCode: "Kode Negara",
      emailAddress: "Alamat Email*",
      emailPlaceholder: "Gunakan email aktif untuk korespondensi",
      linkedin: "LinkedIn",
      linkedinPlaceholder: "Tempelkan tautan profil LinkedIn Anda"
    },
    education: {
      lastEducation: "Pendidikan Terakhir*",
      educationHistory: "Riwayat Pendidikan*",
      schoolName: "Nama Sekolah/Universitas*",
      schoolNamePlaceholder: "Masukkan nama sekolah atau universitas Anda",
      faculty: "Fakultas*",
      facultyPlaceholder: "Masukkan nama fakultas atau jurusan Anda",
      major: "Jurusan*",
      majorPlaceholder: "Masukkan bidang studi atau jurusan Anda",
      from: "Dari*",
      to: "Sampai*",
      selectStartYear: "Pilih tahun mulai",
      selectEndYear: "Pilih tahun selesai",
      certificate: "Sertifikat",
      saveEducation: "Simpan Pendidikan",
      noEducationEntries: "Belum ada riwayat pendidikan"
    },
    language: {
      proficient: "Kemampuan berbicara, membaca, mendengar, dan menulis*",
      enterLanguageName: "Masukkan Nama Bahasa",
      enterLanguagePlaceholder: "Masukkan bahasa...",
      moreThanOneApplicable: "Dapat dipilih lebih dari 1",
      selectProficiencyLevel: "Pilih Tingkat Kemahiran untuk",
      noLanguagesAdded: "Belum ada bahasa yang ditambahkan",
      proficiencyLevels: {
        Native: "Bahasa Ibu",
        Fluent: "Mahir",
        Proficient: "Lancar"
      }
    },
    experience: {
      experienceHistory: "Riwayat Pengalaman Kerja",
      companyName: "Nama Perusahaan*",
      companyNamePlaceholder: "Masukkan nama perusahaan",
      position: "Jabatan*",
      positionPlaceholder: "Masukkan jabatan atau posisi Anda",
      from: "Dari*",
      to: "Sampai*",
      selectStartYear: "Pilih tahun mulai",
      selectEndYear: "Pilih tahun selesai",
      present: "Saat Ini",
      jobDescription: "Deskripsi Pekerjaan*",
      jobDescriptionPlaceholder: "Jelaskan tanggung jawab utama dan pencapaian Anda di posisi ini",
      currentMonthlySalary: "Gaji Per Bulan Saat Ini*",
      currency: "Mata Uang",
      salaryPlaceholder: "Masukkan jumlah (contoh: 8.000.000)",
      reasonsForLeaving: "Alasan Meninggalkan Pekerjaan Sebelumnya*",
      reasonsForLeavingPlaceholder: "Jelaskan secara singkat alasan Anda mencari kesempatan baru",
      noExperienceEntries: "Belum ada riwayat pengalaman kerja"
    },
    achievements: {
      listOfAchievements: "Daftar Pencapaian/Penghargaan",
      achievementAward: "Pencapaian/Penghargaan*",
      achievementPlaceholder: "Masukkan judul pencapaian atau penghargaan",
      description: "Deskripsi*",
      descriptionPlaceholder: "Jelaskan pencapaian atau penghargaan",
      yearObtained: "Tahun Diperoleh*",
      selectAchievementYear: "Pilih tahun pencapaian",
      noAchievements: "Belum ada pencapaian"
    },
    references: {
      listOfReferences: "Daftar Referensi",
      referenceName: "Nama Referensi*",
      referenceNamePlaceholder: "Masukkan nama lengkap orang yang dijadikan referensi",
      organization: "Organisasi*",
      organizationPlaceholder: "Masukkan nama organisasi",
      phoneNumber: "Nomor Telepon*",
      code: "Kode",
      phonePlaceholder: "Masukkan nomor telepon",
      relationship: "Hubungan*",
      relationshipPlaceholder: "Masukkan hubungan Anda dengan orang ini",
      noReferences: "Belum ada referensi"
    },
    others: {
      listOfSkills: "Daftar Keahlian",
      skill: "Keahlian*",
      skillPlaceholder: "Masukkan keahlian atau kompetensi",
      listOfCertifications: "Daftar Sertifikasi",
      certification: "Sertifikasi*",
      certificationPlaceholder: "Masukkan judul sertifikasi",
      yearIssued: "Tahun Diterbitkan*",
      selectCertificationYear: "Pilih tahun sertifikasi",
      issuer: "Penerbit",
      issuerPlaceholder: "Masukkan penerbit sertifikasi",
      certificate: "Sertifikat*",
      resume: "Resume",
      uploadResume: "Unggah Resume (Opsional)",
      acceptedFormats: "Format yang diterima: PDF, DOC, DOCX (Maks 5MB)",
      additionalComments: "Komentar Tambahan",
      commentsPlaceholder: "Tuliskan hal lain yang ingin Anda bagikan (contoh: tujuan karier, ketersediaan, atau motivasi pribadi)",
      noSkills: "Belum ada keahlian",
      noCertifications: "Belum ada sertifikasi"
    },
    summary: {
      personalInformation: "Informasi Pribadi",
      nationality: "Kewarganegaraan",
      dateOfBirth: "Tanggal Lahir",
      placeOfBirth: "Tempat Lahir",
      maritalStatus: "Status Pernikahan",
      idAddress: "Alamat KTP",
      currentAddress: "Alamat Saat Ini",
      phoneNumber: "Nomor Telepon",
      emailAddress: "Alamat Email",
      linkedin: "LinkedIn",
      education: "Pendidikan",
      language: "Bahasa",
      experience: "Pengalaman",
      currentSalary: "Gaji Saat Ini:",
      reasonsForLeaving: "Alasan Meninggalkan:",
      achievements: "Pencapaian",
      references: "Referensi",
      listOfSkills: "Daftar Keahlian",
      listOfCertifications: "Daftar Sertifikasi",
      others: "Lainnya",
      additionalComments: "Komentar Tambahan:",
      resume: "Resume:",
      notUploaded: "Belum diunggah",
      privacyAgreement: "Saya setuju untuk mengirimkan formulir ini, setelah membaca",
      privacyPolicy: "Kebijakan Privasi",
      pages: "halaman.",
      noEducationEntries: "Belum ada riwayat pendidikan",
      noLanguagesAdded: "Belum ada bahasa yang ditambahkan",
      noExperienceEntries: "Belum ada riwayat pengalaman",
      noAchievementsAdded: "Belum ada pencapaian yang ditambahkan",
      noReferencesAdded: "Belum ada referensi yang ditambahkan",
      noSkillsAdded: "Belum ada keahlian yang ditambahkan",
      noCertificationsAdded: "Belum ada sertifikasi yang ditambahkan"
    },
    completion: {
      applicationSubmitted: "Lamaran<br>Telah Dikirim",
      contactMessage: "Kami akan menghubungi Anda jika Anda memenuhi syarat untuk wawancara."
    },
    errors: {
      fullNameRequired: "Nama lengkap wajib diisi",
      nationalityRequired: "Kewarganegaraan wajib diisi",
      dobRequired: "Tanggal lahir wajib diisi",
      dobMinimumAge: "Anda harus berusia minimal 18 tahun untuk melamar. Usia saat ini:",
      dobFuture: "Tanggal lahir tidak boleh di masa depan",
      pobRequired: "Tempat lahir wajib diisi",
      maritalStatusRequired: "Status pernikahan wajib diisi",
      idAddressRequired: "Alamat KTP wajib diisi",
      currentAddressRequired: "Alamat saat ini wajib diisi",
      phoneRequired: "Nomor telepon wajib diisi",
      countryCodeRequired: "Kode negara wajib diisi",
      emailRequired: "Alamat email wajib diisi",
      emailInvalid: "Silakan masukkan alamat email yang valid (contoh: namaanda@email.com)",
      educationLevelRequired: "Silakan pilih tingkat pendidikan Anda",
      educationHistoryRequired: "Silakan tambahkan minimal satu riwayat pendidikan",
      languagesRequired: "Silakan pilih minimal satu bahasa",
      experienceHistoryRequired: "Silakan tambahkan minimal satu riwayat pengalaman",
      currentSalaryRequired: "Gaji per bulan saat ini wajib diisi",
      currencyRequired: "Mata uang wajib diisi",
      reasonsForLeavingRequired: "Alasan meninggalkan pekerjaan sebelumnya wajib diisi",
      achievementsRequired: "Silakan tambahkan minimal satu pencapaian",
      referencesRequired: "Silakan tambahkan minimal satu referensi",
      privacyPolicyRequired: "Anda harus menyetujui kebijakan privasi",
      fillRequiredFields: "Silakan isi semua field yang wajib diisi"
    }
  }
}

// Get current translations based on locale
const t = computed(() => {
  return translations[currentLocale.value] || translations.en
})

// --- STATE MANAGEMENT ---

const steps = computed(() => [
  { id: 1, name: t.value.steps.biography },
  { id: 2, name: t.value.steps.education },
  { id: 3, name: t.value.steps.language },
  { id: 4, name: t.value.steps.experience },
  { id: 5, name: t.value.steps.achievements },
  { id: 6, name: t.value.steps.references },
  { id: 7, name: t.value.steps.others },
  { id: 8, name: t.value.steps.summary },
]);

const currentStep = ref(1);
const validationErrors = ref({});
const showEducationForm = ref(false);
const showExperienceForm = ref(false);
const showAchievementForm = ref(false);
const showReferenceForm = ref(false);
const showSkillForm = ref(false);
const showCertificationForm = ref(false);
const showProficiencyModal = ref(false);
const selectedLanguage = ref('');
const customLanguage = ref('');
const privacyPolicyAgreed = ref(false);
const showDatePicker = ref(false);
const selectedYear = ref('');
const selectedMonth = ref('');
const selectedDay = ref('');
const newEducation = ref({
  schoolName: '',
  faculty: '',
  major: '',
  startDate: '',
  endDate: '',
  gpa: '',
  description: '',
  isCurrent: false,
  certificate: null,
});
const newExperience = ref({
  companyName: '',
  position: '',
  startDate: '',
  endDate: '',
  jobDesc: '',
});
const newAchievement = ref({
  title: '',
  description: '',
  year: '',
});
const newReference = ref({
  name: '',
  organization: '',
  countryCode: '+62',
  phone: '',
  relationship: '',
});

const newSkill = ref('');
const newCertification = ref({
  title: '',
  year: '',
  issuer: '',
  certificate: null,
  expiryDate: '',
  certificationNumber: '',
  credentialId: '',
  type: 'professional',
  description: '',
  notes: '',
});

// Resume file
const resumeFile = ref(null);
const vacancyId = ref(null);

// Computed properties
const showCustomLanguageInput = computed(() => {
  return selectedLanguage.value === 'Other';
});

const availableYears = computed(() => {
  const currentYear = new Date().getFullYear();
  const maxYear = currentYear - 18; // Maximum year for 18+ age requirement
  const years = [];
  for (let year = maxYear; year >= 1970; year--) {
    years.push(year);
  }
  return years;
});

const availableEducationYears = computed(() => {
  const currentYear = new Date().getFullYear();
  const years = [];
  for (let year = currentYear; year >= 1970; year--) {
    years.push(year);
  }
  return years;
});

const availableExperienceYears = computed(() => {
  const currentYear = new Date().getFullYear();
  const years = [];
  for (let year = currentYear; year >= 1970; year--) {
    years.push(year);
  }
  return years;
});

const maxDateOfBirth = computed(() => {
  const today = new Date();
  const eighteenYearsAgo = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
  return eighteenYearsAgo.toISOString().split('T')[0];
});

// Months array
const months = [
  'January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December'
];

// Available days computed property
const availableDays = computed(() => {
  if (!selectedYear.value || selectedMonth.value === '') return [];
  
  const year = parseInt(selectedYear.value);
  const month = parseInt(selectedMonth.value);
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  
  const days = [];
  for (let day = 1; day <= daysInMonth; day++) {
    days.push(day);
  }
  return days;
});

// Education levels
const educationLevels = ['SMA', 'SMK', 'D3', 'S1', 'S2', 'S3'];

// Languages
const languages = [
  { name: 'Bahasa Indonesia', proficiency: '' },
  { name: 'English', proficiency: '' },
  { name: 'Other', proficiency: '', isCustom: true },
];

// Proficiency levels (keep English values for form submission)
const proficiencyLevels = ['Native', 'Fluent', 'Proficient'];

// Function to get translated proficiency level for display
const getTranslatedProficiency = (proficiency) => {
  if (!proficiency) return '';
  return t.value.language.proficiencyLevels[proficiency] || proficiency;
};

// Form data
const formData = reactive({
  personal: {
    fullName: '',
    nationality: '',
    dob: '',
    pob: '',
    maritalStatus: '',
    idaddress: '',
    currentaddress: '',
    sameAsIdAddress: false,
    countryCode: '',
    phone: '',
    email: '',
    linkedin: '',
  },
  education: {
    level: '',
    schoolName: '',
    faculty: '',
    major: '',
    startDate: '',
    endDate: '',
    history: [],
  },
  languages: [],
  experience: {
    companyName: '',
    position: '',
    startDate: '',
    endDate: '',
    jobDesc: '',
    currentSalary: '',
    currency: '',
    reasonsForLeaving: '',
    history: [],
  },
  achievements: {
    title: '',
    description: '',
    year: '',
    history: [],
  },
  references: {
    name: '',
    organization: '',
    phone: '',
    relationship: '',
    history: [],
  },
  others: {
    skills: [],
    certifications: [],
    comments: '',
  },
});

// Validation functions
const validateBiographyStep = () => {
  const errors = {};
  const personal = formData.personal;
  
  if (!personal.fullName?.trim()) {
    errors.fullName = t.value.errors.fullNameRequired;
  }
  if (!personal.nationality?.trim()) {
    errors.nationality = t.value.errors.nationalityRequired;
  }
  if (!personal.dob?.trim()) {
    errors.dob = t.value.errors.dobRequired;
  } else {
    // Check minimum age requirement (18 years old) based on current date
    const dob = new Date(personal.dob);
    const today = new Date();
    
    // Calculate age more precisely
    let age = today.getFullYear() - dob.getFullYear();
    const monthDiff = today.getMonth() - dob.getMonth();
    
    // Adjust age if birthday hasn't occurred this year
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
      age = age - 1;
    }
    
    if (age < 18) {
      errors.dob = `${t.value.errors.dobMinimumAge} ${age} years`;
    }
    
    // Additional check: ensure the date is not in the future
    if (dob > today) {
      errors.dob = t.value.errors.dobFuture;
    }
  }
  if (!personal.pob?.trim()) {
    errors.pob = t.value.errors.pobRequired;
  }
  if (!personal.maritalStatus?.trim()) {
    errors.maritalStatus = t.value.errors.maritalStatusRequired;
  }
  if (!personal.idaddress?.trim()) {
    errors.idaddress = t.value.errors.idAddressRequired;
  }
  if (!personal.currentaddress?.trim()) {
    errors.currentaddress = t.value.errors.currentAddressRequired;
  }
  if (!String(personal.phone ?? '').trim()) {
    errors.phone = t.value.errors.phoneRequired;
  }
  if (!personal.countryCode?.trim()) {
    errors.countryCode = t.value.errors.countryCodeRequired;
  }
  if (!personal.email?.trim()) {
    errors.email = t.value.errors.emailRequired;
  } else {
    // Enhanced email format validation
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(personal.email)) {
      errors.email = t.value.errors.emailInvalid;
    }
  }
  
  return errors;
};

const validateEducationStep = () => {
  const errors = {};
  
  // Check if education level is selected
  if (!formData.education.level?.trim()) {
    errors.educationLevel = t.value.errors.educationLevelRequired;
  }
  
  // Check if at least one education entry exists
  if (!formData.education.history || formData.education.history.length === 0) {
    errors.educationHistory = t.value.errors.educationHistoryRequired;
  }
  
  return errors;
};

const validateLanguageStep = () => {
  const errors = {};
  
  // Check if at least one language is selected
  if (!formData.languages || formData.languages.length === 0) {
    errors.languages = t.value.errors.languagesRequired;
  }
  
  return errors;
};

const validateExperienceStep = () => {
  const errors = {};
  
  // Check if current salary is provided
  if (!formData.experience.currentSalary?.trim()) {
    errors.currentSalary = t.value.errors.currentSalaryRequired;
  }
  if (!formData.experience.currency?.trim()) {
    errors.currency = t.value.errors.currencyRequired;
  }
  
  // Check if reasons for leaving is provided
  if (!formData.experience.reasonsForLeaving?.trim()) {
    errors.reasonsForLeaving = t.value.errors.reasonsForLeavingRequired;
  }
  
  return errors;
};

const validateAchievementsStep = () => {
  const errors = {};
  
  // Achievements are optional, but if user tries to add one, validate it
  if (showAchievementForm.value) {
    if (!newAchievement.value.title?.trim()) {
      errors.achievementTitle = 'Achievement title is required';
    }
    if (!newAchievement.value.description?.trim()) {
      errors.achievementDescription = 'Achievement description is required';
    }
    if (!newAchievement.value.year?.trim()) {
      errors.achievementYear = 'Achievement year is required';
    }
  }
  
  return errors;
};

const validateReferencesStep = () => {
  const errors = {};
  
  // References are optional, but if user tries to add one, validate it
  if (showReferenceForm.value) {
    if (!newReference.value.name?.trim()) {
      errors.referenceName = 'Reference name is required';
    }
    if (!newReference.value.organization?.trim()) {
      errors.referenceOrganization = 'Reference organization is required';
    }
    if (!newReference.value.phone?.trim()) {
      errors.referencePhone = 'Reference phone is required';
    }
    if (!newReference.value.countryCode?.trim()) {
      errors.referenceCountryCode = 'Reference country code is required';
    }
    if (!newReference.value.relationship?.trim()) {
      errors.referenceRelationship = 'Reference relationship is required';
    }
  }
  
  return errors;
};

const validateOthersStep = () => {
  const errors = {};
  
  // Skills are optional, but if user tries to add one, validate it
  if (showSkillForm.value && !newSkill.value?.trim()) {
    errors.skill = 'Skill name is required';
  }
  
  // Certifications are optional, but if user tries to add one, validate it
  if (showCertificationForm.value) {
    if (!newCertification.value.title?.trim()) {
      errors.certificationTitle = 'Certification title is required';
    }
    if (!newCertification.value.year?.trim()) {
      errors.certificationYear = 'Certification year is required';
    }
  }
  
  return errors;
};

const validateSummaryStep = () => {
  const errors = {};
  
  // Check if privacy policy is agreed
  if (!privacyPolicyAgreed.value) {
    errors.privacyPolicy = t.value.errors.privacyPolicyRequired;
  }
  
  return errors;
};

const validateCurrentStep = () => {
  switch (currentStep.value) {
    case 1:
      return validateBiographyStep();
    case 2:
      return validateEducationStep();
    case 3:
      return validateLanguageStep();
    case 4:
      return validateExperienceStep();
    case 5:
      return validateAchievementsStep();
    case 6:
      return validateReferencesStep();
    case 7:
      return validateOthersStep();
    case 8:
      return validateSummaryStep();
    default:
      return {};
  }
};

const clearValidationErrors = () => {
  validationErrors.value = {};
};

// Phone input validation functions
const preventZeroStart = (event) => {
  // Prevent typing '0' if the field is empty or if '0' would be the first character
  if (event.key === '0' && formData.personal.phone === '') {
    event.preventDefault();
  }
};

const handlePhoneInput = (event) => {
  let value = event.target.value;
  
  // Remove any leading zeros
  if (value.startsWith('0')) {
    value = value.substring(1);
    formData.personal.phone = value;
  }
  
  // Clear validation errors
  clearValidationErrors();
};

const handleEmailInput = (event) => {
  const value = event.target.value;
  
  // Real-time email format validation from first character typed
  const trimmed = value.trim();
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

  // If empty, clear error; otherwise validate immediately
  if (!trimmed) {
    delete validationErrors.value.email;
    return;
  }

  if (!emailRegex.test(trimmed)) {
    validationErrors.value.email = 'Please enter a valid email address (e.g. yourname@email.com)';
  } else {
    delete validationErrors.value.email;
  }
};

// Salary input validation functions
const preventNonNumeric = (event) => {
  // Allow: backspace, delete, tab, escape, enter, decimal point
  if ([8, 9, 27, 13, 46, 110, 190].indexOf(event.keyCode) !== -1 ||
      // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
      (event.keyCode === 65 && event.ctrlKey === true) ||
      (event.keyCode === 67 && event.ctrlKey === true) ||
      (event.keyCode === 86 && event.ctrlKey === true) ||
      (event.keyCode === 88 && event.ctrlKey === true) ||
      // Allow: home, end, left, right, down, up
      (event.keyCode >= 35 && event.keyCode <= 40)) {
    return;
  }
  // Ensure that it is a number and stop the keypress
  if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105)) {
    event.preventDefault();
  }
};

const handleSalaryInput = (event) => {
  let value = event.target.value;
  
  // Remove all non-numeric characters except commas
  value = value.replace(/[^\d,]/g, '');
  
  // Remove multiple commas and ensure only one comma per thousand
  value = value.replace(/,+/g, ',');
  
  // Format number with commas
  const numericValue = value.replace(/,/g, '');
  if (numericValue) {
    const formattedValue = parseInt(numericValue).toLocaleString();
    formData.experience.currentSalary = formattedValue;
  } else {
    formData.experience.currentSalary = '';
  }
  
  // Clear validation errors
  clearValidationErrors();
};

const handleReferencePhoneInput = (event) => {
  let value = event.target.value;
  
  // Remove any leading zeros
  if (value.startsWith('0')) {
    value = value.substring(1);
    newReference.value.phone = value;
  }
  
  // Clear validation errors
  clearValidationErrors();
};

// Functions
const nextStep = () => {
  const errors = validateCurrentStep();
  
  if (Object.keys(errors).length > 0) {
    validationErrors.value = errors;
    return;
  }
  
  clearValidationErrors();
  
  if (currentStep.value < steps.value.length) {
    currentStep.value++;
    window.scrollTo(0, 0);
  }
};

const prevStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--;
    window.scrollTo(0, 0);
  }
};

const goToStep = (stepNumber) => {
  if (stepNumber >= 1 && stepNumber <= steps.value.length) {
    // If going forward, validate current step first (like nextStep does)
    if (stepNumber > currentStep.value) {
      const errors = validateCurrentStep();
      
      if (Object.keys(errors).length > 0) {
        validationErrors.value = errors;
        return;
      }
      
      clearValidationErrors();
    }
    
    // Allow navigation (forward after validation, or backward without validation)
    currentStep.value = stepNumber;
    window.scrollTo(0, 0);
  }
};

// Language-related functions
const handleLanguageClick = (language) => {
  if (language.isCustom) {
    // Handle "Other" option - skip proficiency modal and show custom input
    selectedLanguage.value = 'Other';
    showProficiencyModal.value = false;
  } else {
    // Handle predefined languages
    const existingIndex = formData.languages.findIndex(lang => lang.name === language.name);
    if (existingIndex > -1) {
      // Remove if already selected
      formData.languages.splice(existingIndex, 1);
    } else {
      // Add and show proficiency modal
      selectedLanguage.value = language.name;
      showProficiencyModal.value = true;
    }
  }
};

const isLanguageSelected = (languageName) => {
  return formData.languages.some(lang => lang.name === languageName);
};

const getLanguageProficiency = (languageName) => {
  const language = formData.languages.find(lang => lang.name === languageName);
  return language ? language.proficiency : '';
};

const selectProficiency = (proficiency) => {
  // Add the language (either custom or predefined)
  formData.languages.push({
    name: selectedLanguage.value,
    proficiency: proficiency
  });
  closeProficiencyModal();
};

const addCustomLanguage = () => {
  if (customLanguage.value.trim()) {
    // Show proficiency modal for custom language
    selectedLanguage.value = customLanguage.value.trim();
    showProficiencyModal.value = true;
  }
};

const closeProficiencyModal = () => {
  showProficiencyModal.value = false;
  selectedLanguage.value = '';
  customLanguage.value = '';
};

const removeCustomLanguage = (languageName) => {
  const index = formData.languages.findIndex(lang => lang.name === languageName);
  if (index > -1) {
    formData.languages.splice(index, 1);
  }
};

const addEducation = () => {
  showEducationForm.value = true;
};

const saveEducation = () => {
  // Validate education form fields
  const errors = {};
  if (!newEducation.value.schoolName?.trim()) {
    errors.schoolName = 'School Name is required';
  }
  if (!newEducation.value.faculty?.trim()) {
    errors.faculty = 'Faculty is required';
  }
  if (!newEducation.value.major?.trim()) {
    errors.major = 'Major is required';
  }
  if (!newEducation.value.startDate || newEducation.value.startDate === '') {
    errors.startDate = 'Start Date is required';
  }
  if (!newEducation.value.endDate || newEducation.value.endDate === '') {
    errors.endDate = 'End Date is required';
  }
  
  if (Object.keys(errors).length > 0) {
    validationErrors.value = errors;
    return;
  }
  
  if (newEducation.value.schoolName && newEducation.value.faculty && newEducation.value.major && newEducation.value.startDate && newEducation.value.endDate) {
    formData.education.history.push({
      level: formData.education.level || 'S1',
      schoolName: newEducation.value.schoolName,
      faculty: newEducation.value.faculty,
      major: newEducation.value.major,
      startDate: newEducation.value.startDate,
      endDate: newEducation.value.endDate,
      graduateYear: newEducation.value.endDate,
      gpa: newEducation.value.gpa || null,
      description: newEducation.value.description || null,
      isCurrent: newEducation.value.isCurrent || false,
      certificate: newEducation.value.certificate,
    });
    
    // Reset form
    newEducation.value = {
      schoolName: '',
      faculty: '',
      major: '',
      startDate: '',
      endDate: '',
      gpa: '',
      description: '',
      isCurrent: false,
      certificate: null,
    };
    showEducationForm.value = false;
    clearValidationErrors();
  } else {
    alert(t.value.errors.fillRequiredFields);
  }
};

const cancelEducation = () => {
  newEducation.value = {
    schoolName: '',
    faculty: '',
    major: '',
    startDate: '',
    endDate: '',
    gpa: '',
    description: '',
    isCurrent: false,
    certificate: null,
  };
  showEducationForm.value = false;
};

const addExperience = () => {
  showExperienceForm.value = true;
};

const saveExperience = () => {
  if (newExperience.value.companyName && newExperience.value.position && newExperience.value.startDate && newExperience.value.endDate && newExperience.value.jobDesc) {
    formData.experience.history.push({
      companyName: newExperience.value.companyName,
      position: newExperience.value.position,
      startDate: newExperience.value.startDate,
      endDate: newExperience.value.endDate,
      jobDesc: newExperience.value.jobDesc,
    });
    
    // Reset form
    newExperience.value = {
      companyName: '',
      position: '',
      startDate: '',
      endDate: '',
      jobDesc: '',
    };
    showExperienceForm.value = false;
  } else {
    alert(t.value.errors.fillRequiredFields);
  }
};

const cancelExperience = () => {
  newExperience.value = {
    companyName: '',
    position: '',
    startDate: '',
    endDate: '',
    jobDesc: '',
  };
  showExperienceForm.value = false;
};

const handleCertificateUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    // Check if file is PDF
    if (file.type === 'application/pdf') {
      newEducation.value.certificate = file;
    } else {
      alert('Please select a PDF file');
      event.target.value = ''; // Clear the input
    }
  }
};

const handleCertificationFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    // Check file type
    const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    if (allowedTypes.includes(file.type)) {
      newCertification.value.certificate = file;
    } else {
      alert('Please select a PDF, JPG, or PNG file');
      event.target.value = ''; // Clear the input
    }
  }
};




const addSkill = () => {
  showSkillForm.value = true;
};

const saveSkill = () => {
  if (newSkill.value && newSkill.value.trim()) {
    formData.others.skills.push(newSkill.value.trim());
    newSkill.value = '';
    showSkillForm.value = false;
  } else {
    alert('Please enter a skill');
  }
};

const cancelSkill = () => {
  newSkill.value = '';
  showSkillForm.value = false;
};

const addCertification = () => {
  showCertificationForm.value = true;
};

const saveCertification = () => {
  if (newCertification.value.title && newCertification.value.year) {
    formData.others.certifications.push({
      title: newCertification.value.title,
      year: newCertification.value.year,
      issuer: newCertification.value.issuer || '',
      certificate: newCertification.value.certificate,
      expiryDate: newCertification.value.expiryDate || '',
      certificationNumber: newCertification.value.certificationNumber || '',
      credentialId: newCertification.value.credentialId || '',
      type: newCertification.value.type || 'professional',
      description: newCertification.value.description || '',
      notes: newCertification.value.notes || '',
    });
    
    // Reset form
    newCertification.value = {
      title: '',
      year: '',
      issuer: '',
      certificate: null,
      expiryDate: '',
      certificationNumber: '',
      credentialId: '',
      type: 'professional',
      description: '',
      notes: '',
    };
    showCertificationForm.value = false;
  } else {
    alert(t.value.errors.fillRequiredFields);
  }
};

const cancelCertification = () => {
  newCertification.value = {
    title: '',
    year: '',
    issuer: '',
    certificate: null,
    expiryDate: '',
    certificationNumber: '',
    credentialId: '',
    type: 'professional',
    description: '',
    notes: '',
  };
  showCertificationForm.value = false;
};

const copyIdAddress = () => {
  formData.personal.currentaddress = formData.personal.idaddress;
};

const toggleSameAsIdAddress = () => {
  if (formData.personal.sameAsIdAddress) {
    formData.personal.currentaddress = formData.personal.idaddress;
  } else {
    formData.personal.currentaddress = '';
  }
};

const removeEducation = (index) => {
  formData.education.history.splice(index, 1);
};

const removeExperience = (index) => {
  formData.experience.history.splice(index, 1);
};

const addAchievement = () => {
  showAchievementForm.value = true;
};

const saveAchievement = () => {
  if (newAchievement.value.title && newAchievement.value.description && newAchievement.value.year) {
    formData.achievements.history.push({
      title: newAchievement.value.title,
      description: newAchievement.value.description,
      year: newAchievement.value.year,
    });
    
    // Reset form
    newAchievement.value = {
      title: '',
      description: '',
      year: '',
    };
    showAchievementForm.value = false;
  } else {
    alert(t.value.errors.fillRequiredFields);
  }
};

const cancelAchievement = () => {
  newAchievement.value = {
    title: '',
    description: '',
    year: '',
  };
  showAchievementForm.value = false;
};

const removeAchievement = (index) => {
  formData.achievements.history.splice(index, 1);
};

const addReference = () => {
  showReferenceForm.value = true;
};

const saveReference = () => {
  if (newReference.value.name && newReference.value.organization && newReference.value.phone && newReference.value.relationship) {
    formData.references.history.push({
      name: newReference.value.name,
      organization: newReference.value.organization,
      phone: newReference.value.phone,
      countryCode: newReference.value.countryCode,
      relationship: newReference.value.relationship,
    });
    
    // Reset form
    newReference.value = {
      name: '',
      organization: '',
      phone: '',
      countryCode: '+62',
      relationship: '',
    };
    showReferenceForm.value = false;
  } else {
    alert(t.value.errors.fillRequiredFields);
  }
};

const cancelReference = () => {
  newReference.value = {
    name: '',
    organization: '',
    phone: '',
    countryCode: '+62',
    relationship: '',
  };
  showReferenceForm.value = false;
};

const removeReference = (index) => {
  formData.references.history.splice(index, 1);
};

const removeSkill = (index) => {
  formData.others.skills.splice(index, 1);
};

const removeCertification = (index) => {
  formData.others.certifications.splice(index, 1);
};

// Date picker methods
const updateDate = () => {
  // This method is called when year or month changes
  // It ensures the selected day is valid for the selected month/year
  if (selectedYear.value && selectedMonth.value !== '' && selectedDay.value) {
    const year = parseInt(selectedYear.value);
    const month = parseInt(selectedMonth.value);
    const day = parseInt(selectedDay.value);
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    
    if (day > daysInMonth) {
      selectedDay.value = daysInMonth;
    }
  }
};

const confirmDate = () => {
  if (selectedYear.value && selectedMonth.value !== '' && selectedDay.value) {
    const year = selectedYear.value;
    const month = String(parseInt(selectedMonth.value) + 1).padStart(2, '0');
    const day = String(selectedDay.value).padStart(2, '0');
    
    const dateString = `${year}-${month}-${day}`;
    
    // Check age validation based on current date
    const dob = new Date(dateString);
    const today = new Date();
    
    // Calculate age more precisely
    let age = today.getFullYear() - dob.getFullYear();
    const monthDiff = today.getMonth() - dob.getMonth();
    
    // Adjust age if birthday hasn't occurred this year
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
      age = age - 1;
    }
    
    // Check if date is in the future
    if (dob > today) {
      alert('Date of birth cannot be in the future');
      return;
    }
    
    // Check minimum age requirement
    if (age < 18) {
      alert(`You must be at least 18 years old to apply. Current age would be: ${age} years`);
      return;
    }
    
    formData.personal.dob = dateString;
    showDatePicker.value = false;
    clearValidationErrors();
  }
};

// Initialize date picker with current date if available
const initializeDatePicker = () => {
  if (formData.personal.dob) {
    const date = new Date(formData.personal.dob);
    selectedYear.value = date.getFullYear().toString();
    selectedMonth.value = date.getMonth().toString();
    selectedDay.value = date.getDate().toString();
  } else {
    // Set default to exactly 18 years ago from current date
    const today = new Date();
    const eighteenYearsAgo = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
    selectedYear.value = eighteenYearsAgo.getFullYear().toString();
    selectedMonth.value = eighteenYearsAgo.getMonth().toString();
    selectedDay.value = eighteenYearsAgo.getDate().toString();
  }
};

// Initialize date picker on component mount
onMounted(() => {
  initializeDatePicker();
  
  // Read vacancy_id from URL
  const urlParams = new URLSearchParams(window.location.search);
  vacancyId.value = urlParams.get('vacancy');
  console.log('Form mounted - Vacancy ID from URL:', vacancyId.value);
  console.log('Full URL:', window.location.href);
});

// Helper functions for data formatting
const formatPhoneWithCountryCode = (phone, countryCode) => {
  if (!phone || !countryCode) return '';
  return `${countryCode} ${phone}`;
};

const submitForm = async () => {
  if (!privacyPolicyAgreed.value) {
    alert('Please agree to the Privacy Policy before submitting the form.');
    return;
  }
  
  // Validate all steps before submission
  const biographyValid = validateBiographyStep();
  const educationValid = validateEducationStep();
  const languageValid = validateLanguageStep();
  const experienceValid = validateExperienceStep();
  const achievementValid = validateAchievementsStep();
  const referenceValid = validateReferencesStep();
  const othersValid = validateOthersStep();
  
  if (!biographyValid || !educationValid || !languageValid || !experienceValid || !achievementValid || !referenceValid || !othersValid) {
    alert('Please complete all required fields before submitting the form.');
    return;
  }
  
  try {
    // Show loading state
    const submitButton = document.querySelector('button[type="button"]');
    if (submitButton) {
      submitButton.disabled = true;
      submitButton.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Submitting...
      `;
    }

    // Create FormData for file uploads
    const submitData = new FormData();
    
    // Add personal data
    submitData.append('personal[fullName]', formData.personal.fullName || '');
    submitData.append('personal[nationality]', formData.personal.nationality || '');
    submitData.append('personal[sex]', formData.personal.sex || '');
    // Format date properly: month is 0-11, need to add 1 and pad with zeros
    const year = selectedYear.value || '';
    const month = selectedMonth.value !== '' ? String(parseInt(selectedMonth.value) + 1).padStart(2, '0') : '';
    const day = selectedDay.value ? String(selectedDay.value).padStart(2, '0') : '';
    const formattedDob = year && month && day ? `${year}-${month}-${day}` : (formData.personal.dob || '');
    submitData.append('personal[dob]', formattedDob);
    submitData.append('personal[pob]', formData.personal.pob || '');
    submitData.append('personal[maritalStatus]', formData.personal.maritalStatus || '');
    submitData.append('personal[idaddress]', formData.personal.idaddress || '');
    submitData.append('personal[currentaddress]', formData.personal.currentaddress || '');
    submitData.append('personal[sameAsIdAddress]', formData.personal.sameAsIdAddress ? '1' : '0');
    submitData.append('personal[phone]', formatPhoneWithCountryCode(formData.personal.phone, formData.personal.countryCode));
    submitData.append('personal[countryCode]', formData.personal.countryCode || '');
    submitData.append('personal[email]', formData.personal.email || '');
    submitData.append('personal[linkedin]', formData.personal.linkedin || '');
    submitData.append('personal[social_media]', formData.personal.social_media || '');

    // Add education data
    if (formData.education.history && formData.education.history.length > 0) {
      formData.education.history.forEach((edu, index) => {
        // Map frontend education levels to database values
        const levelMapping = {
          'SMA': 'smk1',
          'SMK': 'smk2', 
          'D3': 'd3-1',
          'S1': 's1',
          'S2': 's2',
          'S3': 's3'
        };
        const mappedLevel = levelMapping[edu.level] || edu.level || '';
        
        submitData.append(`education[history][${index}][level]`, mappedLevel);
        submitData.append(`education[history][${index}][schoolName]`, edu.schoolName || '');
        submitData.append(`education[history][${index}][faculty]`, edu.faculty || '');
        submitData.append(`education[history][${index}][major]`, edu.major || '');
        submitData.append(`education[history][${index}][startYear]`, edu.startDate || '');
        submitData.append(`education[history][${index}][endYear]`, edu.endDate || '');
        submitData.append(`education[history][${index}][graduateYear]`, edu.graduateYear || '');
        submitData.append(`education[history][${index}][gpa]`, edu.gpa || '');
        submitData.append(`education[history][${index}][description]`, edu.description || '');
        submitData.append(`education[history][${index}][isCurrent]`, edu.isCurrent ? '1' : '0');
        
        // Handle certificate file upload
        if (edu.certificate && edu.certificate instanceof File) {
          submitData.append(`education[history][${index}][certificate]`, edu.certificate);
        }
      });
    }

    // Add languages data
    if (formData.languages && formData.languages.length > 0) {
      formData.languages.forEach((lang, index) => {
        submitData.append(`languages[${index}][name]`, lang.name || '');
        submitData.append(`languages[${index}][proficiency]`, lang.proficiency || '');
        submitData.append(`languages[${index}][speaking]`, lang.speaking || '');
        submitData.append(`languages[${index}][writing]`, lang.writing || '');
        submitData.append(`languages[${index}][reading]`, lang.reading || '');
        submitData.append(`languages[${index}][listening]`, lang.listening || '');
        submitData.append(`languages[${index}][certificateName]`, lang.certificateName || '');
        submitData.append(`languages[${index}][certificateDate]`, lang.certificateDate || '');
        submitData.append(`languages[${index}][notes]`, lang.notes || '');
      });
    }

    // Add experience data
    if (formData.experience.history && formData.experience.history.length > 0) {
      formData.experience.history.forEach((exp, index) => {
        submitData.append(`experience[history][${index}][companyName]`, exp.companyName || '');
        submitData.append(`experience[history][${index}][position]`, exp.position || '');
        submitData.append(`experience[history][${index}][jobDesc]`, exp.jobDesc || '');
        submitData.append(`experience[history][${index}][startYear]`, exp.startDate || '');
        submitData.append(`experience[history][${index}][endYear]`, exp.endDate || '');
        submitData.append(`experience[history][${index}][employmentType]`, exp.employmentType || '');
        submitData.append(`experience[history][${index}][salaryRange]`, exp.salaryRange || '');
        submitData.append(`experience[history][${index}][reasonsForLeaving]`, exp.reasonsForLeaving || '');
        submitData.append(`experience[history][${index}][supervisorName]`, exp.supervisorName || '');
        submitData.append(`experience[history][${index}][supervisorContact]`, exp.supervisorContact || '');
        submitData.append(`experience[history][${index}][achievements]`, exp.achievements || '');
        submitData.append(`experience[history][${index}][responsibilities]`, exp.responsibilities || '');
        submitData.append(`experience[history][${index}][isCurrent]`, exp.isCurrent ? '1' : '0');
      });
    }

    // Add achievements data
    if (formData.achievements.history && formData.achievements.history.length > 0) {
      formData.achievements.history.forEach((ach, index) => {
        submitData.append(`achievements[history][${index}][title]`, ach.title || '');
        submitData.append(`achievements[history][${index}][description]`, ach.description || '');
        submitData.append(`achievements[history][${index}][organization]`, ach.organization || '');
        submitData.append(`achievements[history][${index}][achievementDate]`, ach.achievementDate || '');
        submitData.append(`achievements[history][${index}][year]`, ach.year || '');
        submitData.append(`achievements[history][${index}][category]`, ach.category || '');
        submitData.append(`achievements[history][${index}][verificationUrl]`, ach.verificationUrl || '');
        submitData.append(`achievements[history][${index}][impact]`, ach.impact || '');
      });
    }

    // Add references data
    if (formData.references.history && formData.references.history.length > 0) {
      formData.references.history.forEach((ref, index) => {
        submitData.append(`references[history][${index}][name]`, ref.name || '');
        submitData.append(`references[history][${index}][organization]`, ref.organization || '');
        submitData.append(`references[history][${index}][phone]`, formatPhoneWithCountryCode(ref.phone, ref.countryCode));
        submitData.append(`references[history][${index}][countryCode]`, ref.countryCode || '');
        submitData.append(`references[history][${index}][relationship]`, ref.relationship || '');
        submitData.append(`references[history][${index}][email]`, ref.email || '');
        submitData.append(`references[history][${index}][notes]`, ref.notes || '');
      });
    }

    // Add skills data
    if (formData.others.skills && formData.others.skills.length > 0) {
      formData.others.skills.forEach((skill, index) => {
        submitData.append(`others[skills][${index}]`, skill);
      });
    }

    // Add certifications data
    if (formData.others.certifications && formData.others.certifications.length > 0) {
      formData.others.certifications.forEach((cert, index) => {
        submitData.append(`others[certifications][${index}][title]`, cert.title || '');
        submitData.append(`others[certifications][${index}][issuer]`, cert.issuer || '');
        submitData.append(`others[certifications][${index}][year]`, cert.year || '');
        submitData.append(`others[certifications][${index}][expiryDate]`, cert.expiryDate || '');
        submitData.append(`others[certifications][${index}][certificationNumber]`, cert.certificationNumber || '');
        submitData.append(`others[certifications][${index}][credentialId]`, cert.credentialId || '');
        submitData.append(`others[certifications][${index}][type]`, cert.type || '');
        submitData.append(`others[certifications][${index}][description]`, cert.description || '');
        submitData.append(`others[certifications][${index}][notes]`, cert.notes || '');
        
        // Handle certificate file upload
        if (cert.certificate && cert.certificate instanceof File) {
          submitData.append(`others[certifications][${index}][certificate]`, cert.certificate);
        }
      });
    }

    // Add other data
    submitData.append('others[comments]', formData.others.comments || '');
    submitData.append('applied_position', getAppliedPosition());
    submitData.append('current_salary', `${formData.experience.currentSalary || ''} ${formData.experience.currency || ''}`);
    submitData.append('currency', formData.experience.currency || '');
    submitData.append('reason_for_leaving', formData.experience.reasonsForLeaving || '');
    submitData.append('privacy_policy_agreed', privacyPolicyAgreed.value ? '1' : '0');
    
    // Add vacancy_id if available
    if (vacancyId.value) {
      submitData.append('vacancy_id', vacancyId.value);
      console.log('Career Application - Vacancy ID:', vacancyId.value);
    }
    
    // Add resume file if uploaded
    if (resumeFile.value) {
      submitData.append('resume', resumeFile.value);
    }

    // Get CSRF token with fallback and refresh capability
    const getCsrfToken = async () => {
      const metaTag = document.querySelector('meta[name="csrf-token"]');
      if (metaTag) {
        return metaTag.getAttribute('content');
      }
      // Fallback: try to get from cookies
      const cookies = document.cookie.split(';');
      for (let cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'XSRF-TOKEN') {
          return decodeURIComponent(value);
        }
      }
      return null;
    };

    // Refresh CSRF token if needed
    const refreshCsrfToken = async () => {
      try {
        const response = await fetch('/csrf-token', {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
          }
        });
        if (response.ok) {
          const data = await response.json();
          // Update the meta tag
          const metaTag = document.querySelector('meta[name="csrf-token"]');
          if (metaTag) {
            metaTag.setAttribute('content', data.csrf_token);
          }
          return data.csrf_token;
        }
      } catch (error) {
        console.error('Failed to refresh CSRF token:', error);
      }
      return null;
    };

    let csrfToken = await getCsrfToken();
    if (!csrfToken) {
      // Try to refresh the token
      csrfToken = await refreshCsrfToken();
      if (!csrfToken) {
        alert('CSRF token not found. Please refresh the page and try again.');
        return;
      }
    }

    // Debug: Log form data before submission
    console.log('Form data being submitted:');
    for (let [key, value] of submitData.entries()) {
      console.log(`${key}:`, value);
    }

    // Submit the form with retry mechanism for CSRF token mismatch
    let response = await fetch('/career-applications', {
      method: 'POST',
      body: submitData,
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json',
      }
    });

    // If CSRF token mismatch, try once more with a fresh token
    if (response.status === 419) {
      console.log('CSRF token mismatch, attempting to refresh token and retry...');
      const freshToken = await refreshCsrfToken();
      if (freshToken) {
        response = await fetch('/career-applications', {
          method: 'POST',
          body: submitData,
          headers: {
            'X-CSRF-TOKEN': freshToken,
            'Accept': 'application/json',
          }
        });
      }
    }

    if (response.ok) {
      // Success - go to step 9 (success message)
      currentStep.value = 9;
      window.scrollTo(0, 0);
    } else {
      // Handle errors
      const errorData = await response.json();
      console.error('Submission error:', errorData);
      console.error('Response status:', response.status);
      console.error('Response headers:', response.headers);
      
      if (response.status === 419) {
        // CSRF token mismatch after retry
        alert('Your session has expired. Please refresh the page and try again.');
        window.location.reload();
      } else if (response.status === 422) {
        // Validation errors
        console.error('Validation errors:', errorData.errors);
        alert('Please check your form data and try again. Check console for details.');
      } else {
        console.error('Server error:', errorData);
        alert('An error occurred while submitting your application. Please try again.');
      }
    }

  } catch (error) {
    console.error('Error submitting form:', error);
    alert('An error occurred while submitting your application. Please try again.');
  } finally {
    // Reset button state
    const submitButton = document.querySelector('button[type="button"]');
    if (submitButton) {
      submitButton.disabled = false;
      submitButton.innerHTML = `
        Submit
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      `;
    }
  }
};

// Helper function to get applied position from URL
const getAppliedPosition = () => {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get('position') || '';
};
</script>