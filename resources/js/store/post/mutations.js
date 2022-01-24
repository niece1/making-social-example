import { get } from 'lodash'

export default {
  PUSH_POSTS (state, data) {
    state.posts.push(...data.filter((post) => {
      //when we push posts to timeline in realtime, if they already exists - filter the data, you try to push
      return !state.posts.map((p) => p.id).includes(post.id)
    }))
  },
  SET_LIKES (state, { id, count }) {
    state.posts = state.posts.map((p) => {
      if (p.id === id) {
        p.likes_count = count
      }
      if (get(p.original_post, 'id') === id) {
        p.original_post.likes_count = count
      }
      return p
    })
  },
  SET_REPOSTS (state, { id, count }) {
    state.posts = state.posts.map((p) => {
      if (p.id === id) {
        p.reposts_count = count
      }
      if (get(p.original_post, 'id') === id) {
        p.original_post.reposts_count = count
      }
      return p
    })
  },
  SET_REPLIES (state, { id, count }) {
    state.posts = state.posts.map((p) => {
      if (p.id === id) {
        p.replies_count = count
      }
      if (get(p.original_post, 'id') === id) {
        p.original_post.replies_count = count
      }
      return p
    })
  },
  POP_POST (state, id) {
    state.posts = state.posts.filter((p) => {
      return p.id !== id
    })
  }
}
