<template>
    <main>
        <TheHeader></TheHeader>
        <router-view></router-view>
    </main>
</template>

<script>
import Vue from 'vue';
import TheHeader from './components/front/layouts/header/TheHeader.vue';
import AlertDialog from "./components/front/layouts/AlertDialog.vue";
import LoadingSpinner from "./components/front/layouts/LoadingSpinner.vue";
Vue.component('loading-spinner',LoadingSpinner)
Vue.component('alert-dialog',AlertDialog)
export default {
    components: {
        TheHeader}
}
</script>
<style>
@import url('./../../public/css/common.css');
</style>