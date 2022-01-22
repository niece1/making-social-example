<template>
  <div>
    <component v-if="post" :is="`post-option-${post.type}`" class="mb-4" :post="post" />
    <reply-create v-if="post" :post="post" @success="$emit('close')" />
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
