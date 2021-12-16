<template>
    <div>
        <div class="gy">Hello</div>{{ user }}
    </div>
</template>

<script>
import axios from 'axios'
export default {
   data() {
     return {
       user: null
}
},
methods: {
      async  getUser() {
let response = await axios.get('/api/user')
this.user = response.data
}
},
mounted() {
    this.getUser()
}
}
</script>

<style lang='scss' scoped>
.gy {
    color: red;
font-size: 30px;
    
}
</style>
