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
      <Form @submit.prevent="onSubmit" @submit="handleRegister" :validation-schema="schema">
      
        <div v-if="!successful">

           <!-- Username Row -->
          <div class="form-group">
            <div class="form-group">
            <label for="">Username</label>
              <Field name="username" type="text" v-model="v$.form.Username.$model" placeholder="Username" class="form-control" />
              <div class="pre-icon os-icon os-icon-user-male-circle"></div>
              <!-- Error Message -->
              <div class="input-errors" v-for="(error, index) of v$.form.Username.$errors" :key="index">
                <div class="error-msg">{{ error.$message }}</div>
              </div>
            </div>
          </div>

              <!-- Email Row -->
          <div class="form-group">
            <label for="">Email</label>
            <Field name="email" type="email" v-model="v$.form.email.$model" placeholder="email@mail.com" class="form-control" />
            <div class="pre-icon os-icon os-icon-email-2-at2"></div>
            <!-- Error Message -->
              <div class="input-errors" v-for="(error, index) of v$.form.email.$errors" :key="index">
                <div class="error-msg">{{ error.$message }}</div>
              </div>
          </div>
              <!-- Password and Confirm Password Row -->
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for=""> Password</label>
                <input class="form-control" placeholder="********" type="password" v-model="v$.form.password.$model">
                <div class="pre-icon os-icon os-icon-fingerprint"></div>
                <!-- Error Message -->
                <div class="input-errors" v-for="(error, index) of v$.form.password.$errors" :key="index">
                  <div class="error-msg">{{ error.$message }}</div>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Confirm Password</label>
                <input @input="checkPassword()" class="form-control" placeholder="Confirm Password" type="password" v-model="v$.form.confirmPassword.$model">
                <!-- Error Message -->
                <div v-show="v$.form.password.$model !== v$.form.confirmPassword.$model">
                  <h6>
                    Password is not confirmed
                  </h6>
                </div>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group">
            <button class="btn btn-primary btn-block" :disabled="v$.form.$invalid" v-on:click="sendCreds" >
              <span
                v-show="loading"
                class="spinner-border spinner-border-sm"
              ></span>
              Sign Up
            </button>
          </div>
        </div>
      
      </Form>
      <div
        v-if="message"
        class="alert"
        :class="successful ? 'alert-success' : 'alert-danger'"
      >
        {{ message }}
      </div>
    </div>
  </div>
</template>
<script>
import { Form, Field } from "vee-validate";
import useVuelidate from '@vuelidate/core'
import { required, email, minLength } from '@vuelidate/validators'
import axios from 'axios'
const REGISTRATION_API_URL = 'http://127.0.0.1:8080/api/register';

export function validName(name) {
  let validNamePattern = new RegExp("^[a-zA-Z]+(?:[-'\\s][a-zA-Z]+)*$");
  if (validNamePattern.test(name)){
    return true;
  }
  return false;
}

export default {
  name: "RegistrationUser",
  components: {
    Form,
    Field,
  },   

  setup () {
    return { v$: useVuelidate() }
  },

  data() {
    return {
      form: {
        Username: '',
        email: '',
        password: '',
        confirmPassword: '',
      },
    };
  },

  mounted() {
    
  },

validations() {
    return {
      form: {
        Username: { 
          required, name_validation: {
            $validator: validName,
            $message: 'Invalid Name. Valid name only contain letters, dashes (-) and spaces'
          } 
        },
        
        email: { required, email },
        password: { required, min: minLength(6) },
        confirmPassword: { required }
      },
    }
  },

  methods: {
    sendCreds(){
      axios
    .post(REGISTRATION_API_URL, {
      name: this.form.Username,
      email: this.form.email,
      password: this.form.password
    })
    .then((response) => console.log(response))
    }
  },
};
</script>
<style scoped>
</style>