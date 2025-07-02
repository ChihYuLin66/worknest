import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { createPinia } from 'pinia'
import './bootstrap'

// Import components
import Dashboard from './components/Dashboard.vue'
import Welcome from './components/Welcome.vue'

// Create router
const routes = [
    { path: '/', component: Welcome },
    { path: '/dashboard', component: Dashboard }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// Create Pinia store
const pinia = createPinia()

// Create Vue app
const app = createApp({})

app.use(router)
app.use(pinia)

app.mount('#app')
