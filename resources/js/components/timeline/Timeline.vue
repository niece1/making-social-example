<template>
    <div>
        <div class="border-b-8 border-gray-800 p-4 w-full">
            <post
                v-for="post in posts"
                :key="post.id"
                :post="post"
            />
            
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {

    methods: {
        ...mapActions({
            getPosts: 'timeline/getPosts'
        }),
    },
    computed: {
        ...mapGetters({
            posts: 'timeline/posts'
        }),
    },
    mounted () {
        this.getPosts()
    }
}
</script>

<style lang='scss' scoped>

</style>
