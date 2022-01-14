<template>
  <div>
    <dropdown v-if="!reposted">
      <template slot="trigger">
          <repost-button :post="post" />
      </template>

      <dropdown-link @click.prevent="repost_unrepost">
        Repost
      </dropdown-link>
      <dropdown-link>
        Repost with comment
      </dropdown-link>
    </dropdown>
    <repost-button v-else :post="post" @click.prevent="repost_unrepost"/>
  </div>
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
        reposts: 'reposts/reposts'
      }),
      reposted () {
        return this.reposts.includes(this.post.id)
      }
    },
    methods: {
      ...mapActions({
        repostPost: 'reposts/repostPost',
        unrepostPost: 'reposts/unrepostPost',
      }),

      repost_unrepost () {
        if (this.reposted) {
          this.unrepostPost(this.post)
          return
        }

        this.repostPost(this.post)
      }
    }
}
</script>