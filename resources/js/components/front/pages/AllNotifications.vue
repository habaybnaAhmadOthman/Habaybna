<template>
  <div class="container-fluid">
    <TheHeader></TheHeader>
    <div class="row justify-center">
      <div class="col-md-6 mt-30 top-r-side xx">
        <div class="mb-30">
          <h2 v-if="notifications.length > 0">الاشعارات</h2>
          <h2 v-else class="center">لا يوجد اشعارات</h2>
        </div>

        <div
          :class="`border-bottom p-10 pointer${
            one.read_at != null ? ' seen' : ''
          }`"
          v-for="(one, index) in notifications"
          :key="index"
          @click="setAsRead(index, one)"
        >
          <!-- <router-link to="habaybna-community"> -->
          <p>{{ one.data.content_ar }}</p>
          <p class="gray font-13">{{ one.created_at }}</p>
          <!-- </router-link> -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TheHeader from "../layouts/header/TheHeader.vue";
export default {
  components: {
    TheHeader,
  },
  methods: {
    setAsRead(i, one) {
      this.callApi("post", "/api/user-notifications/read", one).then((resp) => {
        // this.$store.commit(
        //   "user/setUser",

        //   {
        //     notifications: resp.data,
        //   }
        // );
        this.$store.dispatch('user/setNotifications')
        if (this.$route.path !== "/habaybna-community") this.$router.push('/habaybna-community')
      });
    },
  },
  computed: {
    notifications() {
      //   console.log(this.$store.getters["user/userData"].notifications);
      return this.$store.getters["user/userData"].notifications;
    },
  },
};
</script>
<style scoped>
.seen {
  color: #515a6e;
  background-color: whitesmoke;
}

.xx > .border-bottom {
  border-top: 1px solid #8080806e;
}

.border-bottom:hover {
  opacity: 0.7;
}
</style>
