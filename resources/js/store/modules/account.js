import axios from "axios";

const state = {
  accounts: [],
  assets: [],
  components: [],
  samplePoints: [],
  sites: [],
  assetChain: []
};

const getters = {
  assetChain(state) {
    return state.assetChain
  },
  accounts(state) {
    return state.accounts;
  },
  assets(state) {
    return state.assets;
  },
  components(state) {
    return state.components;
  },
  samplePoints(state) {
    return state.samplePoints;
  },
  sites(state) {
    return state.sites;
  },
  //
  getSitesByAccount(state, accountId) {
    console.log(accountId);
    return state.sites.filter((site) => {
      if (site.account_id === accountId) {
        return site;
      }
    });
  },
};

const mutations = {
  SET_ACCOUNTS(state, data) {
    state.accounts = data;
  },
  SET_ASSETS(state, data) {
    state.assets = data;
  },
  SET_COMPONENTS(state, data) {
    state.components = data;
  },
  SET_SAMPLE_POINTS(state, data) {
    state.samplePoints = data;
  },
  SET_SITES(state, data) {
    state.sites = data;
  },
  SET_ASSET_CHAIN(state, data) {
    state.assetChain = data
  },
  // FLUSH
  FLUSH(state) {
    state.assets = [];
    state.components = [];
    state.samplePoints = [];
    state.sites = [];
  },
};
const actions = {
  getAccountData({ commit }) {
    axios.get("/api/accounts").then((response) => {
      commit("SET_ACCOUNTS", response.data);
    });
  },
  async getAccounts({ commit }) {
    await axios.get("/api/accounts").then((response) => {
      commit("SET_ACCOUNTS", response.data);
    });
  },
  async getAssets({ commit }) {
    await axios.get("/api/assets").then((response) => {
      commit("SET_ASSETS", response.data);
    });
  },
  async getComponents({ commit }) {
    await axios.get("/api/components").then((response) => {
      commit("SET_COMPONENTS", response.data);
    });
  },
  async getSamplePoints({ commit }) {
    await axios.get("/api/sample-points").then((response) => {
      commit("SET_SAMPLE_POINTS", response.data);
    });
  },
  async getSites({ commit }) {
    await axios.get("/api/sites").then((response) => {
      commit("SET_SITES", response.data);
    });
  },
  async getAssetChain({ commit }) {
    await axios.get("/api/assetChain").then((response) => {
      commit("SET_ASSET_CHAIN", response.data)
    })
  },

  // Focused Requests
  async getAssetsBySite({ commit }, siteId) {
    await axios.get("/api/assets-by-site/" + siteId).then((response) => {
      commit("SET_ASSETS", response.data);
    });
  },
  async getSitesByAccount({ commit }, accountId) {
    await axios
      .get("/api/sites-by-account/" + accountId)
      .then((response) => {
        commit("SET_SITES", response.data);
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
