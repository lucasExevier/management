<template>
  <div>
    <main class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <!-- Header -->
        <div class="mb-8">
          <div class="flex items-center space-x-4 mb-4">
            <router-link
              to="/projects"
              class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
              Back to Projects
            </router-link>
          </div>
          <h1 class="text-3xl font-bold text-gray-900">{{ isEditing ? 'Edit Project' : 'Create New Project' }}</h1>
          <p class="mt-2 text-gray-600">
            {{ isEditing ? 'Update your project details and settings.' : 'Fill in the details below to create a new project.' }}
          </p>
        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-lg">
          <div class="px-6 py-6">
            <form @submit.prevent="handleSubmit" class="space-y-6">
              <div>
                <InputText
                  id="name"
                  label="Project Name"
                  placeholder="Enter project name"
                  required
                  :error="errors.name ? errors.name[0] : false"
                  v-model="form.name"
                />
              </div>

              <div>
                <InputTextarea
                  id="description"
                  label="Description"
                  placeholder="Project description..."
                  :error="errors.description ? errors.description[0] : false"
                  v-model="form.description"
                />
              </div>

              <div>
                <InputSelect
                  id="status"
                  label="Status"
                  :options="[
                    { value: 'active', label: 'Active' },
                    { value: 'inactive', label: 'Inactive' },
                    { value: 'completed', label: 'Completed' }
                  ]"
                  :error="errors.status ? errors.status[0] : false"
                  v-model="form.status"
                />
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <InputDate
                    id="start_date"
                    label="Start Date"
                    :error="errors.start_date ? errors.start_date[0] : false"
                    v-model="form.start_date"
                  />
                </div>

                <div>
                  <InputDate
                    id="end_date"
                    label="End Date"
                    :error="errors.end_date ? errors.end_date[0] : false"
                    v-model="form.end_date"
                  />
                </div>
              </div>
            </form>
          </div>

          <!-- Form Actions -->
          <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
            <FormActions
              :loading="loading"
              :show-cancel="true"
              :show-submit="true"
              cancel-text="Cancel"
              :submit-text="isEditing ? 'Update Project' : 'Create Project'"
              loading-text="Saving..."
              @cancel="$router.go(-1)"
            />
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="js">
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'
import InputText from '../Form/InputText.vue'
import InputTextarea from '../Form/InputTextarea.vue'
import InputSelect from '../Form/InputSelect.vue'
import InputDate from '../Form/InputDate.vue'
import FormActions from '../Form/FormActions.vue'

const router = useRouter()
const route = useRoute()
const isEditing = ref(false)
const loading = ref(false)
const errors = ref({})
const form = ref({
  name: '',
  description: '',
  status: 'active',
  start_date: '',
  end_date: ''
})

const fetchProject = async (id) => {
  try {
    const response = await axios.get(`/api/projects/${id}`)
    const project = response.data
    form.value = {
      name: project.name,
      description: project.description,
      status: project.status,
      start_date: project.start_date,
      end_date: project.end_date
    }
  } catch (error) {
    console.error('Failed to fetch project:', error)
  }
}

const handleSubmit = async () => {
  loading.value = true
  errors.value = {}
  try {
    if (isEditing.value) {
      await axios.put(`/api/projects/${route.params.id}`, form.value)
      if (window.notify) {
        window.notify.success('Success', 'Project updated successfully')
      }
    } else {
      await axios.post('/api/projects', form.value)
      if (window.notify) {
        window.notify.success('Success', 'Project created successfully')
      }
    }
    router.push('/projects')
  } catch (error) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
    } else {
      if (window.notify) {
        window.notify.error('Error', 'Failed to save project')
      }
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  if (route.params.id) {
    isEditing.value = true
    fetchProject(route.params.id)
  }
})
</script>
