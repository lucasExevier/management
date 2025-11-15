<template>
  <!-- Navigation -->
  <Navigation />

  <!-- Hero Section -->
  <section class="bg-gradient-to-br from-indigo-50 via-white to-cyan-50 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
          About <span class="text-indigo-600">Orbit</span>
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
          We're revolutionizing project management by empowering teams to collaborate seamlessly,
          track progress effortlessly, and deliver exceptional results.
        </p>
      </div>
    </div>
  </section>

  <!-- Mission Section -->
  <section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-2 gap-16 items-center">
        <div>
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
            Our Mission
          </h2>
          <p class="text-lg text-gray-600 mb-6">
            At Orbit, we believe that great projects are built by great teams. Our mission is to provide
            the tools and insights that help organizations achieve their goals faster, more efficiently,
            and with greater collaboration than ever before.
          </p>
          <p class="text-lg text-gray-600">
            We combine cutting-edge technology with intuitive design to create a platform that adapts
            to your workflow, not the other way around.
          </p>
        </div>
        <div class="relative">
          <div class="aspect-w-4 aspect-h-3 bg-gradient-to-br from-indigo-100 to-cyan-100 rounded-lg flex items-center justify-center">
            <svg class="w-32 h-32 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Values Section -->
  <section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
          Our Values
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          The principles that guide everything we do
        </p>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="text-center p-6">
          <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Innovation</h3>
          <p class="text-gray-600">We constantly push boundaries to deliver cutting-edge solutions that solve real problems.</p>
        </div>

        <div class="text-center p-6">
          <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Collaboration</h3>
          <p class="text-gray-600">We believe in the power of teamwork and building solutions that bring people together.</p>
        </div>

        <div class="text-center p-6">
          <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Excellence</h3>
          <p class="text-gray-600">We strive for perfection in every aspect of our product and service delivery.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="bg-indigo-600 py-16">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-white mb-4">
        Ready to join the Orbit revolution?
      </h2>
      <p class="text-xl text-indigo-100 mb-8">
        Start your free trial today and experience the future of project management.
      </p>
      <router-link to="/register" class="bg-white text-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-50 transition-colors duration-200">
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
          <p class="text-gray-400">Revolutionizing project management for modern teams.</p>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Product</h4>
          <ul class="space-y-2 text-gray-400">
            <li><router-link to="/features" class="hover:text-white">Features</router-link></li>
            <li><router-link to="/pricing" class="hover:text-white">Pricing</router-link></li>
            <li><router-link to="/about" class="hover:text-white">About</router-link></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Support</h4>
          <ul class="space-y-2 text-gray-400">
            <li><router-link to="/contact" class="hover:text-white">Contact</router-link></li>
            <li><a href="#" class="hover:text-white">Help Center</a></li>
            <li><a href="#" class="hover:text-white">Documentation</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Company</h4>
          <ul class="space-y-2 text-gray-400">
            <li><a href="#" class="hover:text-white">Blog</a></li>
            <li><a href="#" class="hover:text-white">Careers</a></li>
            <li><a href="#" class="hover:text-white">Privacy</a></li>
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
