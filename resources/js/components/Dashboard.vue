<template>
  <div>
    <main class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="px-4  sm:px-0">
        <!-- Welcome Section -->
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ user?.name || 'User' }}!</h1>
          <p class="text-gray-600">Here's an overview of your project management activities.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white overflow-hidden shadow-sm border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Projects</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.projects }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-sm border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Tasks</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.tasks }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-sm border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Boards</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.boards }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
          <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Status Overview</h3>
            <ProjectStatusChart :projects="recentProjects" />
          </div>
          <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Task Status Distribution</h3>
            <TaskStatusChart :tasks="allTasks" />
          </div>
        </div>

        <div class="mb-8">
          <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Progress Timeline</h3>
            <ProjectProgressChart :projects="recentProjects" :tasks="allTasks" />
          </div>
        </div>

        <!-- Recent Projects Section -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200">
          <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-semibold text-gray-900">Recent Projects</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Your latest project activities and updates</p>
          </div>
          <ul role="list" class="divide-y divide-gray-200">
            <li v-for="project in recentProjects" :key="project.id" class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-12 w-12">
                    <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center">
                      <span class="text-sm font-semibold text-indigo-700">{{ project.name.charAt(0).toUpperCase() }}</span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-semibold text-gray-900">{{ project.name }}</div>
                    <div class="text-sm text-gray-500">{{ project.description || 'No description available' }}</div>
                    <div class="flex items-center mt-1 space-x-4 text-xs text-gray-400">
                      <span>{{ project.tasks_count || 0 }} tasks</span>
                      <span>{{ project.boards_count || 0 }} boards</span>
                    </div>
                  </div>
                </div>
                <div class="flex items-center space-x-3">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                        :class="{
                          'bg-green-100 text-green-800': project.status === 'active',
                          'bg-yellow-100 text-yellow-800': project.status === 'inactive',
                          'bg-gray-100 text-gray-800': project.status === 'completed'
                        }">
                    {{ project.status }}
                  </span>
                  <router-link
                    :to="`/projects/${project.id}`"
                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                  >
                    View Details
                  </router-link>
                </div>
              </div>
            </li>
            <li v-if="recentProjects.length === 0" class="px-6 py-8 text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900">No projects yet</h3>
              <p class="mt-1 text-sm text-gray-500">Get started by creating your first project.</p>
              <div class="mt-6">
                <router-link
                  to="/projects/create"
                  class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                  </svg>
                  Create Project
                </router-link>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="js">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import ProjectStatusChart from './Charts/ProjectStatusChart.vue'
import TaskStatusChart from './Charts/TaskStatusChart.vue'
import ProjectProgressChart from './Charts/ProjectProgressChart.vue'

const router = useRouter()
const user = ref(null)
const stats = ref({
  projects: 0,
  tasks: 0,
  boards: 0
})
const recentProjects = ref([])
const allTasks = ref([])

const fetchDashboardData = async () => {
  try {
    const [userResponse, projectsResponse, tasksResponse, boardsResponse] = await Promise.all([
      axios.get('/api/user'),
      axios.get('/api/projects'),
      axios.get('/api/tasks'),
      axios.get('/api/boards')
    ])

    user.value = userResponse.data
    recentProjects.value = projectsResponse.data.slice(0, 5)
    allTasks.value = tasksResponse.data
    stats.value.projects = projectsResponse.data.length
    stats.value.tasks = tasksResponse.data.length
    stats.value.boards = boardsResponse.data.length
  } catch (error) {
    console.error('Failed to fetch dashboard data:', error)
  }
}



onMounted(() => {
  fetchDashboardData()
})
</script>
