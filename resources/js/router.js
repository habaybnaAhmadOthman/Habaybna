import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);
import VideoInfoComponent from "./components/VideoInfoComponent.vue";
import EditCourseInfo from "./components/EditCourseInfo.vue";
import AddQuestion from "./components/AddQuestion.vue";
import Quiz from "./components/Quiz.vue";
// import firstPage from './components/pages/firstPage.vue'
import UploadVideos from "./components/UploadVideos.vue";
import AdminDashboard from "./components/admin/AdminDashboard.vue";
import Courses from "./components/admin/Courses.vue";
import ClassRoom from "./components/parents/ClassRoom.vue";
// import VideoInfoComponent from './components/VideoInfoComponent.vue'

import HomePage from "./components/front/pages/HomePage.vue";

// register pages
import RegisterPage from "./components/front/pages/auth/RegisterPage.vue";
import RegisterParentComplete from "./components/front/pages/auth/Register_ParentComplete.vue";
import RegisterSpecialistComplete from "./components/front/pages/auth/Register_SpecialistComplete.vue";
import RegisterOtherComplete from "./components/front/pages/auth/Register_OtherComplete.vue";

// login
import LoginPage from "./components/front/pages/auth/LoginPage.vue";

import UserProfile from "./components/front/pages/dashboard/UserProfile.vue";

import store from "./store/index";

const routes = [
    {
        path: "/admin/uploadVideos/:data",
        component: UploadVideos,
        name: "UploadVideo",
        default: true
    },
    {
        path: "/admin/courses",
        component: Courses,
        name: "Courses"
    },
    {
        path: "/admin/course-create",
        component: VideoInfoComponent,
        name: "VideoInfoComponent"
    },
    {
        path: "/admin/course-edit/:data",
        component: EditCourseInfo,
        name: "EditCourseInfo"
    },
    {
        path: "/parent-dashboard/class-room",
        component: ClassRoom,
        name: "VideoInfoComponent"
    },
    {
        path: "/admin/course-quiz/:data",
        component: Quiz,
        name: "Quiz"
    },
    {
        path: "/admin/add-question/:data",
        component: AddQuestion,
        name: "AddQuestion"
    },
    // ************
    // front
    // ************
    {
        path: "/",
        component: HomePage,
        name: "home"
    },
    {
        path: "/signup",
        component: RegisterPage,
        meta: {
            header: false,
            anonymous: true
        }
    },
    {
        path: "/parent-complete-registration",
        component: RegisterParentComplete,
        meta: {
            header: false,
            requiresAuth: true
        }
    },
    {
        path: "/specialist-complete-registration",
        component: RegisterSpecialistComplete,
        meta: {
            header: false,
            requiresAuth: true
        }
    },
    {
        path: "/other-complete-registration",
        component: RegisterOtherComplete,
        meta: {
            header: false,
            requiresAuth: true
        }
    },
    {
        path: "/signin",
        component: LoginPage,
        meta: {
            header: false,
            requiresAuth: false,
            anonymous: true
        },
        name: "login"
    },
    // user profile #dashboard
    {
        path: "/profile",
        component: UserProfile,
        meta: {
            requiresAuth: true,
            header: false
        }
    }
];

const router = new Router({
    mode: "history",
    routes
});

router.beforeEach((to, from, next) => {
    // if page require auth
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!!localStorage.getItem("login")) {
            next();
        } else {
            next({
                name: "login"
            });
        }
    } else {
        // if the user already logged in and try to register or login again
        if (to.meta.anonymous && !!localStorage.getItem("login")) {
            next({
                name: "home"
            });
        } else {
            next();
        }
    }
});

export default router;
