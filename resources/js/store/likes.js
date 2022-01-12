import axios from 'axios'
import { without } from 'lodash'

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


  }
}