<template>
  <div class="p-4 flex-grow">
    <post v-if="resolvedPost" :post="resolvedPost" class="!border-0" />
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    props: {
      notification: {
        required: true,
        type: Object
      }
    },
    computed: {
      ...mapGetters({
        post: 'notifications/post'
      }),
      resolvedPost () {
        return this.post(this.notification.data.post.id)
      }
    }
  }
</script>
