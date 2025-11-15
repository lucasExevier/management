        <!-- Header -->
       <template>
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
          <h1 class="text-3xl font-bold text-gray-900">{{ isEditing ? 'Edit Report' : 'Create New Report' }}</h1>
          <p class="mt-2 text-gray-600">
            {{ isEditing ? 'Update your daily report details.' : 'Fill in the details below to create a new daily report.' }}
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                  {{ isEditing ? 'Update Your Report' : 'Create Daily Report' }}
                </h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                  {{ isEditing
                    ? 'Make changes to your daily report, update progress, and ensure everything is accurately reflected.'
                    : 'Document your daily progress. Track completed tasks, work in progress, issues encountered, and plans for the future.'
                  }}
                </p>
                <div class="grid grid-cols-2 gap-4 text-center">
                  <div class="bg-white/60 rounded-lg p-4">
                    <div class="text-2xl font-bold text-indigo-600 mb-1">{{ tasks.length }}</div>
                    <div class="text-sm text-gray-600">Tasks Completed</div>
                  </div>
                  <div class="bg-white/60 rounded-lg p-4">
                    <div class="text-2xl font-bold text-blue-600 mb-1">{{ workInProgress.length }}</div>
                    <div class="text-sm text-gray-600">Work in Progress</div>
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
                  <InputDate
                    id="report_date"
                    label="Report Date"
                    :error="errors.report_date ? errors.report_date[0] : false"
                    v-model="form.report_date"
                    :max="today"
                  />

                  <!-- Tasks Section -->
                  <div class="space-y-4">
                    <div class="flex items-center justify-between">
                      <h3 class="text-lg font-medium text-gray-900">Completed Tasks</h3>
                      <button
                        type="button"
                        @click="addTask"
                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Task
                      </button>
                    </div>
                    <div v-for="(task, index) in form.tasks" :key="index" class="flex items-center space-x-2">
                      <InputText
                        :id="`task-${index}`"
                        placeholder="Enter completed task"
                        v-model="form.tasks[index]"
                        class="flex-1"
                      />
                      <button
                        type="button"
                        @click="removeTask(index)"
                        class="inline-flex items-center px-2 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                      </button>
                    </div>
                  </div>

                  <!-- Work in Progress Section -->
                  <div class="space-y-4">
                    <div class="flex items-center justify-between">
                      <h3 class="text-lg font-medium text-gray-900">Work in Progress</h3>
                      <button
                        type="button"
                        @click="addWorkInProgress"
                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Item
                      </button>
                    </div>
                    <div v-for="(item, index) in form.work_in_progress" :key="index" class="flex items-center space-x-2">
                      <InputText
                        :id="`wip-${index}`"
                        placeholder="Enter work in progress"
                        v-model="form.work_in_progress[index]"
                        class="flex-1"
                      />
                      <button
                        type="button"
                        @click="removeWorkInProgress(index)"
                        class="inline-flex items-center px-2 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                      </button>
                    </div>
                  </div>

                  <!-- Issues Section -->
                  <div class="space-y-4">
                    <div class="flex items-center justify-between">
                      <h3 class="text-lg font-medium text-gray-900">Issues Encountered</h3>
                      <button
                        type="button"
                        @click="addIssue"
                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Issue
                      </button>
                    </div>
                    <div v-for="(issue, index) in form.issues" :key="index" class="flex items-center space-x-2">
                      <InputText
                        :id="`issue-${index}`"
                        placeholder="Enter issue encountered"
                        v-model="form.issues[index]"
                        class="flex-1"
                      />
                      <button
                        type="button"
                        @click="removeIssue(index)"
                        class="inline-flex items-center px-2 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                      </button>
                    </div>
                  </div>

                  <!-- Plans Section -->
                  <div class="space-y-4">
                    <div class="flex items-center justify-between">
                      <h3 class="text-lg font-medium text-gray-900">Plans for Next Period</h3>
                      <button
                        type="button"
                        @click="addPlan"
                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Plan
                      </button>
                    </div>
                    <div v-for="(plan, index) in form.plans" :key="index" class="flex items-center space-x-2">
                      <InputText
                        :id="`plan-${index}`"
                        placeholder="Enter plan for next period"
                        v-model="form.plans[index]"
                        class="flex-1"
                      />
                      <button
                        type="button"
                        @click="removePlan(index)"
                        class="inline-flex items-center px-2 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                      </button>
                    </div>
                  </div>

              <!-- Form Actions -->
              <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
                <FormActions
                  :loading="loading"
                  :show-cancel="true"
                  :show-submit="true"
                  cancel-text="Cancel"
                  :submit-text="isEditing ? 'Update Report' : 'Create Report'"
                  loading-text="Saving..."
                  @cancel="$router.go(-1)"
                />
              </div>
              </form>
              </div>
            </div>
          </div>
        </div>
   
