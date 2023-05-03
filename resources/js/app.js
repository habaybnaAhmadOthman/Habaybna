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
// import Push from '../../node_modules/push.js/';



import UploadVideos from './components/UploadVideos.vue'
import router from './router';
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import common from './common';
import VueCoreVideoPlayer from 'vue-core-video-player'
import VueCarousel from 'vue-carousel';
import locale from 'view-design/dist/locale/en-US';
import Vue from 'vue';
import store from './store/index.js';
import './modules/auth.js';
// portal
import MainApp from './MainApp.vue'

// import  portal plugins
import VueSocialSharing from 'vue-social-sharing'
import VueMeta from 'vue-meta'



// var channel = window.Echo.channel('test');
// if ('serviceWorker' in navigator) {
//     console.log('xxxxxxxxxxxzzzz',navigator.serviceWorker);
//    window.addEventListener('load', function() {

//        navigator.serviceWorker.register('./service-worker.js').then(function(registration) {
//        // Registration was successful
//        console.log('ServiceWorker registration successful with scope: ', registration);
//    }, function(err) {
//        // registration failed :(
//            console.log('ServiceWorker registration failed: ', err);
//        });
//    });
// }


// Echo.channel('test')
//     .listen('TestEvent', post => {
//         if (!('Notification' in window)) {
//             alert('Web Notification is not supported');
//             return;
//         } else {
//             // const beamsClient = new PusherPushNotifications.Client({
//             //     instanceId: 'ec559eac-30e5-473c-8414-adabb00c204e',
//             // });
//             // console.log('beamsClient');
//             // console.log('beamsClient.start()', beamsClient.start());
//             // beamsClient.start()
//             //     .then(() => beamsClient.addDeviceInterest('hello'))
//             //     .then(() => console.log('Successfully registered and subscribed!'))
//             //     .catch(console.error);
//         }
//         Notification.requestPermission(permission => {
//             new Notification('New post alert!', {

//                 body: 'post.title', // content for the alert
//                 //   icon: "https://pusher.com/static_logos/320x320.png" // optional image url
//             });


//         });
//     })
// Echo.channel('usernewpost')
//     .listen('NewPost', post => {
//         console.log('post', post);
//         if (!('Notification' in window)) {
//             alert('Web Notification is not supported');
//             return;
//         } else {
//             // const beamsClient = new PusherPushNotifications.Client({
//             //     instanceId: 'ec559eac-30e5-473c-8414-adabb00c204e',
//             // });
//             // console.log('beamsClient');
//             // console.log('beamsClient.start()', beamsClient.start());
//             // beamsClient.start()
//             //     .then(() => beamsClient.addDeviceInterest('hello'))
//             //     .then(() => console.log('Successfully registered and subscribed!'))
//             //     .catch(console.error);
//         }
//         Notification.requestPermission((permission) => {
//             new Notification("منشور جديد", {
//                 body: "لقد قام احد المستخدمين باضافة منشور !", // content for the alert
//                 //   icon:this.getAvatar, // optional image url
//             });
//         });
//     })
// importScripts("https://js.pusher.com/beams/service-worker.js");



// use portal plugins
Vue.use(VueMeta)
Vue.use(VueSocialSharing);



Vue.use(VueCarousel);
Vue.use(ViewUI, {
    locale
});
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
Vue.component('player', Player);
Vue.component('main-app', MainApp)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    // check if user logged in
    async beforeCreate() {
        await this.$store.getters['user/isLoggedin'];
    },

    store,
    router
});

//
