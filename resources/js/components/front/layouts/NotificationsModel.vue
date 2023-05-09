<template>
  <div
    v-if="isNotificationsMenuOpened && isLoggedIn"
    class="notifications-menu"
  >
    <h4>الاشعارات</h4>
    <ul>
      <li
        v-for="(one, index) in notifications.notifications.slice(0, 5)"
        :key="index"
        @click="setAsRead(index, one)"
      >

          {{ one.data.content_ar }}

      </li>
      <li class="center p-10">
        <router-link class="main-color " to="notifications">
          مشاهدة جميع الاشعارات
        </router-link>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  mounted() {
    // console.log(this.toggleNotificationMenu);
  },
  props: ["isNotificationsMenuOpened", "isLoggedIn", "notifications"],
  methods: {
    setAsRead(i, one) {
      this.callApi("post", "/api/user-notifications/read", one).then((resp) => {
        // this.$store.commit("user/setUser",
        //   {
        //       notifications : resp.data,

        //   }
        // );
        this.$store.dispatch('user/setNotifications')
        this.$router.replace("habaybna-community");
      });
    },
  },
//   mounted() {
//     Echo.channel("usernewpost").listen("NewPost", (post) => {

//       // if (!('Notification' in window)) {
//       //     alert('Web Notification is not supported');
//       //     return;
//       // } else {
//       //     // const beamsClient = new PusherPushNotifications.Client({
//       //     //     instanceId: 'ec559eac-30e5-473c-8414-adabb00c204e',
//       //     // });
//       //     // console.log('beamsClient');
//       //     // console.log('beamsClient.start()', beamsClient.start());
//       //     // beamsClient.start()
//       //     //     .then(() => beamsClient.addDeviceInterest('hello'))
//       //     //     .then(() => console.log('Successfully registered and subscribed!'))
//       //     //     .catch(console.error);
//       // }
//       // Notification.requestPermission((permission) => {
//       //     new Notification("منشور جديد", {
//       //         body: "لقد قام احد المستخدمين باضافة منشور !", // content for the alert
//       //         //   icon:this.getAvatar, // optional image url
//       //     });
//       // });
//     });
//   },
  computed: {
      

  },
};
</script>
<style scoped >
.notifications-menu {
  position: absolute;
  border-radius: 7px;
  font-size: medium;
  margin-top: 12px;
  max-height: 367px;
  overflow: hidden;
}
.notifications-menu ul {
  min-width: 300px;
}
.notifications-menu ul li {
  border-bottom: 2px solid #a99eab45;
  list-style: none;
  /* margin-bottom: 10px; */
  padding: 2px 8px;
  padding-top: 13px;
  line-height: 1.2;
  opacity: 0.93;
  background-color: #ffffff;
}
.notifications-menu ul li:hover {
  background-color: #ed8e00;
  color: #ffff;
  opacity: 1;
}
.notifications-menu h4 {
  padding-top: 3px;
  width: 20%;
  line-height: 1;
  color: #780d93;
  border-bottom: 4px solid #ed8e00;
}

.all-notifications {
  border: none !important;
  padding-bottom: 13px !important;
  text-align: center;

  /* font-weight: bolder; */
}
</style>
