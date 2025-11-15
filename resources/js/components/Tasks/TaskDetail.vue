<template>
  <div>
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
              <router-link
                :to="`/tasks/${task.id}/edit`"
                class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Task
              </router-link>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">{{ task.title }}</h1>
            <p class="mt-2 text-gray-600">
              {{ task.description || 'No description provided for this task.' }}
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
                    Task Details
                  </h2>
                  <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    View comprehensive information about this task, including its current status, priority level, and assignment details.
                  </p>
                  <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-white/60 rounded-lg p-4">
                      <div class="text-2xl font-bold text-indigo-600 mb-1">{{ task.status === 'in_progress' ? 'In Progress' : task.status === 'todo' ? 'To Do' : task.status === 'done' ? 'Done' : task.status }}</div>
                      <div class="text-sm text-gray-600">Status</div>
                    </div>
                    <div class="bg-white/60 rounded-lg p-4">
                      <div class="text-2xl font-bold text-blue-600 mb-1">{{ task.priority }}</div>
                      <div class="text-sm text-gray-600">Priority</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Column - Details Section -->
            <div class="lg:col-span-7">
              <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-6">
                  <h3 class="text-lg font-medium text-gray-900 mb-6">Task Information</h3>
                  <dl class="space-y-6">
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                      <dt class="text-sm font-medium text-gray-500">Project</dt>
                      <dd class="text-sm text-gray-900">
                        <router-link :to="`/projects/${task.project?.id}`" class="text-indigo-600 hover:text-indigo-900 font-medium">
                          {{ task.project?.name || 'Unknown' }}
                        </router-link>
                      </dd>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                      <dt class="text-sm font-medium text-gray-500">Board</dt>
                      <dd class="text-sm text-gray-900">
                        <span v-if="task.board">
                          <router-link :to="`/boards/${task.board.id}`" class="text-indigo-600 hover:text-indigo-900 font-medium">
                            {{ task.board.name }}
                          </router-link>
                        </span>
                        <span v-else class="text-gray-500">Not assigned</span>
                      </dd>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                      <dt class="text-sm font-medium text-gray-500">Assigned To</dt>
                      <dd class="text-sm text-gray-900">
                        {{ task.assignedUser?.name || 'Not assigned' }}
                      </dd>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                      <dt class="text-sm font-medium text-gray-500">Created By</dt>
                      <dd class="text-sm text-gray-900">
                        {{ task.creator?.name || 'Unknown' }}
                      </dd>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                      <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                      <dd class="text-sm text-gray-900">
                        {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : 'Not set' }}
                      </dd>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                      <dt class="text-sm font-medium text-gray-500">Created</dt>
                      <dd class="text-sm text-gray-900">
                        {{ new Date(task.created_at).toLocaleDateString() }}
                      </dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                      <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                      <dd class="text-sm text-gray-900">
                        {{ new Date(task.updated_at).toLocaleDateString() }}
                      </dd>
                    </div>
                  </dl>
                </div>
              </div>
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
