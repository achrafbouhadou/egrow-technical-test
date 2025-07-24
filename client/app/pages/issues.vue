<template>
    <div class="min-h-screen bg-gray-50 py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900">Issues</h1>
          <p class="mt-2 text-gray-600">Manage and track all project issues</p>
        </div>
  
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
          <h2 class="text-lg font-medium text-gray-900 mb-4">Filters</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
              <div class="space-y-2">
                <label v-for="status in statusOptions" :key="status.value" class="flex items-center">
                  <input v-model="selectedStatuses" :value="status.value" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                  <span class="ml-2 text-sm text-gray-600">{{ status.label }}</span>
                </label>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
              <select v-model="selectedPriority" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Priorities</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Assigned User</label>
              <input v-model="assignedUser" type="text" placeholder="Enter username..." class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Project</label>
              <select v-model="selectedProject" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Projects</option>
                <option value="1">earum explicabo occaecati</option>
                <option value="2">est nihil nulla</option>
                <option value="3">tempore alias suscipit</option>
              </select>
            </div>
          </div>
          <div class="mt-4 flex justify-end">
            <button @click="clearFilters" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
              Clear Filters
            </button>
          </div>
        </div>
  
        <div v-if="pending" class="text-center py-12 text-gray-500">
          <p>Loading issues...</p>
        </div>
  
        <div v-else-if="data" class="space-y-4">
          <div v-for="issue in data.data" :key="issue.id" class=" bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow" :class="{ 'border-l-4 border-l-red-500': issue.priority === 'high' }">
               <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="flex items-center space-x-3 mb-2">
                    <h3 class="text-lg font-bold text-gray-900">{{ issue.title }}</h3>
                    <span class="text-sm text-gray-500">#{{ issue.id }}</span>
                  </div>
                  
                  <p class="text-sm text-gray-600 mb-3">{{ issue.project.name }}</p>
                  
                  <p class="text-gray-700 mb-4">{{ issue.description }}</p>
                  
                  <div class="flex items-center space-x-4">
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="getStatusBadgeClass(issue.status)"
                    >
                      {{ getStatusLabel(issue.status) }}
                    </span>
                    
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="getPriorityBadgeClass(issue.priority)"
                    >
                      {{ getPriorityLabel(issue.priority) }}
                    </span>
                    
                    <div class="flex items-center text-sm text-gray-600">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                      {{ issue.assigned_to || 'Unassigned' }}
                    </div>
                  </div>
                </div>
                
                <div v-if="issue.priority === 'high'" class="flex-shrink-0 ml-4">
                  <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                </div>
              </div>
              
              <div class="mt-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
                Created: {{ formatDate(issue.created_at) }} • Updated: {{ formatDate(issue.updated_at) }}
                <NuxtLink :to="`/projects/${issue.project.id}/issues-summary`" class="ml-2 text-blue-600 hover:underline">View</NuxtLink>
              </div>
          </div>
  
          <div v-if="data.data.length === 0" class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No issues found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your filters to see more results.</p>
          </div>
  
          <div v-if="data.meta && data.meta.last_page > 1" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">
             <div class="flex-1 flex justify-between sm:hidden">
                <button
                  @click="goToPage(data.meta.current_page - 1)"
                  :disabled="data.meta.current_page === 1"
                  class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  Previous
                </button>
                <button
                  @click="goToPage(data.meta.current_page + 1)"
                  :disabled="data.meta.current_page === data.meta.last_page"
                  class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  Next
                </button>
              </div>
              <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ data.meta.from }}</span> to <span class="font-medium">{{ data.meta.to }}</span> of
                    <span class="font-medium">{{ data.meta.total }}</span> results
                  </p>
                </div>
                <div>
                  <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                    <button
                      @click="goToPage(data.meta.current_page - 1)"
                      :disabled="data.meta.current_page === 1"
                      class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                      Previous
                    </button>
                    
                    
                    <button
                      @click="goToPage(data.meta.current_page + 1)"
                      :disabled="data.meta.current_page === data.meta.last_page"
                      class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                      Next
                    </button>
                  </nav>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { refDebounced } from '@vueuse/core'
  const config = useRuntimeConfig()
  
  const selectedStatuses = ref<string[]>([])
  const selectedPriority = ref('')
  const assignedUser = ref('')
  const selectedProject = ref('')
  const currentPage = ref(1)
  
  const statusOptions = [
    { value: 'open', label: 'Open' },
    { value: 'in_progress', label: 'In Progress' },
    { value: 'resolved', label: 'Resolved' },
    { value: 'closed', label: 'Closed' }
  ]
  
  const debouncedAssignedUser = refDebounced(assignedUser, 500)
  
  const queryParams = computed(() => {
    const params: Record<string, any> = {
      page: currentPage.value
    }
    
    if (selectedStatuses.value.length > 0) {
      params.status = selectedStatuses.value.join(',')
    }
    
    if (selectedPriority.value) {
      params.priority = selectedPriority.value
    }
    
    if (debouncedAssignedUser.value) {
      params.assigned_to = debouncedAssignedUser.value
    }
    
    if (selectedProject.value) {
      params.project_id = selectedProject.value
    }
    
    for (const key in params) {
        if (params[key] === '' || params[key] === null) {
            delete params[key]
        }
    }
  
    return params
  })
  
  const { data, pending, error } = await useLazyFetch('/issues', {
    baseURL: config.public.apiBase,
    query: queryParams,
    watch: [queryParams],
    server: false
  })
  
  function clearFilters() {
    selectedStatuses.value = []
    selectedPriority.value = ''
    assignedUser.value = ''
    selectedProject.value = ''
    currentPage.value = 1 
  }
  
  function goToPage(page: number) {
    if (page > 0 && data.value && page <= data.value.meta.last_page) {
      currentPage.value = page
    }
  }
  
  function getStatusBadgeClass(status: string) {
    const classes = {
      open: 'bg-green-100 text-green-800',
      in_progress: 'bg-blue-100 text-blue-800',
      resolved: 'bg-purple-100 text-purple-800',
      closed: 'bg-gray-100 text-gray-800'
    }
    return classes[status as keyof typeof classes] || 'bg-gray-100 text-gray-800'
  }
  
  function getStatusLabel(status: string) {
    const labels = {
      open: 'Open',
      in_progress: 'In Progress',
      resolved: 'Resolved',
      closed: 'Closed'
    }
    return labels[status as keyof typeof labels] || status
  }
  
  function getPriorityBadgeClass(priority: string) {
    const classes = {
      low: 'bg-yellow-100 text-yellow-800',
      medium: 'bg-orange-100 text-orange-800',
      high: 'bg-red-100 text-red-800'
    }
    return classes[priority as keyof typeof classes] || 'bg-gray-100 text-gray-800'
  }
  
  function getPriorityLabel(priority: string) {
    const labels = {
      low: 'Low',
      medium: 'Medium',
      high: 'High'
    }
    return labels[priority as keyof typeof labels] || priority
  }
  
  function formatDate(dateString: string) {
    if (!dateString) return ''
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    })
  }
  
  useHead({
    title: 'Issues - Project Management'
  })
  </script>