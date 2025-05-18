<template>
  <div id="app">
    <Header v-if="authStore.isAuthenticated" />
    <div class="main-content">
      <router-view />
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useAuthStore } from './store/auth'
import Header from './components/layout/Header.vue'

const authStore = useAuthStore()

onMounted(() => {
  authStore.checkAuth()
})
</script>

<style>
body {
  margin: 0;
  font-family: 'Arial', sans-serif;
  background-color: #f5f5f5;
}

#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: stretch;
}

.main-content {
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
}
</style>
