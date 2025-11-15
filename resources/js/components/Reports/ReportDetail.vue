<template>
  <div>
    <main class="max-w-7xl mx-auto  sm:px-6 lg:px-8">
      <div class="px-4  sm:px-0">
        <!-- Header -->
        <div class="mb-8">
          <div class="flex items-center space-x-4 mb-4">
            <router-link
              to="/reports"
              class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
              Back to Reports
            </router-link>
          </div>
          <h1 class="text-3xl font-bold text-gray-900">Report Details</h1>
          <p class="mt-2 text-gray-600">
            Daily report for {{ formatDate(report.report_date) }} by {{ report.user?.name || 'Unknown User' }}
          </p>
        </div>

        <!-- Report Content -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="space-y-8">
              <!-- Tasks Section -->
              <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Completed Tasks</h3>
                <div v-if="report.tasks && report.tasks.length > 0" class="space-y-2">
                  <div v-for="(task, index) in report.tasks" :key="index" class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                    <p class="ml-3 text-sm text-gray-700">{{ task }}</p>
                  </div>
                </div>
                <p v-else class="text-sm text-gray-500">No tasks completed</p>
              </div>

              <!-- Work in Progress Section -->
              <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Work in Progress</h3>
                <div v-if="report.work_in_progress && report.work_in_progress.length > 0" class="space-y-2">
                  <div v-for="(item, index) in report.work_in_progress" :key="index" class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                    <p class="ml-3 text-sm text-gray-700">{{ item }}</p>
                  </div>
                </div>
                <p v-else class="text-sm text-gray-500">No work in progress</p>
              </div>

              <!-- Issues Section -->
              <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Issues Encountered</h3>
                <div v-if="report.issues && report.issues.length > 0" class="space-y-2">
                  <div v-for="(issue, index) in report.issues" :key="index" class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                    <p class="ml-3 text-sm text-gray-700">{{ issue }}</p>
                  </div>
                </div>
                <p v-else class="text-sm text-gray-500">No issues encountered</p>
              </div>

              <!-- Plans Section -->
              <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Plans for Next Period</h3>
                <div v-if="report.plans && report.plans.length > 0" class="space-y-2">
                  <div v-for="(plan, index) in report.plans" :key="index" class="flex items-start">
                    <div class="flex-shrink-0">
                      <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                    <p class="ml-3 text-sm text-gray-700">{{ plan }}</p>
                  </div>
                </div>
                <p v-else class="text-sm text-gray-500">No plans specified</p>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end space-x-3">
            <router-link
              :to="`/reports/${report.id}/edit`"
              class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Edit Report
            </router-link>
            <button
              @click="deleteReport"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
            >
              Delete Report
            </button>
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

const router = useRouter()
const route = useRoute()
const report = ref({})

const fetchReport = async (id) => {
  try {
    const response = await axios.get(`/api/reports/${id}`)
    report.value = response.data
  } catch (error) {
    console.error('Failed to fetch report:', error)
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const deleteReport = async () => {
  if (confirm('Are you sure you want to delete this report?')) {
    try {
      await axios.delete(`/api/reports/${report.value.id}`)
      if (window.notify) {
        window.notify.success('Success', 'Report deleted successfully')
      }
      router.push('/reports')
    } catch (error) {
      console.error('Failed to delete report:', error)
      if (window.notify) {
        window.notify.error('Error', 'Failed to delete report')
      }
    }
  }
}

onMounted(() => {
  fetchReport(route.params.id)
})
</script>
