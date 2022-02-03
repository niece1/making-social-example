<template>
  <form class="flex" @submit.prevent="submit">
    <img :src="$user.avatar" class="w-12 h-12 rounded-full mr-3">
    <div class="flex-grow">
      <post-create-textarea v-model="form.body" placeholder="Post a reply" />
      <MediaProgressBar class="mb-4" :progress="media.progress" v-if="media.progress" />
      <image-preview :images="media.images" v-if="media.images.length" @removed="removeImage" />
      <video-preview :video="media.video" v-if="media.video" @removed="removeVideo" />
      <div class="flex justify-between">
        <ul class="flex items-center">
          <li class="mr-4">
            <media-button id="media-reply" @selected="handleMediaSelected" />
          </li>
        </ul>
        <div class="flex items-center justify-end">
          <div>
            <create-indicator class="mr-2" :body="form.body" />
          </div>
          <button type="submit" class="bg-blue-500 rounded-full text-gray-300 text-center px-4 py-3 font-bold leading-none">Reply</button>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
  import axios from 'axios'
  import { mapActions } from 'vuex'
  import create from '../../mixins/create'

  export default {
    mixins: [
      create
    ],
    props: {
      post: {
        required: true,
        type: Object
      }
    },
    methods: {
      ...mapActions({
        replyToPost: 'timeline/replyToPost'
      }),
      async postEntity () {
        await this.replyToPost({
          post: this.post,
          data: this.form // form also contains all media id and handled by mixin
        })
        this.$emit('success')
      }
    }
  }
</script>
