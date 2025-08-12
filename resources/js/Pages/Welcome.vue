<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Browser Header Simulation -->
    <!-- <div class="bg-gray-800 text-white px-4 py-2 text-sm flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <div class="flex space-x-2">
          <button class="text-gray-400 hover:text-white">←</button>
          <button class="text-gray-400 hover:text-white">→</button>
          <button class="text-gray-400 hover:text-white">↻</button>
        </div>
        <div class="flex items-center space-x-2">
          <span class="text-green-400">🔒</span>
          <span>safadeco.coop</span>
        </div>
      </div>
      <div class="flex items-center space-x-2">
        <span class="text-gray-400">⚙️ 👤</span>
      </div>
    </div> -->

    <!-- Top Header Bar -->
    <div class="bg-white border-b border-gray-200 px-4 py-3">
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center space-x-8">
          <div class="flex items-center space-x-2 text-gray-600">
            <span class="text-red-500">📍</span>
            <span class="text-sm">J.S Reyes St., Bitan-o, Sorsogon City</span>
          </div>
          <div class="flex items-center space-x-2 text-gray-600">
            <span class="text-blue-500">✉️</span>
            <span class="text-sm">info@safadeco.com</span>
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <div class="relative">
            <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium flex items-center space-x-1">
              <span>Head Office</span>
              <span>▼</span>
            </button>
          </div>
          <button class="flex items-center space-x-1 text-gray-600 hover:text-gray-800">
            <span>👤</span>
            <!-- <span class="text-sm font-medium">Login</span> -->
             <Link :href="route('login')" class="text-sm font-medium">Login</Link>
          </button>
        </div>
      </div>
    </div>

    <!-- Yellow Header Section -->
    <div class="bg-yellow-400 px-4 py-6">
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Logo and Company Name -->
        <div class="flex items-center space-x-4">
          <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
              <span class="text-blue-600 text-xs font-bold">🌾</span>
            </div>
          </div>
          <div>
            <h1 class="text-4xl font-bold text-blue-800">SAFADECO</h1>
            <p class="text-xs text-blue-700 mt-1">Salvacion Farmers Development Cooperative Savings and Credit</p>
          </div>
        </div>

        <!-- Contact Information -->
        <div class="flex space-x-12">
          <div class="text-center">
            <div class="flex items-center space-x-2 text-gray-700 mb-1">
              <span class="text-red-500">📍</span>
              <span class="font-semibold">Main Office</span>
            </div>
            <p class="text-sm text-gray-800 font-medium">J. Reyes Street, Bitan-o, Sorsogon City</p>
          </div>
          <div class="text-center">
            <div class="flex items-center space-x-2 text-gray-700 mb-1">
              <span class="text-blue-500">✉️</span>
              <span class="font-semibold">Write us</span>
            </div>
            <p class="text-sm text-gray-800 font-medium">info@safadeco.com</p>
          </div>
          <div class="text-center">
            <div class="flex items-center space-x-2 text-gray-700 mb-1">
              <span class="text-green-500">📞</span>
              <span class="font-semibold">Call us</span>
            </div>
            <p class="text-sm text-gray-800 font-medium">09614393640</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="bg-blue-600 px-4 py-3">
      <div class="max-w-7xl mx-auto">
        <ul class="flex space-x-8">
          <li><a href="#" class="text-yellow-300 font-semibold hover:text-white transition-colors">HOME</a></li>
          <li><a href="#" class="text-white hover:text-yellow-300 transition-colors">ABOUT US</a></li>
          <li><a href="#" class="text-white hover:text-yellow-300 transition-colors flex items-center">PRODUCTS & SERVICES <span class="ml-1">▼</span></a></li>
          <li><a href="#" class="text-white hover:text-yellow-300 transition-colors flex items-center">MEMBERSHIP <span class="ml-1">▼</span></a></li>
          <li><a href="#" class="text-white hover:text-yellow-300 transition-colors">NEWS</a></li>
          <li><a href="#" class="text-white hover:text-yellow-300 transition-colors">BRANCHES</a></li>
          <li><a href="#" class="text-white hover:text-yellow-300 transition-colors">FEEDBACK</a></li>
          <li><a href="#" class="text-white hover:text-yellow-300 transition-colors">CAREERS</a></li>
        </ul>
      </div>
    </nav>

    <!-- Main Content Area -->
    <div class="relative h-96 bg-cover bg-center" style="background-image: url('/placeholder.svg?height=400&width=1200')">
      <div class="absolute inset-0 bg-black bg-opacity-30"></div>
      
      <!-- Content Overlay -->
      <div class="relative z-10 p-8">
        <div class="max-w-2xl">
          <!-- Updates Header -->
          <div class="border-2 border-yellow-400 inline-block mb-4">
            <div class="flex">
              <div class="bg-blue-600 text-white px-6 py-3">
                <h2 class="text-2xl font-bold">SAFADECO</h2>
              </div>
              <div class="bg-gray-800 text-white px-6 py-3">
                <h2 class="text-2xl font-bold">UPDATES</h2>
              </div>
            </div>
          </div>

          <!-- Content -->
          <div class="text-white">
            <h3 class="text-xl font-bold mb-4">Part 1 SUCCESSFULLY KICKED OFF!</h3>
            <p class="text-lg mb-4">What an exciting start to our <strong>BATIPON MONTH 2025</strong> celebration!</p>
            <p class="text-base">
              We thrilled to announce that the <strong>SAFADECO BATIPON</strong>
            </p>
          </div>
        </div>
      </div>

      <!-- Contact Us Button -->
      <div class="fixed bottom-6 right-6 z-20">
        <button class="bg-white text-gray-800 px-4 py-2 rounded-full shadow-lg hover:shadow-xl transition-shadow flex items-center space-x-2">
          <span>Contact us</span>
        </button>
        <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs">
          <span class="bg-red-500 w-4 h-4 rounded-full flex items-center justify-center text-white text-xs">1</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<style scoped>
/* Additional custom styles if needed */
</style>