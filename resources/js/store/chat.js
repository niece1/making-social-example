import actions from './post/actions'
import mutations from './post/mutations'
import getters from './post/getters'

export default {
  namespaced: true,

  state: {
    posts: []
  },
  getters: {
    ...getters,
    post (state) {
      // return individ object rather than array of posts (find here instead of filter)
      return id => state.posts.find(p => p.id = id)
    },
    parents(state) {
      return id => state.posts.filter(p => {
        return p.id != id && !p.parent_ids.includes(parseInt(id))
      }).sort((a, b) => a.created_at - b.created_at)
    },
    replies(state) {
      return id => state.posts.filter(p => p.parent_id = id).sort((a, b) => a.created_at - b.created_at)
    }
  },
  mutations,
  actions
}
