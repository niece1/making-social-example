import axios from 'axios'
import { without } from 'lodash' //mens lodash library without functions

export default {
  namespaced: true,

  state: {
    likes: []
  },

  getters: {
    likes (state) {
      return state.likes
    }
  },
  // Mutations to push new likes, we pushing because date may have initial list of posts
  mutations: {
    PUSH_LIKES (state, data) {
      state.likes.push(...data)
    },
    PUSH_LIKE (state, id) {
      state.likes.push(id)
    },

    POP_LIKE (state, id) {
      state.likes = without(state.likes, id)//give us back the list likes w/o particular id
    }

  },

  actions: {
    //async because we need network requests,
    //_ is a convention to add required thin we don'tneed (no necessity to commit, because we use realtime)
    async likePost (_, post) {
      await axios.post(`/api/posts/${post.id}/likes`)
    },

    async dislikePost (_, post) {
      await axios.delete(`/api/posts/${post.id}/likes`)
    },
    //by including state, we can read it from our actions
    syncLike ({ commit, state }, id) {
      if (state.likes.includes(id)) {
        commit('POP_LIKE', id)
        return
      }
      // otherwise add like to the list of likes
      commit('PUSH_LIKE', id)
    }

  }
}