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
          <div class="flex items-center">
            <router-link to="/tasks/create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-md text-sm font-medium">
              Create Task
            </router-link>
          </div>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold text-gray-900">Tasks</h1>
          <div class="flex space-x-2">
            <select v-model="statusFilter" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
              <option value="">All Status</option>
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>
            <select v-model="priorityFilter" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
              <option value="">All Priority</option>
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>
          </div>
        </div>

        <div v-if="loading" class="text-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
          <p class="mt-4 text-gray-600">Loading tasks...</p>
        </div>
        <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-md p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">Error loading tasks</h3>
              <div class="mt-2 text-sm text-red-700">{{ error }}</div>
            </div>
          </div>
        </div>
        <div v-else class="bg-white shadow overflow-hidden sm:rounded-md">
          <ul role="list" class="divide-y divide-gray-200">
            <li v-for="task in filteredTasks" :key="task.id" class="px-4 py-4 sm:px-6">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                      <span class="text-sm font-medium text-gray-700">{{ task.title.charAt(0).toUpperCase() }}</span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ task.title }}</div>
                    <div class="text-sm text-gray-500">{{ task.description || 'No description' }}</div>
                    <div class="text-xs text-gray-400 mt-1">
                      Project: {{ task.project?.name || 'Unknown' }}
                      <span v-if="task.board"> | Board: {{ task.board.name }}</span>
                    </div>
                  </div>
                </div>
                <div class="flex items-center space-x-4">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="{
                          'bg-yellow-100 text-yellow-800': task.status === 'pending',
                          'bg-blue-100 text-blue-800': task.status === 'in_progress',
                          'bg-green-100 text-green-800': task.status === 'completed'
                        }">
                    {{ task.status.replace('_', ' ') }}
                  </span>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="{
                          'bg-red-100 text-red-800': task.priority === 'high',
                          'bg-yellow-100 text-yellow-800': task.priority === 'medium',
                          'bg-green-100 text-green-800': task.priority === 'low'
                        }">
                    {{ task.priority }}
                  </span>
                  <router-link :to="`/tasks/${task.id}`" class="text-indigo-600 hover:text-indigo-900 text-sm">
                    View
                  </router-link>
                  <router-link :to="`/tasks/${task.id}/edit`" class="text-gray-600 hover:text-gray-900 text-sm">
                    Edit
                  </router-link>
                  <button @click="openDeleteModal(task)" class="text-red-600 hover:text-red-900 text-sm">
                    Delete
                  </button>
                </div>
              </div>
            </li>
            <li v-if="filteredTasks.length === 0" class="px-4 py-4 sm:px-6 text-center text-gray-500">
              No tasks found. <router-link to="/tasks/create" class="text-indigo-600 hover:text-indigo-900">Create your first task</router-link>
            </li>
          </ul>
        </div>
      </div>
    </main>

    <Modal
      :is-open="showDeleteModal"
      title="Delete Task"
      :message="`Are you sure you want to delete the task '${taskToDelete?.title}'? This action cannot be undone.`"
      confirm-text="Delete Task"
      :loading="deleteLoading"
      @confirm="confirmDelete"
      @cancel="closeDeleteModal"
    />
  </div>
</template>

<script setup lang="js">
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import Modal from '../Modal.vue'

const tasks = ref([])
const statusFilter = ref('')
const priorityFilter = ref('')
const loading = ref(true)
const error = ref(null)
const showDeleteModal = ref(false)
const taskToDelete = ref(null)
const deleteLoading = ref(false)

const filteredTasks = computed(() => {
  return tasks.value.filter(task => {
    const statusMatch = !statusFilter.value || task.status === statusFilter.value
    const priorityMatch = !priorityFilter.value || task.priority === priorityFilter.value
    return statusMatch && priorityMatch
  })
})

const fetchTasks = async () => {
  try {
    loading.value = true
    error.value = null
    const response = await axios.get('/api/tasks')
    tasks.value = response.data
  } catch (err) {
    console.error('Failed to fetch tasks:', err)
    error.value = err.response?.data?.message || 'Failed to load tasks'
  } finally {
    loading.value = false
  }
}

const openDeleteModal = (task) => {
  taskToDelete.value = task
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  taskToDelete.value = null
  deleteLoading.value = false
}

const confirmDelete = async () => {
  if (!taskToDelete.value) return

  deleteLoading.value = true
  try {
    await axios.delete(`/api/tasks/${taskToDelete.value.id}`)
    tasks.value = tasks.value.filter(task => task.id !== taskToDelete.value.id)
    closeDeleteModal()
    if (window.notify) {
      window.notify.success('Success', 'Task deleted successfully')
    }
  } catch (err) {
    console.error('Failed to delete task:', err)
    if (window.notify) {
      window.notify.error('Error', 'Failed to delete task')
    }
  } finally {
    deleteLoading.value = false
  }
}

onMounted(() => {
  fetchTasks()
})
</script>
