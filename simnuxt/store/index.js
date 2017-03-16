export const state = {
  server_key: null
}

export const mutations = {
  SET_USER: function (state, user) {
    state.authUser = user
  },
  SET_KEY: function (state, key) {
    state.server_key = key
  }
}

export const actions = {
  initKey ({ commit }) {
    if (process.BROWSER_BUILD) {
      let serverKey = null
      try {
        serverKey = window.localStorage.getItem('server_key')
      } catch (exception) {
        let cookieName = 'server_key'
        let matches = document.cookie.match('(^|;) ?' + cookieName + '=([^;]*)(;|$)')
        serverKey = unescape(matches[2])
      }
      commit('SET_KEY', serverKey)
    }
  },
  setKey ({ commit }, {serverKey}) {
    if (process.BROWSER_BUILD) {
      try {
        window.localStorage.setItem('server_key', serverKey)
      } catch (exception) {
        let date = new Date(new Date(3000, 1, 1))
        document.cookie = `server_key=` + serverKey + `; path=/; expires=` + date.toUTCString()
      }
    }
    commit('SET_KEY', serverKey)
  }
}
