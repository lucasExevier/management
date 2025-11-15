<template>
  <div>
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Projects</dt>
                    <dd class="text-lg font-medium text-gray-900">{{ stats.projects }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Tasks</dt>
                    <dd class="text-lg font-medium text-gray-900">{{ stats.tasks }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Boards</dt>
                    <dd class="text-lg font-medium text-gray-900">{{ stats.boards }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
          <ProjectStatusChart :projects="recentProjects" />
          <TaskStatusChart :tasks="allTasks" />
        </div>

        <div class="mb-8">
          <ProjectProgressChart :projects="recentProjects" :tasks="allTasks" />
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
          <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Projects</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Your latest project activities</p>
          </div>
          <ul role="list" class="divide-y divide-gray-200">
            <li v-for="project in recentProjects" :key="project.id" class="px-4 py-4 sm:px-6">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                      <span class="text-sm font-medium text-gray-700">{{ project.name.charAt(0).toUpperCase() }}</span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ project.name }}</div>
                    <div class="text-sm text-gray-500">{{ project.description || 'No description' }}</div>
                  </div>
                </div>
                <div class="flex items-center">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="{
                          'bg-green-100 text-green-800': project.status === 'active',
                          'bg-yellow-100 text-yellow-800': project.status === 'inactive',
                          'bg-gray-100 text-gray-800': project.status === 'completed'
                        }">
                    {{ project.status }}
                  </span>
                  <router-link :to="`/projects/${project.id}`" class="ml-4 text-indigo-600 hover:text-indigo-900">
                    View
                  </router-link>
                </div>
              </div>
            </li>
            <li v-if="recentProjects.length === 0" class="px-4 py-4 sm:px-6 text-center text-gray-500">
              No projects yet. <router-link to="/projects" class="text-indigo-600 hover:text-indigo-900">Create your first project</router-link>
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
