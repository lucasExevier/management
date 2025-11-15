<template>
  <nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">
      <li>
        <div>
          <router-link
            to="/dashboard"
            class="text-gray-400 hover:text-gray-500 transition-colors"
          >
            <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10.707 2.293a1 1 0 00-1.414 0l-5.5 5.5A1 1 0 004 8.5V18a2 2 0 002 2h8a2 2 0 002-2V8.5a1 1 0 00-.293-.707l-5.5-5.5z"/>
            </svg>
            <span class="sr-only">Home</span>
          </router-link>
        </div>
      </li>
      <li v-for="(crumb, index) in breadcrumbs" :key="crumb.path" class="flex items-center">
        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
        </svg>
        <router-link
          v-if="index < breadcrumbs.length - 1"
          :to="crumb.path"
          class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors"
        >
          {{ crumb.label }}
        </router-link>
        <span
          v-else
          class="ml-2 text-sm font-medium text-gray-900"
        >
          {{ crumb.label }}
        </span>
      </li>
    </ol>
  </nav>
</template>

<script setup lang="js">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const breadcrumbs = computed(() => {
  const crumbs = []
  const matched = route.matched

  for (let i = 0; i < matched.length; i++) {
    const match = matched[i]
    if (match.meta && match.meta.breadcrumb) {
      const breadcrumb = match.meta.breadcrumb

      // Handle dynamic segments
      let label = breadcrumb.label
      let path = match.path

      // Replace dynamic segments in path and label
      if (match.params) {
        Object.keys(match.params).forEach(param => {
          const value = match.params[param]
          path = path.replace(`:${param}`, value)

          // If label contains param placeholder, replace it
          if (label.includes(`:${param}`)) {
            label = label.replace(`:${param}`, value)
          }
        })
      }

      crumbs.push({
        label,
        path
      })
    }
  }

  return crumbs
})
</script>
