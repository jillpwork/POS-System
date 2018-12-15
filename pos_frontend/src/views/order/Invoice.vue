<template>
  <div>
    <div class="row" style="width: 21cm;margin: auto;">
      <div class="col s9">
        <h4>Order Invoice</h4>
      </div>
      <div class="col s3" style="text-align:right;margin-top: 15px;">
        <button class="btn cyan waves-effect waves-light" type="button" name="save" @click="printInvoice">Print
            <i class="material-icons right">print</i>
          </button>
      </div>
    </div>
    <div id="section-to-print" style="width: 21cm;height: 29.7cm; margin: auto; color:black;background-color:white;border:1px solid black;">
      <div class="row" style="height:5cm;margin: 0px;">
        <div class="col s12" style="text-align:center;">
          <h4 style="font-weight: 500;margin: 10px 0 0px 0;color: grey;">Aalika Beckham</h4>
          <h5 style="margin: 0px 0px 10px 0px;color: grey;">Pret Coture</h5>
          <span style="font-size:15px;">102, State Street Building, Peach Road, <br>Opp Dominos Park,<br> San Diego, California - 95567
          </span>
        </div>
      </div>
      <hr style="margin: 0px;color:black">
      <div class="row">
        <div class="col s3">
          <h5>To,</h5>
          <h6>M/s. <b v-if="order.customer">{{order.customer.fullname}}</b></h6>
          <span v-if="order.customer.address_street">{{order.customer.address_street}}<br></span>
          <span v-if="order.customer.city">{{order.customer.city}} - {{order.customer.postalcode}}</span>
        </div>

        <div class="col s5" style="text-align: right;">
        </div>
        <div class="col s4" style="text-align: left;">
          <h5>TAX INVOICE</h5>
          Bill No: # {{order.order_number}} <br>
          Bill Date: {{order.created_at}}<br>
          GSTIN: 1254367DASGR549
        </div>
      </div>
      <div>
        <table style="height: 395px;border-collapse: collapse;">
          <thead>
            <tr style="border-top:1px solid grey;border-bottom:1px solid grey;">
              <th style="border-right:1px solid grey;">Sr.</th>
              <th style="text-align: center;border-right:1px solid grey;width: 300px;">Description</th>
              <th style="text-align: center; border-right:1px solid grey;">HSN/ACS Code</th>
              <th style="text-align: center; border-right:1px solid grey;">Quantity</th>
              <th style="text-align: center; border-right:1px solid grey;">Rate (₹)</th>
              <th style="text-align: right;">Total (₹)</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in order.order_items" :key="item.item_name" style="height: 30px;">
              <td style="padding: 5px 5px;border-right:1px solid grey">{{index + 1}}</td>
              <td style="text-align: left;padding: 5px 5px;border-right:1px solid grey">{{item.item_name}}</td>
              <td style="text-align: center;padding: 5px 5px;border-right:1px solid grey">22255668</td>
              <td style="text-align: center;padding: 5px 5px;border-right:1px solid grey">{{item.quantity}}</td>
              <td style="text-align: center;padding: 5px 5px;border-right:1px solid grey">{{item.price}}</td>
              <td style="text-align: right;padding: 5px 5px;">{{item.total}}</td>
            </tr>
            <tr style="border-bottom:1px solid grey">
              <td style="border-right:1px solid grey"></td>
              <td style="border-right:1px solid grey"></td>
              <td style="border-right:1px solid grey"></td>
              <td style="border-right:1px solid grey"></td>
              <td style="border-right:1px solid grey"></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="row" style="margin-bottom: 0px;">
        <div class="col s6">
          <h5><u>Terms & Conditions</u> :</h5>
          <table>
            <tr>
              <td style="padding: 0px 5px;"><b>&#8226;</b> Goods once sold will not be taken back.</td>
            </tr>
            <tr>
              <td style="padding: 0px 5px;"><b>&#8226;</b> Unless and otherwise agreed payment should <br> &nbsp;  be made immediately on receipt of Bill.</td>
            </tr>
            <tr>
              <td style="padding: 0px 5px;"><b>&#8226;</b> If the cheque happens to bounce penalty of $150 will be charged.</td>
            </tr>
          </table><br>
          <table>
            <tbody>
              <tr><td>Rupees:</td><td style="text-transform: capitalize;"><u>{{numToWord(order.total_amount)}}</u></td></tr>
            </tbody>
          </table>
        </div>
        <div class="col s6" style="padding: 0px 0 0 109px;">
          <table style="border-left: 1px solid grey;border-bottom: 1px solid grey;">
            <tbody>
              <tr><td style="padding: 5px 5px;">Total</td><td style="text-align:right;padding: 5px 5px;">{{sub_total}} &nbsp;₹</td></tr>
              <tr v-if="total_discount!==0"><td style="padding: 5px 5px;">Discount</td><td style="text-align:right;padding: 5px 5px;">{{total_discount}} &nbsp;₹</td></tr>
              <tr v-if="!tax_out"><td style="padding: 5px 5px;">CGST @ {{order.cgst}}.0%</td><td style="text-align:right;padding: 5px 5px;">{{this.total_cgst}} &nbsp;₹</td></tr>
              <tr v-if="!tax_out"><td style="padding: 5px 5px;">SGST @ {{order.sgst}}.0%</td><td style="text-align:right;padding: 5px 5px;">{{this.total_sgst}} &nbsp;₹</td></tr>
              <tr v-if="tax_out"><td style="padding: 5px 5px;">IGST @ {{order.igst}}.0%</td><td style="text-align:right;padding: 5px 5px;">{{this.total_igst}} &nbsp;₹</td></tr>
              <tr><td style="padding: 5px 5px;">Total Taxed Amt</td><td style="text-align:right;padding: 5px 5px;">{{total_tax}} &nbsp;₹</td></tr>
              <tr><td style="padding: 5px 5px;">Other Charges</td><td style="text-align:right;padding: 5px 5px;">{{order.other_charges}} &nbsp;₹</td></tr>
              <tr v-if="tax_out" style="height: 32px;"><td></td><td></td></tr>
              <tr style="border-top:1px solid grey"><td>TOTAL AMOUNT</td><td style="text-align:right;padding: 5px 5px;">{{order.total_amount}} &nbsp;₹</td></tr>
            </tbody>
          </table>
          <table v-if="total_discount===0">
            <tbody>
              <tr><td></td></tr>
            </tbody>
          </table>
          <div class="row">
            <div class="col s12" style="text-align:center">
            <h6> For Aalika Beckham Pret Coture</h6><br><br>
            <h6>Authorised Signatory</h6>
          </div>
        </div>
        </div>
      </div>
      <!-- <div class="row" style="margin-bottom: 0px !important;">
        <div class="col s8">
        </div>
        <div class="col s4" style="text-align:center">
          <h6> For Aalika Beckham Pret Coture</h6><br><br>
          <h6>Authorised Signatory</h6>
        </div>
      </div> -->
      <!-- <div style="position: absolute;width: 21cm;top: 29.2cm;">
        <div class="row" style="margin-bottom: 0px;height:20px">
          <div class="col s10" style="width: 65%;">
          </div>
        </div>
      </div> -->
    </div>
  </div>
