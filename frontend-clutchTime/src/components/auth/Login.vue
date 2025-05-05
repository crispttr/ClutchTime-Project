// src/views/Login.vue
<template>
  <div class="auth-container">
    <h2>Connexion</h2>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Mot de passe" required />
      <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore de compte ? <RouterLink to="/register">S'inscrire</RouterLink></p>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/axios'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()

const login = async () => {
  try {
    await api.get('/sanctum/csrf-cookie')
    const token = decodeURIComponent(
      document.cookie
        .split('; ')
        .find((c) => c.startsWith('XSRF-TOKEN='))
        ?.split('=')[1] || '',
    )
    await api.post(
      '/api/login',
      { email: email.value, password: password.value },
      { headers: { 'X-XSRF-TOKEN': token } },
    )
    router.push('/story')
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur de connexion'
  }
}
</script>

<style scoped>
.auth-container {
  max-width: 400px;
  margin: auto;
  padding: 2rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
}
input,
button {
  display: block;
  width: 100%;
  margin-bottom: 1rem;
  padding: 0.5rem;
}
.error {
  color: red;
  font-weight: bold;
}
</style>
