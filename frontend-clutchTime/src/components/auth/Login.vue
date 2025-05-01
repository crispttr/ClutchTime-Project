<template>
  <div>
    <h2>Connexion</h2>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Mot de passe" required />
      <button type="submit">Se connecter</button>
    </form>
    <p v-if="error" style="color: red">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '../../axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const email = ref('')
const password = ref('')
const error = ref('')

const login = async () => {
  try {
    await api.get('/sanctum/csrf-cookie')
    await api.post('/api/login', {
      email: email.value,
      password: password.value,
    })
    const res = await api.get('/api/user')
    console.log('Connecté :', res.data)
    router.push('/profile')
  } catch (err) {
    error.value = err.response?.data?.message || 'Identifiants incorrects'
  }
}
</script>
