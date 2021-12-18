import axios from 'axios'

export default {
    namespaced: true,

    state: {
        posts: []
    },
    getters: {
        posts (state) {
            return state.posts
        }
    },
    mutations: {
        PUSH_POSTS (state, data) {
            state.posts.push(...data)
        }
    },
    actions: {
        async getPosts ({ commit }, url) {
            let response = await axios.get(url)
            commit('PUSH_POSTS', response.data.data)
            return response
        }
    }
}
