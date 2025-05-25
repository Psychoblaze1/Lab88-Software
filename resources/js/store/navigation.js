import axios from 'axios'

const state = {
  sidebarIsVisible: {
    default: true
  }
}
const getters = {
}
const mutations = {
  TOGGLE_SIDENAV(state) {
    state.sidebarIsVisible = !state.sidebarIsVisible
  },
}
const actions = {
  toggleSidebarVisibility({ commit }) {
    commit('TOGGLE_SIDENAV')
  },
}


export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}