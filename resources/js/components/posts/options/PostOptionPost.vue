<template>
  <div class="flex w-full">
    <img :src="post.user.avatar" class="w-12 h-12 mr-3 rounded-full">
    <div class="flex-grow">
      <post-username :user="post.user" />
      <div v-if="post.replying_to" class="text-gray-600 mb-2">
        Replying to <a href="#">@{{ post.replying_to }}</a>
      </div>
      <post-body :post="post" />
      <div class="flex flex-wrap mb-4 mt-4" v-if="images.length">
        <div class="w-6/12 flex-grow" v-for="(image, index) in images" :key="index">
          <img :src="image.url" class="rounded-lg">
        </div>
      </div>
      <div v-if="video" class="mt-4 mb-4">
        <video :src="video.url" controls class="rounded-lg"></video>
      </div>
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
    },
    computed: {
      images () {
        return this.post.media.data.filter(m => m.type === 'image')
      },
      video () {
        return this.post.media.data.filter(m => m.type === 'video')[0] //we need first video
      }
    }
  }
</script>
