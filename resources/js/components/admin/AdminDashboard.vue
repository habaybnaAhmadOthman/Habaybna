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
                ادارة المستخدمين
                <Icon type="ios-people" size="24" :style="{ margin: '1px' }" />
              </template>
              <MenuItem name="2-1">
                <router-link to="/admin/parents"> الأهالي </router-link>
                <Icon type="ios-contacts" size="16" />
              </MenuItem>
              <MenuItem name="2-2">
                <router-link to="/admin/specialist"> الأخصائيين </router-link>
                <Icon type="md-contact" size="16" />
              </MenuItem>
              <MenuItem name="2-3">
                <router-link to="/admin/others"> الاخرون </router-link>
                <Icon type="ios-people" size="16" />
              </MenuItem>
              <MenuItem name="2-3">
                <router-link to="/admin/children"> الأطفال </router-link>
                <Icon type="ios-people" size="16" />
              </MenuItem>
            </Submenu>
            <MenuItem name="12">
              <router-link to="/admin/subscribers"> الاشتراكات </router-link>
              <Icon type="md-notifications-outline" size="24" />
            </MenuItem>
            <Submenu name="1">
              <template slot="title">
                الدورات التدريبية
                <Icon type="ios-videocam-outline" size="24" />
              </template>
              <MenuItem name="1-1">
                <Icon type="ios-videocam-outline" size="24" />
                <router-link to="/admin/courses">
                  جميع الدورات التدريبية
                </router-link>
              </MenuItem>
              <MenuItem name="1-2">
                <router-link to="/admin/courses/users-progress">
                  الدورات-حالة المستخدمين</router-link
                >
              </MenuItem>
            </Submenu>

            <MenuItem name="3">
              <router-link to="/admin/coupons"> الكوبونات </router-link>
              <Icon type="ios-code" size="24" />
            </MenuItem>
            <MenuItem name="3">
              <router-link to="/admin/categories"> التصنيفات </router-link>
              <Icon type="ios-code" size="24" />
            </MenuItem>
            <MenuItem name="3">
              <router-link to="/admin/comming-soon"> Comming soon </router-link>
              <Icon type="ios-code" size="24" />
            </MenuItem>
            <MenuItem name="4">
              <router-link to="/admin/calls"> المكالمات </router-link>
              <Icon type="ios-call-outline" size="24" />
            </MenuItem>
            <MenuItem name="4">
              <router-link to="/admin/calls-requests">
                طلبات المكالمات
              </router-link>
              <Icon type="ios-call-outline" size="24" />
            </MenuItem>
            <Submenu name="5">
              <template slot="title">
                طلبات الشراء
                <Icon
                  type="ios-paper-outline"
                  size="24"
                  :style="{ margin: '1px' }"
                />
              </template>
              <MenuItem name="5-1">
                <router-link to="/admin/orders/courses-orders">
                  دورات تدريبية
                </router-link>
                <Icon type="ios-videocam" size="16" />
              </MenuItem>
              <MenuItem name="5-2">
                <router-link to="/admin/orders/courses-orders">
                  مكالمات
                </router-link>
                <Icon type="ios-call" size="16" />
              </MenuItem>
            </Submenu>
            <MenuItem name="6">
              <router-link to="/admin/contents"> المحتوى </router-link>
              <Icon type="ios-call" size="16" />
            </MenuItem>
            <MenuItem name="7">
              <router-link to="/admin/content-new"> المحتوى جديد </router-link>
              <Icon type="ios-call" size="16" />
            </MenuItem>
            <MenuItem name="8">
              <router-link to="/admin/contact-us"> تواصل معنا </router-link>
              <Icon type="ios-call" size="16" />
            </MenuItem>
            <MenuItem name="9">
              <router-link to="/admin/media">التغطية الاعلامية </router-link>
              <Icon type="ios-call" size="16" />
            </MenuItem>
            <MenuItem name="11">
              <router-link to="/admin/partners">الشركاء </router-link>
              <Icon type="ios-call" size="16" />
            </MenuItem>
            <MenuItem name="10">
              <router-link to="/admin/testimonials">
                اراء المستخدمين
              </router-link>
              <Icon type="ios-at-outline" size="24" />
            </MenuItem>
            <MenuItem name="11">
              <router-link to="/admin/habaybna-community">
                مجتمع حبايبنا
              </router-link>
              <Icon type="ios-at-outline" size="24" />
            </MenuItem>
            <!-- <MenuItem name="10">
              <Icon type="ios-at-outline" size="24" />
              <router-link to="/admin/birthday"> gifts request </router-link>
            </MenuItem> -->
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












