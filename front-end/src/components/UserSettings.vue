<template>
    <div class="user-settings">
      <h1>User Settings</h1>
      <form @submit.prevent="updateSettings">
        <label for="username">Username:</label>
        <input id="username" v-model="settings.username" type="text" />
  
        <label for="email">Email:</label>
        <input id="email" v-model="settings.email" type="email" />

        <label for="old_password">Old Password:</label>
        <input id="old_password" v-model="settings.old_password" type="password" />
        
        <label for="password">Password:</label>
        <input id="password" v-model="settings.password" type="password" />
        <!-- Add other settings fields here -->
  
        <button type="submit">Save Changes</button>
      </form>
      <p v-if="message">{{ message }}</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  const accessToken = localStorage.getItem('accessToken'); // getting access token from localStorage
  const API_URL = 'http://127.0.0.1:8080/api';
  
  export default {
    data() {
      return {
        settings: {
          username: '',
          email: '',
          // Add other settings here
        },
        message: '',
      };
    },
    methods: {
      async updateSettings() {
        try {
          let formData = new FormData();
          formData.append('username', this.settings.username);
          formData.append('email', this.settings.email);
          formData.append('old_password', this.settings.old_password);
          formData.append('password', this.settings.password);
          // append other settings here
  
          await axios({
            method: 'put',
            url: API_URL + '/settings',
            data: formData,
            headers: {
              'Authorization': 'Bearer ' + accessToken,
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          });
          this.message = 'Settings updated successfully!';
        } catch (error) {
          console.error('Error updating settings:', error); // log the error to the console
          this.message = 'An error occurred while updating settings.';
        }
      },
    },
    async created() {
      try {
        const response = await axios({
          method: 'get',
          url: API_URL + '/settings',
          headers: {
            'Authorization': 'Bearer ' + accessToken,
          }
        });
        this.settings = response.data;
      } catch (error) {
        console.error('Error fetching settings:', error); // log the error to the console
        this.message = 'An error occurred while fetching settings.';
      }
    },
  };
  </script>
  
  <style scoped>
  /* Add your CSS here */
  </style>
  