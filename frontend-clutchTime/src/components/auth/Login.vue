<template>
  <div class="login-wrapper">
    <div class="background-wrapper"></div>
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
    await api.post('/api/login', {
      email: email.value,
      password: password.value,
    })

    router.push('/') // redirection vers l'accueil
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur de connexion'
  }
}
</script>

<style scoped>
.login-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  overflow: hidden;
  position: relative;
}

.background-wrapper {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  pointer-events: none;
}

.auth-container {
  position: relative;
  z-index: 2;
  max-width: 400px;
  margin: auto;
  padding: 2rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
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
