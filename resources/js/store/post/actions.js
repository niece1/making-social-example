import axios from 'axios'

export default {
  async getPosts ({ commit }, url) {
	let response = await axios.get(url)
	commit('PUSH_POSTS', response.data.data)
    //root: true is a 3d arg needed because we access likes module outside timeline
    commit('likes/PUSH_LIKES', response.data.meta.likes, { root: true })
    commit('reposts/PUSH_REPOSTS', response.data.meta.reposts, { root: true })
    return response
  },
  // _ means we don't need to commit
  async quotePost (_, { post, data }) {
  	await axios.post(`/api/posts/${post.id}/quotes`, data)
  },
  async replyToPost (_, { post, data }) {
  	await axios.post(`/api/posts/${post.id}/replies`, data)
  }
}
