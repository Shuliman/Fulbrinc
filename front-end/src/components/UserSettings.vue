<template>
    <div class="user-settings">
      <h1>User Settings</h1>
      <form @submit.prevent="updateSettings">
        <label for="name">Name:</label>
        <input id="name" v-model="settings.name" type="text" />
  
        <label for="email">Email:</label>
        <input id="email" v-model="settings.email" type="email" />

        <label for="password">New Password:</label>
        <input id="password" v-model="settings.password" type="password" />

        <label for="old_password">Old Password:</label>
        <input id="old_password" v-model="settings.old_password" type="password" />
  
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
          name: '',
          email: '',
          password: '',
          old_password: '',
        },
        message: '',
      };
    },
    methods: {
      async updateSettings() {
        try {
            let data = new URLSearchParams();
            data.append('name', this.settings.name);
            data.append('email', this.settings.email);
            data.append('password', this.settings.password);
            data.append('old_password', this.settings.old_password);

            await axios({
            method: 'put',
            url: API_URL + '/settings',
            data: data,
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
    async mounted() {
      try {
        const response = await axios({
          method: 'get',
          url: API_URL + '/settings',
          headers: {
            'Authorization': 'Bearer ' + accessToken,
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        });
        this.settings.name = response.data.name;
        this.settings.email = response.data.email;
      } catch (error) {
        console.error('Error fetching settings:', error); // log the error to the console
        this.message = 'An error occurred while fetching settings.';
      }
    },
  };
  </script>

<style scoped>
.user-settings {
  width: 100%;
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.user-settings form {
  display: flex;
  flex-direction: column;
}

.user-settings label {
  margin-top: 20px;
}

.user-settings input[type="text"],
.user-settings input[type="email"],
.user-settings input[type="password"] {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
}

.user-settings button {
  margin-top: 20px;
  padding: 10px;
}
</style>