</template>

<script>
import domain from '@/domain_config.js'
export default {
  name: 'Invoice',
  data () {
    return {
      tax_out: false,
      sub_total: 0,
      total_discount: 0,
      total_tax: 0,
      total_cgst: 0,
      total_sgst: 0,
      total_igst: 0,
      order: {
        customer: {}
      }
    }
  },
  methods: {
    numToWord: function (num1) {
      var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen ']
      var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety']
      var num = Math.round(num1)
      if ((num = num.toString()).length > 9) return 'overflow'
      var n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/)
      var str = ''
      if (n) {
        str += (parseInt(n[1]) !== 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : ''
        str += (parseInt(n[2]) !== 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : ''
        str += (parseInt(n[3]) !== 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : ''
        str += (parseInt(n[4]) !== 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : ''
        str += (parseInt(n[5]) !== 0) ? ((str !== '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : ''
      }
      return str + 'Rupees Only'
    },
    getOrder: function () {
      this.axios.get(domain.endpoint + 'orders/' + this.$route.params.order_id).then(response => {
        this.order = response.data
        if (this.order.igst === 0) {
          this.tax_out = false
        } else {
          this.tax_out = true
        }
        this.calculateTotal()
      })
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
    getOtherCalculation: function () {
      if (!this.order.other_charges) {
        this.order.other_charges = 0
      }
      this.total_discount = (this.sub_total * this.order.discount) / 100
      if (this.tax_out) {
        this.total_igst = this.taxToPrice(this.sub_total - this.total_discount, this.order.igst)
        this.total_tax = parseFloat(this.total_igst)
      } else {
        this.total_cgst = this.taxToPrice(this.sub_total - this.total_discount, this.order.cgst)
        this.total_sgst = this.taxToPrice(this.sub_total - this.total_discount, this.order.sgst)
        this.total_tax = parseFloat(this.total_cgst) + parseFloat(this.total_sgst)
      }
      this.order.total_amount = (parseFloat(this.sub_total) - parseFloat(this.total_discount) + parseFloat(this.total_tax) + parseFloat(this.order.other_charges)).toFixed(2)
      this.order.total_amount = Math.round(this.order.total_amount)
    },
    taxToPrice: function (price, tax) {
      return (price * tax / 100).toFixed(2)
    },
    printInvoice: function () {
      window.print()
    }
  },
  mounted: function () {
    this.getOrder()
  }
}
</script>

<style>
@media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
