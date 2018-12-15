<template>
  <div>
    <div class="card-panel">
      <div class="row">
        <div class="col s8">
          <h4 style="margin:0px">Order Add</h4>
        </div>
        <div class="col s4" style="text-align:right;">
          <a class="btn red waves-effect waves-light" type="button" name="save" @click="goBack">Back
          </a>&nbsp;
          <button @click="addOrder" class="btn cyan waves-effect waves-light" type="button" name="save">Save
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>
    </div>
    <div class="card-panel">
      <div class="row">
        <div class="input-field col" :class="{'s12': !show_measurment, 's8': show_measurment}" style="transition: width .5s;">
          <div class="row">
            <div class="input-field col s12 m4 l4">
              <label class="active">Customer *</label>
              <selectable id="customer" display-label="fullname" resource-name="customers" filters="fullname" v-model="order.customer_id" @input="getCustomer" :class="{'error-input': !isValid(order.customer_id, check_order_val)}"></selectable>
            </div>
            <div class="input-field col s12 m4 l4">
              <label class="active">Delivery Date</label>
              <span><input type="date" v-model="order.order_delivery_date" min="2000-01-01" max="2050-12-31"></span>
            </div>
            <div class="col s12 m4 l4" style="text-align:right;margin-top: 15px;">
              <a class="btn-floating" :class="{'green': show_measurment, 'purple': !show_measurment}"  @click="show_measurment=!show_measurment">
                  <i class="material-icons" :class="{'rott': show_measurment}" style="transition: 1s;">accessibility</i>
              </a>
              <!-- <button @click="show_measurment=!show_measurment" class="btn cyan waves-effect waves-light" type="button" name="save">Measurments
                <i class="material-icons right" :class="{'rott': !show_measurment}" style="transition: 1s;">navigate_next</i>
              </button> -->
            </div>
          </div><br>
          <div class="row">
            <div class="input-field col s8">
              <h5>Order Items</h5>
            </div>
            <div class="input-field col s4" style="text-align:right;">
              <button class="btn cyan waves-effect waves-light modal-trigger" href="#modal1" type="button" name="save">Add Order Item
                <i class="material-icons right">control_point</i>
              </button>
              <div id="modal1" class="modal">
                <div class="modal-content">
                  <h4>Order Item</h4>
                  <div class="divider"></div><br>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <input v-model="order_item.item_name" id="item_name" type="text" placeholder="" :class="{'error-input': !isValid(order_item.item_name, check_order_item_val)}">
                      <label class="active" for="item_name">Item Name *</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input v-model="order_item.quantity" id="quantity" type="number" placeholder="" :class="{'error-input': !isValid(order_item.quantity, check_order_item_val)}">
                      <label class="active" for="quantity">Quantity *</label>
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
          <table class="striped">
            <thead>
              <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="order.order_items.length <= 0">
                <td colspan="3" style="text-align:center;"><h5> No item added </h5></td>
              </tr>
              <tr v-for="(item, index) in order.order_items" :key="item.item_name">
                <td>{{item.item_name}}</td>
                <td>{{item.quantity}}</td>
                <td>
                  <a href="JavaScript:void(0)" @click="viewItem(index)"><i class="material-icons">border_color</i></a>&nbsp;
                  <a href="JavaScript:void(0)" @click="deleteItem(index)"><i class="material-icons">delete</i></a>
                </td>
              </tr>
            </tbody>
          </table>
          <br><br>
          <div class="row">
            <div class="input-field col s11">
              <textarea v-model="order.extra_notes" id="extra_notes" class="materialize-textarea" placeholder="" style="border: 1px solid rgb(209, 206, 206);margin-top: 10px;padding: 16px;"></textarea>
              <label for="extra_notes" class="active">Order Notes</label>
            </div>
          </div><br>
          <h5>Order Pictures</h5>
          <div class="divider"></div>
          <div id="modal2" class="modal">
            <div class="modal-content">
              <h4>Order Image</h4>
              <div class="divider"></div><br>
              <img :src="selected_image" alt="Order Image" style="max-width: 100%;">
            </div>
            <div class="modal-footer">
              <a class="btn waves-effect waves-light red lightrn-1 modal-close">Close</a>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input type="file" name="images" style="display:none" ref="imageUpload" @change="takeImages" multiple accept="image/*" />
              <div @click="$refs.imageUpload.click()" @dragenter="dragenter" @dragover="dragover" @drop="drop" style="background-color:#cce3b2;min-height: 100px;border: 1px dashed;text-align:center;padding: 0 10px 3px 15px;"><br>
              <h5>Select Images to Upload</h5>
                <div class="row" @click.stop="">
                  <div class="col img-lst" v-for="(img, index) in order.order_images" :key="index">
                    <div @click.stop="deleteImage(index, true)" class="img-delete"><i class="material-icons">delete</i></div><br>
                    <img class="img-in modal-trigger" :src="backend_url + img.image_path" alt="Order Image" @click.stop="openImageModel(backend_url + img.image_path, true)">
                  </div>
                  <div class="col img-lst" v-for="(img, index) in img_url" :key="index">
                    <div @click.stop="deleteImage(index, false)" class="img-delete"><i class="material-icons">delete</i></div><br>
                    <img class="img-in" :src="img" alt="Order Image" v-if="img" @click.stop="openImageModel(img, false)">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="col s1" v-if="show_measurment">
        </div> -->
        <div class="input-field col s4" v-if="show_measurment">
          <table class="striped">
            <thead>
              <tr>
                <th colspan="2">Customer Measurments</th>
              </tr>
            </thead>
            <tbody v-if="!order.customer_id">
              <tr>
                <td style="text-align:center;"><h5>No Customer Selected</h5></td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr><td>Chest</td><td><input type="text" name="chest" v-model="selected_customer.mesurment.chest"/></td></tr>
              <tr><td>Bust</td><td><input type="text" name="bust" v-model="selected_customer.mesurment.bust"/></td></tr>
              <tr><td>Rib Cage</td><td><input type="text" name="rib_cage" v-model="selected_customer.mesurment.rib_cage"/></td></tr>
              <tr><td>Inseam</td><td><input type="text" name="inseam" v-model="selected_customer.mesurment.inseam"/></td></tr>
              <tr><td>biceps</td><td><input type="text" name="biceps" v-model="selected_customer.mesurment.biceps"/></td></tr>
              <tr><td>waist</td><td><input type="text" name="waist" v-model="selected_customer.mesurment.waist"/></td></tr>
              <tr><td>hip</td><td><input type="text" name="hip" v-model="selected_customer.mesurment.hip"/></td></tr>
              <tr><td>neck_to_floor</td><td><input type="text" name="neck_to_floor" v-model="selected_customer.mesurment.neck_to_floor"/></td></tr>
              <tr><td>shoulder_to_elbow</td><td><input type="text" name="shoulder_to_elbow" v-model="selected_customer.mesurment.shoulder_to_elbow"/></td></tr>
              <tr><td>shoulder_to_wrist</td><td><input type="text" name="shoulder_to_wrist" v-model="selected_customer.mesurment.shoulder_to_wrist"/></td></tr>
              <tr><td>waist_to_knee</td><td><input type="text" name="waist_to_knee" v-model="selected_customer.mesurment.waist_to_knee"/></td></tr>
              <tr><td>waist_to_floor</td><td><input type="text" name="waist_to_floor" v-model="selected_customer.mesurment.waist_to_floor"/></td></tr>
              <tr><td>armpit_to_waist</td><td><input type="text" name="armpit_to_waist" v-model="selected_customer.mesurment.armpit_to_waist"/></td></tr>
              <tr><td>backneck_to_waist</td><td><input type="text" name="backneck_to_waist" v-model="selected_customer.mesurment.backneck_to_waist"/></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import domain from '@/domain_config.js'
