<template>
  <div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Project Status Distribution</h3>
    <div class="h-64">
      <Doughnut :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { Doughnut } from 'vue-chartjs'
import {
  Chart as ChartJS,
  ArcElement,
  Tooltip,
  Legend
} from 'chart.js'

ChartJS.register(ArcElement, Tooltip, Legend)

const props = defineProps({
  projects: {
    type: Array,
    default: () => []
  }
})

const chartData = computed(() => {
  const statusCounts = props.projects.reduce((acc, project) => {
    acc[project.status] = (acc[project.status] || 0) + 1
    return acc
  }, {})

  return {
    labels: Object.keys(statusCounts).map(status =>
      status.charAt(0).toUpperCase() + status.slice(1)
    ),
    datasets: [{
      data: Object.values(statusCounts),
      backgroundColor: [
        '#10B981', // active - green
        '#F59E0B', // inactive - yellow
        '#6B7280'  // completed - gray
      ],
      borderWidth: 2,
      borderColor: '#ffffff'
    }]
  }
})

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'bottom',
      labels: {
        padding: 20,
        usePointStyle: true
      }
    },
    tooltip: {
      callbacks: {
        label: function(context) {
          const label = context.label || ''
          const value = context.parsed || 0
          const total = context.dataset.data.reduce((a, b) => a + b, 0)
          const percentage = Math.round((value / total) * 100)
          return `${label}: ${value} (${percentage}%)`
        }
      }
    }
  }
})
</script>
