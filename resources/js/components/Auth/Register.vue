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
            Create your account
          </h2>
        </div>
        <form class="mt-8 space-y-6" @submit.prevent="handleRegister">
          <div class="space-y-4">
            <InputText
              id="name"
              label="Full Name"
              type="text"
              placeholder="Full Name"
              autocomplete="name"
              required
              :error="errors.name ? errors.name[0] : false"
              v-model="form.name"
            />

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
              autocomplete="new-password"
              required
              :error="errors.password ? errors.password[0] : false"
              v-model="form.password"
            />

            <InputText
              id="password_confirmation"
              label="Confirm Password"
              type="password"
              placeholder="Confirm Password"
              autocomplete="new-password"
              required
              :error="errors.password_confirmation ? errors.password_confirmation[0] : false"
              v-model="form.password_confirmation"
            />
          </div>

          <div v-if="error" class="text-red-600 text-sm text-center">
            {{ error }}
          </div>

          <FormActions
            :loading="loading"
            :show-cancel="false"
            submit-text="Create Account"
            loading-text="Creating Account..."
          />

          <div class="text-center">
            <router-link to="/login" class="font-medium text-indigo-600 hover:text-indigo-500">
              Already have an account? Sign in
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
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})
const loading = ref(false)
const error = ref('')
const errors = ref({})

const handleRegister = async () => {
  loading.value = true
  error.value = ''
  errors.value = {}
  try {
    await axios.post('/api/register', form.value)
    if (window.notify) {
      window.notify.success('Registration Successful', 'Please sign in with your new account')
    }
    router.push('/login')
  } catch (err) {
    if (err.response?.data?.errors) {
      errors.value = err.response.data.errors
    } else {
      error.value = err.response?.data?.message || 'Registration failed'
      if (window.notify) {
        window.notify.error('Registration Failed', error.value)
      }
    }
  } finally {
    loading.value = false
  }
}
</script>
