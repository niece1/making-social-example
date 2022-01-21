<template>
  <div>
    <repost-create :post="post" @success="$emit('close')" />
    <component v-if="post" class="border border-gray-700 rounded-lg mt-4 p-4" :is="`post-option-${post.type}`"
    :post="post" />
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
