export default {
  posts (state) {
    return state.posts.sort((a, b) => b.created_at - a.created_at)
  },
  //get individual post
  post (state) {
    return id => state.posts.find(p => p.id === id)
  }
}
