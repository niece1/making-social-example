<template>
    <form class="flex" @submit.prevent="submit">
        <div class="mr-3">
            <img :src="$user.avatar" class="w-12 h-12 rounded-full mr-3">
        </div>
        <div class="flex-grow">
            <post-create-textarea v-model="form.body" placeholder="Say something"/>
        </div>
        <div class="flex justify-between">
            
            <div class="flex items-center justify-end">
                <div><create-indicator class="mr-2" :body="form.body" /></div>
                <button type="submit" class="bg-blue-500 rounded-full text-gray-300 text-center px-4 py-3 font-bold leading-none">
                    Post
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import axios from 'axios'

export default {
    data () {
        return {
            form: {
                body: ''
            }
        }
    },
    methods: {
        async submit () {
            await axios.post('/api/posts', this.form)
            this.form.body = '' // for input clean after submit
        }
    }
}
</script>

<style lang='scss' scoped>

</style>
