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
  padding: 1.5rem 0 2rem 0;
  font-family: 'Arial', sans-serif;
  background-color: #f8f5ea;
  min-height: 100vh;
  max-width: 700px;
  margin: 0 auto;
  box-sizing: border-box;
}

.title {
  text-align: center;
  font-size: 2rem;
  margin-bottom: 2rem;
}

.content-wrapper {
  max-width: 600px;
  margin: 0 auto;
  width: 100%;
}

.story-list {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.story-card {
  background: #fff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  border-radius: 12px;
  padding: 1.5rem 1.2rem 1.2rem 1.2rem;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  transition:
    box-shadow 0.2s,
    transform 0.2s;
}

.story-card:hover {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.13);
  transform: translateY(-4px) scale(1.02);
}

.story-content {
  flex: 1 1 auto;
  margin-bottom: 1.2rem;
}

.story-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #1976d2;
}

.story-description {
  font-size: 1rem;
  color: #444;
  margin-bottom: 0.5rem;
}

.story-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.7rem;
  justify-content: flex-end;
}

.primary-button,
.start-button {
  background-color: #4caf50;
  color: white;
  padding: 0.6rem 1.1rem;
  border: none;
  border-radius: 6px;
  font-size: 1rem;
  cursor: pointer;
  transition:
    transform 0.2s,
    background 0.2s;
}

.primary-button:hover,
.start-button:hover {
  transform: scale(1.05);
  background-color: #388e3c;
}

.secondary-button {
  background-color: #ffb310;
  color: white;
  padding: 0.6rem 1.1rem;
  border: none;
  border-radius: 6px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s;
}

.secondary-button:hover {
  background-color: #e58f00;
}

.loading {
  text-align: center;
  color: #888;
  font-size: 1.1rem;
  margin-top: 2rem;
}

@media (max-width: 700px) {
  .page-container {
    padding: 1rem 0 2rem 0;
  }

  .title {
    font-size: 1.3rem;
    margin-bottom: 1.2rem;
  }

  .content-wrapper {
    max-width: 100%;
    padding: 0 0.2rem;
  }

  .story-list {
    gap: 1rem;
  }

  .story-card {
    padding: 1rem;
  }

  .story-title {
    font-size: 1.1rem;
  }

  .story-description {
    font-size: 0.95rem;
  }

  .story-actions {
    gap: 0.4rem;
  }

  .primary-button,
  .start-button,
  .secondary-button {
    font-size: 0.97rem;
    padding: 0.5rem 0.7rem;
  }
}
</style>
