<template>
  <ul class="flex mt-4">
    <li class="w3/12">
      <action-reply  :post="post" />
    </li>
    <li class="w3/12">
      <action-repost  :post="post" />
    </li>
    <li class="w3/12">
      <action-like  :post="post" />
    </li>
  </ul>
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
