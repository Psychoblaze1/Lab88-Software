import axios from 'axios'

const state = {
  authenticated: false,
  user: {},
  permissions: []
}

const getters = {
  authenticated(state) {
    return state.authenticated
  },
  user(state) {
    return state.user
  },
  permissions(state) {
    return state.permissions
  }
}
const mutations = {
  SET_AUTHENTICATED(state, value) {
    state.authenticated = value
  },
  SET_USER(state, value) {
    state.user = value
  },
  SET_PERMISSIONS(state, values) {
    state.permissions = values
  }
}
const actions = {
  async login({ commit }, credentials) {
    // Log user in
    await axios.post('/api/login', credentials)
      .then((response) => {
        commit('SET_AUTHENTICATED', true)
        commit('SET_USER', response.data)
      })
  },
  async logout({ commit }) {
    commit('SET_USER', {})
    commit('SET_AUTHENTICATED', false)
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}