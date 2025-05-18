<template>
  <header class="header">
    <span class="header-left">👋 Bonjour, <br />{{ authStore.userName }}</span>
    <button class="logout" @click="handleLogout" title="Déconnexion">
      <span aria-label="Déconnexion">🔒 Déconnexion</span>
    </button>
  </header>
</template>

<script setup>
import { useAuthStore } from '@/store/auth'
const authStore = useAuthStore()

const handleLogout = async () => {
  await authStore.logout()
}
</script>

<style scoped>
.header {
  background-color: #1976d2;
  color: white;
  padding: 0.5rem 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-radius: 8px;
  position: relative;
  gap: 1rem;
}

.header-left {
  font-size: 1.6rem;
  font-weight: 500;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  line-height: 1.2;
}

.logout {
  background-color: #e53935;
  color: white;
  padding: 0.2rem 0.7rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  font-size: 1.3rem;
  gap: 0.3rem;
  min-width: 0;
  min-height: 0;
  height: auto;
  line-height: 1.2;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
  transition:
    background 0.2s,
    box-shadow 0.2s;
  white-space: nowrap;
}
.logout:hover {
  background-color: #c62828;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}
</style>
