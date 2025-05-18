<template>
  <div class="story-wrapper">
    <div class="accueil-bar">
      <button class="home" @click="goHome">🏠 Accueil</button>
    </div>

    <div class="story-content">
      <h2 class="story-title">{{ chapter.title }}</h2>
      <p class="story-text">{{ chapter.content }}</p>

      <div class="choices">
        <button
          v-for="choice in chapter.choices"
          :key="choice.id"
          class="choice-button"
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

const goHome = () => {
  router.push('/accueil')
}

const fetchChapter = async (id, storyId) => {
  try {
    const res = await api.get(`/api/v1/chapters/${id}`, { withCredentials: true })
    chapter.value = res.data
    await authStore.saveProgression(storyId, id)
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
  padding: 2rem 1rem;
  min-height: 100vh;
  background: linear-gradient(145deg, #f8f5ea 50%, #e0ecff 100%);
  display: flex;
  flex-direction: column;
  align-items: center;
}

.accueil-bar {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  width: 100%;
  max-width: 800px;
  margin-bottom: 1.5rem;
}

.home {
  padding: 0.5rem 1.2rem 0.5rem 1rem;
  background: linear-gradient(90deg, #1976d2, #125ca1); /* Dégradé moderne */
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 1.13rem;
  display: inline-flex;
  align-items: center;
  gap: 0.18rem;
  white-space: nowrap;
  transition:
    transform 0.2s,
    background 0.2s;
  min-width: 0;
  min-height: 2.5rem;
  height: auto;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15); /* Ombre légère */
  width: auto;
  max-width: 260px;
}

.home:hover {
  transform: scale(1.05); /* Légère élévation au survol */
  background: linear-gradient(90deg, #125ca1, #1976d2); /* Inversion des couleurs */
}

.story-content {
  max-width: 800px;
  text-align: center;
  background: white;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
}

.story-content:hover {
  transform: translateY(-2px);
}

.story-title {
  font-size: 2rem;
  color: #333;
  margin-bottom: 1rem;
  font-weight: bold;
}

.story-text {
  font-size: 1.2rem;
  line-height: 1.6;
  color: #555;
}

.choices {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 2rem;
}

.choice-button {
  padding: 0.75rem 1.5rem;
  font-size: 1.1rem;
  font-weight: 600;
  background: linear-gradient(90deg, #ffb310, #ff9800);
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition:
    transform 0.2s,
    box-shadow 0.2s;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
}

.choice-button:hover {
  transform: scale(1.04);
  box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
}

@media (max-width: 700px) {
  .story-wrapper {
    padding: 1.5rem 0.5rem;
  }

  .story-content {
    padding: 1.5rem;
  }

  .story-title {
    font-size: 1.6rem;
  }

  .story-text {
    font-size: 1rem;
  }

  .choice-button {
    font-size: 1rem;
    padding: 0.6rem 1.2rem;
  }
}
</style>
