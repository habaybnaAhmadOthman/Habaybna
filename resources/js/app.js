/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');
import CKEditor from '../../node_modules/@ckeditor/ckeditor5-vue2';
import VideoInfoComponent from './components/VideoInfoComponent.vue';
import AdminDashboard from './components/admin/AdminDashboard.vue'
import ParentDashboard from './components/parents/ParentDashboard.vue'
import ClassRoom from './components/parents/ClassRoom.vue'
import Player from './components/Player.vue'

import UploadVideos from './components/UploadVideos.vue'
import router from './router';
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import common from './common';
import VueCoreVideoPlayer from 'vue-core-video-player'
import VueCarousel from 'vue-carousel';
import locale from 'view-design/dist/locale/en-US';



Vue.use(VueCarousel);
Vue.use(ViewUI,{ locale });

Vue.mixin(common)

Vue.use(CKEditor);
Vue.use(VueCoreVideoPlayer)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('video-info-component', VideoInfoComponent);
Vue.component('upload-video', require('./components/UploadVideos.vue').default);
Vue.component('admin-dashboard', require('./components/admin/AdminDashboard.vue').default);
Vue.component('parent-dashboard', require('./components/parents/ParentDashboard.vue').default);
Vue.component('class-room', require('./components/parents/ClassRoom.vue').default);
Vue.component('player',Player);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});

//
