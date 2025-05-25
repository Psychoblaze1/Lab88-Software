import axios from "axios";

const state = {
  testParameters: [],
  testParameterCategories: [],
  testStandards: [],
  instruments: []
};

const getters = {
  instruments(state) {
    return state.instruments
  },
  testParameters(state) {
    return state.testParameters;
  },
  testParameterCategories(state) {
    return state.testParameterCategories;
  },
  testStandards(state) {
    return state.testStandards;
  },
};

const mutations = {
  SET_INSTRUMENTS(state, data) {
    state.instruments = data;
  },
  SET_TEST_PARAMETERS(state, data) {
    state.testParameters = data;
  },
  SET_TEST_PARAMETER_CATEGORIES(state, data) {
    state.testParameterCategories = data;
  },
  SET_TEST_STANDARDS(state, data) {
    state.testStandards = data;
  },

  // FLUSH
  FLUSH(state) {
    state.instruments = [];
    state.testParameters = [];
    state.testParameterCategories = [];
    state.testStandards = [];
  },
};
const actions = {
  async getInstruments({ commit }) {
    await axios.get("/api/instruments").then((response) => {
      commit("SET_INSTRUMENTS", response.data);
    });
  },
  async getTestParameters({ commit }) {
    await axios.get("/api/test-parameters").then((response) => {
      commit("SET_TEST_PARAMETERS", response.data);
    });
  },
  async getTestParameterCategories({ commit }) {
    await axios.get("/api/test-parameter-categories").then((response) => {
      commit("SET_TEST_PARAMETER_CATEGORIES", response.data);
    });
  },
  async getTestStandards({ commit }) {
    await axios.get("/api/test-standards").then((response) => {
      commit("SET_TEST_STANDARDS", response.data);
    });
  },

  // Flush store
  flushAll({ commit }) {
    commit("FLUSH");
  },
};
export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
