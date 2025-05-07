<template>
  <div class="story-wrapper">
    <div class="top-bar">
      <div class="greeting">👋 Bonjour, {{ userName }}</div>
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
import { useRoute, useRouter } from 'vue-router'
import api from '@/axios'

const router = useRouter()
const route = useRoute()

const chapter = ref({ title: '', content: '', choices: [], story_id: null })
const userName = ref('')
const progress = ref(0)

const storyId = route.query.story || 1
const chapterId = route.query.chapter || null

const fetchUser = async () => {
  try {
    const res = await api.get('/api/user')
    userName.value = res.data.name
  } catch (err) {
    console.error("Erreur lors de la récupération de l'utilisateur :", err)
  }
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
    if (!nextId) throw new Error("L'ID du chapitre suivant est indéfini")
    const res = await api.get(`/api/v1/chapters/${nextId}`)
    chapter.value = res.data

    await api.get('/sanctum/csrf-cookie')
    await api.post('/api/v1/progressions', {
      story_id: chapter.value.story_id,
      chapter_id: chapter.value.id,
    })

    progress.value = Math.min(progress.value + 10, 100)
  } catch (err) {
    console.error('Erreur lors de la sélection du choix :', err)
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

.home {
  padding: 0.5rem 1rem;
  background: #1976d2;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
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

.choices button:hover {
  background: #e58f00;
}
</style>
