<template>
  <div>
    <div class="card-panel">
      <div class="row">
        <div class="col s12 l3">
          <h4 style="margin:0px">Order Billing</h4>
        </div>
        <div class="col s12 l3">
          <h4 style="margin:0px"># {{zeroPad(order.order_number, 5)}}</h4>
        </div>
        <div class="col s12 l6" style="text-align:right;">
          <button @click="$router.go(-1)" class="btn red waves-effect waves-light" type="button" name="save">Cancel
            <!-- <i class="material-icons right">print</i> -->
          </button>&nbsp;
          <button @click="printUpdate" class="btn cyan waves-effect waves-light" type="button" name="save">Print
            <i class="material-icons right">print</i>
          </button>&nbsp;
          <button @click="updateOrder" class="btn cyan waves-effect waves-light" type="button" name="save">Save
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>
    </div>
    <div class="card-panel">
      <div class="row">
        <div class="col s4">
          <div class="row">
            <div class="input-field col s4">
              <span style="color: #9e9e9e;">Customer</span>
            </div>
            <div class="col s6" style="margin-top: 9px;">
              <span style="font-size: 25px;">{{order.customer.fullname}}</span>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s4">
              <span style="color: #9e9e9e;">Billing Date</span>
            </div>
            <div class="col s6">
             <input type="date" v-model="order.order_delivery_date" min="2000-01-01" max="2050-12-31" style="margin: 0 0 8px 0;">
            </div>
          </div>
          <div class="row">
            <div class="input-field col s4">
              <span style="color: #9e9e9e;">Order Date</span>
            </div>
            <div class="col s6">
             <input type="date" v-model="order.order_date" min="2000-01-01" max="2050-12-31" disabled="" style="margin: 0 0 8px 0;">
            </div>
          </div>
        </div>
        <div class="col s3" style="border: 1px solid;padding: 0 0 0 0;">
          <div class="row" style="margin: 5px 0px 10px 0;">
            <div class="col s12" style="text-align: center;">
              <div class="switch">
                <label>Inside
                  <input type="checkbox" v-model="tax_out" @change="taxInOut">
                  <span class="lever"></span>Outside
                </label>
              </div>
            </div>
          </div>
          <table style="border-top: 1px solid;">
            <tbody>
              <tr v-if="!tax_out">
                <td class="pd-zero" style="border-right: 1px solid;"><span style="color: #9e9e9e;font-size: 13px;">SGST</span></td>
                <td class="pd-zero" ><input v-model="order.sgst" id="sgst" type="number" class="input-new" placeholder="" @change="getOtherCalculation"> <b>%</b></td>
              </tr>
              <tr v-if="!tax_out">
                <td class="pd-zero" style="border-right: 1px solid;"><span style="color: #9e9e9e;font-size: 13px;">CGST</span></td>
                <td class="pd-zero"><input v-model="order.cgst" id="cgst" type="number" class="input-new" placeholder="" @change="getOtherCalculation"> <b>%</b></td>
              </tr>
              <tr v-if="tax_out">
                <td class="pd-zero" style="border-right: 1px solid;"><span style="color: #9e9e9e;font-size: 13px;">IGST</span></td>
                <td class="pd-zero"><input v-model="order.igst" id="igst" type="number" class="input-new" placeholder="" @change="getOtherCalculation"> <b>%</b></td>
              </tr>
              <tr>
                <td class="pd-zero" style="border-right: 1px solid;"><span style="color: #9e9e9e;font-size: 13px;">Discount</span></td>
                <td class="pd-zero"><input v-model="order.discount" id="discount" type="number" class="input-new" placeholder="" @change="getOtherCalculation"> <b>%</b></td>
              </tr>
              <tr>
                <td class="pd-zero" style="border-right: 1px solid;"><span style="color: #9e9e9e;font-size: 13px;">Other Charges</span></td>
                <td class="pd-zero"> <input v-model="order.other_charges" id="other_charges" type="number" class="input-new" placeholder="" @change="getOtherCalculation"> ₹</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- <div class="col s2"></div> -->
        <div class="col s5" style="text-align:right;padding-right: 38px;">
          <button @click="paymentModelOpen" class="btn cyan waves-effect waves-light" type="button" name="save" style="width: 259px;height: 180px;font-size: 60px; font-family: 'Patua One', cursive;text-transform: capitalize;background-color: #1abc9c!important;box-shadow: 5px 5px #000000b8;border-radius: 20px; ">Pay
          </button>
        </div>
      </div>
    </div>
    <div class="row" style="text-align: center;">
      <div class="col s3">
        <div class="card-panel" style="padding: 5px;">
          <h6>Grand Total</h6>
          <h5>{{order.total_amount}} ₹</h5>
        </div>
      </div>
      <div class="col s1" style="padding-top: 15px;">
        <h4>-</h4>
      </div>
      <div class="col s3">
        <div class="card-panel" style="padding: 5px;">
          <h6>Paid so far</h6>
          <h5>{{order.paid_amount}} ₹</h5>
        </div>
      </div>
      <div class="col s1" style="padding-top: 15px;">
        <h4>=</h4>
      </div>
      <div class="col s3">
        <div class="card-panel" style="padding: 5px;">
          <h6>Pending Amount</h6>
          <h5>{{order.total_amount - order.paid_amount}} ₹</h5>
        </div>
      </div>
    </div>
    <div class="card-panel">
      <div class="row">
        <div class="col s12">
          <div class="row">
            <div class="col s2">
              <h5>Order Items</h5>
            </div>
            <div class="s8">
              <button class="btn cyan waves-effect waves-light modal-trigger" href="#modal1" type="button" name="save" style="background-color: #d8b116 !important;">Add
                <i class="tiny material-icons right">control_point</i>
              </button>
              <div id="modal1" class="modal">
                <div class="modal-content">
                  <h4 style="text-align:left;">Order Item</h4>
                  <div class="divider"></div><br>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <input v-model="order_item.item_name" id="item_name" type="text" placeholder="" :class="{'error-input': !isValid(order_item.item_name, check_order_item_val)}">
                      <label class="active" for="item_name">Item Name *</label>
                      <div class="errorTxt2" v-if="!isValid(order_item.item_name, check_order_item_val)"><div id="cemail-error" class="error">This field is required.</div></div>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input v-model="order_item.quantity" id="quantity" type="number" placeholder="" :class="{'error-input': !isValid(order_item.quantity, check_order_item_val)}">
                      <label class="active" for="quantity">Quantity</label>
                      <div class="errorTxt2" v-if="!isValid(order_item.quantity, check_order_item_val)"><div id="cemail-error" class="error">This field is required.</div></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <textarea v-model="order_item.extra_notes" id="extra_notes" class="materialize-textarea" placeholder=""></textarea>
                      <label for="extra_notes" class="active">Extra Notes</label>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <a class="btn waves-effect waves-light red lightrn-1" @click="closeModel">Cancel</a> &nbsp;
                  <a class="btn waves-effect waves-light purple lightrn-1" @click="addItem">Save</a>
                  <!-- <a href="#!" class="modal-close waves-effect btn-flat">Agree</a> -->
                </div>
              </div>
            </div>
          </div>
          <div class="divider"></div><br>
          <div class="row">
            <div class="input-field col s9">
              <table class="striped">
                <thead>
                  <tr>
                    <th>Item Name</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: center;">Price</th>
                    <th>Amount</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="order.order_items.length <= 0">
                    <td colspan="3" style="text-align:center;"><h5> No item added </h5></td>
                  </tr>
                  <tr v-for="(item, index) in order.order_items" :key="item.item_name">
                    <td>{{item.item_name}}</td>
                    <td><input type="number" name="qty" v-model="order.order_items[index].quantity" style="width:90%" @input="calculateTotal" class="input-center" tabindex="94"/></td>
                    <td><input type="number" name="price" v-model="order.order_items[index].price" style="width:90%" @input="calculateTotal" class="input-center" :class="{'error-input': !isValid(order.order_items[index].price, check_order_item_list_val)}" tabindex="95"/></td>
                    <td>{{item.total}}</td>
                    <td>
                      <a href="JavaScript:void(0)" @click="viewItem(index)"><i class="material-icons" style="font-size: 17px;">border_color</i></a>&nbsp;
                      <a href="JavaScript:void(0)" @click="deleteItem(index)"><i class="material-icons" style="color: #F44336;">delete</i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="input-field col s3" style="margin-top: 25px;"><br>
              <table style="border: 2px solid grey;">
                <tbody>
                  <tr><td>Sub Total</td><td style="text-align:right;">{{sub_total}} &nbsp;₹</td></tr>
                  <tr><td>Discount</td><td style="text-align:right;">{{total_discount}} &nbsp;₹</td></tr>
                  <tr><td>Total Tax</td><td style="text-align:right;">{{total_tax}} &nbsp;₹</td></tr>
                  <tr><td>Other Charges</td><td style="text-align:right;">{{order.other_charges}} &nbsp;₹</td></tr>
                  <tr style="border-top:1px solid grey"><td>Grand Total</td><td style="text-align:right;">{{order.total_amount}} &nbsp;₹</td></tr>
                </tbody>
              </table>
            </div>
          </div><br><br>
        </div>
      </div>
    </div>
    <div class="card-panel">
      <div class="row">
        <div class="col s8">
          <h5>Order Payment</h5>
        </div>
        <div class="col s4">
          <div id="modal2" class="modal" style="width: 370px;">
            <div class="modal-content">
              <h4 style="text-align:left;">Payment Detail</h4>
              <div class="divider"></div><br>
              <div class="row">
                <div class="input-field col s12">
                  <input v-model="payment.payment_amount" id="payment_amount" type="number" placeholder="" :class="{'error-input': !isValid(payment.payment_amount, check_payment_val)}">
                  <label class="active" for="payment_amount">Payment Amount *</label>
                </div>
                <div class="col s12">
                    <span style="padding-bottom: 10px;"><label>Payment Type</label></span><br>
                    <div class="row">
                      <div class="col s6">
                        <input class="with-gap" type="radio" id="one" value="Cash" v-model="payment.payment_type" >
                        <label for="one">Cash</label> &nbsp;
                      </div>
                      <div class="col s6">
                        <input class="with-gap" type="radio" id="two" value="Cheque" v-model="payment.payment_type">
                        <label for="two">Cheque</label>
                      </div>
                      <div class="col s6">
                        <input class="with-gap" type="radio" id="three" value="Card" v-model="payment.payment_type">
                        <label for="three">Card</label>&nbsp;
                      </div>
                      <div class="col s6">
                        <input class="with-gap" type="radio" id="four" value="Others" v-model="payment.payment_type">
                        <label for="four">Others</label>
                      </div>
                    </div>
                </div>
                <div class="input-field col s12" style="margin-top: 30px;">
                  <input v-model="payment.payment_ref_num" id="payment_ref_num" type="text" placeholder="">
                  <label class="active" for="payment_ref_num">Payment Ref.</label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <a class="btn waves-effect waves-light red lightrn-1" @click="closePaymentModel">Cancel</a> &nbsp;
              <a class="btn waves-effect waves-light purple lightrn-1" @click="addPayment">Save</a>
            </div>
          </div>
        </div>
      </div>
      <div class="divider"></div><br>
      <table class="striped">
        <thead>
          <tr>
            <th>Payment Type</th>
            <th>Payment Ref.</th>
            <th>Payment Amount</th>
            <th>Payment Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="order_payments.data.length <= 0">
            <td colspan="5" style="text-align:center;">
              <h5 style="color:#777a7782;">No Payment History</h5>
            </td>
          </tr>
          <tr v-for="(payment, index) in order_payments.data" :key="payment.id" v-else>
            <td>{{payment.payment_type || 'Cash'}}</td>
            <td>{{payment.payment_ref_num || 'NA'}}</td>
            <td>{{payment.payment_amount}}</td>
            <td>{{payment.created_at}}</td>
            <td>
              <a href="JavaScript:void(0)" @click="viewPaymentItem(index)"><i class="material-icons" style="font-size: 17px;">border_color</i></a>&nbsp;
              <a href="JavaScript:void(0)" @click="deletePaymentItem(index)"><i class="material-icons" style="color: #F44336;">delete</i></a>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row">
        <div class="input-field col s9">
          <div class="row">
            <div class="input-field col s11">
              <textarea v-model="order.extra_notes" id="extra_notes" class="materialize-textarea" placeholder="" style="border: 1px solid rgb(209, 206, 206);margin-top: 10px;padding: 16px;"></textarea>
              <label for="extra_notes" class="active">Order Notes</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import domain from '@/domain_config.js'
