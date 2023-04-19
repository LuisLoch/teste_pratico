import { createStore } from 'vuex'
import axios from 'axios'

export default createStore({
  state: {
    customers: [],
    cars: [],
    reviews: [],
    props: {
      cars: [],
      customers: [],
      reviews: []
    }
  },
  mutations: {
    loadCars(state, cars) {
      state.cars = cars['data'];
    },
    loadCustomers(state, customers) {
      state.customers = customers['data'];
    },
    loadReviews(state, reviews) {
      state.reviews = reviews['data'];
    },
    loadBag(state, products) {
      console.log(products)
      state.productsInBag = products
    },
    addToBag(state, product) {
      state.productsInBag.push(product)
      localStorage.setItem('productsInBag', JSON.stringify(state.productsInBag))
    },
    removeFromBag(state, productId) {
      var updatedBag = state.productsInBag.filter(item => productId != item.id)
      state.productsInBag = updatedBag
      localStorage.setItem('productsInBag', JSON.stringify(state.productsInBag))
    }
  },
  actions: {
    loadCars({ commit }) {
      axios.get('http://localhost/blegon/backend/api/cars')
      .then(response => {
        commit('loadCars', response.data)
      })
    },
    loadCustomers({ commit }) {
      axios.get('http://localhost/blegon/backend/api/customers')
      .then(response => {
        commit('loadCustomers', response.data)
      })
    },
    loadReviews({ commit }) {
      axios.get('http://localhost/blegon/backend/api/reviews')
      .then(response => {
        commit('loadReviews', response.data)
      })
    },
    loadBag({ commit }) {
      if(localStorage.getItem('productsInBag')) {
        commit('loadBag', JSON.parse(localStorage.getItem('productsInBag')))
      }
    },
    addToBag({ commit }, product) {
      commit('addToBag', product)
    },
    removeFromBag({ commit }, productId) {
      if(confirm("Deseja realmente remover o produto do carrinho?")) {
        commit('removeFromBag', productId)
      }
    }
  },
  modules: {
  }
})
