<template>
  <div class="auth-container">
    <h2>Inscription</h2>
    <form @submit.prevent="register">
      <input v-model="name" placeholder="Nom" required />
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Mot de passe" required />
      <input
        v-model="passwordConfirmation"
        type="password"
        placeholder="Confirmer mot de passe"
        required
      />
      <button type="submit">S'inscrire</button>
    </form>

    <!-- Affichage des erreurs -->
    <div v-if="errors.length" class="error-messages">
      <p v-for="(error, index) in errors" :key="index" class="error">{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/axios'
import { useRouter } from 'vue-router'

const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const errors = ref([])
const router = useRouter()

const register = async () => {
  errors.value = []
  try {
    await api.get('/sanctum/csrf-cookie')
    const token = decodeURIComponent(
      document.cookie
        .split('; ')
        .find((c) => c.startsWith('XSRF-TOKEN='))
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
        headers: { 'X-XSRF-TOKEN': token },
      },
    )
    router.push('/story')
  } catch (err) {
    if (err.response && err.response.data.errors) {
      errors.value = Object.values(err.response.data.errors).flat()
    } else {
      errors.value = ['Erreur lors de l’inscription']
    }
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
.error-messages {
  color: #ffc72c;
  margin-top: 10px;
}
.error {
  margin: 4px 0;
  font-weight: bold;
}
</style>
