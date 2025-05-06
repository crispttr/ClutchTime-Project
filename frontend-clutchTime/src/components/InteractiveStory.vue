<template>
  <div class="story-wrapper">
    <div class="top-bar">
      <div class="greeting">👋 Hello, {{ userName }}</div>
      <div class="top-right">
        <div class="progress-circle">
          <svg viewBox="0 0 36 36">
            <path
              class="bg"
              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
            />
            <path
              class="progress"
              :stroke-dasharray="progress + ', 100'"
              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
            />
            <text x="18" y="20.35" class="percentage">{{ progress }}%</text>
          </svg>
        </div>
        <button class="home" @click="goHome">🏠 Accueil</button>
        <button @click="logout" class="logout">Logout</button>
        <p v-if="message" class="logout-message">{{ message }}</p>
      </div>
    </div>

    <div class="story-content">
      <h2>{{ chapter.title }}</h2>
      <p>{{ chapter.content }}</p>
      <div class="choices">
        <button
          v-for="choice in chapter.choices"
          :key="choice.id"
          @click="selectChoice(choice.next_chapter_id)"
        >
          {{ choice.text }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/axios'
import { useRoute, useRouter } from 'vue-router'

const router = useRouter()
const route = useRoute()

const chapter = ref({ title: '', content: '', choices: [], story_id: null })
const userName = ref('')
const progress = ref(0)
const message = ref('')

const storyId = route.query.story || 1
const chapterId = route.query.chapter || null

const fetchUser = async () => {
  const res = await api.get('/api/user')
  userName.value = res.data.name
}

const fetchChapter = async (id = 1) => {
  try {
    const res = await api.get(`/api/v1/chapters/${id}`)
    chapter.value = res.data
  } catch (err) {
    console.error(`Erreur lors du chargement du chapitre ${id} :`, err)
  }
}

const selectChoice = async (nextId) => {
  try {
    if (!nextId) throw new Error('nextId est undefined')

    const res = await api.get(`/api/v1/chapters/${nextId}`)
    chapter.value = res.data

    // 🔐 Obtenir le cookie CSRF (à faire au moins une fois par session)
    await api.get('/sanctum/csrf-cookie')

    // 💾 Sauvegarde la progression
    await api.post('/api/v1/progressions', {
      story_id: chapter.value.story_id,
      chapter_id: chapter.value.id,
    })

    progress.value = Math.min(progress.value + 10, 100)
  } catch (err) {
    console.error('Erreur lors de la sélection :', err)
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

const goHome = () => {
  router.push('/')
}

onMounted(async () => {
  try {
    await fetchUser()

    if (chapterId) {
      await fetchChapter(chapterId)
    } else {
      const res = await api.get(`/api/v1/progressions/${storyId}`)
      const saved = res.data
      if (saved?.chapter_id) {
        await fetchChapter(saved.chapter_id)
      } else {
        await fetchChapter(1)
      }
    }
  } catch (err) {
    console.error('Erreur de chargement initial :', err)
    await fetchChapter(1)
  }
})
</script>

<style scoped>
.story-wrapper {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  padding: 2rem;
  font-family: sans-serif;
}

.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.greeting {
  font-size: 1.2rem;
}

.top-right {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.logout,
.home {
  padding: 0.5rem 1rem;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.logout {
  background: #e53935;
}

.logout:hover {
  background: #c62828;
}

.home {
  background: #1976d2;
}

.home:hover {
  background: #125ca1;
}

.progress-circle {
  width: 50px;
  height: 50px;
}

svg {
  width: 100%;
  height: 100%;
}

.bg {
  fill: none;
  stroke: #eee;
  stroke-width: 3.8;
}

.progress {
  fill: none;
  stroke: #4caf50;
  stroke-width: 3.8;
  stroke-linecap: round;
  transition: stroke-dasharray 0.3s;
}

.percentage {
  fill: #333;
  font-size: 0.5em;
  text-anchor: middle;
  dominant-baseline: middle;
}

.story-content {
  margin: auto;
  text-align: center;
  max-width: 600px;
  padding: 2rem;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.choices button {
  margin: 1rem 0;
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  background: #ffb310;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.logout-message {
  color: #4caf50;
  font-weight: bold;
}
</style>
