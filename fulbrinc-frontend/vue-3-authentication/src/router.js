import { createWebHistory, createRouter } from "vue-router";
import MainHome from "./components/MainHome.vue";
import LoginUser from "./components/LoginUser.vue";
import RegistrationUser from "./components/RegistrationUser.vue";
import UserProfile from "./components/UserProfile.vue";
import BoardAdmin from "./components/BoardAdmin.vue";
import BoardModerator from "./components/BoardModerator.vue";
import BoardUser from "./components/BoardUser.vue";
import BookmarkManager from "./components/BookmarkManager.vue";

const routes = [{
        path: "/",
        name: "home",
        component: MainHome,
    },
    {
        path: "/home",
        component: MainHome,
    },
    {
        path: "/login",
        name: "login",
        component: LoginUser,
    },
    {
        path: "/bookmarks",
        name: "bookmarks",
        component: BookmarkManager,
    },
    {
        path: "/register",
        name: "register",
        component: RegistrationUser,
    },
    {
        path: "/profile",
        name: "profile",
        component: UserProfile,
    },
    {
        path: "/admin",
        name: "admin",
        component: BoardAdmin,
    },
    {
        path: "/mod",
        name: "moderator",
        component: BoardModerator,
    },
    {
        path: "/user",
        name: "user",
        component: BoardUser,
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
export default router;