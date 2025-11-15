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
            <router-link to="/boards/create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-md text-sm font-medium">
              Create Board
            </router-link>
          </div>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold text-gray-900">Boards</h1>
        </div>

        <div v-if="loading" class="text-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
          <p class="mt-4 text-gray-600">Loading boards...</p>
        </div>
        <div v-else-if="error" class="bg-red-50 border border-red-200 rounded-md p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">Error loading boards</h3>
              <div class="mt-2 text-sm text-red-700">{{ error }}</div>
            </div>
          </div>
        </div>
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" @dragover.prevent @drop="handleDrop">
          <div
            v-for="board in boards"
            :key="board.id"
            class="bg-white overflow-hidden shadow rounded-lg cursor-move"
            draggable="true"
            @dragstart="handleDragStart($event, board)"
            @dragover.prevent
            @drop="handleDropOnBoard($event, board)"
          >
            <div class="p-6">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">{{ board.name }}</h3>
                <span class="text-sm text-gray-500">Position: {{ board.position }}</span>
              </div>
              <p class="mt-2 text-sm text-gray-600">{{ board.description || 'No description' }}</p>
              <div class="mt-4 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                  <p>Project: {{ board.project?.name || 'Unknown' }}</p>
                  <p>Tasks: {{ board.tasks_count || 0 }}</p>
                </div>
                <div class="flex space-x-2">
                  <router-link :to="`/boards/${board.id}`" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    View
                  </router-link>
                  <router-link :to="`/boards/${board.id}/edit`" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                    Edit
                  </router-link>
                  <button @click="openDeleteModal(board)" class="text-red-600 hover:text-red-900 text-sm font-medium">
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="boards.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">No boards</h3>
          <p class="mt-1 text-sm text-gray-500">Get started by creating a new board.</p>
          <div class="mt-6">
            <router-link to="/boards/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
              <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
              Create Board
            </router-link>
          </div>
        </div>
      </div>
    </main>

    <Modal
      :is-open="showDeleteModal"
      title="Delete Board"
      :message="`Are you sure you want to delete the board '${boardToDelete?.name}'? This action cannot be undone.`"
      confirm-text="Delete Board"
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

const boards = ref([])
const loading = ref(true)
const error = ref(null)
const showDeleteModal = ref(false)
const boardToDelete = ref(null)
const deleteLoading = ref(false)
const draggedBoard = ref(null)

const fetchBoards = async () => {
  try {
    loading.value = true
    error.value = null
    const response = await axios.get('/api/boards')
    boards.value = response.data
  } catch (err) {
    console.error('Failed to fetch boards:', err)
    error.value = err.response?.data?.message || 'Failed to load boards'
  } finally {
    loading.value = false
  }
}

const openDeleteModal = (board) => {
  boardToDelete.value = board
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  boardToDelete.value = null
  deleteLoading.value = false
}

const confirmDelete = async () => {
  if (!boardToDelete.value) return

  deleteLoading.value = true
  try {
    await axios.delete(`/api/boards/${boardToDelete.value.id}`)
    boards.value = boards.value.filter(board => board.id !== boardToDelete.value.id)
    closeDeleteModal()
    if (window.notify) {
      window.notify.success('Success', 'Board deleted successfully')
    }
  } catch (err) {
    console.error('Failed to delete board:', err)
    if (window.notify) {
      window.notify.error('Error', 'Failed to delete board')
    }
  } finally {
    deleteLoading.value = false
  }
}

const handleDragStart = (event, board) => {
  draggedBoard.value = board
  event.dataTransfer.effectAllowed = 'move'
  event.dataTransfer.setData('text/html', event.target.outerHTML)
  event.target.style.opacity = '0.5'
}

const handleDropOnBoard = async (event, targetBoard) => {
  event.preventDefault()
  if (!draggedBoard.value || draggedBoard.value.id === targetBoard.id) return

  const draggedIndex = boards.value.findIndex(b => b.id === draggedBoard.value.id)
  const targetIndex = boards.value.findIndex(b => b.id === targetBoard.id)

  // Store original order for potential rollback
  const originalBoards = [...boards.value]

  // Reorder locally first
  const newBoards = [...boards.value]
  newBoards.splice(draggedIndex, 1)
  newBoards.splice(targetIndex, 0, draggedBoard.value)
  boards.value = newBoards

  // Update positions for all boards based on new order
  try {
    const positionUpdates = boards.value.map((board, index) => ({
      id: board.id,
      position: index
    }))

    // Update all positions in parallel
    await Promise.all(
      positionUpdates.map(update =>
        axios.patch(`/api/boards/${update.id}/position`, {
          position: update.position
        })
      )
    )

    if (window.notify) {
      window.notify.success('Success', 'Board reordered successfully')
    }
  } catch (err) {
    console.error('Failed to update board positions:', err)
    // Revert to original order on error
    boards.value = originalBoards
    if (window.notify) {
      window.notify.error('Error', 'Failed to reorder boards')
    }
  }
}

const handleDrop = (event) => {
  event.preventDefault()
  if (draggedBoard.value) {
    event.target.style.opacity = '1'
    draggedBoard.value = null
  }
}

onMounted(() => {
  fetchBoards()
})
</script>
