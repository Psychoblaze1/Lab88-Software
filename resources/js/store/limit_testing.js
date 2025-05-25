import axios from 'axios'

const state = {
  limit_suites: [],
  suite_parameters: []
}

const getters = {
  limitSuites(state) {
    return state.limit_suites
  },
}

const mutations = {
  SET_LIMIT_SUITES(state, data) {
    state.limit_suites = data
  },
  FLUSH(state) {
    state.limit_suites = []
  }
}

const actions = {
  async getLimitSuites({ commit }) {
    await axios
      .get('/api/limit-suites')
      .then((response) => {
        commit('SET_LIMIT_SUITES', response.data)
      })
  },
  flushAll({ commit }) {
    commit('FLUSH', '')
  }
}


export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}