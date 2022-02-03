<template>
  <div class="w-full inline-block p-4 border-b border-gray-800 hover:bg-gray-800">
    <component :is="`post-option-${post.type}`" :post="post" />
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
