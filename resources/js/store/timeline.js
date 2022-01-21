import axios from 'axios'
import { get } from 'lodash'

export default {
    namespaced: true,

    state: {
        posts: []
    },
    getters: {
        posts (state) {
            return state.posts.sort((a, b) => b.created_at - a.created_at)
        }
    },
    mutations: {
        PUSH_POSTS (state, data) {
            state.posts.push(...data.filter((post) => {
                //when we push posts to timeline in realtime, if they already exists - filter the data, you try to push
                return !state.posts.map((t) => t.id).includes(post.id)
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
        POP_POST (state, id) {
            state.posts = state.posts.filter((p) => {
                return p.id !== id
            })
        },
    },
    actions: {
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
        }
    }
}
