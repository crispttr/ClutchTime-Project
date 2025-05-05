import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/auth/Login.vue'
import Register from '../components/auth/Register.vue'
import InteractiveStory from '../components/InteractiveStory.vue'

const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  {
    path: '/story',
    component: InteractiveStory,
    meta: { requiresAuth: true },
  },
  { path: '/', redirect: '/login' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// 🛡️ Middleware global
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
