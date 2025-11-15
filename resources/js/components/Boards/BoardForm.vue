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
              <h3 class="text-lg font-medium leading-6 text-gray-900">{{ isEditing ? 'Edit Board' : 'Create New Board' }}</h3>
              <p class="mt-1 text-sm text-gray-600">
                {{ isEditing ? 'Update your board details.' : 'Fill in the details to create a new board.' }}
              </p>
            </div>
          </div>
          <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="handleSubmit">
              <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                  <InputText
                    id="name"
                    label="Board Name"
                    placeholder="Enter board name"
                    required
                    :error="errors.name ? errors.name[0] : false"
                    v-model="form.name"
                  />

                  <InputTextarea
                    id="description"
                    label="Description"
                    placeholder="Board description..."
                    :error="errors.description ? errors.description[0] : false"
                    v-model="form.description"
                  />

                  <InputSelect
                    id="project_id"
                    label="Project"
                    placeholder="Select a project"
                    :options="projects.map(p => ({ value: p.id, label: p.name }))"
                    required
                    :error="errors.project_id ? errors.project_id[0] : false"
                    v-model="form.project_id"
                  />

                  <InputText
                    id="position"
                    label="Position"
                    type="number"
                    placeholder="Leave empty for auto-positioning"
                    :error="errors.position ? errors.position[0] : false"
                    hint="Optional. Leave empty to automatically position the board."
                    v-model="form.position"
                  />
                </div>
                <FormActions
                  :loading="loading"
                  :show-cancel="true"
                  :show-submit="true"
                  cancel-text="Cancel"
                  :submit-text="isEditing ? 'Update Board' : 'Create Board'"
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
import FormActions from '../Form/FormActions.vue'

const router = useRouter()
const route = useRoute()
const isEditing = ref(false)
const loading = ref(false)
const errors = ref({})
const projects = ref([])
const form = ref({
  name: '',
  description: '',
  project_id: '',
  position: null
})

const fetchProjects = async () => {
  try {
    const response = await axios.get('/api/projects')
    projects.value = response.data
  } catch (error) {
    console.error('Failed to fetch projects:', error)
  }
}

const fetchBoard = async (id) => {
  try {
    const response = await axios.get(`/api/boards/${id}`)
    const board = response.data
    form.value = {
      name: board.name,
      description: board.description,
      project_id: board.project_id,
      position: board.position
    }
  } catch (error) {
    console.error('Failed to fetch board:', error)
  }
}

const handleSubmit = async () => {
  loading.value = true
  errors.value = {}
  try {
    if (isEditing.value) {
      await axios.put(`/api/boards/${route.params.id}`, form.value)
      if (window.notify) {
        window.notify.success('Success', 'Board updated successfully')
      }
    } else {
      await axios.post('/api/boards', form.value)
      if (window.notify) {
        window.notify.success('Success', 'Board created successfully')
      }
    }
    router.push('/boards')
  } catch (error) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
    } else {
      if (window.notify) {
        window.notify.error('Error', 'Failed to save board')
      }
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchProjects()
  if (route.params.id) {
    isEditing.value = true
    fetchBoard(route.params.id)
  }
})
</script>
