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
import axios from 'axios'

export default {
    data() {
        return {
            posts: []
        }
    },
    methods: {
        async getPosts() {
            let response = await axios.get('/api/timeline')
            this.posts = response.data.data
        }
    },
    mounted() {
        this.getPosts()
    }
}
</script>

<style lang='scss' scoped>

</style>
