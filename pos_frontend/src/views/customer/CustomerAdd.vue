<template>
  <div style="transition: 1s;">
    <div class="card-panel">
      <div class="row">
        <div class="col s8">
          <h4 style="margin:0px">Customer Add</h4>
        </div>
        <div class="col s4" style="text-align:right;">
          <router-link :to="{name: 'CustomerList'}" class="btn red waves-effect waves-light" type="button" name="save">Back
          </router-link>&nbsp;
          <button @click="addCustomer" class="btn cyan waves-effect waves-light" type="button" name="save">Save
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>
    </div>
    <div class="card-panel">
      <h5>Personal Detail</h5>
      <div class="divider"></div><br>
      <div class="row">
        <div class="input-field col s12 m4 l4">
          <input v-model="customer.fullname" id="first_name" type="text" class="validate" placeholder="">
          <label class="active" for="first_name">Full Name *</label>
        </div>
        <div class="input-field col s12 m4 l4">
          <label class="active">Birthdate</label>
          <span><input type="date" v-model="customer.date_of_birth"></span>
        </div>
        <div class="col s12 m3 l3">
          <p>
            <span style="padding-bottom: 10px;">
              <label> Gender</label>
            </span><br>
            <input class="with-gap" type="radio" id="one" value="Female" v-model="customer.gender">
            <label for="one">Female</label> &nbsp;
            <input class="with-gap" type="radio" id="two" value="Male" v-model="customer.gender">
            <label for="two">Male</label>
          </p>
        </div>
        <div class="col s12 m1 l1" style="margin-top: 15px;">
          <a class="btn-floating" :class="{'green': is_show, 'purple': !is_show}"  @click="is_show=!is_show">
              <i class="material-icons" :class="{'rott': is_show}" style="transition: 1s;">accessibility</i>
          </a>
          <!-- <button @click="is_show=!is_show" class="btn cyan waves-effect waves-light" type="button" name="save">Measurement
          </button> -->
        </div>
      </div>
      <transition name="fade">
        <div id="show_msr" v-if="is_show">
          <h5>Measurement</h5>
          <div class="divider"></div>
          <div class="row">
            <div class="input-field col l6">
              <div class="card-panel">
                <div class="row">
                  <div class="input-field col s12 m6 l6" v-if="customer.gender==='Male'">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.chest" placeholder="">
                    <label class="active" for="email">Chest</label>
                  </div>
                  <div class="input-field col s12 m6 l6" v-else>
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.bust" placeholder="">
                    <label class="active" for="email">Bust</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.inseam" placeholder="">
                    <label class="active" for="email">Inseam</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.biceps" placeholder="">
                    <label class="active" for="email">Biceps</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.waist" placeholder="">
                    <label class="active" for="email">Waist</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.hip" placeholder="">
                    <label class="active" for="email">Hip</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="input-field col l6">
              <div class="card-panel">
                <div class="row">
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.rib_cage" placeholder="">
                    <label class="active" for="email">Rib Cage</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.neck_to_floor" placeholder="">
                    <label class="active" for="email">Neck To Floor</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.shoulder_to_elbow" placeholder="">
                    <label class="active" for="email">Shoulder To Elbow</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.shoulder_to_wrist" placeholder="">
                    <label class="active" for="email">Shoulder To Wrist</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.waist_to_knee" placeholder="">
                    <label class="active" for="email"> Waist To Knee</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.waist_to_floor" placeholder="">
                    <label class="active" for="email">Waist To Floor</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.armpit_to_waist" placeholder="">
                    <label class="active" for="email">Armpit To Waist</label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <input id="email" type="text" class="validate" v-model="customer.mesurment.backneck_to_waist" placeholder="">
                    <label class="active" for="email">Backneck To Waist</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
      <h5>Contact Detail</h5>
      <div class="divider"></div><br>
      <div class="row">
        <div class="input-field col s12 m4 l4">
          <input id="email" type="number" class="validate" v-model="customer.mobile" placeholder="">
          <label class="active" for="email">Mobbile Number</label>
        </div>
        <div class="input-field col s12 m4 l4">
          <input id="email" type="number" class="validate" v-model="customer.phone_number" placeholder="">
          <label class="active" for="email">Other Phone Number</label>
        </div>
        <div class="input-field col s12 m4 l4">
          <input id="email" type="email" class="validate" v-model="customer.email" placeholder="">
          <label class="active" for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="text" class="validate" v-model="customer.address_street" placeholder="">
          <label class="active" for="email">Address Street</label>
        </div>
        <div class="input-field col s12 m4 l4">
          <input id="email" type="text" class="validate" v-model="customer.country" placeholder="">
          <label class="active" for="email">Country</label>
        </div>
        <div class="input-field col s12 m4 l4">
          <input id="email" type="text" class="validate" v-model="customer.city" placeholder="">
          <label class="active" for="email">City</label>
        </div>
        <div class="input-field col s12 m4 l4">
          <input id="email" type="number" class="validate" v-model="customer.postalcode" placeholder="">
          <label class="active" for="email">Pincode</label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import domain from '../../domain_config.js'
export default {
  name: 'CustomerAdd',
  data () {
    return {
      is_show: false,
      picked: '',
      customer: {
        'fullname': '',
        'gender': 'Female',
        'date_of_birth': '1990-01-01',
        'email': '',
        'mobile': '',
        'phone_number': '',
        'address_street': '',
        'city': 'San Francisco',
        'country': 'USA',
        'postalcode': '',
        'mesurment': {
          'chest': '',
          'bust': '',
          'rib_cage': '',
          'inseam': '',
          'biceps': '',
          'waist': '',
          'hip': '',
          'neck_to_floor': '',
          'shoulder_to_elbow': '',
          'shoulder_to_wrist': '',
          'waist_to_knee': '',
          'waist_to_floor': '',
          'armpit_to_waist': '',
          'backneck_to_waist': ''
        }
      }
    }
  },
  methods: {
    addCustomer () {
      if (this.$route.params.customer_id) {
        this.axios.put(domain.endpoint + 'customers/' + this.$route.params.customer_id, this.customer).then(response => {
          window.Materialize.toast('Customer Saved!', 4000)
          this.$router.push({ 'name': 'CustomerList' })
        })
      } else {
        this.axios.post(domain.endpoint + 'customers', this.customer).then(response => {
          window.Materialize.toast('Customer Saved!', 4000)
          this.$router.push({ 'name': 'CustomerList' })
        }, response => {
          // console.log(response.message)
          window.Materialize.toast('Please fill required fields!', 4000)
        })
      }
    },
    getCustomer: function () {
      if (this.$route.params.customer_id) {
        this.axios.get(domain.endpoint + 'customers/' + this.$route.params.customer_id).then(response => {
          this.customer = response.data
          if (!this.customer.mesurment) {
            this.customer.mesurment = {
              'chest': '',
              'bust': '',
              'rib_cage': '',
              'inseam': '',
              'biceps': '',
              'waist': '',
              'hip': '',
              'neck_to_floor': '',
              'shoulder_to_elbow': '',
              'shoulder_to_wrist': '',
              'waist_to_knee': '',
              'waist_to_floor': '',
              'armpit_to_waist': '',
              'backneck_to_waist': ''
            }
          }
        })
      }
    }
  },
  mounted: function () {
    this.getCustomer()
  }
}
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
  transition: 1s;
}
.rott {
  transform: rotate(180deg);
}
</style>
