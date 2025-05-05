import { createRouter, createWebHistory } from 'vue-router'
import StoryList from '../components/StoryList.vue'
import InteractiveStory from '../components/InteractiveStory.vue'
import Register from '../components/auth/Register.vue'
import Login from '../components/auth/Login.vue'
import Profile from '../components/auth/Profile.vue'
import Welcome from '../components/Welcome.vue'

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
  {
    path: '/register',
    name: 'register',
    component: Register,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/profile',
    name: 'profile',
    component: Profile,
  },
  { path: '/welcome', component: Welcome },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
