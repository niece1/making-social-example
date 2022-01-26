<template>
    <div class="flex w-full">
        <div class="mr-3">
            <img :src="post.user.avatar" class="w-12 rounded-full">
        </div>
        <div class="flex-grow">
            <post-username :user="post.user" />
            <post-body :post="post" />
            <post class="border border-gray-700 rounded-lg mt-4" :post="post.original_post" />
            <action-faction  :post="post" />
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
