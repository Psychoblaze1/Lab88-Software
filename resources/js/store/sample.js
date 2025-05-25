import axios from 'axios'

const state = {
  samples: [],
  status: [
    "register",
    "receive",
    "prepare",
    "test",
    "validate",
    "report"
  ],
  types: [
    "diesel",
    "petrol",
    "oil",
    "coolant",
  ]
}
// 
const getters = {
  samples(state) {
    return state.samples;
  },
  statuses(state) {
    return state.status;
  },
  sampleTypes(state) {
    return state.types;
  }
}
// 
const mutations = {
  SET_SAMPLES(state, data) {
    state.samples = data
  },
  UPDATE_SAMPLE(state, data) {
    let sample = state.samples.find(sample => sample.id === data.id)
    if (!sample) {
      let index = state.samples.length
      state.samples.splice(index, 1, data)
      console.log('no sample found: UPDATE_SAMPLE', data);
    }
    // Loop through and update by key
    for (const key in data) {
      sample[key] = data[key];
    }
  },
  DELETE_SAMPLE(state, key) {
    state.samples.splice(key, 1);
  },

  FLUSH(state) {
    state.samples = []
  }
}
// 
const actions = {
  setSamples({ commit }, data) {
    commit('SET_SAMPLES', data)
  },
  async getSamples({ commit }) {
    await axios
      .get("/api/samples")
      .then((response) => {
        commit('SET_SAMPLES', response.data)
      })
  },
  async getSample({ commit }, sampleId) {
    await axios
      .get("/api/sample/" + sampleId)
      .then((response) => {
        return response.data;
      })
  },
  async deleteSample({ commit }, data) {
    await axios
      .post("/api/sample/delete", { sample_id: data.sample_id })
      .then((response) => {
        commit('DELETE_SAMPLE', data.arr_key)
      })
  },
  flushAll({ commit }) {
    commit('FLUSH')
  },
  // 
  // STEPS
  async registerSample({ commit }, data) {
    //update DB
    await axios
      .post('/api/sample/register', { formData: data })
      .then(response => {
        if (response.status === 200) {
          commit('UPDATE_SAMPLE', response.data)
        }
      })
  },
  // 
  async receiveSample({ commit }, data) {
    await axios
      .post('/api/sample/receive/', { data: data })
      .then(response => {
        if (response.status === 200) {
          commit('UPDATE_SAMPLE', response.data)
        }
      })
  },
  // 
  async prepareSample({ commit }, data) {
    await axios
      .post('/api/sample/prepare/', { formData: data })
      .then(response => {
        console.log(response.data)
        if (response.status === 200) {
          commit('UPDATE_SAMPLE', response.data)
        }
      })
  },
  // 
  async testSample({ commit }, data) {
    await axios
      .post('/api/sample/test/', { formData: data })
      .then(response => {
        if (response.status === 200) {
          console.log(response.data)
          commit('UPDATE_SAMPLE', response.data)
        }
      })
  },
  // 
  async validateSample({ commit }, data) {
    await axios
      .post('/api/sample/validate/', { formData: data })
      .then(response => {
        console.log(response.data)
        if (response.status === 200) {
          commit('UPDATE_SAMPLE', response.data)
        }
      })
  },
}
// 
export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}