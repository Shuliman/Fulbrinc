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
        </div>
    </div>
  </div>
</template>
<script>
import {Field } from "vee-validate";
import useVuelidate from '@vuelidate/core'
import { required, email, minLength } from '@vuelidate/validators'
import axios from 'axios'
const API_URL = 'http://127.0.0.1:8080/api';

export default {

  name: "LoginUser",
  components: {
    Field,
  },

  setup() {
    return { v$: useVuelidate() }
  },
  
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
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
    sendCreds(){
          axios
            .post(API_URL + '/login', {
              email: this.$data.form.email,
              password: this.$data.form.password
            })
            .then((response) => console.log(response))
      }
  },

};
</script>
<style scoped>
</style>