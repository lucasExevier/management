<template>
  <div>
    <div v-if="loading" class="text-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
      <p class="mt-4 text-gray-600">Loading project...</p>
    </div>
    <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-md p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-red-800">Error loading project</h3>
          <div class="mt-2 text-sm text-red-700">{{ error }}</div>
        </div>
      </div>
    </div>
    <div v-else-if="project">
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
              <router-link
                :to="`/projects/${project.id}/edit`"
                class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Project
              </router-link>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">{{ project.name }}</h1>
            <p class="mt-2 text-gray-600">
              {{ project.description || 'No description provided for this project.' }}
            </p>
          </div>

          <!-- Two Column Layout -->
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column - Icon Section -->
            <div class="lg:col-span-5">
              <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-8 lg:p-12 h-full flex flex-col justify-center">
                <div class="text-center">
                  <div class="w-24 h-24 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                  </div>
                  <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Project Overview
                  </h2>
                  <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    Monitor project progress, manage boards and tasks, and track team collaboration all in one place.
                  </p>
                  <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-white/60 rounded-lg p-4">
                      <div class="text-2xl font-bold text-emerald-600 mb-1">{{ project.boards?.length || 0 }}</div>
                      <div class="text-sm text-gray-600">Boards</div>
                    </div>
                    <div class="bg-white/60 rounded-lg p-4">
                      <div class="text-2xl font-bold text-green-600 mb-1">{{ project.tasks?.length || 0 }}</div>
                      <div class="text-sm text-gray-600">Tasks</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Column - Details Section -->
            <div class="lg:col-span-7">
              <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-6">
                  <h3 class="text-lg font-medium text-gray-900 mb-6">Project Information</h3>
                  <dl class="space-y-6">
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                      <dt class="text-sm font-medium text-gray-500">Status</dt>
                      <dd class="text-sm text-gray-900">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                              :class="{
                                'bg-green-100 text-green-800': project.status === 'active',
                                'bg-yellow-100 text-yellow-800': project.status === 'inactive',
                                'bg-gray-100 text-gray-800': project.status === 'completed'
                              }">
                          {{ project.status }}
                        </span>
                      </dd>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                      <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                      <dd class="text-sm text-gray-900">
                        {{ project.start_date ? new Date(project.start_date).toLocaleDateString() : 'Not set' }}
                      </dd>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                      <dt class="text-sm font-medium text-gray-500">End Date</dt>
                      <dd class="text-sm text-gray-900">
                        {{ project.end_date ? new Date(project.end_date).toLocaleDateString() : 'Not set' }}
                      </dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                      <dt class="text-sm font-medium text-gray-500">Created</dt>
                      <dd class="text-sm text-gray-900">
                        {{ new Date(project.created_at).toLocaleDateString() }}
                      </dd>
                    </div>
                  </dl>
                </div>
              </div>

              <!-- Boards Section -->
              <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden mt-6">
                <div class="px-6 py-6">
                  <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Project Boards</h3>
                    <router-link :to="`/projects/${project.id}/boards/create`" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                      </svg>
                      Create Board
                    </router-link>
                  </div>
                  <div v-if="project.boards && project.boards.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="board in project.boards" :key="board.id" class="bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors">
                      <h4 class="font-medium text-gray-900 mb-2">{{ board.name }}</h4>
                      <p class="text-sm text-gray-600 mb-3">{{ board.description || 'No description' }}</p>
                      <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">{{ board.tasks_count || 0 }} tasks</span>
                        <router-link :to="`/boards/${board.id}`" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                          View Board →
                        </router-link>
                      </div>
                    </div>
                  </div>
                  <div v-else class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No boards</h3>
                    <p class="mt-1 text-sm text-gray-500">This project doesn't have any boards yet.</p>
                    <div class="mt-6">
                      <router-link :to="`/projects/${project.id}/boards/create`" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create the first board
                      </router-link>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Tasks Section -->
              <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden mt-6">
                <div class="px-6 py-6">
                  <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Project Tasks</h3>
                    <router-link :to="`/projects/${project.id}/tasks/create`" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                      </svg>
                      Create Task
                    </router-link>
                  </div>
                  <div v-if="project.tasks && project.tasks.length > 0" class="space-y-4">
                    <div v-for="task in project.tasks" :key="task.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                      <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                              :class="{
                                'bg-yellow-100 text-yellow-800': task.status === 'todo',
                                'bg-blue-100 text-blue-800': task.status === 'in_progress',
                                'bg-green-100 text-green-800': task.status === 'done',
                                'bg-red-100 text-red-800': task.status === 'blocked'
                              }">
                          {{ task.status.replace('_', ' ') }}
                        </span>
                        <router-link :to="`/tasks/${task.id}`" class="text-indigo-600 hover:text-indigo-900 font-medium">
                          {{ task.title }}
                        </router-link>
                      </div>
                      <div class="flex items-center space-x-2">
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
                  <div v-else class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No tasks</h3>
                    <p class="mt-1 text-sm text-gray-500">This project doesn't have any tasks yet.</p>
                    <div class="mt-6">
                      <router-link :to="`/projects/${project.id}/tasks/create`" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create the first task
                      </router-link>
                    </div>
                  </div>
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
const project = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchProject = async () => {
  try {
    loading.value = true
    error.value = null
    const response = await axios.get(`/api/projects/${route.params.id}`)
    project.value = response.data
  } catch (err) {
    console.error('Failed to fetch project:', err)
    error.value = err.response?.data?.message || 'Failed to load project'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchProject()
})
</script>
