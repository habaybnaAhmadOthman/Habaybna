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
import Calls from "./components/admin/calls/Calls.vue";
import Parents from "./components/admin/parent/Parents.vue";
import CreateParent from "./components/admin/parent/Create.vue";
import CreateCoupon from "./components/admin/coupon/Create.vue";
import CoursesOrders from "./components/admin/orders/courses/Index.vue";
import CreateContent from "./components/admin/contents/Create.vue";
import CreateCall from "./components/admin/calls/Create.vue";
import CreateSpecialist from "./components/admin/specialist/Create.vue";
import CreateOther from "./components/admin/other/Create.vue";
import ShowSpecialist from "./components/admin/specialist/Show.vue";
import ShowPackage from "./components/admin/calls/Show.vue";
import ShowOther from "./components/admin/other/Show.vue";
import Specialists from "./components/admin/specialist/Specialists.vue";
import Coupons from "./components/admin/coupon/Coupons.vue";
import PreviewCourse from "./components/admin/courses/Preview.vue";
import CourseCertificate from "./components/admin/courses/Certificate.vue";
import UsersProgress from "./components/admin/courses/UsersProgress.vue";
import ShowCoupon from "./components/admin/coupon/Show.vue";
import Others from "./components/admin/other/Others.vue";
import Show from "./components/admin/parent/Show.vue";
import ClassRoom from "./components/parents/ClassRoom.vue";
// import VideoInfoComponent from './components/VideoInfoComponent.vue'

import HomePage from "./components/front/pages/HomePage.vue";
import ErrorPage from "./components/front/pages/ErrorPage.vue";
import onlineCoursesPage from "./components/front/pages/onlineCoursesPage.vue";
import allCoursesPage from "./components/front/pages/allCoursesPage.vue";
// courses
import CoursePage from "./components/front/pages/courses/CoursePage.vue";
import ClassRoomPage from "./components/front/pages/courses/ClassRoom.vue";
import Cirtificate from "./components/front/views/coursepage/Certificate.vue";
import PaymentStatus from "./components/front/pages/courses/PaymentStatus.vue";
import ExamPage from "./components/front/pages/courses/ExamPage.vue";



// register pages
import RegisterPage from "./components/front/pages/auth/RegisterPage.vue";
import RegisterParentComplete from "./components/front/pages/auth/Register_ParentComplete.vue";
import RegisterSpecialistComplete from "./components/front/pages/auth/Register_SpecialistComplete.vue";
import RegisterOtherComplete from "./components/front/pages/auth/Register_OtherComplete.vue";

// login
import LoginPage from "./components/front/pages/auth/LoginPage.vue";


import UserProfile_Template from "./components/front/views/userprofile/UserProfile_Template";
import UserProfile_MyAccount from "./components/front/pages/dashboard/UserProfile.vue";
import UserProfile_MyCourses from "./components/front/pages/dashboard/MyCourses.vue";

import store from "./store/index";

