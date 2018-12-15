<template>
  <div class="about">
    <!-- {{this.upload.image}} -->
    <input type="file" name="img" @change="takeImg" multiple/>
    <button @click="uploadImg">Upload Image</button><br>
    <img :src="img" alt="user image" style="width: 200px;margin-left:10px;" v-for="(img, index) in img_url" v-if="img" :key="index">
  </div>
</template>
<script>
import domain from '../domain_config.js'
export default {
  name: 'About',
  data () {
    return {
      upload: {
        image: 'photo uploading'
      },
      img_url: []
    }
  },
  methods: {
    uploadImg: function () {
      this.axios.post(domain.endpoint + 'uploadimg/', this.upload).then(response => {
        console.log('response of upload')
      })
    },
    takeImg: function (event) {
      var files = event.target.files
      this.img_url = []
      for (var i in files) {
        if (i === 'length') {
          break
        }
        var filReader = new FileReader()
        var file = files[i]
        var thisI = this
        filReader.onload = (e) => {
          thisI.img_url.push(e.target.result)
        }
        filReader.readAsDataURL(file)
      }
      this.upload.image = this.img_url
    }
  }
}
</script>
