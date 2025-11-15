<template>
  <!-- Navigation -->
  <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <router-link to="/" class="flex-shrink-0">
            <h1 class="text-2xl font-bold text-indigo-600">Orbit</h1>
          </router-link>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-8">
          <router-link
            to="/"
            class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md hover:bg-gray-50"
          >
            Home
          </router-link>
          <router-link
            to="/about"
            class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md hover:bg-gray-50"
          >
            About
          </router-link>
          <router-link
            to="/features"
            class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md hover:bg-gray-50"
          >
            Features
          </router-link>
          <router-link
            to="/pricing"
            class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md hover:bg-gray-50"
          >
            Pricing
          </router-link>
          <router-link
            to="/contact"
            class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md hover:bg-gray-50"
          >
            Contact
          </router-link>
          <router-link
            to="/login"
            class="text-indigo-600 hover:text-indigo-800 px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md hover:bg-indigo-50"
          >
            Sign In
          </router-link>
          <router-link
            to="/register"
            class="bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Get Started
          </router-link>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center">
          <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="text-gray-700 hover:text-indigo-600 p-2 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Navigation -->
      <div v-show="mobileMenuOpen" class="md:hidden border-t border-gray-200 bg-white">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <router-link
            to="/"
            @click="mobileMenuOpen = false"
            class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md transition-colors duration-200"
          >
            Home
          </router-link>
          <router-link
            to="/about"
            @click="mobileMenuOpen = false"
            class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md transition-colors duration-200"
          >
            About
          </router-link>
          <router-link
            to="/features"
            @click="mobileMenuOpen = false"
            class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md transition-colors duration-200"
          >
            Features
          </router-link>
          <router-link
            to="/pricing"
            @click="mobileMenuOpen = false"
            class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md transition-colors duration-200"
          >
            Pricing
          </router-link>
          <router-link
            to="/contact"
            @click="mobileMenuOpen = false"
            class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md transition-colors duration-200"
          >
            Contact
          </router-link>
          <div class="border-t border-gray-200 pt-3 mt-3">
            <router-link
              to="/login"
              @click="mobileMenuOpen = false"
              class="block px-3 py-2 text-base font-medium text-indigo-600 hover:text-indigo-800 rounded-md hover:bg-indigo-50 transition-colors duration-200"
            >
              Sign In
            </router-link>
            <router-link
              to="/register"
              @click="mobileMenuOpen = false"
              class="block px-3 py-2 mt-1 text-base font-medium bg-indigo-600 text-white hover:bg-indigo-700 rounded-md text-center transition-colors duration-200 shadow-sm"
            >
              Get Started
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue'

const mobileMenuOpen = ref(false)
</script>
