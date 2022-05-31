<style scoped>
/* .layout {
  border: 1px solid #d7dde4;
  background: #f5f7f9;
  position: relative;
  border-radius: 4px;
  overflow: hidden;
  height:100vh;
  min-height:100vh !important;


} */
.ivu-layout-content {
  width: 95%;
  padding: 5px;
  min-height: 100vh !important;
  margin: 10px auto;
  /* border-radius: 5px; */
}
.layout-logo {
  width: 100px;
  height: 30px;
  background: #5b6270;
  border-radius: 3px;
  float: left;
  position: relative;
  top: 15px;
  left: 20px;
}
.layout-nav {
  width: 420px;
  margin: 0 auto;
  margin-right: 20px;
}
.ivu-layout-sider {
  text-align: right !important;
}
footer {
  background-color: #515a6e;
  clear: both;
  position: relative;
  min-height: 60px;
  margin-top: auto;
}
</style>
<template>
  <div class="layout">
    <Layout>
      <Header>
        <Menu mode="horizontal" theme="dark">
          <div class="layout-logo"></div>
          <div class="layout-nav">
            <MenuItem name="3">
              <Button @click="logoutUser()">Logout</Button>
            </MenuItem>
          </div>
        </Menu>
      </Header>
      <Layout>
        <Sider hide-trigger :style="{ background: '#fff' }">
          <Menu theme="light" width="auto" :open-names="[]">
            <Submenu name="2">
              <template slot="title">
                <Icon type="ios-people" size="24" :style="{ margin: '1px' }" />
                ادارة المستخدمين
              </template>
              <MenuItem name="2-1">
                <Icon type="ios-contacts" size="16" />
                <router-link to="/admin/parents"> الأهالي </router-link>
              </MenuItem>
              <MenuItem name="2-2">
                <Icon type="md-contact" size="16" />
                <router-link to="/admin/specialist"> الأخصائيين </router-link>
              </MenuItem>
              <MenuItem name="2-3">
                <Icon type="ios-people" size="16" />
                <router-link to="/admin/others"> الاخرون </router-link>
              </MenuItem>
            </Submenu>
            <Submenu name="1">
              <template slot="title">
                <Icon type="ios-videocam-outline" size="24" />
                الدورات التدريبية
              </template>
              <MenuItem name="1-1">
                <Icon type="ios-videocam-outline" size="24" />
                <router-link to="/admin/courses">
                  جميع الدورات التدريبية</router-link
                >
              </MenuItem>
              <MenuItem name="1-2">
                <Icon type="ios-videocam-outline" size="24" />
                <router-link to="/admin/courses/users-progress">
                  الدورات-حالة المستخدمين</router-link
                >
              </MenuItem>
            </Submenu>

            <MenuItem name="3">
              <Icon type="ios-code" size="24" />
              <router-link to="/admin/coupons"> الكوبونات </router-link>
            </MenuItem>
            <MenuItem name="4">
              <Icon type="ios-call-outline" size="24" />
              <router-link to="/admin/calls"> المكالمات </router-link>
            </MenuItem>
            <Submenu name="5">
              <template slot="title">
                <Icon
                  type="ios-paper-outline"
                  size="24"
                  :style="{ margin: '1px' }"
                />
                طلبات الشراء
              </template>
              <MenuItem name="5-1">
                <Icon type="ios-videocam" size="16" />
                <router-link to="/admin/orders/courses-orders">
                  دورات تدريبية
                </router-link>
              </MenuItem>
              <MenuItem name="5-2">
                <Icon type="ios-call" size="16" />
                <router-link to="/admin/orders/courses-orders">
                  مكالمات
                </router-link>
              </MenuItem>
            </Submenu>
            <MenuItem name="6">
              <Icon type="ios-call" size="16" />
              <router-link to="/admin/contents"> المحتوى </router-link>
            </MenuItem>
            <MenuItem name="7">
              <Icon type="ios-call" size="16" />
              <router-link to="/admin/contact-us"> تواصل معنا </router-link>
            </MenuItem>
            <MenuItem name="7">
              <Icon type="ios-call" size="16" />
              <router-link to="/admin/media">التغطية الاعلامية   </router-link>
            </MenuItem>
          </Menu>
        </Sider>
        <Layout :style="{ padding: '0 5px' }">
          <Content
            :style="{ padding: '5px', minHeight: '280px', background: '#fff' }"
          >
            <router-view></router-view>
          </Content>
        </Layout>
      </Layout>
      <footer>Footer</footer>
    </Layout>
  </div>
</template>
<script>
export default {
  created() {
    //         this.callApi(
    //   "get",
    //   "/api/admin/contact-us/all-messages"
    // ).then(res=>{
    // })
  },
  data() {
    return {};
  },
  methods: {
    logoutUser() {
      this.$store.dispatch("user/Adminlogout");
      location.href = "/";
    },
  },
};
</script>












