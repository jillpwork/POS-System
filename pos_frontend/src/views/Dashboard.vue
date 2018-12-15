<template>
  <div>
    <!-- <h2>This is Dashboard</h2> -->
    <!-- <p class="caption">A Simple Blank Page to use it for your custome design and elements.</p> -->
    <!-- <div class="divider"></div> -->
    <div class="card-panel">
      <div class="row">
        <div class="col s10">
          <h4 style="margin:0px">Dashboard</h4>
        </div>
        <div class="col s2" style="text-align: right;">
          <button class="btn waves-effect waves-light " type="submit" name="action" @click="collapseAll">
            <span v-if="is_earning_show">Hide All </span>
            <span v-if="!is_earning_show">Show All</span>
          </button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col s6">
        <div class="card-panel">
          <button class="btn waves-effect waves-light" :class="{'light-pink': !is_earning_show, 'green darken-1': is_earning_show}" type="button" name="action" style="width:100%">Payment Received
            <i class="material-icons right" v-if="!is_earning_show">face</i>
            <i class="material-icons right" v-else>tag_faces</i>
          </button>
        </div>
        <div class="card-panel white-text accent-2" style="text-align: center;background-color:#d56c4b;" v-if="is_earning_show">
          <div class="row">
            <div class="col s10" style="text-align:center;padding-left: 62px;">
              <h4>{{payment_graph_data.current_month_payment}}</h4>
              <h5>{{payment_graph_data.current_month_year}}</h5>
            </div>
            <div class="col s2" style="text-align:right;">
              <h2>₹</h2>
            </div>
          </div>
        </div>
        <div class="card-panel" v-if="is_earning_show">
          <highcharts :options="chartEarning"></highcharts>
        </div>
      </div>
      <div class="col s6">
        <div class="card-panel">
          <button class="btn waves-effect waves-light" :class="{'light-pink': !is_expense_show, 'dark-yellow': is_expense_show}" type="button" name="action" style="width:100%">Expense
            <i class="material-icons right" v-if="!is_expense_show">face</i>
            <i class="material-icons right" v-else>mood_bad</i>
            <!-- <i class="material-icons right" :class="{'icn-down': is_expense_show, 'icn-up': !is_expense_show}" style="transition: 1s;">send</i> -->
          </button>
        </div>
        <div class="card-panel" style="background-color: bisque; text-align: center;" v-if="is_expense_show">
          <div class="row">
            <div class="col s10" style="text-align:center;padding-left: 62px;">
              <h4>{{payment_graph_data.current_month_expense}}</h4>
              <h5>{{payment_graph_data.current_month_year}}</h5>
            </div>
            <div class="col s2" style="text-align:right;">
              <h2>₹</h2>
            </div>
          </div>
        </div>
        <div class="card-panel" v-if="is_expense_show">
          <highcharts :options="chartExpense"></highcharts>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import domain from '../domain_config.js'
import { Chart } from 'highcharts-vue'
export default {
  name: 'Dashboard',
  components: {
    highcharts: Chart
  },
  data () {
    return {
      is_earning_show: false,
      is_expense_show: false,
      payment_graph_data: {},
      chartEarning: {
        chart: {
          type: 'column'
        },
        title: {
          text: 'Monthly Total Earning'
        },
        subtitle: {
          text: ''
        },
        xAxis: {
          categories: [],
          crosshair: true
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Amount (Rs.)'
          }
        },
        tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0"><b>{point.y:.1f} Rs.</b></td></tr>',
          // footerFormat: '</table>',
          shared: true,
          useHTML: true
        },
        plotOptions: {
          column: {
            pointPadding: 0.2,
            borderWidth: 0
          }
        },
        series: [{
          name: 'Earning',
          data: []

        }]
      },
      chartExpense: {
        chart: {
          type: 'column'
        },
        title: {
          text: 'Monthly Total Expenses'
        },
        subtitle: {
          text: ''
        },
        xAxis: {
          categories: [],
          crosshair: true
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Amount (Rs.)'
          }
        },
        tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0"><b>{point.y:.1f} Rs.</b></td></tr>',
          // footerFormat: '</table>',
          shared: true,
          useHTML: true
        },
        plotOptions: {
          column: {
            pointPadding: 0.2,
            borderWidth: 0
          }
        },
        series: [{
          name: 'Expenses',
          data: []

        }]
      }
    }
  },
  methods: {
    // getAllEarning: function () {
    //   this.is_earning_show = !this.is_earning_show
    // },
    // getAllExpense: function () {
    //   this.is_expense_show = !this.is_expense_show
    // },
    collapseAll: function () {
      if (this.is_earning_show) {
        this.is_earning_show = false
        this.is_expense_show = false
      } else {
        this.is_earning_show = true
        this.is_expense_show = true
      }
    }
  },
  mounted: function () {
    // this.getCustomers()
    this.axios.get(domain.endpoint + 'payments-graph').then(response => {
      this.payment_graph_data = response.data
      this.chartEarning.series[0].data = response.data.payment_received.amounts
      this.chartEarning.xAxis.categories = response.data.payment_received.months
      this.chartExpense.series[0].data = response.data.expenses.amounts
      this.chartExpense.xAxis.categories = response.data.expenses.months
    })
  }
}
</script>

<style>
.icn-down {
  transform: rotate(90deg);
}
.icn-up {
  transform: rotate(-90deg);
}
.light-pink {
  background-color: #3F51B5;
  pointer-events: none;
}
.dark-yellow {
  background-color: #b68a04;
  pointer-events: none;
}
</style>
