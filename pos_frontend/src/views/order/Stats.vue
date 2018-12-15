<template>
  <div>
    <div class="card-panel">
      <div class="row">
        <div class="col s8">
          <h4 style="margin:0px">Customer Orders</h4>
        </div>
        <div class="col s4" style="text-align: right;">
          <!-- <router-link :to="{'name': 'OrderAdd'}" class="waves-effect waves-light btn-large ">
            <i class="material-icons right">content_paste</i> New Order
          </router-link> -->
          <!-- <router-link :to="{'name': 'OrderAdd'}" class="btn-floating waves-effect waves-light "><i class="material-icons">content_paste</i></router-link> -->
        </div>
      </div>
    </div>
    <div class="card-panel">
      <div class="row">
        <div class="input-field col s3">
          <label class="active">Customer</label>
          <selectable id="customer" display-label="fullname" resource-name="customers" filters="fullname" v-model="search_customer" @input="getOrders"></selectable>
        </div>
        <div class="input-field col s3">
          <input v-model="search_order_number" id="search_order_number" type="number" placeholder="" @change="getOrders">
          <label class="active" for="item_name">Order Number</label>
        </div>
        <div class="col s3">
            <span>
              <label>Payment Status</label>
            </span><br>
            <input class="with-gap" type="radio" id="one" value="all" v-model="search_payment_status" @change="getOrders">
            <label for="one">All</label> &nbsp;
            <input class="with-gap" type="radio" id="two" value="true" v-model="search_payment_status" @change="getOrders">
            <label for="two">Paid</label>
            <input class="with-gap" type="radio" id="three" value="false" v-model="search_payment_status" @change="getOrders">
            <label for="three">Pending</label>
        </div>
        <div class="input-field col s3" style="text-align:right;">
          <a class="btn waves-effect waves-light amber darken-4" @click="clearFilter"><i class="material-icons">refresh</i></a>
        </div>
      </div>
      <!-- <div class="row">
        <div class="input-field col s3">
          <label class="active">From date</label>
          <span><input type="date" v-model="search_from_date" @change="getOrders"></span>
        </div>
        <div class="input-field col s3">
          <label class="active">To date</label>
          <span><input type="date" v-model="search_to_date" @change="getOrders"></span>
        </div>
      </div> -->
      <br>
      <table class="striped">
        <thead>
          <tr>
            <th>Order Number</th>
            <th>Customer</th>
            <th>Order Date</th>
            <th>Billing Amount</th>
            <th>Pending Amount</th>
            <th style="text-align:center;">
              Payment Status
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="orders.data.length <= 0">
            <td colspan="6" style="text-align:center;"><h5>No Orders Found</h5></td>
          </tr>
          <tr v-for="order in orders.data" :key="order.id">
            <td>{{order.order_number}}</td>
            <td><a href="JavaScript:void(0)" @click="getSelectedCustomer(order.customer_id)">{{order.customer_name}}</a></td>
            <td>{{order.order_date_n_day}}</td>
            <td style="text-align:center;"><span v-if="order.total_amount">{{order.total_amount}}</span><span v-else>NA</span></td>
            <td style="text-align:center;">{{order.total_amount - order.paid_amount || 'NA'}}</td>
            <td style="text-align:center;"><span v-if="order.paid_status" style="color: green;">Paid</span><span v-else style="color: red;">Pending</span></td>
            <td>
              <router-link :to="{name: 'OrderBilling', params: {'order_id': order.id}}">
               <i class="material-icons">credit_card</i>
              </router-link>&nbsp;
              <!-- <router-link :to="{name: 'OrderEdit', params: {'order_id': order.id}}">
                <i class="material-icons">border_color</i>
              </router-link> -->
            </td>
          </tr>
        </tbody>
      </table>
      <div id="modal1" class="modal">
        <div class="modal-content">
          <h4>{{selected_customer.fullname}}</h4>
          <div class="divider"></div><br>
          <div class="row">
            <div class="input-field col s12 m4 l4">
              <input id="email" type="number" v-model="selected_customer.mobile" placeholder="" disabled="" style="color: black;">
              <label class="active" for="email">Mobbile Number</label>
            </div>
            <div class="input-field col s12 m4 l4">
              <input id="email" type="number" v-model="selected_customer.phone_number" placeholder="" disabled="" style="color: black;">
              <label class="active" for="email">Other Phone Number</label>
            </div>
            <div class="input-field col s12 m4 l4">
              <input id="email" type="email" v-model="selected_customer.email" placeholder="" disabled="" style="color: black;">
              <label class="active" for="email">Email</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="email" type="text" v-model="selected_customer.address_street" placeholder="" disabled="" style="color: black;">
              <label class="active" for="email">Address Street</label>
            </div>
            <div class="input-field col s12 m4 l4">
              <input id="email" type="text" v-model="selected_customer.country" placeholder="" disabled="" style="color: black;">
              <label class="active" for="email">Country</label>
            </div>
            <div class="input-field col s12 m4 l4">
              <input id="email" type="text" v-model="selected_customer.city" placeholder="" disabled="" style="color: black;">
              <label class="active" for="email">City</label>
            </div>
            <div class="input-field col s12 m4 l4">
              <input id="email" type="number" v-model="selected_customer.postalcode" placeholder="" disabled="" style="color: black;">
              <label class="active" for="email">Pincode</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a class="btn waves-effect waves-light red lightrn-1 modal-close">Close</a> &nbsp;
          <!-- <a href="#!" class="modal-close waves-effect btn-flat">Agree</a> -->
        </div>
      </div>
      <hr>
      <div id="pagination" style="text-align: right;"></div>
    </div>
  </div>
