import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/auth/Login.vue'
import Register from '../components/auth/Register.vue'
import InteractiveStory from '../components/InteractiveStory.vue'
import Accueil from '../components/Accueil.vue'

const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  {
    path: '/',
    component: Accueil,
    meta: { requiresAuth: true },
  },
  {
    path: '/story',
    component: InteractiveStory,
    meta: { requiresAuth: true },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Middleware d'auth global
router.beforeEach(async (to, from, next) => {
  const requiresAuth = to.meta.requiresAuth
  if (requiresAuth) {
    try {
      const res = await fetch('http://localhost:8000/api/user', {
        credentials: 'include',
      })
      if (!res.ok) throw new Error()
      next()
    } catch {
      next('/login')
    }
  } else {
    next()
  }
})

export default router
