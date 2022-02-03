<template>
  <div>
    <div>
      <post v-for="p in parents(id)" :post="p" :key="p.id" />
    </div>
    <div class="text-lg border-b-8 border-t-8 border-gray-800">
      <post v-if="post(id)" :post="post(id)" />
    </div>
    <div>
      <post v-for="p in replies(id)" :post="p" :key="p.id" />
    </div>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'
  
  export default {
    props: {
      id: {
        required: true,
        type: String
      }
    },
    methods: {
      ...mapActions({
        getPosts: 'chat/getPosts'
      })
    },
    computed: {
      ...mapGetters({
        post: 'chat/post',
        parents: 'chat/parents',
        replies: 'chat/replies',
      })
    },
    mounted () {
      this.getPosts(`/api/posts/${this.id}`)
      this.getPosts(`/api/posts/${this.id}/replies`)
    }
  }
</script>
