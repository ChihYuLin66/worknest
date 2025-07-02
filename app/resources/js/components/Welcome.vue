<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-16">
      <div class="text-center">
        <h1 class="text-5xl font-bold text-gray-900 mb-6">
          Welcome to <span class="text-indigo-600">WorkNest</span>
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
          Your comprehensive workspace management solution. Organize, collaborate, and achieve more with our powerful tools.
        </p>
        <div class="space-x-4">
          <router-link 
            to="/dashboard" 
            class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300"
          >
            Get Started
          </router-link>
          <a 
            href="#features" 
            class="inline-block border border-indigo-600 text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition duration-300"
          >
            Learn More
          </a>
        </div>
      </div>
      
      <div id="features" class="mt-20 grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <div class="text-indigo-600 text-3xl mb-4">📊</div>
          <h3 class="text-xl font-semibold mb-2">Analytics Dashboard</h3>
          <p class="text-gray-600">Track your progress with comprehensive analytics and insights.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <div class="text-indigo-600 text-3xl mb-4">👥</div>
          <h3 class="text-xl font-semibold mb-2">Team Collaboration</h3>
          <p class="text-gray-600">Work together seamlessly with your team members.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <div class="text-indigo-600 text-3xl mb-4">⚡</div>
          <h3 class="text-xl font-semibold mb-2">Fast & Efficient</h3>
          <p class="text-gray-600">Built for speed and efficiency to boost your productivity.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Welcome'
}
</script>
