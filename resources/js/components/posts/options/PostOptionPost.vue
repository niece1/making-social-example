<template>
    <div class="flex w-full">
        <div class="mr-3">
            <img :src="post.user.avatar" class="w-12 rounded-full">
        </div>
        <div class="flex-grow">
            <post-username :user="post.user" />   
            <p class="text-gray-300 whitespace-pre-wrap">{{ post.body }}</p>
            <action-faction :post="post" />
            
        </div>
    </div>
</template>

<script>
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
