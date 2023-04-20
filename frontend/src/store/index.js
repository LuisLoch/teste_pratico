import { createStore } from 'vuex'
import axios from 'axios'

export default createStore({
  state: {
    customers: [],
    cars: [],
    reviews: [],
    props: {
      cars: {},
      customers: {},
      reviews: {},
      reloadFlag: false
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
    setCarsProps(state, carsProps) {
      state.props.cars = carsProps
    },
    setCustomersProps(state, customersProps) {
      state.props.customers = customersProps
    },
    setReviewsProps(state, reviewsProps) {
      state.props.reviews = reviewsProps
    },
    bindReloadFlag(state) {
      state.props.reloadFlag = !state.props.reloadFlag
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
    setCarsProps({ commit }, carsProps) {
      commit('setCarsProps', carsProps)
    },
    setCustomersProps({ commit }, customersProps) {
      commit('setCustomersProps', customersProps)
    },
    setReviewsProps({ commit }, reviewsProps) {
      commit('setReviewsProps', reviewsProps)
    },
    bindReloadFlag({ commit }) {
      commit('bindReloadFlag')
    }
  },
  modules: {
  }
})
