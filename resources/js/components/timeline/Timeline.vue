<template>
    <div>
        <div class="border-b-8 border-gray-800 p-4 w-full">
            <post-create />
        </div>
        <post
            v-for="post in posts"
            :key="post.id"
            :post="post"
        />
        <div v-if="posts.length" v-observe-visibility="{ callback: handleScrolledToBottomOfTimeline }"></div>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'

export default {
    data () {
        return {
            page: 1,
            lastPage: 1
        }
    },
    methods: {
        ...mapActions({
            getPosts: 'timeline/getPosts'
        }),
        // for websockets
        ...mapMutations({
            PUSH_POSTS: 'timeline/PUSH_POSTS'
        }),
        loadPosts () {
            this.getPosts(this.urlWithPage).then((response) => {
                // infinite scroll
                this.lastPage = response.data.meta.last_page
            })
        },
        handleScrolledToBottomOfTimeline (isVisible) {
            if (!isVisible) {
                return
            }
            if (this.lastPage === this.page) {
                return
            }
            this.page++
            this.loadPosts()
        }
    },
    computed: {
        ...mapGetters({
            posts: 'timeline/posts'
        }),
        urlWithPage () {
            return `/api/timeline?page=${this.page}`
        }
    },
    mounted () {
        this.loadPosts()

        Echo.private(`timeline.${this.$user.id}`)
        .listen('.PostWasCreated', (e) => {
          this.PUSH_POSTS([e])
        })
    }
}
</script>

<style lang='scss' scoped>

</style>
