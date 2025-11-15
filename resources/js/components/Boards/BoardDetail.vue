<template>
  <div class="min-h-screen bg-gray-100">
    <div v-if="loading" class="text-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
      <p class="mt-4 text-gray-600">Loading board...</p>
    </div>
    <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-md p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-red-800">Error loading board</h3>
          <div class="mt-2 text-sm text-red-700">{{ error }}</div>
        </div>
      </div>
    </div>
    <div v-else-if="board">
      <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <div class="flex-shrink-0 flex items-center">
                <router-link to="/dashboard" class="text-xl font-bold text-gray-900">Project Management System</router-link>
              </div>
            </div>
            <div class="flex items-center space-x-4">
              <router-link :to="`/boards/${board.id}/edit`" class="text-gray-600 hover:text-gray-900">
                Edit Board
              </router-link>
              <router-link to="/boards" class="text-gray-600 hover:text-gray-900">
                Back to Boards
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
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ board.name }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ board.description || 'No description' }}</p>
              </div>
              <span class="text-sm text-gray-500">Position: {{ board.position }}</span>
            </div>
          </div>
          <div class="border-t border-gray-200">
            <dl>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Project</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  <router-link :to="`/projects/${board.project?.id}`" class="text-indigo-600 hover:text-indigo-900">
                    {{ board.project?.name || 'Unknown' }}
                  </router-link>
                </dd>
              </div>
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Tasks Count</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ board.tasks?.length || 0 }}</dd>
              </div>
              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Created</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ new Date(board.created_at).toLocaleDateString() }}</dd>
              </div>
              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Updated</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ new Date(board.updated_at).toLocaleDateString() }}</dd>
              </div>
            </dl>
          </div>
        </div>

        <!-- Tasks Section -->
        <div class="mt-8">
          <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-medium text-gray-900">Tasks in this Board</h4>
            <router-link :to="`/projects/${board?.project?.id}/tasks/create?board_id=${board.id}`" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-md text-sm font-medium">
              Add Task to Board
            </router-link>
          </div>
          <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul role="list" class="divide-y divide-gray-200">
              <li v-for="task in board.tasks" :key="task.id" class="px-4 py-4 sm:px-6">
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
                  </div>
                </div>
              </li>
              <li v-if="!board.tasks || board.tasks.length === 0" class="px-4 py-4 sm:px-6 text-center text-gray-500">
                No tasks in this board yet. <router-link :to="`/projects/${board?.project?.id}/tasks/create?board_id=${board.id}`" class="text-indigo-600 hover:text-indigo-900">Add the first task</router-link>
              </li>
            </ul>
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
const board = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchBoard = async () => {
  try {
    loading.value = true
    error.value = null
    const response = await axios.get(`/api/boards/${route.params.id}`)
    board.value = response.data
  } catch (err) {
    console.error('Failed to fetch board:', err)
    error.value = err.response?.data?.message || 'Failed to load board'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchBoard()
})
</script>
