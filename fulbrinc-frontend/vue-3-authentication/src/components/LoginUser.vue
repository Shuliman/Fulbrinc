<template>
  <div class="col-md-12">
    <div class="card card-container">
      <img
        id="profile-img"
        width="40"
        height="40"
        src="../assets/avatar_2x.png"
        class="profile-img-card"
      />
          <!-- Email -->
        <div class="form-group" :class="{ error: v$.form.email.$errors.length }">
          <label for="">Email</label>
          <Field name="email" type="email" v-model="v$.form.email.$model" placeholder="Email" class="form-control" />
          <div class="pre-icon os-icon os-icon-user-male-circle"></div>
            <!-- error message -->
          <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
            <div class="error-msg">{{ error.$message }}</div>
          </div>
        </div>
        <!-- Password -->
        <div class="form-group" :class="{ error: v$.form.password.$errors.length }">
          <label for="">Password</label>
          <Field name="password" type="password" v-model="v$.form.password.$model" placeholder="********" class="form-control" />
              <!-- error message -->
          <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
            <div class="error-msg">{{ error.$message }}</div>
          </div>
        </div>

          <!-- Submit Button -->
        <div class="form-group">
          <button :disabled="v$.form.$invalid" class="btn btn-primary btn-block" v-on:click="sendCreds" >Login</button>
          <AuthStatus v-if="showAuthStatusModal" :message="authStatusMessage" @close="onAuthStatusModalClose" />

        </div>
    </div>
  </div>
</template>
<script>
import AuthStatus from "@/components/UI/AuthStatus.vue";
import {Field } from "vee-validate";
import useVuelidate from '@vuelidate/core'
import { required, email, minLength } from '@vuelidate/validators'
import axios from 'axios'
const API_URL = 'http://127.0.0.1:8080/api';

export default {

  name: "LoginUser",
  components: {
    Field,
    AuthStatus,
  },

  setup() {
    return { v$: useVuelidate() }
  },
  
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      showAuthStatusModal: false,
      authStatusMessage: "",
    };
  },

  validations() {
    return {
      form: {
        email: {
           required, email 
        },
        password: {
            required, 
            min: minLength(6)
        },
      },
    }
  },

  methods: {
    sendCreds() {
      axios
        .post(API_URL + "/login", {
          email: this.$data.form.email,
          password: this.$data.form.password,
        })
        .then((response) => {
          // saving token into localStorage
          localStorage.setItem("accessToken", response.data.token);
          console.log(response);

          this.showAuthStatusModal = true;
          this.authStatusMessage = "Login successful!";
        })
        .catch((error) => {
          console.error(error);

          this.showAuthStatusModal = true;
          this.authStatusMessage = "Login failed. Please try again.";
        });
    },
    onAuthStatusModalClose() {
      this.showAuthStatusModal = false;
      this.authStatusMessage = "";
    },
  },

};
</script>
<style scoped>
  .card-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #1d1d1d;
    border: 2px solid #00bcd4;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    border-radius: 5px;
    padding: 20px;
    margin: 20px;

  }

  #profile-img {
    border-radius: 50%;
    background-color: #00bcd4;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    margin-bottom: 20px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
  }

  .form-control {
    width: 80%;
    height: 40px;
    border: none;
    border-radius: 5px;
    background-color: #333333;
    color: #00bcd4;
    font-size: 16px;
  }
  .btn-primary {
    background-color: #00bcd4;
    border: none;
    color: #fff;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 20px;
  }
</style>