<template>
    <form class="flex" @submit.prevent="submit">
        <img :src="$user.avatar" class="w-12 h-12 rounded-full mr-3">
        <div class="flex-grow">
            <post-create-textarea v-model="form.body" placeholder="Say something"/>
        </div>
        <!-- if length(has any images), show component -->
        <image-preview :images="media.images" v-if="media.images.length" @removed="removeImage" />
        <video-preview :video="media.video" v-if="media.video" @removed="removeVideo" />
        <div class="flex justify-between">
            <ul class="flex items-center">
                <li class="mr-4">
                    <media-button id="media" @selected="handleMediaSelected" />
                </li>
            </ul>
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
                body: '',
                media: []
            },
            media: {
                images: [],
                video: null
            },
            mediaTypes: {
                images: [],
                video: null
            }
        }
    },
    methods: {
        async submit () {
            await axios.post('/api/posts', this.form)
            this.form.body = '' // for input clean after submit
        },
        async getMediaTypes () {
            let response = await axios.get('api/media/types')
            this.mediaTypes = response.data.data
        },
        handleMediaSelected (files) {
            Array.from(files).slice(0, 4).forEach((file) => {
                if (this.mediaTypes.image.includes(file.type)) {
                    this.media.images.push(file)
                }
                if (this.mediaTypes.video.includes(file.type)) {
                    this.media.video = file // because we have only 1 video type
                }
            })
            if (this.media.video) {
                this.media.images = []
            }
        },
        removeVideo () {
            this.media.video = null
        },
        removeImage (image) {
            this.media.images = this.media.images.filter((i) => {
                return image !== i
            })
        },
    },
    mounted () {
        this.getMediaTypes()
    }
}
</script>

<style lang='scss' scoped>

</style>
