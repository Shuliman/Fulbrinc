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
      <Form @submit="handleLogin" :validation-schema="schema">
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
          <button :disabled="v$.form.$invalid" class="btn btn-primary btn-block">Login</button>
        </div>
      </Form>
    </div>
  </div>
</template>
<script>
import { Form, Field } from "vee-validate";
import useVuelidate from '@vuelidate/core'
import { required, email, minLength } from '@vuelidate/validators'

export default {

  name: "LoginUser",
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
  },

};
</script>
<style scoped>
</style>