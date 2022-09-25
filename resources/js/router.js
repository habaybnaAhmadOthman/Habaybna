import Vue from "vue";
import Router from "vue-router";
import VueGtm from '@gtm-support/vue2-gtm';

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
import CallsRequests from "./components/admin/callsRequests/Calls.vue";
import Media from "./components/admin/media/Index.vue";
import ShowMedia from "./components/admin/media/Show.vue";
import CreateMedia from "./components/admin/media/Create.vue";
import ContactUs from "./components/admin/contactUs/ContactUs.vue";
import Parents from "./components/admin/parent/Parents.vue";
import CreateParent from "./components/admin/parent/Create.vue";
import CreateCoupon from "./components/admin/coupon/Create.vue";
import CoursesOrders from "./components/admin/orders/courses/Index.vue";
import Contents from "./components/admin/contents/Contents.vue";
import CreateContent from "./components/admin/contents/Create.vue";
import UpdateContent from "./components/admin/contents/Show.vue";

import ContentsNew from "./components/admin/contentsNew/Contents.vue";
import CreateContentNew from "./components/admin/contentsNew/Create.vue";
import UpdateContentNew from "./components/admin/contentsNew/Show.vue";

// Testimonials admin
import Testimonials from "./components/admin/testimonials/Testimonials.vue";
import TestimonialsCreate from "./components/admin/testimonials/Create.vue";
import TestimonialsShow from "./components/admin/testimonials/Show.vue";

import CreateCall from "./components/admin/calls/Create.vue";
import CreateSpecialist from "./components/admin/specialist/Create.vue";
import CreateOther from "./components/admin/other/Create.vue";
import ShowSpecialist from "./components/admin/specialist/Show.vue";
import ShowMessage from "./components/admin/contactUs/Show.vue";
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
import CallPaymentStatus from "./components/front/pages/courses/CallPaymentStatus.vue";
import ExamPage from "./components/front/pages/courses/ExamPage.vue";

// library
import LibraryPage from "./components/front/pages/library/LibraryPage.vue";
import ArticlePage from "./components/front/pages/library/ArticlePage.vue";
// specialist
import SpecialistPage from "./components/front/pages/specialist/SpecialistPage";
import SpecialistsPage from "./components/front/pages/specialist/SpecialistsPage.vue";
import allSpecialistsPage from "./components/front/pages/specialist/allSpecialistsPage.vue";
import PartnersProgramPage from "./components/front/pages/PartnersProgramPage.vue";
import NSBirthday from "./components/front/pages/NSBirthday.vue";
import NSBirthdayStatus from "./components/front/pages/NSBirthdayStatus.vue";
import TermsPage from "./components/front/pages/TermsPage.vue";
import TermsEnPage from "./components/front/pages/TermsEnPage.vue";
import AboutPage from "./components/front/pages/AboutHabaybna.vue";
import AboutEnPage from "./components/front/pages/AboutHabaybnaEn.vue";
import MediaCoveragePage from "./components/front/pages/MediaCoveragePage.vue";



// register pages
import RegisterPage from "./components/front/pages/auth/RegisterPage.vue";
import RegisterParentComplete from "./components/front/pages/auth/Register_ParentComplete.vue";
import RegisterSpecialistComplete from "./components/front/pages/auth/Register_SpecialistComplete.vue";
import RegisterOtherComplete from "./components/front/pages/auth/Register_OtherComplete.vue";

// login
import LoginPage from "./components/front/pages/auth/LoginPage.vue";
import ForgetPasswordPage from "./components/front/pages/auth/ForgetPasswordPage.vue";


import UserProfile_Template from "./components/front/views/userprofile/UserProfile_Template";
import UserProfile_MyAccount from "./components/front/pages/dashboard/UserProfile.vue";
import UserProfile_MyCourses from "./components/front/pages/dashboard/MyCourses.vue";
import UserProfile_MyFavouriteCourses from "./components/front/pages/dashboard/MyFavouriteCourses.vue";
import UserProfile_MyFavouriteContent from "./components/front/pages/dashboard/MyFavouriteContents.vue";

