<template>
  <Head :title="`${vacancy ? 'Edit Vacancy' : 'Create New Vacancy'} - HLI Admin`" />
  <AdminLayout 
    :current-page="vacancy ? 'vacancies' : 'vacancies'" 
    :title="vacancy ? 'Edit Vacancy' : 'Create New Vacancy'" 
    :user="user"
  >
    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">
            {{ vacancy ? 'Edit Vacancy' : 'Create New Vacancy' }}
          </h2>
          <p class="text-sm text-gray-600 mt-1">
            {{ vacancy ? 'Update vacancy posting details' : 'Add a new career opportunity' }}
          </p>
        </div>
        <div class="flex space-x-3">
          <Link
            href="/hli-admin/vacancies"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
          >
            Cancel
          </Link>
        </div>
      </div>
    </div>

    <!-- Success/Error Messages -->
    <div v-if="showFlashMessage && $page.props.flash && $page.props.flash.success" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg relative">
      <button @click="closeFlashMessage" class="absolute top-2 right-2 text-green-600 hover:text-green-800">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      {{ $page.props.flash.success }}
    </div>
    <div v-if="showFlashMessage && $page.props.flash && $page.props.flash.error" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg relative">
      <button @click="closeFlashMessage" class="absolute top-2 right-2 text-red-600 hover:text-red-800">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      {{ $page.props.flash.error }}
    </div>

    <form @submit.prevent="submitForm" class="space-y-6">
      <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
        
        <div class="space-y-6">
          <!-- Job Name -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
              Job Title <span class="text-red-500">*</span>
            </label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.title }"
            />
            <div v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</div>
          </div>

          <!-- Department Name -->
          <div>
            <label for="department_name" class="block text-sm font-medium text-gray-700 mb-2">
              Department Name <span class="text-red-500">*</span>
            </label>
            <input
              id="department_name"
              v-model="form.department_name"
              type="text"
              required
              placeholder="e.g., Engineering, Marketing, Sales"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.department_name }"
            />
            <div v-if="errors.department_name" class="mt-1 text-sm text-red-600">{{ errors.department_name }}</div>
          </div>

          <!-- Requirements -->
          <div>
            <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">
              Requirements
            </label>
            <TiptapEditor
              v-model="form.requirements"
              placeholder="List the key requirements for this position..."
              :has-error="!!errors.requirements"
              :error-message="errors.requirements"
              min-height="150px"
            />
          </div>

          <!-- Job Description -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
              Job Description <span class="text-red-500">*</span>
            </label>
            <TiptapEditor
              v-model="form.description"
              placeholder="Provide a detailed description of the role, responsibilities, and what the candidate will be doing..."
              :has-error="!!errors.description"
              :error-message="errors.description"
              min-height="250px"
            />
          </div>

          <!-- Employee Benefit -->
          <div>
            <label for="employee_benefit" class="block text-sm font-medium text-gray-700 mb-2">
              Employee Benefit
            </label>
            <TiptapEditor
              v-model="form.employee_benefit"
              placeholder="List the employee benefits and perks offered for this position..."
              :has-error="!!errors.employee_benefit"
              :error-message="errors.employee_benefit"
              min-height="150px"
            />
          </div>

          <!-- Status -->
          <div>
            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
              Status
            </label>
            <select
              id="is_active"
              v-model="form.is_active"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.is_active }"
            >
              <option :value="1">Active</option>
              <option :value="0">Inactive</option>
            </select>
            <div v-if="errors.is_active" class="mt-1 text-sm text-red-600">{{ errors.is_active }}</div>
            <p class="mt-1 text-sm text-gray-500">Active vacancies will be shown on the front website</p>
          </div>
        </div>
      </div>

      <!-- Form Actions -->
      <div class="flex justify-end space-x-3">
        <Link
          href="/hli-admin/vacancies"
          class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
        >
          Cancel
        </Link>
        <button
          type="submit"
          :disabled="isSubmitting"
          class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95] disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="isSubmitting" class="flex items-center">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ vacancy ? 'Updating...' : 'Creating...' }}
          </span>
          <span v-else>{{ vacancy ? 'Update Vacancy' : 'Create Vacancy' }}</span>
        </button>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'
import TiptapEditor from '@/Components/TiptapEditor.vue'

const props = defineProps({
  vacancy: Object,
  user: Object
})

const showFlashMessage = ref(true)
const isSubmitting = ref(false)

const form = useForm({
  title: props.vacancy?.title || '',
  requirements: props.vacancy?.requirements || '',
  description: props.vacancy?.description || '',
  department_name: props.vacancy?.department_name || '',
  employee_benefit: props.vacancy?.employee_benefit || '',
  is_active: props.vacancy?.is_active !== undefined ? props.vacancy.is_active : 1,
})

const errors = ref({})

const submitForm = () => {
  isSubmitting.value = true
  errors.value = {}

  if (props.vacancy) {
    // Update existing vacancy
    form.put(`/hli-admin/vacancies/${props.vacancy.id}`, {
      onSuccess: () => {
        isSubmitting.value = false
      },
      onError: (errorBag) => {
        errors.value = errorBag
        isSubmitting.value = false
      }
    })
  } else {
    // Create new vacancy
    form.post('/hli-admin/vacancies', {
      onSuccess: () => {
        isSubmitting.value = false
      },
      onError: (errorBag) => {
        errors.value = errorBag
        isSubmitting.value = false
      }
    })
  }
}

const closeFlashMessage = () => {
  showFlashMessage.value = false
}

onMounted(() => {
  setTimeout(() => {
    showFlashMessage.value = false
  }, 10000)
})
</script>
