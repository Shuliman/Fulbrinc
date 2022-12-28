<template>
    <div class="bookmarks-manager">
      <h1>Bookmarks manager</h1>
  
      <div class="bookmarks-list">
        <h2>Bookmarks list</h2>
        <ul>
          <li v-for="bookmark in bookmarks" :key="bookmark.id">
           <p>{{ bookmark.title}}</p>
            <h3>{{ bookmark.description}}</h3>
            <button @click="deleteBookmark(bookmark.id)">Delete</button>
          </li>
        </ul>
      </div>
  
      <div class="add-bookmark-form">
        <h2>Add bookmark</h2>
        <form @submit.prevent="addBookmark">
          <label>
            Title:
            <input v-model="newBookmark.title" type="text" required />
          </label>
          <br/>
          <label>
            Description:
            <input v-model="newBookmark.description" type="text" required />
          </label>
          <br/>
          <button type="submit">Add</button>
        </form>
      </div>
    </div>
  </template>
  

<script>
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8080/api';
const accessToken = localStorage.getItem('accessToken'); //getting access token from localStorage

export default {
  name: "BookmarkManager",
  data() {
    return {
      user: {
        user_id: 69,
      },
      bookmarks: [],
      newBookmark: {
        title: "",
        description: ""
      }
    };
  },

  created() {
    this.fetchBookmarks();
  },

  methods: {
    async fetchBookmarks() {
    try {
        const response = await axios.get(API_URL + '/posts', {
          headers: {
            Accept: 'application/json',
            Authorization: 'Bearer ' + accessToken,
        },
        });
        // refreshing bookmarks list in data component getted from response
        this.bookmarks = response.data.data;
    } catch (error) {
        console.error(error);
        }
    },

    async addBookmark() {
    try {
      const accessToken = localStorage.getItem('accessToken');

      const response = await axios.post(API_URL + '/posts', {
        title: this.newBookmark.title,
        description: this.newBookmark.description
      }, {
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + accessToken,
        },
      });

      console.log(response);
      this.fetchBookmarks();
    } catch (error) {
      console.error(error);
    }
  },


    async removeBookmark(id) {
      try {
        await axios.delete(API_URL + `/posts/${id}`);
        this.fetchBookmarks();
      } catch (error) {
        console.error(error);
      }
    },

  }

};
</script>
  