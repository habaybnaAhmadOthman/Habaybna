<template>
    <main>
        <transition name="fade">
            <router-view :key="forceRefresh"></router-view>
        </transition>
        
        <LoginModal v-if="!isLoggedIn"></LoginModal>
        <alert-dialog
          :show="!!alertDialogMsg"
          :title="alertDialogMsg"
          @close="closeAlertDialogMsg"
        >
        </alert-dialog>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
    </main>
</template>

<script>
import Vue from 'vue';

import AlertDialog from "./components/front/layouts/AlertDialog.vue";
import LoginModal from "./components/front/layouts/LoginModal.vue";
import InfoModal from "./components/front/layouts/InfoModal.vue";
import LoadingSpinner from "./components/front/layouts/LoadingSpinner.vue";
Vue.component('loading-spinner',LoadingSpinner)
Vue.component('alert-dialog',AlertDialog)
Vue.component('info-modal',InfoModal)
export default {
  components: {LoginModal},
  computed: {
      isLoggedIn() {
          return this.$store.getters["user/isLoggedIn"];
      },
      isLoading() {
          return this.$store.getters["isLoading"];
      },
      forceRefresh(){
        const key =  this.$store.getters["forceRefresh"]
        return key
      },
      alertDialogMsg(){
        return this.$store.getters["alertDialogMsg"]
      }
  },
  methods: {
    closeAlertDialogMsg(){
      this.$store.commit('alertDialogMsg',null)
    }
  }
}
</script>
<style>
@import url('./../../public/css/common.css');
@import url('./../../public/css/userprofile.css');
</style>
<style scope>
.slide-left-enter-active,
.slide-left-leave-active,
.slide-right-enter-active,
.slide-right-leave-active {
  transition-duration: 0.5s;
  transition-property: height, opacity, transform;
  transition-timing-function: cubic-bezier(0.55, 0, 0.1, 1);
  overflow: hidden;
}

.slide-left-enter,
.slide-right-leave-active {
  opacity: 0;
  transform: translate(2em, 0);
}

.slide-left-leave-active,
.slide-right-enter {
  opacity: 0;
  transform: translate(-2em, 0);
}
</style>