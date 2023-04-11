import { createRouter, createWebHistory } from 'vue-router'
import Home from './Screens/Home.vue'
const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
 
]
const router = createRouter({
  history: createWebHistory(),
  routes
})
export default router