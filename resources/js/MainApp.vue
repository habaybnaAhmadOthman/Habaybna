<template>
    <main>
        <transition name="fade">
            <router-view></router-view>
        </transition>
        
        <LoginModal v-if="!isLoggedIn"></LoginModal>
        
    </main>
</template>

<script>
import Vue from 'vue';

import AlertDialog from "./components/front/layouts/AlertDialog.vue";
import LoginModal from "./components/front/layouts/LoginModal.vue";
import LoadingSpinner from "./components/front/layouts/LoadingSpinner.vue";
Vue.component('loading-spinner',LoadingSpinner)
Vue.component('alert-dialog',AlertDialog)
export default {
  components: {LoginModal},
  computed: {
      isLoggedIn() {
          return this.$store.getters["user/isLoggedIn"];
      }
  },
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