export default {
  name: 'OrderAdd',
  data () {
    return {
      tax_out: false,
      sub_total: 0,
      total_discount: 0,
      total_tax: 0,
      show_measurment: false,
      selected_customer: {},
      edit_index: '',
      order_item: {
        quantity: 1
      },
      check_order_item_val: false,
      check_order_item_list_val: false,
      check_payment_val: false,
      order: {
        customer_id: '',
        customer: {},
        order_delivery_date: '',
        order_items: []
      },
      order_payments: {
        data: []
      },
      payment: {
        payment_amount: '',
        payment_type: 'Cash',
        order_id: this.$route.params.order_id
      },
      payment_index: ''
    }
  },
  methods: {
    zeroPad: function (num, places) {
      if (!num) {
        return 0
      }
      var zero = places - num.toString().length + 1
      return Array(+(zero > 0 && zero)).join('0') + num
    },
    closeModel: function () {
      this.order_item = { quantity: 1 }
      this.edit_index = ''
      this.check_order_item_val = false
      window.$('#modal1').modal('close')
    },
    taxToPrice: function (price, tax) {
      return (price * tax / 100).toFixed(2)
    },
    calculateTotal: function () {
      this.sub_total = 0
      for (var index in this.order.order_items) {
        if (!this.order.order_items[index].price) {
          continue
        }
        this.order.order_items[index].total = parseFloat(this.order.order_items[index].price) * parseFloat(this.order.order_items[index].quantity)
        // console.log(index)
        this.sub_total = parseFloat(this.sub_total) + parseFloat(this.order.order_items[index].total)
        this.sub_total = (this.sub_total).toFixed(2)
      }
      this.getOtherCalculation()
    },
    taxInOut: function () {
      if (this.tax_out) {
        this.order.igst = 0
      }
      this.getOtherCalculation()
    },
    getOtherCalculation: function () {
      if (!this.order.other_charges) {
        this.order.other_charges = 0
      }
      this.total_discount = (this.sub_total * this.order.discount) / 100
      if (this.tax_out) {
        var totalIgst = this.taxToPrice(this.sub_total - this.total_discount, this.order.igst)
        this.total_tax = parseFloat(totalIgst)
      } else {
        var totalCgst = this.taxToPrice(this.sub_total - this.total_discount, this.order.cgst)
        var totalSgst = this.taxToPrice(this.sub_total - this.total_discount, this.order.sgst)
        this.total_tax = parseFloat(totalCgst) + parseFloat(totalSgst)
      }
      this.order.total_amount = (parseFloat(this.sub_total) - parseFloat(this.total_discount) + parseFloat(this.total_tax) + parseFloat(this.order.other_charges)).toFixed(2)
      this.order.total_amount = Math.round(this.order.total_amount)
    },
    isValid: function (inputValue, validFor) {
      if (validFor) {
        if (!inputValue) {
          return false
        }
        return true
      } else {
        return true
      }
    },
    addItem: function () {
      if (!this.order_item.item_name || !this.order_item.quantity) {
        this.check_order_item_val = true
        window.Materialize.toast('Please fill required fields', 2000, 'tst-alert')
        return false
      }
      if (this.edit_index !== '') {
        this.order.order_items[this.edit_index] = Object.assign({}, this.order_item)
        window.Materialize.toast('Item Updated', 2000, 'tst-warning')
      } else {
        this.order.order_items.push(this.order_item)
        // window.Materialize.toast('Item Added', 4000, 'tst-success')
      }
      this.closeModel()
    },
    viewItem: function (index) {
      this.edit_index = index
      this.order_item = Object.assign({}, this.order.order_items[index])
      window.$('#modal1').modal('open')
    },
    deleteItem: function (index) {
      this.order.order_items.splice(index, 1)
      this.edit_index = ''
      this.calculateTotal()
      // window.Materialize.toast('Item Deleted!', 4000, 'tst-success')
    },
    updateOrder: function () {
      if (this.tax_out) {
        this.order.cgst = 0
        this.order.sgst = 0
      } else {
        this.order.igst = 0
      }
      this.order.images = []
      this.axios.put(domain.endpoint + 'orders/' + this.$route.params.order_id, this.order).then(response => {
        // this.$router.push({ 'name': 'OrderList' })
        this.$router.go(-1)
        window.Materialize.toast('Order Updated!', 2000, 'tst-success')
      })
    },
    printUpdate: function () {
      if (this.tax_out) {
        this.order.cgst = 0
        this.order.sgst = 0
      } else {
        this.order.igst = 0
      }
      this.order.images = []
      if (this.checkPricingAvail()) {
        this.axios.put(domain.endpoint + 'orders/' + this.$route.params.order_id, this.order).then(response => {
          this.$router.push({ 'name': 'Invoice', params: { 'order_id': this.$route.params.order_id } })
        })
      } else {
        this.check_order_item_list_val = true
      }
    },
    getOrder: function () {
      this.axios.get(domain.endpoint + 'orders/' + this.$route.params.order_id).then(response => {
        this.order = response.data
        this.getOrderPayment(this.$route.params.order_id)
        if (this.order.igst === 0) {
          this.tax_out = false
        } else {
          this.tax_out = true
        }
        this.calculateTotal()
      })
    },
    totalPaidAmount: function () {
      this.order.paid_amount = 0
      for (var indx in this.order_payments.data) {
        this.order.paid_amount = parseFloat(this.order.paid_amount) + parseFloat(this.order_payments.data[indx].payment_amount)
      }
    },
    getOrderPayment: function (orderId) {
      this.axios.get(domain.endpoint + 'payments?filter=order_id:' + orderId).then(response => {
        this.order_payments = response.data
        this.totalPaidAmount()
      })
    },
    paymentModelOpen: function () {
      // console.log(this.order.total_amount - this.order.paid_amount)
      this.payment.payment_amount = this.order.total_amount - this.order.paid_amount
      window.$('#modal2').modal('open')
    },
    closePaymentModel: function () {
      this.payment = {
        payment_type: 'Cash',
        order_id: this.$route.params.order_id
      }
      window.$('#modal2').modal('close')
    },
    addPayment: function () {
      if (!this.payment.payment_amount) {
        this.check_payment_val = true
        window.Materialize.toast('Please fill required fields', 2000, 'tst-alert')
        return false
      } else {
        if (this.payment_index !== '') {
          console.log(this.order_payments.data[this.payment_index].payment_amount)
          if (this.payment.payment_amount > this.order.total_amount - this.order.paid_amount + this.order_payments.data[this.payment_index].payment_amount) {
            window.Materialize.toast('Payment Amount is more than bill amount', 2000, 'tst-alert')
            return false
          }
        } else {
          if (this.payment.payment_amount > this.order.total_amount - this.order.paid_amount) {
            window.Materialize.toast('Payment Amount is more than bill amount', 2000, 'tst-alert')
            return false
          }
        }
      }
      if (this.payment_index !== '') {
        this.axios.put(domain.endpoint + 'payments/' + this.payment.id, this.payment).then(response => {
          this.closePaymentModel()
          this.getOrderPayment(this.$route.params.order_id)
          this.payment_index = ''
          window.Materialize.toast('Payment Updated', 2000, 'tst-warning')
        })
      } else {
        this.axios.post(domain.endpoint + 'payments', this.payment).then(response => {
          this.closePaymentModel()
          this.getOrderPayment(this.$route.params.order_id)
          this.payment_index = ''
          // window.Materialize.toast('Payment Added', 4000, 'tst-success')
        })
      }
    },
    viewPaymentItem: function (index) {
      this.payment_index = index
      this.payment = Object.assign({}, this.order_payments.data[index])
      window.$('#modal2').modal('open')
    },
    deletePaymentItem: function (index) {
      this.axios.delete(domain.endpoint + 'payments/' + this.order_payments.data[index].id).then(response => {
        this.closePaymentModel()
        this.getOrderPayment(this.$route.params.order_id)
        this.payment_index = ''
        // window.Materialize.toast('Payment Deleted', 4000, 'tst-success')
      })
    },
    checkPricingAvail: function () {
      for (var index in this.order.order_items) {
        if (!this.order.order_items[index].price) {
          window.Materialize.toast('Please fill pricing of all item', 2000, 'tst-alert')
          return false
        }
      }
      return true
    }
  },
  mounted: function () {
    window.$('select').material_select()
    window.$('#modal1').modal()
    window.$('#modal2').modal()
    this.getOrder()
  }
}
</script>

<style>
.input-new {
  height: 1rem !important;
  width: 81px !important;
  margin: 0 0 10px 0 !important;
  text-align: center !important;
}
.input-center {
  text-align: center !important;
}
.pd-zero {
  padding: 0 0 0 25px !important;
}
.tst-alert {
  background-color:#f44336;
}
.tst-success {
  background-color:#4caf50;
}
.tst-warning {
  background-color:#ff9800;
}
.error-input {
  border-bottom: 2px solid red !important;
  box-shadow: 0 0px 0 0 #607D8B !important;
}
</style>
