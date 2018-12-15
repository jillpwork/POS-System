<template>
  <div>
    <div class="card-panel">
      <div class="row">
        <div class="col s10">
          <h4 style="margin:0px">Expense List</h4>
        </div>
        <div class="col s2" style="text-align: right;">
          <!-- <a class="btn-floating waves-effect waves-light" @click="openModel"><i class="material-icons">add</i></a> -->
          <a class="waves-effect waves-light btn-large" @click="openModel">
            <i class="material-icons right">playlist_add</i> New Expense
          </a>
        </div>
      </div>
    </div>
    <div class="card-panel">
      <div class="row">
        <div class="input-field col s3">
          <input v-model="search_expense" id="fullname" type="text" placeholder="" @input="getExpenses">
          <label class="active" for="fullname">Expense</label>
        </div>
        <div class="input-field col s3">
          <label class="active">From date</label>
          <span><input type="date" v-model="search_from_date" @change="getExpenses"></span>
        </div>
        <div class="input-field col s3">
          <label class="active">To date</label>
          <span><input type="date" v-model="search_to_date" @change="getExpenses"></span>
        </div>
        <div class="input-field col s3" style="text-align:right;">
          <a class="btn waves-effect waves-light amber darken-4" @click="clearFilter"><i class="material-icons">refresh</i></a>
        </div>
      </div><br>
      <table class="striped">
        <thead>
          <tr>
            <th>Expense Description</th>
            <th>Amount</th>
            <th>Expense Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="expenses.data.length <= 0">
            <td colspan="4" style="text-align:center;"><h5>No Expense Found</h5></td>
          </tr>
          <tr v-for="(expense, index) in expenses.data" :key="expense.id">
            <td>{{expense.expense_description}}</td>
            <td>{{expense.amount}}</td>
            <td>{{expense.display_date}}</td>
            <td>
              <a href="JavaScript:void(0)" @click="openEditModel(index)">
                <i class="material-icons">border_color</i>
              </a>&nbsp;
              <a href="JavaScript:void(0)" @click="deleteExpense(index)">
                <i class="material-icons" style="color: #F44336;">delete</i>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
      <div id="modal1" class="modal" style="width: 370px;">
        <div class="modal-content">
          <h4 style="text-align:left;">Expense Detail</h4>
          <div class="divider"></div><br>
          <div class="row">
            <div class="input-field col s12">
              <input v-model="expense.expense_description" id="expense_description" type="text" placeholder="" :class="{'error-input': !isValid(expense.expense_description, check_exp_val)}">
              <label class="active" for="item_name">Expense Description *</label>
            </div>
            <div class="input-field col s12">
              <input v-model="expense.amount" id="expense_description" type="number" placeholder="" :class="{'error-input': !isValid(expense.amount, check_exp_val)}">
              <label class="active" for="item_name">Expense Amount *</label>
            </div>
            <div class="input-field col s12">
              <label class="active">Expense Date</label>
              <span><input type="date" v-model="expense.expense_date" min="2000-01-01" max="2050-12-31"></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a class="btn waves-effect waves-light red lightrn-1" @click="closeModel">Cancel</a> &nbsp;
          <a class="btn waves-effect waves-light purple lightrn-1" @click="addExpense">Save</a>
        </div>
      </div>
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
      today_date: '',
      search_expense: '',
      search_from_date: '',
      search_to_date: '',
      expenses: {
        data: []
      },
      expense: {
        expense_description: '',
        amount: '',
        expense_date: ''
      },
      edit_index: '',
      check_exp_val: false
    }
  },
  methods: {
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
    clearFilter: function () {
      this.search_expense = ''
      this.search_from_date = ''
      this.search_to_date = ''
      this.getExpenses()
    },
    openModel: function () {
      this.expense = {
        expense_description: '',
        amount: '',
        expense_date: this.today_date
      }
      window.$('#modal1').modal('open')
    },
    getFilterExpenses: function (pagNumber) {
      var url = '?page=' + pagNumber
      if (this.search_expense !== '') {
        url += '&expense=' + this.search_expense
      }
      if (this.search_to_date && this.search_from_date) {
        url += '&from_date=' + this.search_from_date + '&to_date=' + this.search_to_date
      }
      // url += '&filter='
      // if (this.search_name !== '') {
      //   url += 'fullname:' + this.search_name
      // }
      // if (this.search_number !== '') {
      //   if (this.search_name) {
      //     url += ','
      //   }
      //   url += 'mobile:' + this.search_number
      // }
      this.axios.get(domain.endpoint + 'expenses' + url).then(response => {
        this.expenses = response.data
      })
    },
    getExpenses () {
      var url = '?'
      if (this.search_expense !== '') {
        url += 'expense=' + this.search_expense
      }
      if (this.search_to_date && this.search_from_date) {
        url += '&from_date=' + this.search_from_date + '&to_date=' + this.search_to_date
      }
      this.axios.get(domain.endpoint + 'expenses' + url).then(response => {
        this.expenses = response.data
        var vm = this
        window.$('#pagination').twbsPagination('destroy')
        window.$('#pagination').twbsPagination({
          totalPages: this.expenses.meta.last_page,
          visiblePages: 10,
          onPageClick: function (event, page) {
            vm.getFilterExpenses(page)
          }
        })
      })
    },
    addExpense () {
      if (this.edit_index !== '') {
        this.axios.put(domain.endpoint + 'expenses/' + this.expenses.data[this.edit_index].id, this.expense).then(response => {
          window.Materialize.toast('Expense Updated!', 2000, 'tst-success')
          this.getExpenses()
          this.closeModel()
          this.edit_index = ''
        })
      } else {
        this.axios.post(domain.endpoint + 'expenses/', this.expense).then(response => {
          window.Materialize.toast('Expense Added!', 2000, 'tst-success')
          this.getExpenses()
          this.closeModel()
          this.edit_index = ''
        })
      }
    },
    openEditModel: function (indx) {
      this.edit_index = indx
      window.$('#modal1').modal('open')
      this.expense = Object.assign({}, this.expenses.data[indx])
    },
    deleteExpense: function (indx) {
      this.axios.delete(domain.endpoint + 'expenses/' + this.expenses.data[indx].id).then(response => {
        window.Materialize.toast('Expense Deleted!', 2000, 'tst-alert')
        this.getExpenses()
      })
    },
    closeModel () {
      this.expense = {
        expense_description: '',
        amount: '',
        expense_date: this.today_date
      }
      window.$('#modal1').modal('close')
    }
  },
  mounted: function () {
    var todayDate = new Date().toJSON().slice(0, 10).replace(/-/g, '-').split('-')
    this.today_date = todayDate[0] + '-' + todayDate[1] + '-' + todayDate[2]
    window.$('#modal1').modal()
    this.getExpenses()
  }
}
</script>
