<template>
  <Head :title="`${publication ? 'Edit Publication' : 'Create New Publication'} - HLI Admin`" />
  <AdminLayout 
    :current-page="publication ? 'publications' : 'publications'" 
    :title="publication ? 'Edit Publication' : 'Create New Publication'" 
    :user="user"
  >
    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">
            {{ publication ? 'Edit Publication' : 'Create New Publication' }}
          </h2>
          <p class="text-sm text-gray-600 mt-1">
            {{ publication ? 'Update publication details' : 'Add a new publication' }}
          </p>
        </div>
        <div class="flex space-x-3">
          <Link
            href="/hli-admin/publications"
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
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Title -->
          <div class="md:col-span-2">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
              Title *
            </label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.title }"
            />
            <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
          </div>

          <!-- Category -->
          <div>
            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
              Category *
            </label>
        <select
          id="category"
          v-model="form.category"
          required
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
          :class="{ 'border-red-500': errors.category }"
        >
          <option value="">Select Category</option>
          <option value="article">Article</option>
          <option value="press-release">Press Release</option>
          <option value="company-activities">Company Activities</option>
          <option value="life-at-hli">Life at HLI</option>
        </select>
            <p v-if="errors.category" class="mt-1 text-sm text-red-600">{{ errors.category }}</p>
          </div>

          <!-- Status -->
          <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
              Status *
            </label>
            <select
              id="status"
              v-model="form.status"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.status }"
            >
              <option value="draft">Draft</option>
              <option value="published">Published</option>
              <option value="archived">Archived</option>
            </select>
            <p v-if="errors.status" class="mt-1 text-sm text-red-600">{{ errors.status }}</p>
          </div>

          <!-- Published Date -->
          <div>
            <label for="published_date" class="block text-sm font-medium text-gray-700 mb-1">
              Published Date
            </label>
            <input
              id="published_date"
              v-model="form.published_date"
              type="date"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.published_date }"
            />
            <p v-if="errors.published_date" class="mt-1 text-sm text-red-600">{{ errors.published_date }}</p>
          </div>

          <!-- Featured -->
          <div class="flex items-center">
            <input
              id="featured"
              v-model="form.featured"
              type="checkbox"
              class="h-4 w-4 text-[#4D9F95] focus:ring-[#4D9F95] border-gray-300 rounded"
            />
            <label for="featured" class="ml-2 block text-sm text-gray-900">
              Featured Publication
            </label>
          </div>
        </div>
      </div>

      <!-- Content Section -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Content</h3>
        
        <!-- Text Content -->
        <div class="mb-6">
          <label for="text" class="block text-sm font-medium text-gray-700 mb-1">
            Content *
          </label>
          <textarea
            id="text"
            v-model="form.text"
            rows="10"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
            :class="{ 'border-red-500': errors.text }"
            placeholder="Write your publication content here..."
          ></textarea>
          <p v-if="errors.text" class="mt-1 text-sm text-red-600">{{ errors.text }}</p>
        </div>

        <!-- Image Upload -->
        <div>
          <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
            Featured Image
          </label>
          <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
            <div class="space-y-1 text-center">
              <svg v-if="!imagePreview" class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <div v-if="imagePreview" class="mx-auto h-32 w-32 relative">
                <img :src="imagePreview" alt="Preview" class="h-32 w-32 object-cover rounded-lg" />
                <button
                  type="button"
                  @click="clearImage"
                  class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600"
                  title="Remove image"
                >
                  ×
                </button>
              </div>
              <div class="flex text-sm text-gray-600">
                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#4D9F95] hover:text-[#3d7f75] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#4D9F95]">
                  <span>Upload a file</span>
                  <input
                    id="image"
                    ref="imageInput"
                    type="file"
                    accept="image/*"
                    @change="handleImageChange"
                    class="sr-only"
                  />
                </label>
                <p class="pl-1">or drag and drop</p>
              </div>
              <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
            </div>
          </div>
          <p v-if="errors.image" class="mt-1 text-sm text-red-600">{{ errors.image }}</p>
          <p v-if="imageUploadError" class="mt-1 text-sm text-red-600">{{ imageUploadError }}</p>
        </div>
      </div>

      <!-- SEO Section -->
      <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Settings</h3>
        
        <div class="space-y-6">
          <!-- Meta Title -->
          <div>
            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">
              Meta Title
            </label>
            <input
              id="meta_title"
              v-model="form.meta_title"
              type="text"
              maxlength="255"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.meta_title }"
            />
            <p v-if="errors.meta_title" class="mt-1 text-sm text-red-600">{{ errors.meta_title }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ form.meta_title?.length || 0 }}/255 characters</p>
          </div>

          <!-- Meta Description -->
          <div>
            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">
              Meta Description
            </label>
            <textarea
              id="meta_description"
              v-model="form.meta_description"
              rows="3"
              maxlength="500"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.meta_description }"
            ></textarea>
            <p v-if="errors.meta_description" class="mt-1 text-sm text-red-600">{{ errors.meta_description }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ form.meta_description?.length || 0 }}/500 characters</p>
          </div>

          <!-- Meta Keywords -->
          <div>
            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">
              Meta Keywords
            </label>
            <input
              id="meta_keywords"
              v-model="form.meta_keywords"
              type="text"
              maxlength="500"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4D9F95] focus:border-transparent"
              :class="{ 'border-red-500': errors.meta_keywords }"
              placeholder="keyword1, keyword2, keyword3"
            />
            <p v-if="errors.meta_keywords" class="mt-1 text-sm text-red-600">{{ errors.meta_keywords }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ form.meta_keywords?.length || 0 }}/500 characters</p>
          </div>
        </div>
      </div>

      <!-- Form Actions -->
      <div class="flex justify-end space-x-3">
        <Link
          href="/hli-admin/publications"
          class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
        >
          Cancel
        </Link>
        <button
          type="submit"
          :disabled="isSubmitting"
          class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95] disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="isSubmitting">Saving...</span>
          <span v-else>{{ publication ? 'Update Publication' : 'Create Publication' }}</span>
        </button>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'
