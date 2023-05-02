<template>
  <div id="app">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
      <a href="/" class="navbar-brand">fulbrinc</a>
      <div class="navbar-nav mr-auto">
        <li class="nav-item">
          <router-link to="/home" class="nav-link">
            <font-awesome-icon icon="home" /> Home
          </router-link>
        </li>
        <li v-if="showAdminBoard" class="nav-item">
          <router-link to="/admin" class="nav-link">Admin Board</router-link>
        </li>
        <li v-if="showModeratorBoard" class="nav-item">
          <router-link to="/mod" class="nav-link">Moderator Board</router-link>
        </li>
        <li class="nav-item">
          <router-link v-if="currentUser" to="/user" class="nav-link">User</router-link>
        </li>
      </div>
      <div v-if="!currentUser" class="navbar-nav ml-auto">
        <li class="nav-item">
          <router-link to="/register" class="nav-link">
            <font-awesome-icon icon="user-plus" /> Sign Up
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/login" class="nav-link">
            <font-awesome-icon icon="sign-in-alt" /> Login
          </router-link>
        </li>
      </div>
      <div v-if="currentUser" class="navbar-nav ml-auto">
        <li class="nav-item">
          <router-link to="/profile" class="nav-link">
            <font-awesome-icon icon="user" />
            {{ currentUser.username }}
          </router-link>
        </li>
        <li class="nav-item">
          <a class="nav-link" @click.prevent="logOut">
            <font-awesome-icon icon="sign-out-alt" /> LogOut
          </a>
        </li>
      </div>
    </nav>
    <div class="container">
      <router-view />
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    },
    showAdminBoard() {
      if (this.currentUser && this.currentUser['roles']) {
        return this.currentUser['roles'].includes('ROLE_ADMIN');
      }
      return false;
    },
    showModeratorBoard() {
      if (this.currentUser && this.currentUser['roles']) {
        return this.currentUser['roles'].includes('ROLE_MODERATOR');
      }
      return false;
    }
  },
  methods: {
    logOut() {
      this.$store.dispatch('auth/logout');
      this.$router.push('/login');
    }
  }
};
</script>
<style>
  #app {
    padding-bottom: 20px;
    background-color: #1d1d1d;
  }


  .navbar {
    background-color: #1d1d1d;
    border-bottom: 2px solid #00bcd4;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  }

  .nav-link {
    color: #00bcd4;
    font-size: 16px;
    font-weight: bold;
  }

  .nav-link:hover {
    color: #ffffff;
  }

  .navbar-brand {
    color: #00bcd4;
    font-size: 24px;
    font-weight: bold;
  }

  .container {
    background-color: #1d1d1d;
    color: #00bcd4;
  }

  .btn {
    background-color: #00bcd4;
    color: #ffffff;
    border: none;
    font-size: 16px;
    font-weight: bold;
  }

  .btn:hover {
    background-color: #ffffff;
    color: #00bcd4;
    border: 2px solid #00bcd4;
  }
</style>