<template>
  <div class="page-container">
    <h2 class="title">📚 Histoires disponibles</h2>
    <div class="content-wrapper">
      <div v-if="stories.length" class="story-list">
        <div v-for="story in stories" :key="story.id" class="story-card">
          <div class="story-content">
            <template v-if="authStore.progressions[story.id] && chapters[story.id]">
              <h3 class="story-title">Chapitre en cours : {{ chapters[story.id].title }}</h3>
              <p class="story-description">{{ chapters[story.id].content }}</p>
            </template>
            <template v-else>
              <h3 class="story-title">{{ story.title }}</h3>
              <p class="story-description">{{ story.description }}</p>
            </template>
          </div>
          <div class="story-actions">
            <template v-if="authStore.progressions[story.id]">
              <button
                class="primary-button"
                @click="goToStory(story.id, authStore.progressions[story.id])"
              >
                ▶️ Reprendre
              </button>
              <button class="secondary-button" @click="resetProgression(story.id)">
                🔁 Recommencer
              </button>
            </template>
            <button v-else class="start-button" @click="startStory(story.id)">Commencer</button>
          </div>
        </div>
      </div>
      <p v-else class="loading">Chargement des histoires...</p>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/store/auth'
import api from '@/axios'

const authStore = useAuthStore()
const router = useRouter()
const stories = ref([])
const message = ref('')
const chapters = reactive({}) // { [storyId]: { title, content } }

const startStory = (storyId) => {
  try {
    router.push({ path: '/story', query: { story: storyId } })
  } catch (err) {
    console.error("Erreur lors du démarrage de l'histoire:", err)
  }
}

const goToStory = (storyId, chapterId) => {
  router.push({ path: '/story', query: { story: storyId, chapter: chapterId } })
}

const resetProgression = async (storyId) => {
  await authStore.resetProgression(storyId)
  chapters[storyId] = null
}

const fetchChapter = async (chapterId, storyId) => {
  try {
    const res = await api.get(`/api/v1/chapters/${chapterId}`)
    chapters[storyId] = {
      title: res.data.title,
      content: res.data.content,
    }
  } catch (err) {
    chapters[storyId] = null
  }
}

const fetchStories = async () => {
  try {
    const res = await api.get('/api/v1/stories', { withCredentials: true })
    stories.value = res.data
    for (const story of stories.value) {
      await authStore.fetchProgression(story.id)
      const chapterId = authStore.progressions[story.id]
      if (chapterId) {
        await fetchChapter(chapterId, story.id)
      } else {
        chapters[story.id] = null
      }
    }
  } catch (err) {
    console.error('Erreur lors du chargement des histoires:', err)
  }
}

onMounted(async () => {
  await authStore.checkAuth()
  await fetchStories()
})
</script>

<style scoped>
.page-container {
  padding: 4.5rem 0 2rem 0;
  font-family: 'Arial', sans-serif;
  background: linear-gradient(120deg, #f8f5ea 70%, #f0f4ff 100%);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.title {
  text-align: center;
  font-size: 2.3rem;
  margin-bottom: 2.2rem;
  color: #222;
  font-weight: 700;
  letter-spacing: 0.5px;
}

.content-wrapper {
  max-width: 700px;
  margin: 0 auto;
  width: 100%;
}

.story-list {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  align-items: center;
}

.story-card {
  background: #fff;
  box-shadow:
    0 8px 32px rgba(25, 118, 210, 0.1),
    0 1.5px 8px rgba(0, 0, 0, 0.07);
  border-radius: 18px;
  padding: 2.1rem 1.5rem 1.5rem 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  transition:
    box-shadow 0.2s,
    transform 0.2s;
  max-width: 600px;
  width: 100%;
  margin: 0 auto;
}

.story-card:hover {
  box-shadow:
    0 12px 36px rgba(25, 118, 210, 0.18),
    0 2px 12px rgba(0, 0, 0, 0.13);
  transform: translateY(-4px) scale(1.025);
}

.story-title {
  font-size: 1.35rem;
  font-weight: 700;
  margin-bottom: 0.6rem;
  color: #1976d2;
}

.story-description {
  font-size: 1.08rem;
  color: #444;
  margin-bottom: 0.7rem;
}

.story-actions {
  display: flex;
  gap: 0.8rem;
  justify-content: flex-end;
}

.primary-button,
.start-button {
  background: linear-gradient(90deg, #4caf50 60%, #1976d2 100%);
  color: white;
  padding: 0.65rem 1.3rem;
  border: none;
  border-radius: 8px;
  font-size: 1.08rem;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);
  transition:
    background 0.2s,
    box-shadow 0.2s,
    transform 0.15s;
}
.primary-button:hover,
.start-button:hover {
  background: linear-gradient(90deg, #388e3c 60%, #125ca1 100%);
  box-shadow: 0 4px 16px rgba(25, 118, 210, 0.13);
  transform: scale(1.04);
}
.secondary-button {
  background: linear-gradient(90deg, #ffb310 60%, #ff9800 100%);
  color: white;
  padding: 0.65rem 1.3rem;
  border: none;
  border-radius: 8px;
  font-size: 1.08rem;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(255, 179, 16, 0.08);
  transition:
    background 0.2s,
    box-shadow 0.2s,
    transform 0.15s;
}
.secondary-button:hover {
  background: linear-gradient(90deg, #e58f00 60%, #ffb310 100%);
  box-shadow: 0 4px 16px rgba(255, 179, 16, 0.13);
  transform: scale(1.04);
}
.loading {
  text-align: center;
  color: #888;
  font-size: 1.1rem;
  margin-top: 2rem;
}
@media (max-width: 700px) {
  .page-container {
    padding: 2.5rem 0 1.2rem 0;
  }
  .title {
    font-size: 1.25rem;
    margin-bottom: 1.2rem;
  }
  .content-wrapper {
    max-width: 100vw;
    padding: 0 0.2rem;
  }
  .story-list {
    gap: 1rem;
  }
  .story-card {
    padding: 1.1rem 0.5rem 1rem 0.5rem;
    border-radius: 12px;
  }
  .story-title {
    font-size: 1.08rem;
  }
  .story-description {
    font-size: 0.98rem;
  }
  .story-actions {
    gap: 0.4rem;
  }
  .primary-button,
  .start-button,
  .secondary-button {
    font-size: 0.97rem;
    padding: 0.5rem 0.7rem;
    border-radius: 6px;
  }
}
</style>
