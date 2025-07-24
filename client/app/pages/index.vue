<template>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center">
      <div class="max-w-md w-full space-y-8 text-center">
        <div>
          <h1 class="text-4xl font-bold text-gray-900 mb-4">Project Management</h1>
          <p class="text-lg text-gray-600 mb-8">Track and manage your project issues efficiently</p>
          
          <div class="space-y-4">
            <NuxtLink
              to="/issues"
              class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
            >
              View All Issues
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  useHead({
    title: 'Project Management - Issue Tracker'
  })
  </script>