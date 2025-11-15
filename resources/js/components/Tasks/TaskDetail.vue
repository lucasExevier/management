<template>
  <div class="min-h-screen bg-gray-100">
    <div v-if="loading" class="text-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
      <p class="mt-4 text-gray-600">Loading task...</p>
    </div>
    <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-md p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-red-800">Error loading task</h3>
          <div class="mt-2 text-sm text-red-700">{{ error }}</div>
        </div>
      </div>
    </div>
    <div v-else-if="task">
      <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <div class="flex-shrink-0 flex items-center">
                <router-link to="/dashboard" class="text-xl font-bold text-gray-900">Project Management System</router-link>
              </div>
            </div>
            <div class="flex items-center space-x-4">
              <router-link :to="`/tasks/${task.id}/edit`" class="text-gray-600 hover:text-gray-900">
                Edit Task
              </router-link>
              <router-link to="/tasks" class="text-gray-600 hover:text-gray-900">
                Back to Tasks
              </router-link>
            </div>
          </div>
        </div>
      </nav>

      <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6">
            <div class="flex justify-between items-start">
              <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ task.title }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ task.description || 'No description' }}</p>
              </div>
              <div class="flex space-x-2">
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
              </div>
            </div>
          </div>
          <div class="border-t border-gray-200">
            <dl>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Project</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  <router-link :to="`/projects/${task.project?.id}`" class="text-indigo-600 hover:text-indigo-900">
                    {{ task.project?.name || 'Unknown' }}
                  </router-link>
                </dd>
              </div>
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Board</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  <span v-if="task.board">
                    <router-link :to="`/boards/${task.board.id}`" class="text-indigo-600 hover:text-indigo-900">
                      {{ task.board.name }}
                    </router-link>
                  </span>
                  <span v-else class="text-gray-500">Not assigned</span>
                </dd>
              </div>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Assigned To</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  {{ task.assignedUser?.name || 'Not assigned' }}
                </dd>
              </div>
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Created By</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  {{ task.creator?.name || 'Unknown' }}
                </dd>
              </div>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : 'Not set' }}
                </dd>
              </div>
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Created</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  {{ new Date(task.created_at).toLocaleDateString() }}
                </dd>
              </div>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Updated</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  {{ new Date(task.updated_at).toLocaleDateString() }}
                </dd>
              </div>
            </dl>
          </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="js">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const task = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchTask = async () => {
  try {
    loading.value = true
    error.value = null
    const response = await axios.get(`/api/tasks/${route.params.id}`)
    task.value = response.data
  } catch (err) {
    console.error('Failed to fetch task:', err)
    error.value = err.response?.data?.message || 'Failed to load task'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchTask()
})
</script>
