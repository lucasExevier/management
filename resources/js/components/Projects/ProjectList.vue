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
            <router-link to="/projects/create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-md text-sm font-medium">
              Create Project
            </router-link>
          </div>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold text-gray-900">Projects</h1>
        </div>

        <div v-if="loading" class="text-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
          <p class="mt-4 text-gray-600">Loading projects...</p>
        </div>
        <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-md p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">Error loading projects</h3>
              <div class="mt-2 text-sm text-red-700">{{ error }}</div>
            </div>
          </div>
        </div>
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="project in projects" :key="project.id" class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">{{ project.name }}</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="{
                        'bg-green-100 text-green-800': project.status === 'active',
                        'bg-yellow-100 text-yellow-800': project.status === 'inactive',
                        'bg-gray-100 text-gray-800': project.status === 'completed'
                      }">
                  {{ project.status }}
                </span>
              </div>
              <p class="mt-2 text-sm text-gray-600">{{ project.description || 'No description' }}</p>
              <div class="mt-4 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                  <p>Tasks: {{ project.tasks_count || 0 }}</p>
                  <p>Boards: {{ project.boards_count || 0 }}</p>
                </div>
                <div class="flex space-x-2">
                  <router-link :to="`/projects/${project.id}`" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    View
                  </router-link>
                  <router-link :to="`/projects/${project.id}/edit`" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                    Edit
                  </router-link>
                  <button @click="openDeleteModal(project)" class="text-red-600 hover:text-red-900 text-sm font-medium">
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="projects.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">No projects</h3>
          <p class="mt-1 text-sm text-gray-500">Get started by creating a new project.</p>
          <div class="mt-6">
            <router-link to="/projects/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
              <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
              Create Project
            </router-link>
          </div>
        </div>
      </div>
    </main>

    <Modal
      :is-open="showDeleteModal"
      title="Delete Project"
      :message="`Are you sure you want to delete the project '${projectToDelete?.name}'? This action cannot be undone.`"
      confirm-text="Delete Project"
      :loading="deleteLoading"
      @confirm="confirmDelete"
      @cancel="closeDeleteModal"
    />
  </div>
</template>

<script setup lang="js">
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Modal from '../Modal.vue'

const projects = ref([])
const loading = ref(true)
const error = ref(null)
const showDeleteModal = ref(false)
const projectToDelete = ref(null)
const deleteLoading = ref(false)

const fetchProjects = async () => {
  try {
    loading.value = true
    error.value = null
    const response = await axios.get('/api/projects')
    projects.value = response.data
  } catch (err) {
    console.error('Failed to fetch projects:', err)
    error.value = err.response?.data?.message || 'Failed to load projects'
  } finally {
    loading.value = false
  }
}

const openDeleteModal = (project) => {
  projectToDelete.value = project
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  projectToDelete.value = null
  deleteLoading.value = false
}

const confirmDelete = async () => {
  if (!projectToDelete.value) return

  deleteLoading.value = true
  try {
    await axios.delete(`/api/projects/${projectToDelete.value.id}`)
    projects.value = projects.value.filter(project => project.id !== projectToDelete.value.id)
    closeDeleteModal()
    if (window.notify) {
      window.notify.success('Success', 'Project deleted successfully')
    }
  } catch (err) {
    console.error('Failed to delete project:', err)
    if (window.notify) {
      window.notify.error('Error', 'Failed to delete project')
    }
  } finally {
    deleteLoading.value = false
  }
}

onMounted(() => {
  fetchProjects()
})
</script>
