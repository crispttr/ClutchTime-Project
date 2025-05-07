<template>
  <div class="page-container">
    <div class="top-bar">
      <div class="greeting">👋 Bonjour, {{ userName }}</div>
      <button @click="logout" class="logout">Déconnexion</button>
      <p v-if="message" class="logout-message">{{ message }}</p>
    </div>

    <div class="accueil">
      <h2>📚 Histoires disponibles</h2>

      <div v-if="stories.length" class="story-list">
        <div v-for="story in stories" :key="story.id" class="story-card">
          <h3>{{ story.title }}</h3>
          <p>{{ story.description }}</p>

          <div v-if="progressions[story.id]" class="button-group">
            <button class="primary-button" @click="goToStory(story.id, progressions[story.id])">
              ▶️ Reprendre
            </button>
            <button class="secondary-button" @click="resetProgression(story.id)">
              🔁 Recommencer
            </button>
          </div>

          <button v-else class="start-button" @click="startStory(story.id)">Commencer</button>
        </div>
      </div>

      <p v-else>Chargement des histoires...</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/axios'

const router = useRouter()
const stories = ref([])
const progressions = ref({})
const userName = ref('')
const message = ref('')

const fetchUser = async () => {
  const res = await api.get('/api/user')
  userName.value = res.data.name
}

const fetchStories = async () => {
  const res = await api.get('/api/v1/stories')
  stories.value = res.data
}

const fetchProgressions = async () => {
  for (const story of stories.value) {
    try {
      const res = await api.get(`/api/v1/progressions/${story.id}`)
      if (res.data?.chapter_id) {
        progressions.value[story.id] = res.data.chapter_id
      }
    } catch {}
  }
}

const logout = async () => {
  try {
    await api.get('/sanctum/csrf-cookie')
    await api.post('/api/logout')
    message.value = 'Vous êtes déconnecté.'
    setTimeout(() => router.replace('/login'), 1000)
  } catch (err) {
    console.error('Erreur lors de la déconnexion :', err)
    message.value = 'Erreur de déconnexion.'
  }
}

const startStory = (storyId) => {
  router.push({ path: '/story', query: { story: storyId } })
}

const goToStory = (storyId, chapterId) => {
  router.push({ path: '/story', query: { story: storyId, chapter: chapterId } })
}

const resetProgression = async (storyId) => {
  try {
    await api.delete(`/api/v1/progressions/${storyId}`)
    progressions.value[storyId] = null
  } catch (err) {
    console.error('Erreur lors de la réinitialisation :', err)
  }
}

onMounted(async () => {
  await fetchUser()
  await fetchStories()
  await fetchProgressions()
})
</script>

<style scoped>
.page-container {
  padding: 1rem;
  font-family: 'Arial', sans-serif;
  background-color: #f3f4f6;
}

.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding: 0.5rem 1rem;
  background-color: #1976d2;
  color: white;
  border-radius: 8px;
}

.greeting {
  font-size: 1.2rem;
}

.logout {
  padding: 0.5rem 1rem;
  background: #e53935;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.logout:hover {
  background: #c62828;
}

.accueil {
  margin: 2rem auto;
  text-align: center;
}

.story-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
}

.story-card {
  background-color: white;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.primary-button,
.start-button {
  background-color: #4caf50;
  color: white;
  padding: 0.75rem 1.25rem;
  border: none;
  border-radius: 6px;
  margin: 0.5rem 0;
  cursor: pointer;
  transition: transform 0.2s ease;
}

.primary-button:hover,
.start-button:hover {
  transform: scale(1.05);
}

.secondary-button {
  background-color: #ffb310;
  color: white;
  padding: 0.75rem 1.25rem;
  border: none;
  border-radius: 6px;
  margin-left: 0.5rem;
  cursor: pointer;
}

.secondary-button:hover {
  background-color: #e58f00;
}

.logout-message {
  margin-top: 0.5rem;
  color: #4caf50;
}
</style>
