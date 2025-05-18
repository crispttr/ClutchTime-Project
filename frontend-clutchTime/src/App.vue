<template>
  <div id="app">
    <!-- ✅ Affiche le header seulement si l'utilisateur est authentifié -->
    <Header v-if="authStore.isAuthenticated" />

    <!-- ✅ Zone principale de contenu avec affichage des pages -->
    <div class="main-content">
      <router-view />
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useAuthStore } from './store/auth'
import Header from './components/layout/Header.vue'

// Initialisation du store d'authentification
const authStore = useAuthStore()

// Vérifie l'authentification dès que l'application est montée
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
  padding-top: 4.2rem; /* Compense la hauteur du header fixe */
  box-sizing: border-box;
}
</style>
