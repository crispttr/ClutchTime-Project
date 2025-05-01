<template>
  <div>
    <h2>Mon profil</h2>
    <div v-if="user">
      <p>👤 Nom : {{ user.name }}</p>
      <p>📧 Email : {{ user.email }}</p>
      <button @click="logout">Se déconnecter</button>
    </div>
    <div v-else>
      <p>Chargement...</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../../axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const user = ref(null)

onMounted(async () => {
  try {
    const res = await api.get('/api/user')
    user.value = res.data
  } catch {
    router.push('/login')
  }
})

const logout = async () => {
  await api.post('/api/logout')
  router.push('/login')
}
</script>
