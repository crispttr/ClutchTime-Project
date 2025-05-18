<template>
  <div class="story-wrapper">
    <div class="accueil-bar">
      <button class="home" @click="goHome">🏠 Accueil</button>
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
import { useAuthStore } from '@/store/auth'
import api from '@/axios'

const authStore = useAuthStore()
const router = useRouter()
const route = useRoute()

const chapter = ref({ title: '', content: '', choices: [] })

// ✅ Fonction pour retourner à l'accueil
const goHome = () => {
  router.push('/accueil')
}

const fetchChapter = async (id, storyId) => {
  try {
    const res = await api.get(`/api/v1/chapters/${id}`, { withCredentials: true })
    chapter.value = res.data
    await authStore.saveProgression(storyId, id) // ✅ Sauvegarder la progression
  } catch (err) {
    console.error('Erreur lors du chargement du chapitre:', err)
  }
}

const selectChoice = async (nextId) => {
  try {
    const storyId = route.query.story
    await fetchChapter(nextId, storyId)
  } catch (err) {
    console.error('Erreur lors du choix:', err)
  }
}

onMounted(async () => {
  await authStore.checkAuth()
  const storyId = route.query.story
  const chapterId = route.query.chapter || 1
  await fetchChapter(chapterId, storyId)
})
</script>

<style scoped>
.story-wrapper {
  padding: 1.5rem 0 2rem 0;
  min-height: 100vh;
  background: #f8f5ea;
}

.accueil-bar {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 1rem;
  padding: 0 1rem;
}

.home {
  padding: 0.5rem 1rem;
  background: #1976d2;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.2s;
}
.home:hover {
  background: #125ca1;
}

.story-content {
  margin: 0 auto;
  text-align: center;
  max-width: 700px;
  padding: 0 1rem 2rem 1rem;
  background: none;
  border-radius: 0;
  box-shadow: none;
}
.choices {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 2rem;
}
.choices button {
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  background: #ffb310;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s;
}
.choices button:hover {
  background: #e58f00;
}
@media (max-width: 700px) {
  .story-wrapper {
    padding: 1rem 0 2rem 0;
  }
  .accueil-bar {
    padding: 0 0.2rem;
  }
  .story-content {
    max-width: 100vw;
    padding: 0 0.2rem 1.5rem 0.2rem;
  }
  .choices {
    gap: 0.5rem;
    margin-top: 1.2rem;
  }
  .choices button {
    font-size: 0.97rem;
    padding: 0.5rem 0.7rem;
  }
}
</style>
