<template>
  <div class="d-flex align-center hide-do-profile">
    <!-- <div v-if="show" class="notification-modal relative">
          <div>
              منشور جديد
          </div>
      </div> -->
    <div class="notifications" @click="toggleNotificationMenu">
      <figure>
        <img src="/images/notification.svg" />
      </figure>
      <span
        v-if="notRead.length > 0"
        style="
          color: red;
          fontsize: x-smal;
          position: absolute;
          color: red;
          top: 40px;
          right: 13px;
        "
      >
        {{ notRead.length }}
      </span>

      <NotificationsModel
        :isLoggedIn="isLoggedIn"
        :isNotificationsMenuOpened="isNotificationsMenuOpened"
        :notifications="notifications"
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
  props: ["isLoggedIn", "isMobileMenuOpened", "isNotificationsMenuOpened"],
  components: { MobileMenu, NotificationsModel },
  data() {
    return {
      show: false,
    };
  },

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
    notifications() {
      return this.$store.getters["user/notifications"];
    },
    notRead() {
      return this.notifications.notifications.filter(
        (one) => one.read_at == null
      );
    },
  },
  mounted() {
    if (this.$store.getters["user/isLoggedIn"]) {
      Echo.channel("usernewcomment").listen("NewComment", (post) => {
          console.log(post);
        if (this.$store.getters["user/isLoggedIn"]) {
          if (
            this.$store.getters["user/userData"].id == post.usernewcomment ||
            this.$store.getters["user/userData"].canMakeComment
          ) {
            const beamsClient = new PusherPushNotifications.Client({
              instanceId: "ec559eac-30e5-473c-8414-adabb00c204e",
            });
            beamsClient
              .start()
              .then(() => beamsClient.addDeviceInterest(`usernewcomment.${post.usernewcomment}`))
              .then(() => beamsClient.getDeviceInterests())
              .catch(console.error);
            this.$store.dispatch("user/setNotifications");
            this.$store.dispatch("community/setPosts");
          }
        }
        if (!("Notification" in window)) {
          alert("Web Notification is not supported");
          return;
        } else {
        }
      });
      Echo.channel("usernewpost").listen("NewPost", (post) => {
        if (this.$store.getters["user/isLoggedIn"]) {
          const beamsClient = new PusherPushNotifications.Client({
            instanceId: "ec559eac-30e5-473c-8414-adabb00c204e",
          });

          beamsClient
            .start()
            .then(() => beamsClient.addDeviceInterest("newpost"))
            .then(() => beamsClient.getDeviceInterests())
            .catch(console.error);
          this.$store.dispatch("user/setNotifications");
          this.$store.dispatch("community/setPosts");
        }
      });

      /////// comment notifications
    }
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
.notification-modal > div {
  position: absolute;
  top: 8vw;
  right: -40vw;
  padding: 8px 20px;
  background: #7818a8;
  color: #fff;
  border-radius: 6px;
  width: 250px;
  text-align: center;
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
@media screen and (max-width: 766px) {
  .notifications {
    visibility: hidden;
    clear: both;
    float: left;
    margin: 10px auto 5px 20px;
    width: 28%;
    display: none;
  }
}
</style>
