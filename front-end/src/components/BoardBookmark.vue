<template>
  <div class="bookmarks-manager">
    <h1>Bookmarks Board</h1>

    <div class="bookmarks-list">
      <h2>Bookmarks list</h2>
      <ul>
        <li v-for="bookmark in bookmarks" :key="bookmark.id">
         <p>{{ bookmark.title}}</p>
          <h3>{{ bookmark.description}}</h3>
          <button @click="removeBookmark(bookmark.id)">Delete</button>
          <button @click="showEditPopup = true">Edit bookmark
            <edit-bookmark
              v-if="showEditPopup"
              :bookmark="editBookmark"
              @close="showEditPopup = false"
              @save="saveBookmark"
            ></edit-bookmark>
        </button>

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
import EditBookmark from './UI/EditBookmark.vue';


const API_URL = 'http://127.0.0.1:8080/api';
const accessToken = localStorage.getItem('accessToken'); //getting access token from localStorage

export default {
name: "BoardBookmark",
data() {
  return {
    showEditPopup: false,
    bookmarks: [],
    newBookmark: {
      title: "",
      description: ""
    },
    editBookmarkData: {},
  };
},

components: {
    EditBookmark,
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

    const response = await axios.post(API_URL + '/posts', this.newBookmark, {
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + accessToken,
      },
    });
    this.newBookmark = { title: '', description: '' };
    console.log(response);
    this.fetchBookmarks();
  } catch (error) {
    console.error(error);
  }
},


  async removeBookmark(id) {
    try {
      await axios.delete(API_URL + `/posts/${id}`, {
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
          Authorization: 'Bearer ' + accessToken,
        },
      });
      this.fetchBookmarks();
    } catch (error) {
      console.error(error);
    }
  },


async editBookmark(id) {
      try {
        const response = await axios.patch(API_URL + `/posts/${id}`, {
          headers: {
            Accept: 'application/json',
            Authorization: 'Bearer ' + accessToken,
          },
        });
        this.editBookmarkData = response.data.data;
        this.showEditPopup = true;
        this.fetchBookmarks();
      } catch (error) {
    console.error(error);
  }
},


}

};
</script>
<style scoped>
.add-bookmark-form {
  position: absolute;
  top: 0;
  right: 0;
  margin-top: 5rem;
  margin-right: 5rem;
}

.bookmarks-list {
  margin-top: 2rem;
  position: relative;
}

.bookmarks-list h2 {
  margin-bottom: 1rem;
}

.bookmarks-list ul {
  list-style: none;
  padding: 0;
}

.bookmarks-list li {
  margin-bottom: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #eee;
}

.add-bookmark-form h2 {
  margin-bottom: 1rem;
}

.add-bookmark-form input {
  display: block;
  margin-bottom: 1rem;
}

.add-bookmark-form button {
  padding: 0.5rem 1rem;
  background: #39b2dd;
  border: none;
  cursor: pointer;
}

</style>