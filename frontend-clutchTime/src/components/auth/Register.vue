<template>
  <div>
    <h2>Inscription</h2>
    <form @submit.prevent="register">
      <input v-model="name" placeholder="Nom" required />
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Mot de passe" required />
      <button type="submit">S'inscrire</button>
    </form>
    <p v-if="error" style="color: red">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '../../axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const name = ref('')
const email = ref('')
const password = ref('')
const error = ref('')

const register = async () => {
  try {
    await api.get('/sanctum/csrf-cookie')
    await api.post('/api/register', {
      name: name.value,
      email: email.value,
      password: password.value,
    })
    const res = await api.get('/api/user')
    console.log('Inscrit :', res.data)
    router.push('/profile')
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors de l’inscription'
  }
}
</script>
