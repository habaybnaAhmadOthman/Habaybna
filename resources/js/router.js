import Vue from 'vue'
import  Router  from 'vue-router'

Vue.use(Router)
import VideoInfoComponent from './components/VideoInfoComponent.vue';
import firstPage from './components/pages/firstPage.vue'
import UploadVideos from './components/UploadVideos.vue'
import AdminDashboard from './components/admin/AdminDashboard.vue'
import Courses from './components/admin/Courses.vue'
import ClassRoom from './components/parents/ClassRoom.vue'
// import VideoInfoComponent from './components/VideoInfoComponent.vue'

const routes = [
    // {

    //     path: '/admin',
    //     component: AdminDashboard,
    //     name: 'AdminDashboard',
    // },
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

        path: '/parent-dashboard/class-room',
        component: ClassRoom,
        name: 'VideoInfoComponent',
    },

]

export default new Router ({
    mode:'history',
    routes
})
