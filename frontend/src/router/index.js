import { createRouter, createWebHashHistory } from 'vue-router'
import HomePage from '../views/HomePage.vue'
import CarrosPage from '../views/CarrosPage.vue'
import ClientesPage from '../views/ClientesPage.vue'
import ReviewsPage from '../views/ReviewsPage.vue'
import CarrosCadastroPage from '../views/CarrosCadastroPage.vue'
import CarrosCadastroPageComCliente from '../views/CarrosCadastroPageComCliente.vue'
import ClientesCadastroPage from '../views/ClientesCadastroPage.vue'
import ReviewsCadastroPage from '../views/ReviewsCadastroPage.vue'
import CarrosEditarPage from '../views/CarrosEditarPage.vue'
import ClientesEditarPage from '../views/ClientesEditarPage.vue'
import ReviewsEditarPage from '../views/ReviewsEditarPage.vue'

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
    path: '/cars/createwithcustomer',
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
  {
    path: '/cars/edit',
    name: 'CarrosEditarPage',
    component: CarrosEditarPage
  },
  {
    path: '/customers/edit',
    name: 'ClientesEditarPage',
    component: ClientesEditarPage
  },
  {
    path: '/reviews/edit',
    name: 'ReviewsEditarPage',
    component: ReviewsEditarPage
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
