<template>
  <Head :title="`${mode === 'create' ? 'Create Department Category' : 'Edit Department Category'} - HLI Admin`" />
  <AdminLayout 
    :current-page="mode === 'create' ? 'departments' : 'departments'" 
    :title="mode === 'create' ? 'Create Department Category' : 'Edit Department Category'" 
    search-placeholder="Search..." 
    :user="user"
  >
    <div class="max-w-2xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
        <div class="flex items-center space-x-3">
          <Link
            href="/hli-admin/departments"
            class="text-gray-500 hover:text-gray-700"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </Link>
          <div>
            <h2 class="text-xl font-semibold text-gray-800">
              {{ mode === 'create' ? 'Create New Department Category' : 'Edit Department Category' }}
            </h2>
            <p class="text-gray-600">
              {{ mode === 'create' ? 'Add a new department category to the system' : 'Update department category information' }}
            </p>
          </div>
        </div>
      </div>

      <!-- Form -->
      <form @submit.prevent="submitForm" class="space-y-6">
        <div class="bg-white shadow-sm rounded-lg p-6">
          <!-- Name Field -->
          <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
              Department Name <span class="text-red-500">*</span>
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.name }"
              placeholder="Enter department name"
            />
            <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
          </div>

          <!-- Code Field -->
          <div class="mb-6">
            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
              Department Code <span class="text-red-500">*</span>
            </label>
            <input
              id="code"
              v-model="form.code"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent font-mono"
              :class="{ 'border-red-500': errors.code }"
              placeholder="e.g., HR, IT, FIN"
              @input="form.code = form.code.toUpperCase().replace(/[^A-Z0-9]/g, '')"
            />
            <p v-if="errors.code" class="mt-1 text-sm text-red-600">{{ errors.code }}</p>
            <p class="mt-1 text-sm text-gray-500">Unique code for the department (letters and numbers only)</p>
          </div>

          <!-- Description Field -->
          <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
              Description
            </label>
            <textarea
              id="description"
              v-model="form.description"
              rows="4"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.description }"
              placeholder="Enter department description"
            ></textarea>
            <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
          </div>

          <!-- Status and Sort Order -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Status Field -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Status
              </label>
              <div class="flex items-center space-x-4">
                <label class="flex items-center">
                  <input
                    v-model="form.is_active"
                    type="radio"
                    :value="true"
                    class="h-4 w-4 text-[#4D9F95] focus:ring-[#4D9F95] border-gray-300"
                  />
                  <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
                <label class="flex items-center">
                  <input
                    v-model="form.is_active"
                    type="radio"
                    :value="false"
                    class="h-4 w-4 text-[#4D9F95] focus:ring-[#4D9F95] border-gray-300"
                  />
                  <span class="ml-2 text-sm text-gray-700">Inactive</span>
                </label>
              </div>
            </div>

            <!-- Sort Order Field -->
            <div>
              <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                Sort Order
              </label>
              <input
                id="sort_order"
                v-model.number="form.sort_order"
                type="number"
                min="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
                :class="{ 'border-red-500': errors.sort_order }"
                placeholder="0"
              />
              <p v-if="errors.sort_order" class="mt-1 text-sm text-red-600">{{ errors.sort_order }}</p>
              <p class="mt-1 text-sm text-gray-500">Lower numbers appear first</p>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3">
          <Link
            href="/hli-admin/departments"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
          >
            Cancel
          </Link>
          <button
            type="submit"
            :disabled="processing"
            class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95] disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="processing" class="flex items-center">
              <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ mode === 'create' ? 'Creating...' : 'Updating...' }}
            </span>
            <span v-else>{{ mode === 'create' ? 'Create Department' : 'Update Department' }}</span>
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { reactive } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  department: Object,
  mode: String,
  user: Object
})

const form = useForm({
  name: props.department?.name || '',
  code: props.department?.code || '',
  description: props.department?.description || '',
  is_active: props.department?.is_active ?? true,
  sort_order: props.department?.sort_order || 0
})

const processing = form.processing
const errors = form.errors

const submitForm = () => {
  if (props.mode === 'create') {
    form.post('/hli-admin/departments')
  } else {
    form.put(`/hli-admin/departments/${props.department.id}`)
  }
}
</script>
