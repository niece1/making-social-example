<template>
  <a href="#" class="flex items-center text-base" @click.prevent="like_dislike">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="fill-current text-gray-600 w-5 mr-2" :class="{ 'text-red-600': liked }">
      <path d="M12.76 3.76a6 6 0 0 1 8.48 8.48l-8.53 8.54a1 1 0 0 1-1.42 0l-8.53-8.54a6 6 0 0 1 8.48-8.48l.76.75.76-.75zm7.07 7.07a4 4 0 1 0-5.66-5.66l-1.46 1.47a1 1 0 0 1-1.42 0L9.83 5.17a4 4 0 1 0-5.66 5.66L12 18.66l7.83-7.83z"/>
    </svg>
    <span class="text-gray-600" :class="{ 'text-red-600': liked }">
      {{ post.likes_count }}
    </span>
  </a>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    props: {
        post: {
            required: true,
            type: Object
        }
    },
    computed: {
      ...mapGetters({
        likes: 'likes/likes'
      }),

      liked () {
        //if post id within array of likes
        return this.likes.includes(this.post.id)
      }
    },
    methods: {
      ...mapActions({
        likePost: 'likes/likePost',
        dislikePost: 'likes/dislikePost',
      }),

      like_dislike () {
        if (this.liked) {
          this.dislikePost(this.post)
          return
        }

        this.likePost(this.post)
      }
    }
}
</script>

<style lang='scss' scoped>

</style>
