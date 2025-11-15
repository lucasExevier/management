<template>
  <div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Task Status Distribution</h3>
    <div class="h-64">
      <Bar :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'

ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend
)

const props = defineProps({
  tasks: {
    type: Array,
    default: () => []
  }
})

const chartData = computed(() => {
  const statusCounts = props.tasks.reduce((acc, task) => {
    acc[task.status] = (acc[task.status] || 0) + 1
    return acc
  }, {})

  return {
    labels: Object.keys(statusCounts).map(status =>
      status.charAt(0).toUpperCase() + status.slice(1)
    ),
    datasets: [{
      label: 'Tasks',
      data: Object.values(statusCounts),
      backgroundColor: [
        '#3B82F6', // todo - blue
        '#F59E0B', // in_progress - yellow
        '#10B981', // completed - green
        '#EF4444'  // cancelled - red
      ],
      borderWidth: 1,
      borderColor: '#ffffff'
    }]
  }
})

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    },
    tooltip: {
      callbacks: {
        label: function(context) {
          return `Tasks: ${context.parsed.y}`
        }
      }
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      ticks: {
        stepSize: 1
      }
    }
  }
})
</script>
