<template>
  <div>
    <!-- START HEADER -->
    <header id="header" class="page-topbar">
      <!-- start header nav-->
      <div class="navbar-fixed">
        <nav class="navbar-color gradient-45deg-purple-deep-orange gradient-shadow">
          <div class="nav-wrapper">
            <ul class="right hide-on-med-and-down">
              <li>
                <a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen">
                  <i class="material-icons">settings_overscan</i>
                </a>
              </li>
              <li>
                <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                  <span class="avatar-status avatar-online">
                    <img src="/images/avatar/avatar-7.png" alt="avatar">
                    <i></i>
                  </span>
                </a>
              </li>
              <!-- <li>
                <a href="#" data-activates="chat-out" class="waves-effect waves-block waves-light chat-collapse">
                  <i class="material-icons">format_indent_increase</i>
                </a>
              </li> -->
            </ul>
            <!-- profile-dropdown -->
            <ul id="profile-dropdown" class="dropdown-content">
              <!-- <li>
                <a href="#" class="grey-text text-darken-1">
                  <i class="material-icons">face</i> Profile</a>
              </li>
              <li>
                <a href="#" class="grey-text text-darken-1">
                  <i class="material-icons">settings</i> Settings</a>
              </li>
              <li>
                <a href="#" class="grey-text text-darken-1">
                  <i class="material-icons">live_help</i> Help</a>
              </li> -->
              <!-- <li class="divider"></li> -->
              <!-- <li>
                <a href="#" class="grey-text text-darken-1">
                  <i class="material-icons">lock_outline</i> Lock</a>
              </li> -->
              <li>
                <a href="#" class="grey-text text-darken-1" @click="logout">
                  <i class="material-icons">keyboard_tab</i> Logout
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <!-- END HEADER -->
    <!-- //////////////////////////////////////////////////////////////////////////// -->
    <!-- START MAIN -->
    <div id="main">
      <!-- START WRAPPER -->
      <div class="wrapper">
        <!-- START LEFT SIDEBAR NAV-->
        <aside id="left-sidebar-nav" class="nav-expanded nav-lock nav-collapsible">
          <div class="brand-sidebar">
            <h1 class="logo-wrapper">
              <a href="/" class="brand-logo darken-1">
                <img src="/images/logo/materialize-logo.png" alt="materialize logo">
                <span class="logo-text hide-on-med-and-down">Neon</span>
              </a>
              <a href="#" class="navbar-toggler">
                <i class="material-icons">radio_button_checked</i>
              </a>
            </h1>
          </div>
          <ul id="slide-out" class="side-nav fixed leftside-navigation">
            <li class="no-padding">
              <ul class="collapsible" data-collapsible="accordion">
                <router-link tag="li" :to="{name: 'Dashboard'}" class="bold">
                  <a class="waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Dashboard</span>
                  </a>
                </router-link>
                <router-link tag="li" :to="{name: 'CustomerList'}" class="bold">
                  <a class="waves-effect waves-cyan">
                    <i class="material-icons">people</i>
                    <span class="nav-text">Customers</span>
                  </a>
                </router-link>
                <router-link tag="li" :to="{name: 'OrderList'}" class="bold">
                  <a class="waves-effect waves-cyan">
                    <i class="material-icons">assignment_turned_in</i>
                    <span class="nav-text">Orders</span>
                  </a>
                </router-link>
                <router-link tag="li" :to="{name: 'ExpenseList'}" class="bold">
                  <a class="waves-effect waves-cyan">
                    <i class="material-icons">mood_bad</i>
                    <span class="nav-text">Expenses</span>
                  </a>
                </router-link>
                <router-link tag="li" :to="{name: 'Stats'}" class="bold">
                  <a class="waves-effect waves-cyan">
                    <i class="material-icons">equalizer</i>
                    <span class="nav-text">Stats</span>
                  </a>
                </router-link>
                <li class="bold" @click="logout">
                  <a class="waves-effect waves-cyan">
                    <i class="material-icons">keyboard_tab</i>
                    <span class="nav-text">Logout</span>
                  </a>
                </li>
                <router-link tag="li" :to="{'name': 'OrderAdd'}" class="bold">
                  <a class="btn btn-large waves-effect waves-light gradient-45deg-green-teal gradient-shadow" style="border-radius: 51px;    width: 175px;
">
                    <i class="material-icons" style="color: white;font-size:24px;">add_circle</i>
                    <span class="nav-text" style="font-weight:1000;">New Order</span>
                  </a>
                </router-link>
              </ul>
            </li>
          </ul>
          <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only gradient-45deg-light-blue-cyan gradient-shadow">
            <i class="material-icons">menu</i>
          </a>
        </aside>
        <!-- END LEFT SIDEBAR NAV-->
        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <!-- START CONTENT -->
        <section id="content">
          <!--start container-->
          <div class="container">
            <div class="section">
              <router-view/>
            </div>
          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <!-- START RIGHT SIDEBAR NAV-->
        <aside id="right-sidebar-nav">
          <ul id="chat-out" class="side-nav rightside-navigation">
            <li class="li-hover">
              <div class="row">
                <div class="col s12 border-bottom-1 mt-5">
                  <ul class="tabs">
                    <li class="tab col s4">
                      <a href="#activity" class="active">
                        <span class="material-icons">graphic_eq</span>
                      </a>
                    </li>
                    <li class="tab col s4">
                      <a href="#chatapp">
                        <span class="material-icons">face</span>
                      </a>
                    </li>
                    <li class="tab col s4">
                      <a href="#settings">
                        <span class="material-icons">settings</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <div id="settings" class="col s12">
                  <h6 class="mt-5 mb-3 ml-3">GENERAL SETTINGS</h6>
                </div>
                <div id="chatapp" class="col s12">
                  <h6 class="mt-5 mb-3 ml-3">Persons</h6>
                  <div class="collection border-none">

                  </div>
                </div>
                <div id="activity" class="col s12">
                  <h6 class="mt-5 mb-3 ml-3">RECENT ACTIVITY</h6>
                </div>
              </div>
            </li>
          </ul>
        </aside>
        <!-- END RIGHT SIDEBAR NAV-->
      </div>
      <!-- END WRAPPER -->
    </div>
    <!-- END MAIN -->
    <!-- //////////////////////////////////////////////////////////////////////////// -->
    <!-- START FOOTER -->
    <!-- <footer class="page-footer gradient-45deg-purple-deep-orange">
      <div class="footer-copyright">
        <div class="container">
          <span>Copyright © 2018 All rights reserved.</span>
          <span class="right hide-on-small-only"> Design and Developed by PIXINVENT </span>
        </div>
      </div>
    </footer> -->
    <!-- END FOOTER -->
  </div>
</template>

<script>

export default {
  name: 'Main',
  methods: {
    logout: function () {
      window.localStorage.clear()
      this.$router.push({ 'name': 'Login' })
    }
  }
}
</script>
