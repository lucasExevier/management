<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <router-link to="/dashboard" class="text-xl font-bold text-gray-900">Project Management System</router-link>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
          <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
              <h3 class="text-lg font-medium leading-6 text-gray-900">{{ isEditing ? 'Edit Project' : 'Create New Project' }}</h3>
              <p class="mt-1 text-sm text-gray-600">
                {{ isEditing ? 'Update your project details.' : 'Fill in the details to create a new project.' }}
              </p>
            </div>
          </div>
          <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="handleSubmit">
              <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
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

                  <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                      <InputDate
                        id="start_date"
                        label="Start Date"
                        :error="errors.start_date ? errors.start_date[0] : false"
                        v-model="form.start_date"
                      />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                      <InputDate
                        id="end_date"
                        label="End Date"
                        :error="errors.end_date ? errors.end_date[0] : false"
                        v-model="form.end_date"
                      />
                    </div>
                  </div>
                </div>
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
