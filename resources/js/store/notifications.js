import axios from 'axios'
import getters from './post/getters'
import mutations from './post/mutations'
import actions from './post/actions'

export default {
  namespaced: true,

  state: {
    notifications: [],
    posts: []
  },
  getters: {
    ...getters,
    notifications (state) {
      return state.notifications
    },
    postIdsFromNotifications (state) {
      return state.notifications.map(n => n.data.post.id)
    }
  },
  mutations: {
    ...mutations,
    PUSH_NOTIFICATIONS (state, data) {
      state.notifications.push(...data)
    }
  },
  actions: {
    ...actions,
    async getNotifications ({ commit, dispatch, getters }, url) {
      let response = await axios.get(url)
      commit('PUSH_NOTIFICATIONS', response.data.data)
      dispatch('getPosts', `/api/posts?ids=${getters.postIdsFromNotifications.join(',')}`)
      return response
    }
  }
}
