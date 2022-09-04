<template>
  <aside class="user-side-nav bg-white z-1">
    <img
      src="/images/close-icon.svg"
      width="30"
      height="30"
      @click="closeNavMenu"
      class="close-nav-menu mo"
    />
    <ul class="user-side-nav-list">
      <li class="mo">
        <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/"
          >الصفحة الرئيسية</router-link
        >
      </li>
      <li>
        <router-link
          class="d-block p-side-15 pt-10 pb-10 trans"
          to="/profile/my-account"
          @click.native="closeNavMenu"
          >إعدادات الحساب</router-link
        >
      </li>
      <!-- <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/" @click.native="closeNavMenu"
                    >حساب الطفل</router-link
                >
            </li>
            <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/" @click.native="closeNavMenu"
                    >الإستشارات</router-link
                >
            </li> -->
      <li>
        <router-link
          class="d-block p-side-15 pt-10 pb-10 trans"
          to="/profile/my-courses"
          @click.native="closeNavMenu"
          >دوراتي المشترك بها</router-link
        >
      </li>
      <li>
        <router-link
          class="d-block p-side-15 pt-10 pb-10 trans"
          to="/profile/my-favourite-courses"
          @click.native="closeNavMenu"
          >الدورات المفضلة</router-link
        >
      </li>
      <template v-if="isSpecialist">
        <li v-if="canMakeCalls">

          <span
            class="d-block p-side-15 pt-10 pb-10 trans pointer submenu-target"
            @click="collapseMenu('calls')"
            >المكالمات</span
          >
          <transition name="slide">
            <aside class="submenu trans" v-if="isCallSubMenuOpened">
              <li>
                <router-link
                  class="d-block p-side-15 pt-10 pb-10 trans"
                  to="/profile/my-sessions-times"
                  @click.native="closeNavMenu"
                  >تحديد أوقات الجلسات</router-link
                >
              </li>
              <li>
                <router-link
                  class="d-block p-side-15 pt-10 pb-10 trans"
                  to="/profile/my-call-log"
                  @click.native="closeNavMenu"
                  >سجل المكالمات</router-link
                >
              </li>
            </aside>
          </transition>
        </li>

      </template>
      <!-- if user not specialist (parents,others) -->
      <li v-else>
        <router-link
          class="d-block p-side-15 pt-10 pb-10 trans"
          to="/profile/my-call-log"
          @click.native="closeNavMenu"
          >سجل المكالمات</router-link
        >
      </li>
      <li>
        <router-link
          class="d-block p-side-15 pt-10 pb-10 trans"
          to="/profile/my-favourite-contents"
          @click.native="closeNavMenu"
          >المقالات المفضلة</router-link
        >
      </li>
      <li class="mo">
        <button
          @click="logout"
          class="
            d-block
            p-side-15
            pt-10
            pb-10
            trans
            bg-none
            w-100
            border-0
            logout-btn
          "
        >
          تسجيل خروج
        </button>
      </li>
    </ul>
  </aside>
</template>

<script>
export default {
  data() {
    return {
      isMenuOpened: false,
      isCallSubMenuOpened: false,
    };
  },
  computed: {
    userType() {
      return this.$store.getters["user/type"];
    },
    isSpecialist() {
      return this.userType == "specialist";
    },
    canMakeCalls(){
      return this.$store.getters['user/userData'].canMakeCalls
    }
  },
  methods: {
    closeNavMenu() {
      document.querySelector(".user-side-nav").classList.remove("active");
    },
    logout() {
      this.$store.dispatch("user/logout");
      if (this.$router.currentRoute.path == "/") {
        this.$store.commit("forceRefresh");
      } else {
        this.$router.push("/");
      }
    },
    collapseMenu(menuName) {
      if (menuName == "calls") {
        this.isCallSubMenuOpened = !this.isCallSubMenuOpened;
      }
    },
  },
};
</script>

<style scoped>
.user-side-nav {
  min-width: 230px;
  max-width: 230px;
  color: #686a76;
  box-shadow: -1px 1px 1px rgb(0 0 0 / 10%);
  min-height: calc(100vh - 65px);
}
.user-side-nav-list {
  padding-top: 57px;
}
.user-side-nav li > * {
  border-right: 4px solid transparent;
  color: #212529;
}
.user-side-nav li a.router-link-exact-active,
.user-side-nav li:hover > a,
.user-side-nav li:hover > span {
  background: #660066;
  color: #fff;
  border-color: #b915b9;
}
.submenu li:hover a {
  background: transparent;
  color: #212529;
  border-color: transparent;
}
.submenu {
  transform-origin: top;
  border: 0 !important;
}
.submenu li a:before {
  content: "";
  width: 7px;
  height: 7px;
  background: #000;
  margin-left: 10px;
  border-radius: 50%;
  display: inline-block;
}
.slide-enter,
.slide-leave-to {
  transform: scaleY(0);
}
.user-side-nav .submenu a.router-link-exact-active:before {
  background: #fff;
}
.user-side-nav .submenu li:hover a.router-link-exact-active:before {
  background: #000;
}
@media (max-width: 767px) {
  .user-side-nav {
    position: fixed;
    min-width: 85%;
    max-width: none;
    top: 0;
    left: 0;
    transition: 0.3s;
    opacity: 0;
    left: -90%;
    visibility: hidden;
    min-height: 100%;
    max-height: 100%;
    overflow-y: auto;
    z-index: 11;
  }
  .user-side-nav.active {
    opacity: 1;
    left: 0%;
    visibility: visible;
  }
  .close-nav-menu {
    position: absolute;
    top: 20px;
    right: 20px;
  }
  .logout-btn {
    text-align: right;
    color: #3fc4e0 !important;
    background: transparent !important;
  }
  .user-side-nav:before {
    content: "";
    position: fixed;
    right: 0;
    top: 0;
    width: 15%;
    height: 100%;
    z-index: 0;
    backdrop-filter: brightness(0.9) blur(2px);
    -webkit-backdrop-filter: brightness(0.9) blur(2px);
  }
}
</style>
