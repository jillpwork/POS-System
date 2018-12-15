<template>
  <div class="disableSelection" @keydown.enter = 'enter'
        @keydown.down = 'down'
        @keydown.up = 'up'
        @keydown.left = 'getItemListNext(items_list.links.prev)'
        @keydown.right = "getItemListNext(items_list.links.next)"
        @keydown.esc ="clearData">
      <input type="text" class="form-control" v-model="search_keyword" @input="getItemList" style="width:100%;margin: 0px;" tabindex="0"/>
      <div v-if="dataIs" style="position: absolute; z-index:9999;width:95%;margin-top: -10px;">
        <div class="collection">
          <a href="#!" class="collection-item" v-for="(item, index) in items_list.data" @click="selectItem(item)" :data-original-index="item.id" tabindex="0" :class="{'active': isActive(index)}" :key="item.id">{{item[displayLabel]}}</a>
        </div>
    </div>
  </div>
</template>

<script>
import domain from '@/domain_config.js'
export default {
  name: 'selectable',
  props: ['value', 'resourceName', 'displayLabel', 'subLabel', 'filters', 'outputLabel', 'addible', 'extraFilters'],
  data () {
    return {
      dataIs: false,
      search_keyword: '',
      current: 0,
      items_list: {
        meta: {},
        links: {},
        data: []
      }
    }
  },
  methods: {
    enter () {
      if (this.search_keyword) {
        this.selectItem(this.items_list.data[this.current])
      }
    },
    up () {
      if (this.current > 0) {
        this.current--
      }
    },
    down () {
      if (this.current < this.items_list.data.length - 1) {
        this.current++
      }
    },
    isActive (index) {
      return index === this.current
    },
    clearData: function () {
      this.search_keyword = ''
      this.$emit('input', '')
      this.dataIs = false
    },
    getItemList: function () {
      // for (var i in this.extraFilters) {
      //   url = url + '&' + this.extraFilters[i].name + '=' + this.extraFilters[i].value
      // }
      this.axios.get(domain.endpoint + this.resourceName + '?filter=' + this.filters + ':' + this.search_keyword).then(response => {
        this.items_list = response.data
        this.current = 0
        this.dataIs = true
        if (this.addible && this.items_list.objects <= 0) {
          this.dataIs = false
          var dol = {}
          dol[this.displayLabel] = this.search_keyword
          this.$emit('input', dol)
        }
        if (!this.search_keyword) {
          this.$emit('input', '')
          this.dataIs = false
        }
      })
    },
    getItemListNext: function (nextIt) {
      console.log(nextIt)
      this.axios.get(nextIt).then(response => {
        this.items_list = response.data
        this.current = 0
      })
    },
    selectItem: function (pro) {
      this.search_keyword = pro[this.displayLabel]
      this.dataIs = false
      this.$emit('input', pro['id'])
    }
  },
  watch: {
    value: function (val) {
      // console.log('here')
      if (!val) {
        this.search_keyword = ''
        return false
      }
      var searcIt = val
      this.axios.get(domain.endpoint + this.resourceName + '/' + searcIt).then(response => {
        this.search_keyword = response.data[this.displayLabel]
      })
    }
  },
  mounted: function () {
    this.axios.get(domain.endpoint + this.resourceName).then(response => {
      this.items_list = response.data
    })
    if (!this.value) {
      this.search_keyword = ''
      return false
    }
    var searcIt = this.value
    this.axios.get(domain.endpoint + this.resourceName + '/' + searcIt).then(response => {
      this.search_keyword = response.data[this.displayLabel]
    })
  }
}
</script>
