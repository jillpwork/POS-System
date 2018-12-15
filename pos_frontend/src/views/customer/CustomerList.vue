<template>
  <div>
    <div class="card-panel">
      <div class="row">
        <div class="col s8">
          <h4 style="margin:0px">Customer List</h4>
        </div>
        <div class="col s4" style="text-align: right;">
          <router-link :to="{'name': 'CustomerAdd'}" class="waves-effect waves-light btn-large ">
            <i class="material-icons right">person_add</i> New Customer
          </router-link>
          <!-- <router-link :to="{'name': 'CustomerAdd'}" class="btn-floating waves-effect waves-light "><i class="material-icons">person_add</i></router-link> -->
        </div>
      </div>
    </div>
    <div class="card-panel">
      <div class="row">
        <div class="input-field col s3">
          <input v-model="search_name" id="fullname" type="text" placeholder="" @input="getCustomers">
          <label class="active" for="fullname">Customer Name</label>
        </div>
        <div class="input-field col s3">
          <input v-model="search_number" id="number" type="text" placeholder="" @input="getCustomers">
          <label class="active" for="number">Contact Number</label>
        </div>
        <div class="input-field col s6" style="text-align:right;">
          <a class="btn waves-effect waves-light amber darken-4" @click="clearFilter"><i class="material-icons">refresh</i></a>
        </div>
      </div><br>
      <table class="striped">
        <thead>
          <tr>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Contact Number</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="customers.data.length <= 0">
            <td colspan="4" style="text-align:center;"><h5>No Customer Found</h5></td>
          </tr>
          <tr v-for="customer in customers.data" :key="customer.id">
            <td>{{customer.fullname}}</td>
            <td>{{customer.email || 'NA'}}</td>
            <td>{{customer.mobile}}, {{customer.phone_number}}</td>
            <td>
              <router-link :to="{name: 'OrderAdd', query: {'customer_id': customer.id}}">
                <i class="material-icons">content_paste</i>
              </router-link>&nbsp;
              <router-link :to="{name: 'CustomerEdit', params: {'customer_id': customer.id}}">
                <i class="material-icons">border_color</i>
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
      <hr>
      <div id="pagination" style="text-align: right;"></div>
    </div>
  </div>
</template>

<script>
import domain from '../../domain_config.js'
export default {
  name: 'CustomerList',
  data () {
    return {
      search_name: '',
      search_number: '',
      customers: {
        data: []
      }
    }
  },
  methods: {
    clearFilter: function () {
      this.search_name = ''
      this.search_number = ''
      this.getCustomers()
    },
    getFilterCustomer: function (pagNumber) {
      var url = '?page=' + pagNumber
      url += '&filter='
      if (this.search_name !== '') {
        url += 'fullname:' + this.search_name
      }
      if (this.search_number !== '') {
        if (this.search_name) {
          url += ','
        }
        url += 'mobile:' + this.search_number
      }
      this.axios.get(domain.endpoint + 'customers' + url).then(response => {
        this.customers = response.data
      })
    },
    getCustomers () {
      var url = '?filter='
      if (this.search_name !== '') {
        url += 'fullname:' + this.search_name
      }
      if (this.search_number !== '') {
        if (this.search_name) {
          url += ','
        }
        url += 'mobile:' + this.search_number
      }
      this.axios.get(domain.endpoint + 'customers' + url).then(response => {
        this.customers = response.data
        var vm = this
        window.$('#pagination').twbsPagination('destroy')
        window.$('#pagination').twbsPagination({
          totalPages: this.customers.meta.last_page,
          visiblePages: 10,
          onPageClick: function (event, page) {
            vm.getFilterCustomer(page)
          }
        })
      })
    }
  },
  mounted: function () {
    this.getCustomers()
  }
}
</script>
