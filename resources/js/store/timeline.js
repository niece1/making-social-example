import getters from './post/getters'
import mutations from './post/mutations'
import actions from './post/actions'

export default {
  namespaced: true,
  state: {
    posts: []
  },
  getters,
  mutations,
  actions
}
