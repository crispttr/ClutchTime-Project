<template>
  <div v-if="chapter">
    <h2>{{ chapter.title }}</h2>
    <p>{{ chapter.content }}</p>

    <div v-if="chapter.choices.length">
      <h3>Que fais-tu ?</h3>
      <ul>
        <li v-for="choice in chapter.choices" :key="choice.id">
          <button @click="loadChapter(choice.next_chapter_id)">
            {{ choice.text }}
          </button>
        </li>
      </ul>
    </div>
    <div v-else>
      <p>Fin de l’histoire.</p>
    </div>
  </div>
  <p v-else>Chargement...</p>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../axios'

const route = useRoute()
const storyId = parseInt(route.params.id)
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
  const res = await api.get('/api/v1/chapters')
  const allChapters = res.data
  const first = allChapters.find((c) => c.is_start && c.story_id === storyId)
  if (first) loadChapter(first.id)
})
</script>
