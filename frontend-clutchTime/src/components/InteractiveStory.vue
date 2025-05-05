<template>
  <div class="story-page">
    <header class="story-header">
      <span class="hello">👋 Hello, {{ user?.name }}</span>
      <!-- ProgressCircle viendra ici -->
    </header>

    <div class="chapter-box" v-if="chapter">
      <h2>{{ chapter.title }}</h2>
      <p>{{ chapter.content }}</p>

      <div class="choices" v-if="chapter.choices?.length">
        <h3>Que fais-tu ?</h3>
        <button
          v-for="choice in chapter.choices"
          :key="choice.id"
          @click="loadChapter(choice.next_chapter_id)"
        >
          {{ choice.text }}
        </button>
      </div>
      <div v-else>
        <p><strong>Fin de l’histoire.</strong></p>
      </div>
    </div>

    <p v-else>Chargement...</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/axios'

const user = ref(null)
const chapter = ref(null)

const loadChapter = async (id) => {
  if (!id) {
    chapter.value = null
    return
  }

  const res = await api.get(`/api/v1/chapters/${id}`)
  chapter.value = res.data
}

onMounted(async () => {
  try {
    const userRes = await api.get('/api/user')
    user.value = userRes.data

    const start = await api.get('/api/v1/chapters')
    const first = start.data.find((chap) => chap.is_start)
    if (first) loadChapter(first.id)
  } catch (err) {
    console.error(err)
  }
})
</script>

<style scoped>
.story-page {
  max-width: 800px;
  margin: auto;
  padding: 2rem;
}

.story-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.chapter-box {
  background-color: #fdfdfd;
  padding: 1.5rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

button {
  margin-top: 1rem;
  display: block;
  padding: 0.5rem 1rem;
  border: none;
  background: #1976d2;
  color: white;
  border-radius: 5px;
  cursor: pointer;
}
button:hover {
  background: #125ca1;
}
</style>
