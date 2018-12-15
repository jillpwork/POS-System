import Vue from 'vue'
import axios from 'axios'
// import VueAxios from 'vue-axios'
import Router from 'vue-router'
import BaseRoute from './views/BlankRoute'
import Login from './views/Login'
import Main from './views/Main'
import Dashboard from './views/Dashboard'
import CustomerList from './views/customer/CustomerList'
import CustomerAdd from './views/customer/CustomerAdd'
import OrderList from './views/order/OrderList'
import OrderAdd from './views/order/OrderAdd'
import OrderBilling from './views/order/OrderBilling'
import Invoice from './views/order/Invoice'
import ExpenseList from './views/expense/ExpenseList'
import Stats from './views/order/Stats'
import About from './views/About'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  linkActiveClass: 'active',
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/invoice/:order_id',
      name: 'Invoice',
      component: Invoice
    },
    {
      path: '/',
      component: Main,
      children: [
        {
          path: '/',
          name: 'Dashboard',
          component: Dashboard,
          meta: {
            title: 'Dashboard'
          }
        },
        {
          path: 'customer',
          component: BaseRoute,
          children: [
            {
              path: '/',
              name: 'CustomerList',
              component: CustomerList
            },
            {
              path: 'add',
              name: 'CustomerAdd',
              component: CustomerAdd
            },
            {
              path: 'edit/:customer_id',
              name: 'CustomerEdit',
              component: CustomerAdd
            }
          ]
        },
        {
          path: 'order',
          component: BaseRoute,
          children: [
            {
              path: '/',
              name: 'OrderList',
              component: OrderList
            },
            {
              path: 'add',
              name: 'OrderAdd',
              component: OrderAdd
            },
            {
              path: 'edit/:order_id',
              name: 'OrderEdit',
              component: OrderAdd
            },
            {
              path: 'billing/:order_id',
              name: 'OrderBilling',
              component: OrderBilling
            }
          ]
        },
        {
          path: 'stats',
          name: 'Stats',
          component: Stats
        },
        {
          path: 'expense',
          component: BaseRoute,
          children: [
            {
              path: '/',
              name: 'ExpenseList',
              component: ExpenseList
            }
            // {
            //   path: 'add',
            //   name: 'ExpenseAdd',
            //   component: ExpenseList
            // },
            // {
            //   path: 'edit/:expense_id',
            //   name: 'ExpenseEdit',
            //   component: ExpenseList
            // }
          ]
        }
      ]
    },
    {
      path: '/about',
      component: About
    }
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (about.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
    // }
  ]
})

if (window.localStorage.getItem('metrix')) {
  axios.defaults.headers.common['Authorization'] = window.localStorage.getItem('metrix')
}

router.beforeEach((to, from, next) => {
  if (window.localStorage.getItem('metrix')) {
    if (to.name === 'Login') {
      next({ name: 'Dashboard' })
    } else {
      next()
    }
  } else {
    if (to.name !== 'Login' && to.name !== 'ResetForgotPassword') {
      next({ name: 'Login' })
    } else {
      next()
    }
  }
})

export default router
