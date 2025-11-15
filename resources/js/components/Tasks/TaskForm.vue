<template>
  <div>
    <main class="max-w-7xl mx-auto  sm:px-6 lg:px-8">
      <div class="px-4  sm:px-0">
        <!-- Header -->
        <div class="mb-8">
          <div class="flex items-center space-x-4 mb-4">
            <router-link
              to="/tasks"
              class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
              Back to Tasks
            </router-link>
          </div>
          <h1 class="text-3xl font-bold text-gray-900">{{ isEditing ? 'Edit Task' : 'Create New Task' }}</h1>
          <p class="mt-2 text-gray-600">
            {{ isEditing ? 'Update your task details and settings.' : 'Fill in the details below to create a new task.' }}
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                  </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                  {{ isEditing ? 'Update Your Task' : 'Create Amazing Tasks' }}
                </h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                  {{ isEditing
                    ? 'Make changes to your task details, update priorities, and ensure everything is on track for successful completion.'
                    : 'Organize your work efficiently. Set clear objectives, assign priorities, and track progress with our intuitive task management system.'
                  }}
                </p>
                <div class="grid grid-cols-2 gap-4 text-center">
                  <div class="bg-white/60 rounded-lg p-4">
                    <div class="text-2xl font-bold text-indigo-600 mb-1">{{ projects.length }}</div>
                    <div class="text-sm text-gray-600">Active Projects</div>
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

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
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

                    <div>
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

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <InputSelect
                        id="board_id"
                        label="Board (Optional)"
                        placeholder="Select a board"
                        :options="boards.map(b => ({ value: b.id, label: b.name }))"
                        :error="errors.board_id ? errors.board_id[0] : false"
                        v-model="form.board_id"
                      />
                    </div>

                    <div>
                      <InputDate
                        id="due_date"
                        label="Due Date"
                        :error="errors.due_date ? errors.due_date[0] : false"
                        v-model="form.due_date"
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
                  :submit-text="isEditing ? 'Update Task' : 'Create Task'"
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
  // Client-side validation
  if (!form.value.title.trim()) {
    if (window.notify) {
      window.notify.error('Validation Error', 'Task title is required')
    }
    return
  }
  if (!form.value.status) {
    if (window.notify) {
      window.notify.error('Validation Error', 'Task status is required')
    }
    return
  }
  if (!form.value.priority) {
    if (window.notify) {
      window.notify.error('Validation Error', 'Task priority is required')
    }
    return
  }
  if (!form.value.project_id) {
    if (window.notify) {
      window.notify.error('Validation Error', 'Project selection is required')
    }
    return
  }

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