// user profile ==> Calls
import UserProfile_SessionTimes from "./components/front/pages/dashboard/calls/SessionTimes.vue";
import UserProfile_CallLogs from "./components/front/pages/dashboard/calls/CallLog.vue";



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
        path: "/admin/testimonials",
        component: Testimonials,
        name: "Testimonials"
    },
    {
        path: "/admin/testimonials/create",
        component: TestimonialsCreate,
        name: "TestimonialsCreate"
    },
    {
        path: "/admin/testimonials/:data",
        component: TestimonialsShow,
        name: "TestimonialsShow"
    },

    {
        path: "/admin/media",
        component: Media,
        name: "Media"
    },
    {
        path: "/admin/media-create",
        component: CreateMedia,
        name: "CreateMedia"
    },
    {
        path: "/admin/parents",
        component: Parents,
        name: "Parents"
    },
    {
        path: "/admin/contact-us",
        component: ContactUs,
        name: "ContactUs"
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
        path: "/admin/content-new",
        component: ContentsNew,
        name: "ContentsNew"
    },
    {
        path: "/admin/content-new/create",
        component: CreateContentNew,
        name: "CreateContentNew"
    },
    {
        path: "/admin/content-new/:data",
        component: UpdateContentNew,
        name: "UpdateContentNew"
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
        path: "/admin/contents",
        component: Contents,
        name: "Contents"
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
        path: "/admin/content/:data",
        component: UpdateContent,
        name: "UpdateContent"
    },
    {
        path: "/admin/contact-us/:data",
        component: ShowMessage,
        name: "ShowMessage"
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
        path: "/admin/media-update/:data",
        component: ShowMedia,
        name: "ShowMedia"
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

    {
        path: "/admin/calls-requests",
        component: CallsRequests,
        name: "CallsRequests"
    },

    // ************
    // front
    // ************
    // *****************
    // about habaybna pages
    // *****************
    {
        path: "/partners-program",
        component: PartnersProgramPage
    },
    {
        path: "/Nadeem-Sirajs-Birthday-Gift",
        component: NSBirthday
    },
    {
        path: "/terms-and-conditions",
        component: TermsPage
    },
    {
        path: "/terms-and-conditions-en",
        component: TermsEnPage
    },
    {
        path: "/about-habaybna",
        component: AboutPage
    },
    {
        path: "/about-habaybna-en",
        component: AboutEnPage
    },
    {
        path: "/media-coverage",
        component: MediaCoveragePage
    },
    // *****************
    // end habaybna pages
    // *****************
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
            anonymous: true,
            back: true
        }
    },
    {
        path: "/parent-complete-registration",
        component: RegisterParentComplete,
        meta: {
            // requiresAuth: true
        }
    },
    {
        path: "/specialist-complete-registration",
        component: RegisterSpecialistComplete,
        meta: {
            // requiresAuth: true
        }
    },
    {
        path: "/other-complete-registration",
        component: RegisterOtherComplete,
        meta: {
            // requiresAuth: true
        }
    },
    {
        path: "/signin",
        component: LoginPage,
        meta: {
            requiresAuth: false,
            anonymous: true,
            back: true
        },
        name: "login"
    },
    {
        path: "/forget-password",
        component: ForgetPasswordPage,
        meta: {
            requiresAuth: false,
            anonymous: true,
            back: true
        },
        name: "forgetPassword"
    },
    // user profile #dashboard
    {
        path: "/profile",
        component: UserProfile_Template,
        meta: {
            requiresAuth: true
        },
        children: [{
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
            {
                path: "my-favourite-courses",
                component: UserProfile_MyFavouriteCourses,
                meta: {
                    header: false
                },
                name: 'myFavouriteCourses'
            },
            {
                path: "my-favourite-contents",
                component: UserProfile_MyFavouriteContent,
                meta: {
                    header: false
                },
                name: 'myFavouriteContents'
            },
            // calls
            {
                path: "my-sessions-times",
                component: UserProfile_SessionTimes,
                name: 'mySessionsTimes'
            },
            {
                path: "my-call-log",
                component: UserProfile_CallLogs,
                name: 'myCallLog'
            },

        ]
    },
    // *****************
    // courses
    {
        path: "/courses/:course",
        component: CoursePage,
        meta: {
            requiresAuth: false,
            back: true
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
            requiresAuth: true,
            back: true
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
        path: "/call-payment-success",
        component: CallPaymentStatus,
        meta: {
            requiresAuth: true
        },

    },
    {
        path: "/gift-payment-status",
        component: NSBirthdayStatus,


    },
    {
        path: "/course/:course/certificate",
        component: Cirtificate,
        meta: {
            requiresAuth: true
        },
        props: true
    },
    // *****************
    // specialist page
    {
        path: "/all-specialists",
        component: allSpecialistsPage
    },
    {
        path: "/ask-specialists",
        component: SpecialistsPage
    },
    {
        path: "/specialist/:specialist",
        component: SpecialistPage,
        props: true,
    },
    // *****************
    // content pages
    {
        path: "/library",
        component: LibraryPage,
        name: 'library'
    },
    {
        path: "/library/:article",
        component: ArticlePage,
        props: true
    },

    {
        path: "*",
        component: ErrorPage,
        name: 'errorPage'
    }
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

Vue.use(VueGtm, {
    id: 'GTM-NZQPBCZ', // Your GTM single container ID, array of container ids ['GTM-xxxxxx', 'GTM-yyyyyy'] or array of objects [{id: 'GTM-xxxxxx', queryParams: { gtm_auth: 'abc123', gtm_preview: 'env-4', gtm_cookies_win: 'x'}}, {id: 'GTM-yyyyyy', queryParams: {gtm_auth: 'abc234', gtm_preview: 'env-5', gtm_cookies_win: 'x'}}], // Your GTM single container ID or array of container ids ['GTM-xxxxxx', 'GTM-yyyyyy']
    // queryParams: {
    //   // Add URL query string when loading gtm.js with GTM ID (required when using custom environments)
    //   gtm_auth: 'AB7cDEf3GHIjkl-MnOP8qr',
    //   gtm_preview: 'env-4',
    //   gtm_cookies_win: 'x'
    // },
    defer: false, // Script can be set to `defer` to speed up page load at the cost of less accurate results (in case visitor leaves before script is loaded, which is unlikely but possible). Defaults to false, so the script is loaded `async` by default
    compatibility: false, // Will add `async` and `defer` to the script tag to not block requests for old browsers that do not support `async`
    nonce: '2726c7f26c', // Will add `nonce` to the script tag
    enabled: true, // defaults to true. Plugin can be disabled by setting this to false for Ex: enabled: !!GDPR_Cookie (optional)
    debug: true, // Whether or not display console logs debugs (optional)
    loadScript: true, // Whether or not to load the GTM Script (Helpful if you are including GTM manually, but need the dataLayer functionality in your components) (optional)
    vueRouter: router, // Pass the router instance to automatically sync with router (optional)
    // ignoredViews: ['homepage'], // Don't trigger events for specified router names (optional)
    trackOnNextTick: false // Whether or not call trackView in Vue.nextTick
});


export default router;
