import { createWebHistory, createRouter } from "vue-router";
import LoginUser from "./components/LoginUser.vue";
import RegistrationUser from "./components/RegistrationUser.vue";
import UserProfile from "./components/UserProfile.vue";
import BoardAdmin from "./components/BoardAdmin.vue";
import BoardModerator from "./components/BoardModerator.vue";
import BoardBookmark from "./components/BoardBookmark.vue";
import UserSettings from '@/components/UserSettings.vue'    

const routes = [{
        path: "/login",
        name: "login",
        component: LoginUser,
    },
    {
        path: "/bookmarks",
        name: "bookmarks",
        component: BoardBookmark,
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
        path: '/settings',
        name: 'UserSettings',
        component: UserSettings
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
export default router;