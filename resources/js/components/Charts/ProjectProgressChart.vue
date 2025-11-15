<template>
  <div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Project Progress Overview</h3>
    <div class="h-64">
      <Line :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Line } from 'vue-chartjs'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

const props = defineProps({
  projects: {
    type: Array,
    default: () => []
  },
  tasks: {
    type: Array,
    default: () => []
  }
})

const chartData = computed(() => {
  // Get last 7 projects for the chart
  const recentProjects = props.projects.slice(-7)

  const projectNames = recentProjects.map(p => p.name.length > 15 ? p.name.substring(0, 15) + '...' : p.name)
  const completedTasks = recentProjects.map(project => {
    const projectTasks = props.tasks.filter(task => task.project_id === project.id)
    return projectTasks.filter(task => task.status === 'completed').length
  })
  const totalTasks = recentProjects.map(project => {
    return props.tasks.filter(task => task.project_id === project.id).length
  })

  return {
    labels: projectNames,
    datasets: [
      {
        label: 'Total Tasks',
        data: totalTasks,
        borderColor: '#3B82F6',
        backgroundColor: '#3B82F6',
        tension: 0.4,
        fill: false
      },
      {
        label: 'Completed Tasks',
        data: completedTasks,
        borderColor: '#10B981',
        backgroundColor: '#10B981',
        tension: 0.4,
        fill: false
      }
    ]
  }
})

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'top'
    },
    tooltip: {
      mode: 'index',
      intersect: false
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      ticks: {
        stepSize: 1
      }
    },
    x: {
      ticks: {
        maxRotation: 45,
        minRotation: 45
      }
    }
  },
  interaction: {
    mode: 'nearest',
    axis: 'x',
    intersect: false
  }
})
</script>
