import { without } from 'lodash'

export default {
  namespaced: true,

  state: {
    reposts: []
  },
  getters: {
    reposts (state) {
      return state.reposts
    }
  },
  mutations: {
    PUSH_REPOSTS (state, data) {
      state.reposts.push(...data)
    },
    PUSH_REPOST (state, id) {
      state.reposts.push(id)
    },
    POP_REPOST (state, id) {
      state.reposts = without(state.reposts, id)
    }
  },
  actions: {
    async repostPost (_, post) {
      await axios.post(`/api/posts/${post.id}/reposts`)
    },
    async unrepostPost (_, post) {
      await axios.delete(`/api/posts/${post.id}/reposts`)
    },
    syncRepost ({ commit, state }, id) {
      if (state.reposts.includes(id)) {
        commit('POP_REPOST', id)
        return
      }
      commit('PUSH_REPOST', id)
    }
  }
}
