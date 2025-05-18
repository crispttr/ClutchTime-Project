import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/store/auth'
import Accueil from '@/views/Accueil.vue'
import Story from '@/views/Story.vue'
import Login from '@/components/auth/Login.vue'
import Register from '@/components/auth/Register.vue'

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/accueil', component: Accueil, meta: { requiresAuth: true } },
  { path: '/story', component: Story, meta: { requiresAuth: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()

  // Vérifier l'authentification si elle n'est pas encore faite
  if (!authStore.isAuthenticated) {
    await authStore.checkAuth()
  }

  // Si la route nécessite l'authentification et que l'utilisateur n'est pas connecté
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    return next('/login')
  }

  // Redirection vers l'accueil si déjà connecté
  if ((to.path === '/login' || to.path === '/register') && authStore.isAuthenticated) {
    return next('/accueil')
  }

  next()
})

export default router
