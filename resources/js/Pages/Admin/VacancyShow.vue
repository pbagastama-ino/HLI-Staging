<template>
  <Head title="Vacancy Details - HLI Admin" />
  <AdminLayout 
    current-page="vacancies" 
    title="Vacancy Details" 
    :user="user"
  >
    <div class="mb-6">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-gray-800">{{ vacancy.title }}</h2>
          <p class="text-sm text-gray-600 mt-1">{{ vacancy.department_name }}</p>
        </div>
        <div class="flex space-x-3">
          <Link
            :href="`/hli-admin/vacancies/${vacancy.id}/edit`"
            class="px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
          >
            Edit Vacancy
          </Link>
          <Link
            href="/hli-admin/vacancies"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
          >
            Back to List
          </Link>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Main Content -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Job Description -->
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Job Description</h3>
          <div class="prose max-w-none text-gray-700 html-content">
            <div v-html="vacancy.description"></div>
          </div>
        </div>

        <!-- Requirements -->
        <div v-if="vacancy.requirements" class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Requirements</h3>
          <div class="prose max-w-none text-gray-700 html-content">
            <div v-html="vacancy.requirements"></div>
          </div>
        </div>

        <!-- Employee Benefit -->
        <div v-if="vacancy.employee_benefit" class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Employee Benefit</h3>
          <div class="prose max-w-none text-gray-700 html-content">
            <div v-html="vacancy.employee_benefit"></div>
          </div>
        </div>

        <!-- Applications -->
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Applications ({{ vacancy.applications?.length || 0 }})</h3>
          <div v-if="vacancy.applications && vacancy.applications.length > 0" class="space-y-4">
            <div v-for="application in vacancy.applications" :key="application.id" class="border border-gray-200 rounded-lg p-4">
              <div class="flex justify-between items-start">
                <div>
                  <h4 class="font-medium text-gray-900">{{ application.full_name }}</h4>
                  <p class="text-sm text-gray-600">{{ application.email }}</p>
                  <p class="text-sm text-gray-500">{{ formatDate(application.created_at) }}</p>
                </div>
                <Link
                  :href="`/hli-admin/career-applications/${application.id}`"
                  class="text-[#4D9F95] hover:text-[#3d7f75] text-sm font-medium"
                >
                  View Application
                </Link>
              </div>
            </div>
          </div>
          <div v-else class="text-gray-500 text-center py-8">
            No applications yet
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="space-y-6">
        <!-- Vacancy Info -->
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Vacancy Information</h3>
          <dl class="space-y-3">
            <div>
              <dt class="text-sm font-medium text-gray-500">Department</dt>
              <dd class="text-sm text-gray-900">{{ vacancy.department_name }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Created By</dt>
              <dd class="text-sm text-gray-900">{{ vacancy.creator?.name || 'Unknown' }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Created At</dt>
              <dd class="text-sm text-gray-900">{{ formatDate(vacancy.created_at) }}</dd>
            </div>
            <div v-if="vacancy.updated_by">
              <dt class="text-sm font-medium text-gray-500">Last Updated By</dt>
              <dd class="text-sm text-gray-900">{{ vacancy.updater?.name || 'Unknown' }}</dd>
            </div>
            <div v-if="vacancy.updated_at">
              <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
              <dd class="text-sm text-gray-900">{{ formatDate(vacancy.updated_at) }}</dd>
            </div>
          </dl>
        </div>

        <!-- Actions -->
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
          <div class="space-y-3">
            <Link
              :href="`/hli-admin/vacancies/${vacancy.id}/edit`"
              class="w-full flex justify-center px-4 py-2 text-sm font-medium text-white bg-[#4D9F95] rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4D9F95]"
            >
              Edit Vacancy
            </Link>
            <button
              @click="deleteVacancy"
              class="w-full flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            >
              Delete Vacancy
            </button>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/AdminLayout.vue'

const props = defineProps({
  vacancy: Object,
  user: Object
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const deleteVacancy = () => {
  if (confirm(`Are you sure you want to delete "${props.vacancy.title}"?`)) {
    router.delete(`/hli-admin/vacancies/${props.vacancy.id}`)
  }
}
</script>

<style scoped>
.html-content :deep(ul),
.html-content :deep(ol) {
  padding-left: 1.5rem;
  margin: 0.75rem 0;
}

.html-content :deep(ul) {
  list-style-type: disc;
}

.html-content :deep(ol) {
  list-style-type: decimal;
}

.html-content :deep(li) {
  margin: 0.25rem 0;
  padding-left: 0.25rem;
}

.html-content :deep(strong),
.html-content :deep(b) {
  font-weight: 700;
}

.html-content :deep(em),
.html-content :deep(i) {
  font-style: italic;
}

.html-content :deep(h1) {
  font-size: 2em;
  font-weight: bold;
  margin: 1rem 0;
}

.html-content :deep(h2) {
  font-size: 1.5em;
  font-weight: bold;
  margin: 0.875rem 0;
}

.html-content :deep(h3) {
  font-size: 1.25em;
  font-weight: bold;
  margin: 0.75rem 0;
}

.html-content :deep(blockquote) {
  border-left: 4px solid #4D9F95;
  padding-left: 1rem;
  margin: 1rem 0;
  font-style: italic;
  color: #6b7280;
}

.html-content :deep(p) {
  margin: 0.5rem 0;
}

.html-content :deep(p:first-child) {
  margin-top: 0;
}

.html-content :deep(p:last-child) {
  margin-bottom: 0;
}
</style>
