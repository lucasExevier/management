<template>
  <!-- Navigation -->
  <Navigation />

  <!-- Hero Section -->
  <section class="bg-gradient-to-br from-slate-50 via-white to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
      <div class="text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
          Streamline Your
          <span class="text-indigo-600">Project Management</span>
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto leading-relaxed">
          Experience enterprise-grade project management with our intuitive platform.
          Track progress, collaborate seamlessly, and deliver exceptional results with confidence.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <router-link
            to="/register"
            class="bg-indigo-600 text-white px-8 py-3 rounded-md text-lg font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm"
          >
            Start Free Trial
          </router-link>
          <router-link
            to="/about"
            class="border border-gray-300 text-gray-700 px-8 py-3 rounded-md text-lg font-semibold hover:border-indigo-600 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
          >
            Learn More
          </router-link>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
          Everything you need to succeed
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Powerful features designed to help your team work smarter, not harder.
        </p>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg border border-gray-200 p-8 hover:shadow-md transition-shadow duration-200">
          <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-3">Project Tracking</h3>
          <p class="text-gray-600 leading-relaxed">Monitor project progress with real-time dashboards and comprehensive reporting tools that keep your team informed and on track.</p>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-8 hover:shadow-md transition-shadow duration-200">
          <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-3">Team Collaboration</h3>
          <p class="text-gray-600 leading-relaxed">Foster seamless communication and collaboration across your entire organization with integrated tools and real-time updates.</p>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-8 hover:shadow-md transition-shadow duration-200">
          <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-3">Lightning Fast</h3>
          <p class="text-gray-600 leading-relaxed">Experience blazing-fast performance with our optimized platform and intuitive interface designed for productivity.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="bg-indigo-600 py-16">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-white mb-4">
        Ready to transform your workflow?
      </h2>
      <p class="text-xl text-indigo-100 mb-8">
        Join thousands of teams already using our platform to achieve their goals.
      </p>
      <router-link
        to="/register"
        class="bg-white text-indigo-600 px-8 py-3 rounded-md text-lg font-semibold hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors duration-200 shadow-sm"
      >
        Get Started Today
      </router-link>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-4 gap-8">
        <div>
          <h3 class="text-xl font-bold mb-4">Orbit</h3>
          <p class="text-gray-400">Enterprise-grade project management for modern teams.</p>
        </div>
        <div>
          <h4 class="font-semibold mb-4 text-gray-300">Product</h4>
          <ul class="space-y-2 text-gray-400">
            <li><router-link to="/features" class="hover:text-white transition-colors duration-200">Features</router-link></li>
            <li><router-link to="/pricing" class="hover:text-white transition-colors duration-200">Pricing</router-link></li>
            <li><router-link to="/about" class="hover:text-white transition-colors duration-200">About</router-link></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-4 text-gray-300">Support</h4>
          <ul class="space-y-2 text-gray-400">
            <li><router-link to="/contact" class="hover:text-white transition-colors duration-200">Contact</router-link></li>
            <li><a href="#" class="hover:text-white transition-colors duration-200">Help Center</a></li>
            <li><a href="#" class="hover:text-white transition-colors duration-200">Documentation</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-4 text-gray-300">Company</h4>
          <ul class="space-y-2 text-gray-400">
            <li><a href="#" class="hover:text-white transition-colors duration-200">Blog</a></li>
            <li><a href="#" class="hover:text-white transition-colors duration-200">Careers</a></li>
            <li><a href="#" class="hover:text-white transition-colors duration-200">Privacy</a></li>
          </ul>
        </div>
      </div>
      <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
        <p>&copy; 2024 Orbit. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import Navigation from '../components/Navigation.vue'
</script>
