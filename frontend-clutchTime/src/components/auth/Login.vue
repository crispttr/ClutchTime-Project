<template>
  <div class="auth-container">
    <!-- Titre de la page de connexion -->
    <h2>Connexion</h2>

    <!-- Champ pour saisir l'email -->
    <input v-model="email" type="email" placeholder="Email" />

    <!-- Champ pour saisir le mot de passe -->
    <input v-model="password" type="password" placeholder="Mot de passe" />

    <!-- Bouton pour lancer la connexion -->
    <button @click="handleLogin">Se connecter</button>

    <!-- Affichage du message d'erreur en cas de problème -->
    <p v-if="authStore.error" class="error">{{ authStore.error }}</p>

    <!-- Lien pour aller à la page d'inscription -->
    <p class="register-link">
      Pas encore inscrit ?
      <!-- Utilisation d'un lien pour naviguer vers la page de registre -->
      <a @click.prevent="goToRegister" href="#">S'inscrire</a>
    </p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth'

// Initialisation du store d'authentification
const authStore = useAuthStore()

// Déclaration des variables pour l'email et le mot de passe
const email = ref('')
const password = ref('')

// Initialisation du routeur pour naviguer entre les pages
const router = useRouter()

// Fonction de gestion de la connexion
const handleLogin = async () => {
  // Appel à la fonction login du store avec l'email et le mot de passe saisis
  const success = await authStore.login(email.value, password.value)
  // Si la connexion est réussie, rediriger vers la page d'accueil
  if (success) {
    router.push('/accueil')
  }
}

// Fonction pour aller à la page d'inscription
const goToRegister = () => {
  router.push('/register')
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
button {
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
button:hover {
  background: linear-gradient(90deg, #125ca1 60%, #388e3c 100%);
  box-shadow: 0 4px 16px rgba(25, 118, 210, 0.13);
}
.error {
  color: #e53935;
  margin-top: 0.5rem;
  font-weight: bold;
  font-size: 0.98rem;
  width: 100%;
  text-align: left;
}
.register-link {
  text-align: center;
  margin-top: 1rem;
  font-size: 0.97rem;
}
.register-link a {
  color: #1976d2;
  text-decoration: underline;
  cursor: pointer;
  font-weight: 500;
}
.register-link a:hover {
  color: #125ca1;
}
@media (max-width: 500px) {
  .auth-container {
    padding: 1.2rem 0.3rem 1.5rem 0.3rem;
    max-width: 98vw;
  }
  input,
  button {
    font-size: 0.97rem;
    padding: 0.6rem 0.7rem;
  }
}
</style>
