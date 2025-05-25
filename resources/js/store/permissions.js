import axios from 'axios'

const state = {
    permissions: []
}

const getters = {
    permissions: state => state.permissions
}

const actions = {
    fetchPermissions({ commit }) {
        // Make an HTTP request to fetch the user's permissions
        axios.get('/api/permissions').then(response => {
            // Update the state with the fetched permissions
            commit('SET_PERMISSIONS', response.data)
        })
    }
}

const mutations = {
    SET_PERMISSIONS(state, payload) {
        state.permissions = payload
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}