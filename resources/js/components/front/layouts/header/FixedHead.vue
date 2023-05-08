<template>
  <div>
    <!-- mobile buttons -->
    <div class="mobile-fixed-bar">
      <router-link to="/" class="home-mo mo center mobile-link">
        <figure>
          <img src="/images/home-icon.svg" />
        </figure>
        <p class="font-10 mobile-icon-color">الرئيسية</p>
      </router-link>
      <router-link to="/ask-specialists" class="mo center mobile-link">
        <figure>
          <img src="/images/consult-mob-icon.svg" width="24" height="21" />
        </figure>
        <p class="font-10 mobile-icon-color">الإستشارات</p>
      </router-link>
      <router-link to="/online-courses" class="mo center mobile-link">
        <figure>
          <img
            class="dark-icon"
            src="/images/mo-video-bottom.svg"
            width="24"
            height="21"
          />
        </figure>
        <p class="font-10 mobile-icon-color">الدورات</p>
      </router-link>
      <div class="profile-mo mo center mobile-link" @click="openProfileMenu">
        <figure>
          <img :src="userAvatar" />
        </figure>
        <p class="font-10 mobile-icon-color">حسابي</p>
      </div>
      <router-link  v-if="isLoggedIn" to="/notifications" class="mo center mobile-link">
        <figure>
          <img src="/images/notification.svg" />
        </figure>
        <p class="font-10 mobile-icon-color">الاشعارات</p>
      </router-link>
      <div class="profile-mo mo center mobile-link">
        <figure>
          <img src="/images/menu-icon-mobile.svg" @click="toggleMobileMenu" />
        </figure>
        <p class="font-10 mobile-icon-color">المزيد</p>
      </div>

    </div>
    <LeftSide
      :isMobileMenuOpened="isMobileMenuOpened"
      :isNotificationsMenuOpened="isNotificationsMenuOpened"
      @toggleNotificationMenu="toggleNotificationMenu"
      :toggleMobileMenu="toggleMobileMenu"
      @toggleMobileMenu="toggleMobileMenu"
      :isLoggedIn="isLoggedIn"
    ></LeftSide>
  </div>
</template>

<script>
import LeftSide from "./LeftSide.vue";

export default {
  components: {
    LeftSide,
  },
  data() {
    return {
      isMobileMenuOpened: false,
      isNotificationsMenuOpened: false,
    };
  },
  computed: {
    isLoggedIn() {
      return this.$store.getters["user/isLoggedIn"];
    },
    userAvatar() {
      let avatar = this.$store.getters["user/userData"].avatar;
      if (avatar == "default.jpg" || !this.isLoggedIn)
        avatar = "/images/profile-avatar-mo.svg";
      return avatar;
    },
  },
  methods: {
    toggleMobileMenu() {
      this.isMobileMenuOpened = !this.isMobileMenuOpened;
    },
    toggleNotificationMenu() {
        console.log('two');
      this.isNotificationsMenuOpened = !this.isNotificationsMenuOpened;
    },
    openProfileMenu() {
      if (this.isLoggedIn) {
        document.querySelector(".user-side-nav").classList.add("active");
      } else {
        this.$router.push("/signin");
      }
    },
    // openNotificationsMenu() {
    //   if (this.isLoggedIn) {
    //     document.querySelector(".user-side-nav").classList.add("active");
    //   } else {
    //     this.$router.push("/signin");
    //   }
    // },
  },
};
</script>

<style scoped>
a {
  position: relative;
}
.mobile-icon-color {
  color: #6e6d6d;
}
.courses-mo,
.dark-icon {
  filter: brightness(0.4);
}
@media (max-width: 767px) {
  .mobile-link p {
    margin-top: -7px;
    font-weight: bold;
  }
  .mobile-fixed-bar {
    position: fixed;
    bottom: 0;
    top: auto;
    padding-left: 12px;
    padding-right: 12px;
    background: #f4f4f4;
    box-shadow: 2px -1px 8px 0px rgb(0 0 0 / 30%);
    right: 0;
    height: 48px;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 10;
  }

  .mobile-link img {
    height: 21px;
    margin-bottom: 3px;
  }
  .profile-mo img {
    width: 21px;
    mix-blend-mode: multiply;
  }
}
</style>
