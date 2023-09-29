import { createRouter, createWebHistory } from 'vue-router'
import NProgress from 'nprogress'
import Home from '../views/Home.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/About.vue')
    },
    {
      path: '/patient',
      name: 'Patient',
      component: () => import('../views/patient/PatientList.vue')
    },  
    {
      path: '/patient/create',
      name: 'PatientCreate',
      component: () => import('../views/patient/PatientCreate.vue')
    },  
    {
      path: '/patient/edit/:id',
      name: 'PatientEdit',
      component: () => import('../views/patient/PatientEdit.vue')
    },  
  ]
})

router.beforeResolve((to, from, next) => {
  if (to.name) {
    NProgress.start()
  }
  next()
})

router.afterEach(() => {
  NProgress.done()
})

export default router
