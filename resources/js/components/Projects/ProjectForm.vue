<template>
  <div>
    <main class="max-w-7xl mx-auto  sm:px-6 lg:px-8">
      <div class="px-4  sm:px-0">
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

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
          <!-- Left Column - Icon Section -->
          <div class="lg:col-span-5">
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl p-8 lg:p-12 h-full flex flex-col justify-center">
              <div class="text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-lg">
                  <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                  </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                  {{ isEditing ? 'Update Your Project' : 'Create Amazing Projects' }}
                </h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                  {{ isEditing
                    ? 'Make changes to your project details, update timelines, and ensure everything is on track for successful completion.'
                    : 'Organize your work efficiently. Set clear objectives, define timelines, and track progress with our intuitive project management system.'
                  }}
                </p>
                <div class="grid grid-cols-2 gap-4 text-center">
                  <div class="bg-white/60 rounded-lg p-4">
                    <div class="text-2xl font-bold text-indigo-600 mb-1">{{ projects.length }}</div>
                    <div class="text-sm text-gray-600">Total Projects</div>
                  </div>
                  <div class="bg-white/60 rounded-lg p-4">
                    <div class="text-2xl font-bold text-blue-600 mb-1">{{ boards.length }}</div>
                    <div class="text-sm text-gray-600">Available Boards</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column - Form Section -->
          <div class="lg:col-span-7">
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg">
              <div class="px-6 py-6">
                <form @submit.prevent="handleSubmit" class="space-y-6">
                  <InputText
                    id="name"
                    label="Project Name"
                    placeholder="Enter project name"
                    required
                    :error="errors.name ? errors.name[0] : false"
                    v-model="form.name"
                  />

                  <InputTextarea
                    id="description"
                    label="Description"
                    placeholder="Project description..."
                    :error="errors.description ? errors.description[0] : false"
                    v-model="form.description"
                  />

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
              </form>
              </div>
            </div>
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
const projects = ref([])
const boards = ref([])
const form = ref({
  name: '',
  description: '',
  status: 'active',
  start_date: '',
  end_date: ''
})

const fetchProjects = async () => {
  try {
    const response = await axios.get('/api/projects')
    projects.value = response.data
  } catch (error) {
    console.error('Failed to fetch projects:', error)
  }
}

const fetchBoards = async () => {
  try {
    const response = await axios.get('/api/boards')
    boards.value = response.data
  } catch (error) {
    console.error('Failed to fetch boards:', error)
  }
}

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
  // Client-side validation
  if (!form.value.name.trim()) {
    if (window.notify) {
      window.notify.error('Validation Error', 'Project name is required')
    }
    return
  }
  if (!form.value.status) {
    if (window.notify) {
      window.notify.error('Validation Error', 'Project status is required')
    }
    return
  }

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
  fetchProjects()
  fetchBoards()
  if (route.params.id) {
    isEditing.value = true
    fetchProject(route.params.id)
  }
})
</script>
