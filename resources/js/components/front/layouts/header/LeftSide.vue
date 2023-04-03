<template>
  <div class="d-flex align-center hide-do-profile">
    <div class="notifications" @click="toggleNotificationMenu">
      <figure>
        <img src="/images/notification.svg" />
      </figure>

      <NotificationsModel
        :isLoggedIn="isLoggedIn"
        :isNotificationsMenuOpened="isNotificationsMenuOpened"

      />
    </div>
    <div class="bar do hh-all"></div>

    <div class="do hh-all" v-if="isLoggedIn">
      <router-link
        to="/profile/my-courses"
        class="d-flex align-center user-box"
      >
        <img
          :src="userAvatar"
          alt="gift"
          class="rounded object-fit ml-10 user-avatar"
        />
        <p class="black one-line">{{ userName }}</p>
      </router-link>
    </div>

    <template v-if="!isLoggedIn">
      <router-link
        to="/signup"
        class="signin-box-btn pr-30 relative bold black do nowrap hh-all"
        >مستخدم جديد</router-link
      >
      <router-link
        to="/signin"
        class="signin-box-btn pr-30 relative bold black do nowrap hh-all"
        >تسجيل الدخول</router-link
      >
    </template>
    <template v-else>
      <button
        @click="logout"
        class="sign-out-box bg-none border-0 pointer pr-30 relative bold black do nowrap hh-all"
      >
        تسجيل الخروج
      </button>
    </template>
    <!-- <img src="/images/menu-icon.svg" class="mo" @click="toggleMobileMenu"> -->
    <transition name="swing">
      <MobileMenu
        :isLoggedIn="isLoggedIn"
        @closeMobileMenu="toggleMobileMenu"
        @logout="logout"
        v-if="isMobileMenuOpened"
        :userAvatar="userAvatar"
      ></MobileMenu>
    </transition>
  </div>
</template>

<script>
import MobileMenu from "./MobileMenu.vue";
import NotificationsModel from "../NotificationsModel.vue";

export default {
  emits: ["toggleMobileMenu", "toggleNotificationMenu"],
  props: ["isLoggedIn", "isMobileMenuOpened",'isNotificationsMenuOpened'],
  components: { MobileMenu, NotificationsModel },

  methods: {
    async logout() {
      await this.$store.dispatch("user/logoutModal");
      if (this.$router.currentRoute.name != "home") {
        this.$router.push("/");
      }
      this.forceRefresh();
    },
    forceRefresh() {
      this.$store.commit("forceRefresh");
    },
    toggleMobileMenu() {
      this.$emit("toggleMobileMenu");
    },
    toggleNotificationMenu() {
        console.log('one');
      this.$emit("toggleNotificationMenu");
    },
  },
  computed: {
    userAvatar() {
      return this.$store.getters["user/userData"].avatar;
    },
    userName() {
      const user = this.$store.getters["user/userData"];
      return user.firstName + " " + user.lastName;
    },
  },
};
</script>

<style scoped>
.bar {
  width: 1px;
  border-left: 1px solid #e1e1e1;
  height: 35px;
  margin: 0 22px;
}
.sign-out-box:before {
  content: "";
  background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAARCAYAAADdRIy+AAAABHNCSVQICAgIfAhkiAAAALpJREFUOE/NlO0NAVEQRc/tQAd0QAeoAB2sDqgAHemAEuhACVQw8mQ2sRvvY5MN3t+5OXMzd+aJxDOzMzBNaVq1g74NrIBRgcOda9IOC0AviZnZb4FmNgMWkrafXHd26MATcAFWkm7v4AbQV6OeQWxsA2DixTuwlnSsxW1gDhZrMpcU9rQZijvMBRocjl30AKqowxzJHYRQwgyvwDI5ww7AANr0knKuaee16Q1oZuGWhzkgsC86vb/4vp6vInJf5SsvrwAAAABJRU5ErkJggg==)
    no-repeat;
  position: absolute;
  width: 20px;
  height: 17px;
  right: 0;
  top: 3px;
}
.notifications {
  min-width: 50px;
  height: 50px;
  position: relative;
}
.notifications:hover {
  cursor: pointer;
}

.free-call-btn {
  background: #606;
  padding: 10px 15px;
}
.user-avatar {
  width: 50px;
  height: 50px;
}
.swing-enter-active {
  animation: swing 0.3s ease-out;
}

.swing-leave-active {
  animation: swing 0.3s ease-in reverse;
}
.user-box {
  width: 200px;
}
.profile .hide-do-profile .hh-all {
  display: none !important;
}
@keyframes swing {
  from {
    left: -100%;
    opacity: 0;
  }

  to {
    left: 0;
    opacity: 1;
  }
}
@media (max-width: 1200px) {
  .free-call-btn {
    display: none;
  }
}
</style>
