<template>
  <div class="auth-container">
    <h2>Connexion</h2>
    <input v-model="email" type="email" placeholder="Email" />
    <input v-model="password" type="password" placeholder="Mot de passe" />
    <button @click="handleLogin">Se connecter</button>
    <p v-if="authStore.error" class="error">{{ authStore.error }}</p>
    <p class="register-link">
      Pas encore inscrit ?
      <a @click.prevent="goToRegister" href="#">S'inscrire</a>
    </p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth'

const authStore = useAuthStore()
const email = ref('')
const password = ref('')
const router = useRouter()

const handleLogin = async () => {
  const success = await authStore.login(email.value, password.value)
  if (success) {
    router.push('/accueil')
  }
}

const goToRegister = () => {
  router.push('/register')
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
  padding: 0.75rem;
}

.error {
  color: red;
  margin-top: 0.5rem;
}

.register-link {
  text-align: center;
  margin-top: 1rem;
  font-size: 0.95rem;
}

.register-link a {
  color: #1976d2;
  text-decoration: underline;
  cursor: pointer;
}

.register-link a:hover {
  color: #125ca1;
}
</style>
