<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/axios'

const router = useRouter()
const isAuthenticated = ref(false)

const checkAuth = async () => {
  try {
    const res = await api.get('/api/user')
    if (res.data && res.data.name) {
      isAuthenticated.value = true
      if (router.currentRoute.value.path === '/login') {
        router.push('/home')
      }
    } else {
      isAuthenticated.value = false
      if (router.currentRoute.value.path !== '/login') {
        router.push('/login')
      }
    }
  } catch (err) {
    console.error("Erreur de vérification de l'authentification :", err)
    isAuthenticated.value = false
    if (router.currentRoute.value.path !== '/login') {
      router.push('/login')
    }
  }
}

onMounted(() => {
  checkAuth()
})
</script>

<style>
body {
  margin: 0;
  font-family: 'Arial', sans-serif;
  background-color: #f5f5f5;
  background-image: './fond.avif';
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
}

#app {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
