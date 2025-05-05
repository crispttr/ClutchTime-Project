<template>
  <div>
    <h2>Bienvenue !</h2>
    <p v-if="message">{{ message }}</p>
    <p v-else>Chargement...</p>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import api from '../axios'

const message = ref('')

onMounted(async () => {
  try {
    const res = await api.get('/api/welcome-message')
    message.value = res.data.message
  } catch (err) {
    message.value = 'Erreur : accès non autorisé'
  }
})
</script>