</template>

<script>
import domain from '../../domain_config.js'
import Selectable from '@/components/Selectable.vue'
export default {
  name: 'OrderList',
  components: {
    Selectable
  },
  data () {
    return {
      search_customer: '',
      search_order_number: '',
      search_payment_status: 'all',
      search_from_date: '',
      search_to_date: '',
      selected_customer: {},
      orders: {
        data: []
      }
    }
  },
  methods: {
    clearFilter: function () {
      this.search_customer = ''
      this.search_order_number = ''
      this.search_payment_status = 'all'
      this.search_from_date = ''
      this.search_to_date = ''
      this.orders = {
        data: []
      }
      // this.getOrders()
    },
    changeCustomer: function () {
      this.$router.push({ 'name': 'Stats', 'query': { 'customer': this.search_customer } })
    },
    getSelectedCustomer: function (id) {
      this.axios.get(domain.endpoint + 'customers/' + id).then(response => {
        this.selected_customer = response.data
        window.$('.modal').modal('open')
      })
    },
    getFilterOrder: function (pagNumber) {
      var url = '?page=' + pagNumber
      if (this.search_payment_status !== 'all') {
        url += '&filter=paid_status:' + this.search_payment_status + ','
        // this.search_payment_status = ''
      } else {
        url += '&filter='
      }
      if (this.search_customer) {
        url += 'customer_id:' + this.search_customer + ','
        this.$router.push({ 'name': 'Stats', 'query': { 'customer': this.search_customer } })
      } else {
        this.orders = {
          data: []
        }
        return false
      }
      if (this.search_order_number) {
        url += 'order_number:' + this.search_order_number + ','
      }
      if (this.search_to_date && this.search_from_date) {
        url += '&from_date=' + this.search_from_date + '&to_date=' + this.search_to_date
      }
      this.axios.get(domain.endpoint + 'orders' + url).then(response => {
        this.orders = response.data
      })
    },
    getOrders () {
      var url = '?filter=' // '?filter=paid_status:' + this.search_payment_status + ','
      if (this.search_payment_status !== 'all') {
        url += 'paid_status:' + this.search_payment_status + ','
        // this.search_payment_status = ''
      }
      if (this.search_customer) {
        url += 'customer_id:' + this.search_customer + ','
      } else {
        this.orders = {
          data: []
        }
        return false
      }
      if (this.search_order_number) {
        url += 'order_number:' + this.search_order_number + ','
      }
      if (this.search_to_date && this.search_from_date) {
        url += '&from_date=' + this.search_from_date + '&to_date=' + this.search_to_date
      }
      this.axios.get(domain.endpoint + 'orders' + url).then(response => {
        this.orders = response.data
        var vm = this
        window.$('#pagination').twbsPagination('destroy')
        window.$('#pagination').twbsPagination({
          totalPages: this.orders.meta.last_page,
          visiblePages: 10,
          onPageClick: function (event, page) {
            vm.getFilterOrder(page)
          }
        })
      })
    }
  },
  mounted: function () {
    window.$('.modal').modal()
    if (this.$route.query.customer) {
      this.search_customer = this.$route.query.customer
      this.getOrders()
    }
  }
}
</script>
