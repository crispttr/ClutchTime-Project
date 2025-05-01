<template>
  <div>
    <h2>Histoires disponibles</h2>
    <ul v-if="stories.length">
      <li v-for="story in stories" :key="story.id">
        <h3>{{ story.title }}</h3>
        <p>{{ story.description }}</p>
        <button @click="startStory(story.id)">Commencer</button>
      </li>
    </ul>
    <p v-else>Chargement...</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../axios'

const router = useRouter()
const stories = ref([])

const fetchStories = async () => {
  const res = await api.get('/api/v1/stories')
  stories.value = res.data
}

const startStory = (id) => {
  router.push({ name: 'story', params: { id } })
}

onMounted(fetchStories)
</script>
