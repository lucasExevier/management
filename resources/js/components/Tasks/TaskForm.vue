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
              <h3 class="text-lg font-medium leading-6 text-gray-900">{{ isEditing ? 'Edit Task' : 'Create New Task' }}</h3>
              <p class="mt-1 text-sm text-gray-600">
                {{ isEditing ? 'Update your task details.' : 'Fill in the details to create a new task.' }}
              </p>
            </div>
          </div>
          <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="handleSubmit">
              <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                  <InputText
                    id="title"
                    label="Task Title"
                    placeholder="Enter task title"
                    required
                    :error="errors.title ? errors.title[0] : false"
                    v-model="form.title"
                  />

                  <InputTextarea
                    id="description"
                    label="Description"
                    placeholder="Task description..."
                    :error="errors.description ? errors.description[0] : false"
                    v-model="form.description"
                  />

                  <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                      <InputSelect
                        id="status"
                        label="Status"
                        :options="[
                          { value: 'todo', label: 'To Do' },
                          { value: 'in_progress', label: 'In Progress' },
                          { value: 'done', label: 'Done' },
                          { value: 'blocked', label: 'Blocked' }
                        ]"
                        :error="errors.status ? errors.status[0] : false"
                        v-model="form.status"
                      />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                      <InputSelect
                        id="priority"
                        label="Priority"
                        :options="[
                          { value: 'low', label: 'Low' },
                          { value: 'medium', label: 'Medium' },
                          { value: 'high', label: 'High' }
                        ]"
                        :error="errors.priority ? errors.priority[0] : false"
                        v-model="form.priority"
                      />
                    </div>
                  </div>

                  <InputSelect
                    id="project_id"
                    label="Project"
                    placeholder="Select a project"
                    :options="projects.map(p => ({ value: p.id, label: p.name }))"
                    required
                    :error="errors.project_id ? errors.project_id[0] : false"
                    v-model="form.project_id"
                  />

                  <InputSelect
                    id="board_id"
                    label="Board (Optional)"
                    placeholder="Select a board"
                    :options="boards.map(b => ({ value: b.id, label: b.name }))"
                    :error="errors.board_id ? errors.board_id[0] : false"
                    v-model="form.board_id"
                  />

                  <InputDate
                    id="due_date"
                    label="Due Date"
                    :error="errors.due_date ? errors.due_date[0] : false"
                    v-model="form.due_date"
                  />
                </div>
                <FormActions
                  :loading="loading"
                  :show-cancel="true"
                  :show-submit="true"
                  cancel-text="Cancel"
                  :submit-text="isEditing ? 'Update Task' : 'Create Task'"
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
const projects = ref([])
const boards = ref([])
const form = ref({
  title: '',
  description: '',
  status: 'todo',
  priority: 'medium',
  project_id: '',
  board_id: '',
  due_date: ''
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

const fetchTask = async (id) => {
  try {
    const response = await axios.get(`/api/tasks/${id}`)
    const task = response.data
    form.value = {
      title: task.title,
      description: task.description,
      status: task.status,
      priority: task.priority,
      project_id: task.project_id,
      board_id: task.board_id,
      due_date: task.due_date
    }
  } catch (error) {
    console.error('Failed to fetch task:', error)
  }
}

const handleSubmit = async () => {
  loading.value = true
  errors.value = {}
  try {
    if (isEditing.value) {
      await axios.put(`/api/tasks/${route.params.id}`, form.value)
      if (window.notify) {
        window.notify.success('Success', 'Task updated successfully')
      }
    } else {
      await axios.post('/api/tasks', form.value)
      if (window.notify) {
        window.notify.success('Success', 'Task created successfully')
      }
    }
    router.push('/tasks')
  } catch (error) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
    } else {
      if (window.notify) {
        window.notify.error('Error', 'Failed to save task')
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
    fetchTask(route.params.id)
  }
})
</script>
