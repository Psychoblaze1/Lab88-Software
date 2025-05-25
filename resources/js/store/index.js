import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

// modules
import account from './modules/account'
import auth from './modules/auth'
import lab from './lab'
import limitTesting from './limit_testing'
import navigation from './navigation'
import sample from './sample'
import system from './system'
import systemLibrary from './modules/systemLibrary'

export default new Vuex.Store({
  plugins: [
    createPersistedState()
  ],
  modules: {
    account,
    auth,
    lab,
    limitTesting,
    navigation,
    sample,
    system,
    systemLibrary
  }
})