const routes = [{
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
        path: "/admin/parents",
        component: Parents,
        name: "Parents"
    },
    {
        path: "/admin/parent/create",
        component: CreateParent,
        name: "CreateParent"
    },
    {
        path: "/admin/courses/users-progress",
        component: UsersProgress,
        name: "UsersProgress"
    },
    {
        path: "/admin/content/create",
        component: CreateContent,
        name: "CreateContent"
    },
    {
        path: "/admin/specialist/create",
        component: CreateSpecialist,
        name: "CreateSpecialist"
    },
    {
        path: "/admin/other/create",
        component: CreateOther,
        name: "CreateOther"
    },
    {
        path: "/admin/specialist",
        component: Specialists,
        name: "Specialists"
    },
    {
        path: "/admin/coupons",
        component: Coupons,
        name: "Coupons"
    },
    {
        path: "/admin/others",
        component: Others,
        name: "Others"
    },
    {
        path: "/admin/parent/:data",
        component: Show,
        name: "Show"
    },
    {
        path: "/admin/calls/package/:data",
        component: ShowPackage,
        name: "ShowPackage"
    },
    {
        path: "/admin/specialist/:data",
        component: ShowSpecialist,
        name: "ShowSpecialist"
    },
    {
        path: "/admin/coupon/:data",
        component: ShowCoupon,
        name: "ShowCoupon"
    },
    {
        path: "/admin/other/:data",
        component: ShowOther,
        name: "ShowOther"
    },
    {
        path: "/admin/course-create",
        component: VideoInfoComponent,
        name: "VideoInfoComponent"
    },
    {
        path: "/admin/course-certificate/:data",
        component: CourseCertificate,
        name: "CourseCertificate"
    },
    {
        path: "/admin/course-edit/:data",
        component: EditCourseInfo,
        name: "EditCourseInfo"
    },
    {
        path: "/admin/course/preview/:data",
        component: PreviewCourse,
        name: "PreviewCourse"
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
    {
        path: "/admin/coupons/create",
        component: CreateCoupon,
        name: "CreateCoupon"
    },
    {
        path: "/admin/orders/courses-orders",
        component: CoursesOrders,
        name: "CoursesOrders"
    },
    {
        path: "/admin/calls/create",
        component: CreateCall,
        name: "CreateCall"
    },
    {
        path: "/admin/calls",
        component: Calls,
        name: "Calls"
    },
    // ************
    // front
    // ************
    {
        path: "/api/course-payment-callback",
        component: Cirtificate,
        // meta: {
        //     requiresAuth: true
        // }
    },
    {
        path: "/",
        component: HomePage,
        name: "home"
    },
    {
        path: "/online-courses",
        component: onlineCoursesPage,
        name: "onlineCourses"
    },
    {
        path: "/all-courses",
        component: allCoursesPage,
        name: "allCourses"
    },
    // *****************
    // auth pages
    {
        path: "/signup",
        component: RegisterPage,
        meta: {
            anonymous: true
        }
    },
    {
        path: "/parent-complete-registration",
        component: RegisterParentComplete,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: "/specialist-complete-registration",
        component: RegisterSpecialistComplete,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: "/other-complete-registration",
        component: RegisterOtherComplete,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: "/signin",
        component: LoginPage,
        meta: {
            requiresAuth: false,
            anonymous: true
        },
        name: "login"
    },
    // user profile #dashboard
    {
        path: "/profile",
        component: UserProfile_Template,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: "my-account",
                component: UserProfile_MyAccount,
                meta: {
                    header: false
                },
                name: 'myAccount'
            },
            {
                path: "my-courses",
                component: UserProfile_MyCourses,
                meta: {
                    header: false
                },
                name: 'myCourses'
            },
    ]
    },
    // *****************
    // courses
    {
        path: "/courses/:course",
        component: CoursePage,
        meta: {
            requiresAuth: false
        },
        props: true
    },
    {
        path: "/courses/:course/exam",
        component: ExamPage,
        meta: {
            requiresAuth: true
        },
        props: true
    },
    {
        path: "/courses/:course/:lesson",
        component: ClassRoomPage,
        meta: {
            requiresAuth: true
        },
        props: true
    },

    {
        path: "/payment-success",
        component: PaymentStatus,
        meta: {
            requiresAuth: true
        },

    },
    {
        path: "/certificate",
        component: Cirtificate,
        meta: {
            requiresAuth: true
        }
    },


    { path: "*", component: ErrorPage }
];

const router = new Router({
    mode: "history",
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return {
                x: 0,
                y: 0
            }
        }
    }
});

router.beforeEach((to, from, next) => {
    // if page require auth
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters['user/isLoggedIn']) {
            next();
        } else {
            next({
                name: "login"
            });
        }
    } else {
        // if the user already logged in and try to register or login again
        if (to.meta.anonymous && store.getters['user/isLoggedIn']) {
            next({
                name: "home"
            });
        } else {
            next();
        }
    }
});

export default router;
