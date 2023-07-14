<template>
    <div class="user-settings">
      <h1>User Settings</h1>
      
      <form @submit.prevent="updateSettings">
        <label for="username">Username:</label>
        <input id="username" v-model="settings.username" type="text" />
  
        <label for="email">Email:</label>
        <input id="email" v-model="settings.email" type="email" />
  
        <!-- Add other settings fields here -->
  
        <button type="submit">Save Changes</button>
      </form>
  
      <p v-if="message">{{ message }}</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
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
          await axios.put(API_URL +'/settings', this.settings, {
            headers: {
              'Authorization': `Bearer ${this.$store.state.token}`
            }
          });
          this.message = 'Settings updated successfully!';
        } catch (error) {
          this.message = 'An error occurred while updating settings.';
        }
      },
    },
    async created() {
      try {
        const response = await axios.get(API_URL +'/settings', {
          headers: {
            'Authorization': `Bearer ${this.$store.state.token}`
          }
        });
        this.settings = response.data;
      } catch (error) {
        this.message = 'An error occurred while fetching settings.';
      }
    },
  };
  </script>
  
  <style scoped>
  /* Add your CSS here */
  </style>
  