<template>
  <!-- ✅ Ajouter la classe local-header en plus de header -->
  <header class="header local-header">
    <div class="header-content">
      <span class="greeting">👋 Bonjour, {{ authStore.userName }}</span>
      <nav class="header-nav">
        <!-- Place pour d'autres liens ou menus -->
        <slot></slot>
      </nav>
      <button @click="handleLogout" class="logout">🔒 Déconnexion</button>
    </div>
  </header>
</template>

<script setup>
import { useAuthStore } from '@/store/auth'
const authStore = useAuthStore() // Initialisation du store d'authentification

// Fonction de déconnexion de l'utilisateur
const handleLogout = async () => {
  //
  await authStore.logout()
}
</script>

<style scoped>
/* ✅ Style spécifique pour le header local */
.local-header {
  background-color: #1976d2;
  color: white;
  padding: 0.5rem 1rem;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100vw;
  box-sizing: border-box;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
  min-height: 3.5rem;
}

.header-content {
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 1200px; /* Limite pour un aspect esthétique */
  margin: 0 auto;
  gap: 1.2rem;
}

.greeting {
  font-size: 1.2rem;
  margin-right: 1.5rem;
  white-space: nowrap;
}

.header-nav {
  flex: 1 1 auto;
  display: flex;
  align-items: center;
  gap: 1.2rem;
}

.logout {
  background-color: #e53935;
  color: white;
  padding: 0.32rem 0.5rem 0.32rem 0.4rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 0.93rem;
  transition: background-color 0.3s;
  white-space: nowrap;
  min-width: 0;
  min-height: 50px;
  height: auto;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.15rem;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
  margin-left: auto;
  max-width: 200px;
}

.logout span,
.logout {
  overflow: hidden;
  text-overflow: ellipsis;
}

.logout:hover {
  background-color: #c62828;
}

@media (max-width: 700px) {
  .header-content {
    flex-direction: row;
    gap: 0.5rem;
    max-width: 100vw;
  }
  .greeting {
    font-size: 1rem;
    margin-right: 0.5rem;
  }
  .header-nav {
    gap: 0.5rem;
  }
  .logout {
    font-size: 0.9rem;
    padding: 0.25rem 0.5rem;
  }
}
</style>
