import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
import HighchartsVue from 'highcharts-vue'

Vue.use(VueAxios, axios)
Vue.config.productionTip = false
Vue.use(HighchartsVue)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
