<template>
    <form class="flex" @submit.prevent="submit">
        <div class="mr-3">
            <img :src="$user.avatar" class="w-12 h-12 rounded-full mr-3">
        </div>
        <div class="flex-grow">
            <textarea class="bg-gray-900 w-full outline-none text-gray-300 text-lg resize-none mb-2" v-model="form.body" placeholder="placeholder" autofocus>
                
            </textarea>
        </div>
        <div class="flex justify-between">
            <div>act</div>
            <div>
<button
            type="submit"
            class="bg-blue-500 rounded-full text-gray-300 text-center px-4 py-3 font-bold leading-none"
          >
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
        }
    }
}
</script>