import axios from 'axios'

const props = defineProps({
  publication: {
    type: Object,
    default: null
  },
  user: {
    type: Object,
    required: true
  }
})

const showFlashMessage = ref(true)
const isSubmitting = ref(false)
const imagePreview = ref(null)
const imageInput = ref(null)
const imageUploadError = ref(null)

const form = reactive({
  title: props.publication?.title || '',
  text: props.publication?.text || '',
  image: null,
  category: props.publication?.category || '',
  published_date: props.publication?.published_date ? props.publication.published_date.split('T')[0] : '',
  status: props.publication?.status || 'draft',
  featured: props.publication?.featured || false,
  meta_title: props.publication?.meta_title || '',
  meta_description: props.publication?.meta_description || '',
  meta_keywords: props.publication?.meta_keywords || ''
})

const errors = computed(() => props.$page?.props?.errors || {})

const handleImageChange = (event) => {
  const file = event.target.files[0]
  
  // Clear any previous errors
  imageUploadError.value = null
  
  if (file) {
    // Basic file validation
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']
    if (!allowedTypes.includes(file.type)) {
      imageUploadError.value = 'Please select a valid image file (JPEG, PNG, JPG, or GIF)'
      event.target.value = '' // Clear the input
      return
    }
    
    // Check file size (2MB limit)
    const maxSize = 2 * 1024 * 1024 // 2MB in bytes
    if (file.size > maxSize) {
      imageUploadError.value = 'File size must be less than 2MB'
      event.target.value = '' // Clear the input
      return
    }
    
    form.image = file
    
    // Create preview
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const submitForm = async () => {
  isSubmitting.value = true
  
  // Debug: Log current form values
  console.log('Current form values:', form)
  
  // Check if we have an image file to upload
  const hasImageFile = form.image instanceof File
  
  if (hasImageFile) {
    // Use FormData for file uploads
    const formData = new FormData()
    
    // Add all form fields
    formData.append('title', form.title || '')
    formData.append('text', form.text || '')
    formData.append('category', form.category || '')
    formData.append('status', form.status || 'draft')
    formData.append('published_date', form.published_date || '')
    formData.append('featured', form.featured ? 1 : 0)
    formData.append('meta_title', form.meta_title || '')
    formData.append('meta_description', form.meta_description || '')
    formData.append('meta_keywords', form.meta_keywords || '')
    formData.append('image', form.image)
    
    console.log('Using FormData for file upload:', form.image.name)
    console.log('FormData contents:', {
      title: formData.get('title'),
      text: formData.get('text'),
      category: formData.get('category'),
      image: formData.get('image'),
      imageType: form.image.type,
      imageSize: form.image.size
    })
    
    const url = props.publication 
      ? `/hli-admin/publications/${props.publication.id}`
      : '/hli-admin/publications'
    
    const method = props.publication ? 'patch' : 'post'

    // Use axios for file uploads to ensure proper FormData handling
    try {
      // Add method override for updates
      if (props.publication) {
        formData.append('_method', 'PATCH')
      }
      
      // Get CSRF token from Laravel's meta tag or use Inertia's approach
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                       window.Laravel?.csrfToken || 
                       document.querySelector('input[name="_token"]')?.value
      
      if (!csrfToken) {
        throw new Error('CSRF token not found. Please refresh the page and try again.')
      }
      
      const response = await axios({
        method: 'post',
        url: url,
        data: formData,
        headers: {
          'Content-Type': 'multipart/form-data',
          'X-CSRF-TOKEN': csrfToken,
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      
      console.log('Form submitted successfully with FormData')
      isSubmitting.value = false
      
      // Redirect after successful submission
      router.visit('/hli-admin/publications')
    } catch (error) {
      console.error('Form submission errors:', error.response?.data?.errors || error.message)
      isSubmitting.value = false
      
      // Show user-friendly error message
      if (error.response?.data?.errors) {
        const errors = error.response.data.errors
        const errorMessages = Object.values(errors).flat()
        alert('Upload failed: ' + errorMessages.join(', '))
      } else if (error.message) {
        alert('Upload failed: ' + error.message)
      } else {
        alert('Upload failed. Please try again.')
      }
    }
  } else {
    // Use regular object for non-file submissions
    const data = {
      title: form.title || '',
      text: form.text || '',
      category: form.category || '',
      status: form.status || 'draft',
      published_date: form.published_date || '',
      featured: form.featured ? 1 : 0,
      meta_title: form.meta_title || '',
      meta_description: form.meta_description || '',
      meta_keywords: form.meta_keywords || ''
    }

    console.log('Using regular object (no file):', data)

    const url = props.publication 
      ? `/hli-admin/publications/${props.publication.id}`
      : '/hli-admin/publications'
    
    const method = props.publication ? 'patch' : 'post'

    router[method](url, data, {
      onSuccess: () => {
        isSubmitting.value = false
      },
      onError: (errors) => {
        isSubmitting.value = false
        console.error('Form submission errors:', errors)
        
        // Show user-friendly error message
        const errorMessages = Object.values(errors).flat()
        alert('Submission failed: ' + errorMessages.join(', '))
      },
      onFinish: () => {
        isSubmitting.value = false
      }
    })
  }
}

const closeFlashMessage = () => {
  showFlashMessage.value = false
}

const clearImage = () => {
  form.image = null
  imagePreview.value = null
  imageUploadError.value = null
  if (imageInput.value) {
    imageInput.value.value = ''
  }
}

onMounted(() => {
  // Set image preview if editing existing publication
  if (props.publication?.image_url) {
    imagePreview.value = props.publication.image_url
  }
  
  // Auto-hide flash message after 10 seconds
  setTimeout(() => {
    showFlashMessage.value = false
  }, 10000)
})
</script>
