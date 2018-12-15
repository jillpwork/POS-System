<template>
  <div class="cyan">
    <div id="login-page" class="row">
      <div class="col s12 z-depth-4 card-panel" style="width: 350px;margin: 10% 0% 14% 37%;">
      <form class="login-form" style="padding-top: 17px;">
        <div class="row margin">
          <div class="input-field col s12">
            <i class="material-icons prefix pt-5">person_outline</i>
            <input id="username" type="text" v-model="user_auth.username" @keyup.enter="login">
            <label for="username" class="center-align">Username</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="material-icons prefix pt-5">lock_outline</i>
            <input id="password" type="password" v-model="user_auth.password" @keyup.enter="login">
            <label for="password">Password</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <a href="#" class="btn waves-effect waves-light col s12" @click="login">Login</a>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 m12 l12">
            <!-- <p class="margin right-align medium-small"><a href="page-forgot-password.html">Forgot password ?</a></p> -->
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'
import domain from '../domain_config.js'
export default {
  name: 'login',
  data () {
    return {
      user_auth: {
        username: '',
        password: ''
      }
    }
  },
  methods: {
    login: function () {
      this.axios.post(domain.endpoint + 'login/', this.user_auth).then(response => {
        window.localStorage.setItem('metrix', response.data.auth_token)
        this.axios.defaults.headers.common['Authorization'] = response.data.auth_token
        this.$router.push({ 'name': 'Dashboard' })
        location.reload()
      }, response => {
        window.Materialize.toast('Invalid Username Or Password!', 4000, 'tst-alert')
      })
    }
  }
}
</script>
