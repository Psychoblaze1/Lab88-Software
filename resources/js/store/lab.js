import axios from 'axios'

const state = {
  labs: [],
  instruments: [],
}

const getters = {
  labs(state) {
    return state.labs
  },
  instruments(state) {
    return state.instruments
  },
}

const mutations = {
  SET_LABS(state, data) {
    state.labs = data
  },
  SET_INSTRUMENTS(state, data) {
    state.instruments = data
  },

  FLUSH(state) {
    state.instruments = []
  }
}

const actions = {
  async getLabs({ commit }) {
    await axios
      .get('/api/labs')
      .then((response) => {
        commit('SET_LABS', response.data)
      })
  },
  async getInstruments({ commit }) {
    await axios
      .get('/api/instruments')
      .then((response) => {
        commit('SET_INSTRUMENTS', response.data)
      })
  },
  flushAll({ commit }) {
    commit('FLUSH')
  }
}


export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}