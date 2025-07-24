// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  modules: [
    '@nuxtjs/tailwindcss'
  ],
  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_API_URL || 'http://api.test/api'
    }
  },
  components: [
    {
      path: '@/components',
      pathPrefix: false, 
    }
  ]
})
