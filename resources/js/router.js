import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
import VideoInfoComponent from './components/VideoInfoComponent.vue';
import EditCourseInfo from './components/EditCourseInfo.vue';
import AddQuestion from './components/AddQuestion.vue';
import Quiz from './components/Quiz.vue';
// import firstPage from './components/pages/firstPage.vue'
import UploadVideos from './components/UploadVideos.vue'
import AdminDashboard from './components/admin/AdminDashboard.vue'
import Courses from './components/admin/Courses.vue'
import ClassRoom from './components/parents/ClassRoom.vue'
// import VideoInfoComponent from './components/VideoInfoComponent.vue'

import HomePage from './components/front/pages/HomePage.vue'
import RegisterPage from './components/front/pages/auth/RegisterPage.vue'

const routes = [
    {
        path: '/admin/uploadVideos/:data',
        component: UploadVideos,
        name: 'UploadVideo',
        default: true,
    },
    {
        path: '/admin/courses',
        component: Courses,
        name: 'Courses',
    },
    {
        path: '/admin/course-create',
        component: VideoInfoComponent,
        name: 'VideoInfoComponent',
    },
    {
        path: '/admin/course-edit/:data',
        component: EditCourseInfo,
        name: 'EditCourseInfo',
    },
    {
        path: '/parent-dashboard/class-room',
        component: ClassRoom,
        name: 'VideoInfoComponent',
    },
    {
        path: '/admin/course-quiz/:data',
        component: Quiz,
        name: 'Quiz',
    },
    {
        path: '/admin/add-question/:data',
        component: AddQuestion,
        name: 'AddQuestion',
    },
    // ************
    // front
    // ************
    {
        path:'/',
        component: HomePage
    },
    {
        path: '/signup',
        component: RegisterPage
    },
    // {
    //     path: '/user-profile',
    //     component: UserProfile
    // }
]

export default new Router({
    mode: 'history',
    routes
})