import Selectable from '@/components/Selectable.vue'
export default {
  name: 'OrderAdd',
  components: {
    Selectable
  },
  data () {
    return {
      check_order_item_val: false,
      check_order_val: false,
      show_measurment: false,
      selected_customer: {},
      edit_index: '',
      order_item: {
        quantity: 1
      },
      order: {
        customer_id: '',
        order_delivery_date: '',
        order_items: []
      },
      img_url: [],
      backend_url: domain.domain,
      selected_image: ''
    }
  },
  methods: {
    deleteImage (index, isServer) {
      if (isServer) {
        console.log('delete serverl Image')
        this.axios.delete(domain.endpoint + 'order_images/' + this.order.order_images[index].id).then(response => {
          window.Materialize.toast('Order Image Deleted!!', 2000, 'tst-alert')
          this.getOrder()
        })
      } else {
        this.img_url.splice(index, 1)
        window.Materialize.toast('Order Image Deleted!!', 2000, 'tst-alert')
      }
    },
    dragenter (e) {
      e.stopPropagation()
      e.preventDefault()
    },
    dragover (e) {
      e.stopPropagation()
      e.preventDefault()
    },
    drop (e) {
      e.stopPropagation()
      e.preventDefault()
      var dt = e.dataTransfer
      var files = dt.files
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
    },
    takeImages: function (event) {
      var files = event.target.files
      for (var i in files) {
        if (i === 'length') {
          break
        }
        var filReader = new FileReader()
        var file = files[i]
        console.log(file)
        var thisI = this
        filReader.onload = (e) => {
          thisI.img_url.push(e.target.result)
        }
        filReader.readAsDataURL(file)
      }
    },
    openImageModel: function (img, isServer) {
      if (isServer) {
        this.selected_image = img
      } else {
        this.selected_image = img
      }
      window.$('#modal2').modal('open')
    },
    closeModel: function () {
      this.order_item = { quantity: 1 }
      this.edit_index = ''
      this.check_order_item_val = false
      window.$('#modal1').modal('close')
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
      } else {
        this.order.order_items.push(this.order_item)
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
      window.Materialize.toast('Item Deleted!', 4000)
    },
    addOrder: function () {
      if (!this.order.customer_id) {
        this.check_order_val = true
        window.Materialize.toast('Please fill required fields', 2000, 'tst-alert')
        return false
      } else if (this.order.order_items.length <= 0) {
        window.Materialize.toast('Please add atleast one item', 2000, 'tst-alert')
        return false
      }
      this.axios.put(domain.endpoint + 'customers/' + this.selected_customer.id, this.selected_customer).then(response => {
      })
      this.order.images = this.img_url
      if (this.$route.params.order_id) {
        this.axios.put(domain.endpoint + 'orders/' + this.$route.params.order_id, this.order).then(response => {
          this.$router.push({ 'name': 'OrderList' })
          window.Materialize.toast('Order Updated!', 4000)
        })
      } else {
        this.axios.post(domain.endpoint + 'orders', this.order).then(response => {
          this.$router.push({ 'name': 'OrderList' })
          window.Materialize.toast('Order Created!', 4000)
        })
      }
    },
    getOrder: function () {
      this.axios.get(domain.endpoint + 'orders/' + this.$route.params.order_id).then(response => {
        this.order = response.data
        this.getCustomer()
      })
    },
    getCustomer: function () {
      this.axios.get(domain.endpoint + 'customers/' + this.order.customer_id).then(response => {
        this.selected_customer = response.data
        if (!this.selected_customer.mesurment) {
          this.selected_customer.mesurment = {
            chest: '',
            bust: '',
            rib_cage: '',
            inseam: '',
            biceps: '',
            waist: '',
            hip: '',
            neck_to_floor: '',
            shoulder_to_elbow: '',
            shoulder_to_wrist: '',
            waist_to_knee: '',
            waist_to_floor: '',
            armpit_to_waist: '',
            backneck_to_waist: ''
          }
        }
      })
    },
    goBack: function () {
      this.$router.go(-1)
    }
  },
  mounted: function () {
    window.$('select').material_select()
    window.$('.modal').modal()
    if (this.$route.params.order_id) {
      this.getOrder()
    } else {
      var todayDate = new Date().toJSON().slice(0, 10).replace(/-/g, '-').split('-')
      this.order.order_delivery_date = todayDate[0] + '-' + todayDate[1] + '-' + todayDate[2]
      this.order.order_date = todayDate[0] + '-' + todayDate[1] + '-' + todayDate[2]
      if (this.$route.query.customer_id) {
        this.order.customer_id = this.$route.query.customer_id
        this.getCustomer()
      }
    }
  }
}
</script>

<style>
.rott {
  transform: rotate(180deg);
}
.img-delete {
  top: 37px;
  right: 3px;
  position: relative;
  cursor: pointer;
  width: 38px;
  float: right;
  background-color: #e3e3e300;
  color: #f4433600;
  text-align: center;
  border-radius: 10px;
  padding: 5px 0 0 0;
  z-index: 2;
  transition: background-color 1000ms linear;
  transition: color 500ms linear;
}

.img-lst {
  text-align:right;
}

.img-in {
  max-width: 200px;
  max-height: 200px;
  transition: opacity 500ms linear;
}

.img-lst:hover .img-in {
    opacity:0.5;
}

.img-lst:hover .img-delete {
  background-color: #e3e3e3;
  color: #F44336;
}
</style>
