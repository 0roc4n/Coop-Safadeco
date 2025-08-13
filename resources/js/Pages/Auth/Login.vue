<template>
  <Head title="Login" />
  <div class="min-h-screen bg-gray-50">
    <!-- Header with SAFADECO branding -->
    <div class="bg-yellow-400 px-4 py-6">
      <div class="max-w-md mx-auto flex items-center justify-center">
        <div class="flex items-center space-x-3">
          <!-- SAFADECO Logo placeholder -->
          <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
            <span class="text-white font-bold text-lg">S</span>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-blue-800">SAFADECO</h1>
            <p class="text-xs text-blue-700">Salvation Farmers Development Cooperative Savings and Credit</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Login Form Container -->
    <div class="flex items-center justify-center px-4 py-12">
      <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
          <!-- Card Header -->
          <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white text-center">Login</h2>
            <p class="text-blue-100 text-sm text-center mt-1">Access your SAFADECO account</p>
          </div>

          <!-- Card Body -->
          <div class="px-6 py-8">
            <!-- Status Message -->
            <div v-if="status" class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md text-sm">
              {{ status }}
            </div>

            <!-- Login Form -->
            <form @submit.prevent="handleSubmit" class="space-y-6">
              <!-- Email Field -->
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                  Email Address
                </label>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  required
                  autofocus
                  autocomplete="username"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Enter your email"
                />
                <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
              </div>

              <!-- Password Field -->
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                  Password
                </label>
                <input
                  id="password"
                  v-model="form.password"
                  type="password"
                  required
                  autocomplete="current-password"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Enter your password"
                />
                <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</p>
              </div>

              <!-- Remember Me Checkbox -->
              <div class="flex items-center">
                <input
                  id="remember"
                  v-model="form.remember"
                  type="checkbox"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                  Remember me
                </label>
              </div>

              <!-- Form Actions -->
              <div class="flex items-center justify-between">
                <a
                  href="#"
                  class="text-sm text-blue-600 hover:text-blue-800 underline focus:outline-none focus:ring-2 focus:ring-blue-500 rounded"
                >
                  Forgot your password?
                </a>

                <button
                  type="submit"
                  :disabled="processing"
                  :class="{ 'opacity-50 cursor-not-allowed': processing }"
                  class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200"
                >
                  <span v-if="processing">Signing in...</span>
                  <span v-else>Sign In</span>
                </button>
              </div>
            </form>
          </div>

          <!-- Card Footer -->
          <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <p class="text-center text-sm text-gray-600">
              Need help? Contact us at 
              <a href="mailto:info@safadeco.com" class="text-blue-600 hover:text-blue-800">info@safadeco.com</a>
            </p>
          </div>
        </div>

        <!-- Additional Links -->
        <div class="mt-6 text-center">
          <p class="text-sm text-gray-600">
            Not a member yet? 
            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Apply for membership</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'

// Form state
const form = reactive({
  email: '',
  password: '',
  remember: false
})

// Component state
const processing = ref(false)
const status = ref('')
const errors = reactive({
  email: '',
  password: ''
})

// Form submission handler
const handleSubmit = async () => {
  errors.email = ''
  errors.password = ''
  status.value = ''
  processing.value = true

  try {
    // Use Inertia to post to Laravel Jetstream login route
    await router.post('/login', {
      email: form.email,
      password: form.password,
      remember: form.remember,
    }, {
      onError: (err) => {
        errors.email = err.email || ''
        errors.password = err.password || ''
      },
      onSuccess: () => {
        status.value = 'Login successful! Redirecting...'
        form.password = ''
      },
      onFinish: () => {
        processing.value = false
      }
    })
  } catch (error) {
    errors.email = 'Login failed. Please try again.'
    processing.value = false
  }
}
</script>