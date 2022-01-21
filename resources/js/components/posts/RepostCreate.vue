<template>
  <form class="flex" @submit.prevent="submit">
    <img :src="$user.avatar" class="w-12 h-12 rounded-full mr-3">
    <div class="flex-grow">
      <post-create-textarea v-model="form.body" placeholder="Repost it" />
      <div class="flex justify-between">
        <ul class="flex items-center"></ul>
        <div class="flex items-center justify-end">
          <div>
            <create-indicator class="mr-2" :body="form.body" />
          </div>
          <button type="submit" class="bg-blue-500 rounded-full text-gray-300 text-center px-4 py-3 font-bold leading-none">
            Repost
          </button>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
  import axios from 'axios'


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



    }
</script>