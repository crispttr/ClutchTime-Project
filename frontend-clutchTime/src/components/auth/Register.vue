<template>
  <div>
    <h2>Inscription</h2>
    <form @submit.prevent="register">
      <input v-model="name" placeholder="Nom" required />
      <input v-model="email" placeholder="Email" type="email" required />
      <input v-model="password" placeholder="Mot de passe" type="password" required />
      <input
        v-model="passwordConfirmation"
        placeholder="Confirmer le mot de passe"
        type="password"
        required
      />
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
const passwordConfirmation = ref('')
const error = ref('')

const register = async () => {
  try {
    await api.get('/sanctum/csrf-cookie')

    const xsrfToken = decodeURIComponent(
      document.cookie
        .split('; ')
        .find((row) => row.startsWith('XSRF-TOKEN='))
        ?.split('=')[1] || '',
    )

    await api.post(
      '/api/register',
      {
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: passwordConfirmation.value,
      },
      {
        headers: {
          'X-XSRF-TOKEN': xsrfToken,
        },
      },
    )

    const res = await api.get('/api/user')
    console.log('Utilisateur inscrit:', res.data)
    router.push('/profile')
  } catch (err) {
    console.error(err)
    if (err.response?.data?.errors) {
      error.value = Object.values(err.response.data.errors).flat().join(', ')
    } else {
      error.value = 'Erreur CSRF : ' + (err.response?.data?.message || 'inconnue')
    }
  }
}
</script>
