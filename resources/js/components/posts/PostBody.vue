<template>
  <p class="text-gray-300 whitespace-pre-wrap">
    <component :is="body" />
  </p>
</template>

<script>
  export default {
    props: {
      post: {
        required: true,
        type: Object
      }
    },
    computed: {
      body () {
        return {
          'template': `<div>${this.replaceFacilities(this.post.body)}</div>`
        }
      },
      facilities () {
        return this.post.facilities.data.sort((a, b) => b.start - a.start)
      }
    },
    methods: {
      replaceFacilities (body) {
        this.facilities.forEach((facility) => {
          body = body.substring(0, facility.start) + this.facilityComponent(facility) + body.substring(facility.end)
        })
        return body
      },
      facilityComponent (facility) {
        return `<${facility.type}-facility body="${facility.body}" />`
      }
    }
  }
</script>
