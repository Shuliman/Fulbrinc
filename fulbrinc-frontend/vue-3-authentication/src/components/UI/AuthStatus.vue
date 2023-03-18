<template>
    <div class="modal" :class="{ 'is-active': showModal }">
      <div class="modal-background" ></div>
      <div class="modal-content">
        <div class="box" @click="closeModal">
          <p>{{ message }} </p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "AuthModal",
    props: {
      message: {
        type: String,
        required: true,
      },
    },
    data() {
      return {
        showModal: true,
      };
    },
    methods: {
      closeModal() {
        this.showModal = false;
        this.$emit("close");
      },
    },
  };
  </script>  
  <style scoped>
  .modal {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .btn-primary {
  background-color: #00bcd4;
  border: none;
  color: #fff;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 20px;
}
  
  .modal-content {
    max-width: 300px;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    padding: 20px;
  }
  
  .modal-close.is-large {
    position: absolute;
    top: 10px;
    right: 10px;
    border: none;
    background-color: transparent;
    color: #fff;
    font-size: 24px;
    transition: color 0.3s ease-in-out;
  }
  
  .modal-close.is-large:hover {
    color: #888;
  }
  </style>
  