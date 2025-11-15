<template>
  <nav class="bg-white shadow-sm border-b border-gray-200 px-6 py-3">
    <div class="flex items-center justify-between">
      <!-- Left side - Search bar -->
      <div class="flex-1 max-w-md">
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
          <input
            type="text"
            placeholder="Search projects, tasks, boards..."
            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            v-model="searchQuery"
            @input="handleSearch"
          >
        </div>
      </div>

      <!-- Right side - Action icons -->
      <div class="flex items-center space-x-4">
        <!-- Messages Dropdown -->
        <MessagesDropdown
          :unread-message-count="unreadMessageCount"
          :has-new-messages="hasNewMessages"
          @close="closeMessagesDropdown"
        />

        <!-- Notifications Dropdown -->
        <NotificationsDropdown
          :unread-notification-count="unreadNotificationCount"
          :has-new-notifications="hasNewNotifications"
          @close="closeNotificationsDropdown"
        />

        <!-- Settings -->
        <button
          @click="openSettings"
          class="p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md"
        >
          <span class="sr-only">Settings</span>
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
        </button>

        <!-- Quick Actions Dropdown -->
        <div class="relative">
          <button
            @click="toggleQuickActions"
            class="p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md"
          >
            <span class="sr-only">Quick actions</span>
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
          </button>

          <!-- Quick Actions Dropdown Menu -->
          <div
            v-if="showQuickActions"
            class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10"
            @click.stop
          >
            <div class="py-1">
              <router-link
                to="/projects/create"
                @click="closeQuickActions"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
              >
                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                New Project
              </router-link>
              <router-link
                to="/tasks/create"
                @click="closeQuickActions"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
              >
                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                New Task
              </router-link>
              <router-link
                to="/boards/create"
                @click="closeQuickActions"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
              >
                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                New Board
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>


  </nav>
</template>

<script setup lang="js">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import MessagesDropdown from './MessagesDropdown.vue'
import NotificationsDropdown from './NotificationsDropdown.vue'

const router = useRouter()

const searchQuery = ref('')
const showQuickActions = ref(false)
const unreadMessageCount = ref(0)
const unreadNotificationCount = ref(0)
const hasNewMessages = ref(false)
const hasNewNotifications = ref(false)

const handleSearch = () => {
  // Implement search functionality
  if (searchQuery.value.trim()) {
    // Navigate to search results or emit event
    console.log('Searching for:', searchQuery.value)
  }
}

const closeMessagesDropdown = () => {
  // Handle messages dropdown close if needed
}

const closeNotificationsDropdown = () => {
  // Handle notifications dropdown close if needed
}

const openSettings = () => {
  // Navigate to settings page
  router.push('/settings')
}

const toggleQuickActions = () => {
  showQuickActions.value = !showQuickActions.value
}

const closeQuickActions = () => {
  showQuickActions.value = false
}

// Simulate fetching notification counts
const fetchNotificationCounts = async () => {
  // In a real app, this would fetch from API
  unreadMessageCount.value = 3
  unreadNotificationCount.value = 5
  hasNewMessages.value = unreadMessageCount.value > 0
  hasNewNotifications.value = unreadNotificationCount.value > 0
}

onMounted(() => {
  fetchNotificationCounts()
})
</script>
