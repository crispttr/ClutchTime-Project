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
    <p class="login-link">
      Déjà inscrit ?
      <a @click.prevent="goToLogin" href="#">Se connecter</a>
    </p>
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
    router.push('/accueil')
  } catch (err) {
    if (err.response && err.response.data.errors) {
      errors.value = Object.values(err.response.data.errors).flat()
    } else {
      errors.value = ['Erreur lors de l’inscription']
    }
  }
}

const goToLogin = () => {
  router.push('/login')
}
</script>

<style scoped>
.auth-container {
  max-width: 400px;
  margin: 2.5rem auto 0 auto;
  padding: 2.2rem 1.5rem 2rem 1.5rem;
  border-radius: 14px;
  background: #fff8e6;
  box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
}
.auth-container h2 {
  margin-bottom: 1.5rem;
  color: #1976d2;
  font-size: 1.6rem;
  font-weight: 700;
  letter-spacing: 0.5px;
}
input {
  width: 100%;
  margin-bottom: 1.1rem;
  padding: 0.7rem 1rem;
  border: 1.5px solid #e0e0e0;
  border-radius: 7px;
  font-size: 1rem;
  background: #fff;
  transition:
    border 0.2s,
    box-shadow 0.2s;
  outline: none;
}
input:focus {
  border-color: #1976d2;
  box-shadow: 0 0 0 2px #1976d220;
}
button[type='submit'] {
  width: 100%;
  background: linear-gradient(90deg, #1976d2 60%, #4caf50 100%);
  color: #fff;
  border: none;
  border-radius: 7px;
  padding: 0.7rem 0;
  font-size: 1.08rem;
  font-weight: 600;
  cursor: pointer;
  margin-bottom: 0.5rem;
  box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);
  transition:
    background 0.2s,
    box-shadow 0.2s;
}
button[type='submit']:hover {
  background: linear-gradient(90deg, #125ca1 60%, #388e3c 100%);
  box-shadow: 0 4px 16px rgba(25, 118, 210, 0.13);
}
.error-messages {
  color: #e53935;
  margin-top: 10px;
  margin-bottom: 0.5rem;
  width: 100%;
  text-align: left;
}
.error {
  margin: 4px 0;
  font-weight: bold;
  font-size: 0.98rem;
}
.login-link {
  text-align: center;
  margin-top: 1rem;
  font-size: 0.97rem;
}
.login-link a {
  color: #1976d2;
  text-decoration: underline;
  cursor: pointer;
  font-weight: 500;
}
.login-link a:hover {
  color: #125ca1;
}
@media (max-width: 500px) {
  .auth-container {
    padding: 1.2rem 0.3rem 1.5rem 0.3rem;
    max-width: 98vw;
  }
  input,
  button[type='submit'] {
    font-size: 0.97rem;
    padding: 0.6rem 0.7rem;
  }
}
</style>
