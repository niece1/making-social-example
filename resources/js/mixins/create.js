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
        video: null,
        progress: 0
      },
      mediaTypes: {}
    }
  },
  methods: {
    async submit () {
      // if needs to prevent showing progress bar whe we click Post button w/o media attached
      if (this.media.images.length || this.media.video) {
        let media = await this.uploadMedia()
        this.form.media = media.data.data.map(r => r.id)
      }
      await this.postEntity() // used in PostCreate, RepostCreate methods postEntity()
      this.form.body = ''
      this.form.media = []
      this.media.video = null
      this.media.images = []
      this.media.progress = 0
    },
    handleUploadProgress (event) {
      this.media.progress = parseInt(Math.round((event.loaded / event.total) * 100))
    },
    async uploadMedia () {
      return await axios.post('/api/media', this.buildMediaForm(), {
        // we add headers because we upload files
        headers: {
          'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: this.handleUploadProgress
      })
    },
    buildMediaForm () {
      let form = new FormData()
      if (this.media.images.length) {
        this.media.images.forEach((image, index) => {
          // inside media entry needed for multiple file uploads
          form.append(`media[${index}]`, image)
        })
      }
      if (this.media.video) {
        form.append('media[0]', this.media.video)
      }
      return form
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
