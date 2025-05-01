import { createRouter, createWebHistory } from 'vue-router'
import StoryList from '../components/StoryList.vue'
import InteractiveStory from '../components/InteractiveStory.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: StoryList,
  },
  {
    path: '/story/:id',
    name: 'story',
    component: InteractiveStory,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
