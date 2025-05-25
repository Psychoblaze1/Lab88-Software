import axios from 'axios'

const state = {
  loading: false,
  error: [],
  messages: [],

}
const getters = {
  errors(state) {
    return state.errors
  },
  messages(state) {
    return state.messages
  },
  loading(state) {
    return state.loading
  }
}
const mutations = {
  SET_ERROR(state, value) {
    state.errors.push(value)
  },
  SET_MESSAGE(state, value) {
    state.messages.push(value)
  },
  SET_LOADING(state, value) {
    state.loading = value
  },
  DELETE_MESSAGE(state, messageKey) {
    state.messages.splice(messageKey, 1)
  }
}
const actions = {
  // TODO: handle new/updates/etc of assets
  toggleIsLoading({ commit }) {
    commit('TOGGLE_IS_LOADING')
  },
  setError({ commit }, data) {
    commit('SET_ERROR', data)
  },
  setMessage({ commit }, data) {
    commit('SET_MESSAGE', data)
  },
  setLoading({ commit }, value) {
    commit('SET_LOADING', value)
  },
  removeMessage({ commit }, messageKey) {
    commit('DELETE_MESSAGE', messageKey)
  },

  flushAll({ dispatch }) {
    dispatch("accountAssets/flushAll");
    dispatch("limitTesting/flushAll");
    dispatch("sample/flushAll");
    dispatch("testParameters/flushAll");
  },

}


export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}