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
    }
  },
  actions: {
    async repostPost (_, post) {
      await axios.post(`/api/posts/${post.id}/reposts`)
    },

    async unrepostPost (_, post) {
      await axios.delete(`/api/posts/${post.id}/reposts`)
    },

  }
}