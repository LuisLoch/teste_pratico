import { createRouter, createWebHashHistory } from 'vue-router'
import HomePage from '../views/HomePage.vue'
import CarrosPage from '../views/CarrosPage.vue'
import ClientesPage from '../views/ClientesPage.vue'
import ReviewsPage from '../views/ReviewsPage.vue'
import CarrosCadastroPage from '../views/CarrosCadastroPage.vue'
import CarrosCadastroPageComCliente from '../views/CarrosCadastroPageComCliente.vue'
import ClientesCadastroPage from '../views/ClientesCadastroPage.vue'
import ReviewsCadastroPage from '../views/ReviewsCadastroPage.vue'

const routes = [
  {
    path: '/',
    name: 'HomePage',
    component: HomePage
  },
  {
    path: '/cars',
    name: 'CarrosPage',
    component: CarrosPage
  },
  {
    path: '/customers',
    name: 'ClientesPage',
    component: ClientesPage
  },
  {
    path: '/reviews',
    name: 'ReviewsPage',
    component: ReviewsPage
  },
  {
    path: '/cars/create',
    name: 'CarrosCadastroPage',
    component: CarrosCadastroPage
  },
  {
    path: '/cars/create/:id',
    name: 'CarrosCadastroPageComCliente',
    component: CarrosCadastroPageComCliente
  },
  {
    path: '/customers/create',
    name: 'ClientesCadastroPage',
    component: ClientesCadastroPage
  },
  {
    path: '/reviews/create',
    name: 'ReviewsCadastroPage',
    component: ReviewsCadastroPage
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
