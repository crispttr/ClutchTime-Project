<template>
  <div class="page-container">
    <div class="top-bar">
      <div class="greeting">👋 Hello, {{ userName }}</div>
    </div>

    <div class="accueil">
      <h2>📚 Histoires disponibles</h2>

      <div v-if="stories.length" class="story-list">
        <div v-for="story in stories" :key="story.id" class="story-card">
          <h3>{{ story.title }}</h3>
          <p>{{ story.description }}</p>

          <div v-if="progressions[story.id]">
            <button @click="goToStory(story.id, progressions[story.id])">▶️ Reprendre</button>
            <button class="secondary" @click="resetProgression(story.id)">🔁 Recommencer</button>
          </div>

          <button v-else @click="startStory(story.id)">Commencer</button>
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
}

.top-bar {
  position: absolute;
  top: 1rem;
  left: 1rem;
  font-weight: bold;
  font-size: 1rem;
}

.accueil {
  max-width: 900px;
  margin: 5rem auto 0;
  padding: 2rem;
}

.story-list {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.story-card {
  padding: 1.5rem;
  border: 1px solid #ddd;
  border-radius: 10px;
  background: #f9f9f9;
  box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
}

.story-card h3 {
  margin: 0 0 0.5rem;
}

.story-card button {
  margin-top: 1rem;
  padding: 0.5rem 1rem;
  border: none;
  background: #1976d2;
  color: white;
  border-radius: 6px;
  cursor: pointer;
}

.story-card button:hover {
  background: #0f5bb5;
}

.story-card button.secondary {
  margin-left: 0.5rem;
  background-color: #e0e0e0;
  color: #333;
}

.story-card button.secondary:hover {
  background-color: #ccc;
}
</style>
