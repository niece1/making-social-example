<template>
    <div class="w-full inline-block p-4 border-b border-gray-800 hover:bg-gray-800">
        
        <div class="flex w-full">
            <div class="mr-3">
                <img :src="post.user.avatar" class="w-12 rounded-full">
            </div>
            <div>
                <post-username
                    :user="post.user"
                />   
                <p class="text-gray-300 whitespace-pre-wrap">{{ post.body }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    props: {
        post: {
            required: true,
            type: Object
        }
    }
}
</script>

<style lang='scss' scoped>

</style>
