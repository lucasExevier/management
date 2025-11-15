<template>
  <!-- Navigation -->
  <Navigation />

  <div class="min-h-screen flex">
    <!-- Left side - Image -->
    <div class="hidden lg:flex lg:w-1/2 bg-gray-100">
      <img src="http://127.0.0.1:8000/images/project.jpg" alt="Project Management" class="w-full h-full object-cover object-center" onerror="this.style.display='none'">
    </div>

    <!-- Right side - Form -->
    <div class="flex-1 flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 lg:w-1/2">
      <div class="max-w-md w-full space-y-8">
        <div>
          <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Sign in to your account
          </h2>
        </div>
        <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
          <div class="space-y-4">
            <InputText
              id="email"
              label="Email address"
              type="email"
              placeholder="Email address"
              autocomplete="email"
              required
              :error="errors.email ? errors.email[0] : false"
              v-model="form.email"
            />

            <InputText
              id="password"
              label="Password"
              type="password"
              placeholder="Password"
              autocomplete="current-password"
              required
              :error="errors.password ? errors.password[0] : false"
              v-model="form.password"
            />
          </div>

          <FormActions
            :loading="loading"
            :show-cancel="false"
            submit-text="Sign in"
            loading-text="Signing in..."
          />

          <div class="text-center">
            <router-link to="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
              Don't have an account? Register
            </router-link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="js">
import Navigation from '../Navigation.vue'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import InputText from '../Form/InputText.vue'
import FormActions from '../Form/FormActions.vue'

const router = useRouter()
const form = ref({
  email: '',
  password: ''
})
const loading = ref(false)
const error = ref('')
const errors = ref({})

const handleLogin = async () => {
  loading.value = true
  error.value = ''
  errors.value = {}
  try {
    const response = await axios.post('/api/login', form.value)
    localStorage.setItem('token', response.data.token)
    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`
    router.push('/dashboard')
  } catch (err) {
    if (err.response?.data?.errors) {
      errors.value = err.response.data.errors
    } else {
      error.value = err.response?.data?.message || 'Login failed'
      if (window.notify) {
        window.notify.error('Login Failed', error.value)
      }
    }
  } finally {
    loading.value = false
  }
}
</script>
