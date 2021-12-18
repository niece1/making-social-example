<template>
    <div>
        <div class="border-b-8 border-gray-800 p-4 w-full">
            <post
                v-for="post in posts"
                :key="post.id"
                :post="post"
            />
            <div v-if="posts.length" v-observe-visibility="{ callback: handleScrolledToBottomOfTimeline }">
                
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

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
        loadPosts () {
            this.getPosts(this.urlWithPage).then((response) => {
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
    }
}
</script>

<style lang='scss' scoped>

</style>
