<template>
  <div
    v-if="isNotificationsMenuOpened && isLoggedIn"
    class="notifications-menu"
  >
    <h4>الاشعارات</h4>
    <ul>
      <li>ل وقال خلال مشستيب قد قام احمج بالتعليق على صورة لك</li>
      <li>ل وقال خلال مشستيب قد قام احمج بالتعليق على صورة لك</li>
      <li>ل وقال خلال مشستيب قد قام احمج بالتعليق على صورة لك</li>
      <li>
        <router-link to="#"
          >ل وقال خلال مشستيب قد قام احمج بالتعليق على صورة لك</router-link
        >
      </li>
      <li class="all-notifications main-color">مشاهدة جميع الاشعارات</li>
    </ul>
  </div>
</template>
<script>
export default {
  mounted() {
    // console.log(this.toggleNotificationMenu);
  },
  props: ["isNotificationsMenuOpened", "isLoggedIn"],
  methods: {},
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
