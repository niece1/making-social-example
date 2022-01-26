<template>
  <div class="p-4">
    <div class="text-gray-300 mb-4">
      <post-username :user="notification.data.user" /> mentioned you in a post
    </div>
    <p class="text-gray-600">
      {{ notification.data.post.body }}
    </p>
  </div>
</template>

<script>
  export default {
    props: {
      notification: {
        required: true,
        type: Object
      }
    }
  }
</script>