</template>

<script setup lang="js">
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'
import InputText from '../Form/InputText.vue'
import InputDate from '../Form/InputDate.vue'
import FormActions from '../Form/FormActions.vue'

const router = useRouter()
const route = useRoute()
const isEditing = ref(false)
const loading = ref(false)
const errors = ref({})
const form = ref({
  report_date: new Date().toISOString().split('T')[0],
  tasks: [''],
  work_in_progress: [''],
  issues: [''],
  plans: ['']
})

const today = computed(() => {
  return new Date().toISOString().split('T')[0]
})

const tasks = computed(() => form.value.tasks.filter(task => task.trim()))
const workInProgress = computed(() => form.value.work_in_progress.filter(item => item.trim()))

const addTask = () => {
  form.value.tasks.push('')
}

const removeTask = (index) => {
  if (form.value.tasks.length > 1) {
    form.value.tasks.splice(index, 1)
  }
}

const addWorkInProgress = () => {
  form.value.work_in_progress.push('')
}

const removeWorkInProgress = (index) => {
  if (form.value.work_in_progress.length > 1) {
    form.value.work_in_progress.splice(index, 1)
  }
}

const addIssue = () => {
  form.value.issues.push('')
}

const removeIssue = (index) => {
  if (form.value.issues.length > 1) {
    form.value.issues.splice(index, 1)
  }
}

const addPlan = () => {
  form.value.plans.push('')
}

const removePlan = (index) => {
  if (form.value.plans.length > 1) {
    form.value.plans.splice(index, 1)
  }
}

const fetchReport = async (id) => {
  try {
    const response = await axios.get(`/api/reports/${id}`)
    const report = response.data
    form.value = {
      report_date: report.report_date,
      tasks: report.tasks && report.tasks.length > 0 ? report.tasks : [''],
      work_in_progress: report.work_in_progress && report.work_in_progress.length > 0 ? report.work_in_progress : [''],
      issues: report.issues && report.issues.length > 0 ? report.issues : [''],
      plans: report.plans && report.plans.length > 0 ? report.plans : ['']
    }
  } catch (error) {
    console.error('Failed to fetch report:', error)
  }
}

const handleSubmit = async () => {
  // Filter out empty strings
  const cleanedForm = {
    report_date: form.value.report_date,
    tasks: form.value.tasks.filter(task => task.trim()),
    work_in_progress: form.value.work_in_progress.filter(item => item.trim()),
    issues: form.value.issues.filter(issue => issue.trim()),
    plans: form.value.plans.filter(plan => plan.trim())
  }

  loading.value = true
  errors.value = {}
  try {
    if (isEditing.value) {
      await axios.put(`/api/reports/${route.params.id}`, cleanedForm)
      if (window.notify) {
        window.notify.success('Success', 'Report updated successfully')
      }
    } else {
      await axios.post('/api/reports', cleanedForm)
      if (window.notify) {
        window.notify.success('Success', 'Report created successfully')
      }
    }
    router.push('/reports')
  } catch (error) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
    } else {
      if (window.notify) {
        window.notify.error('Error', 'Failed to save report')
      }
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  if (route.params.id) {
    isEditing.value = true
    fetchReport(route.params.id)
  }
})
</script>
