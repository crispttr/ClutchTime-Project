import { defineStore } from 'pinia'
import { ref, reactive } from 'vue'
import api from '@/axios'
import { useRouter } from 'vue-router'

export const useAuthStore = defineStore('auth', () => {
  const isAuthenticated = ref(false)
  const userName = ref('')
  const error = ref('')
  const successMessage = ref('')
  const progressions = reactive({})
  const router = useRouter()

  const login = async (email, password) => {
    try {
      await api.get('/sanctum/csrf-cookie', { withCredentials: true })
      await api.post('/api/login', { email, password }, { withCredentials: true })
      await checkAuth()
      return true
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de connexion'
      return false
    }
  }

  const logout = async () => {
    try {
      await api.get('/sanctum/csrf-cookie', { withCredentials: true })
      await api.post('/api/logout', {}, { withCredentials: true })
      isAuthenticated.value = false
      userName.value = ''
      localStorage.removeItem('isAuthenticated')
      router.push('/login')
    } catch (err) {
      error.value = 'Erreur lors de la déconnexion'
    }
  }

  const saveProgression = async (storyId, chapterId) => {
    try {
      await api.get('/sanctum/csrf-cookie', { withCredentials: true })
      await api.post(
        '/api/v1/progressions',
        {
          story_id: storyId,
          chapter_id: chapterId,
        },
        { withCredentials: true },
      )
      progressions[storyId] = chapterId
    } catch (err) {
      console.error('Erreur lors de la sauvegarde de la progression:', err)
    }
  }

  const fetchProgression = async (storyId) => {
    try {
      const res = await api.get(`/api/v1/progressions/${storyId}`, { withCredentials: true })
      if (res.data?.chapter_id) {
        progressions[storyId] = res.data.chapter_id
      } else {
        progressions[storyId] = null
      }
    } catch (err) {
      console.error('Erreur lors du chargement de la progression:', err)
    }
  }

  const checkAuth = async () => {
    try {
      const res = await api.get('/api/user', { withCredentials: true })
      if (res.data && res.data.name) {
        isAuthenticated.value = true
        userName.value = res.data.name
        localStorage.setItem('isAuthenticated', 'true')
      } else {
        isAuthenticated.value = false
        userName.value = ''
        localStorage.removeItem('isAuthenticated')
      }
    } catch (err) {
      isAuthenticated.value = false
      userName.value = ''
      localStorage.removeItem('isAuthenticated')
    }
  }

  const resetProgression = async (storyId) => {
    try {
      await api.delete(`/api/v1/progressions/${storyId}`, { withCredentials: true })
      progressions[storyId] = null
    } catch (err) {
      error.value = 'Erreur lors de la réinitialisation de la progression'
    }
  }

  return {
    isAuthenticated,
    userName,
    error,
    successMessage,
    progressions,
    login,
    logout,
    saveProgression,
    fetchProgression,
    resetProgression,
    checkAuth,
  }
})
