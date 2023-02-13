<template>
    <form @submit.prevent="editBookmark" @click.self="closeModal">
        <div class="modal-close" @click="closeModal">&#10006;</div>
      <label>
        Title:
        <input v-model="localBookmark.title" type="text" required />
      </label>
      <br />
      <label>
        Description:
        <input v-model="localBookmark.description" type="text" required />
      </label>
      <br />
      <button type="submit">Save</button>
      <button type="button" @click="closeModal">Cancel</button>
    </form>
  </template>
  <script>
  export default {
    name: 'EditBookmarkModal',
    props: {
      bookmark: {
        type: Object,
        required: true,
      },
      closeModal: {
        type: Function,
        required: true,
      },
    },
    data() {
      return {
        localBookmark: this.bookmark,
      }
    },
  }
  </script>