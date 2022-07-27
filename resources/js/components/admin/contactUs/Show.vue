<style>
.ivu-layout {
  background-color: #515a6e !important;
}
.ivu-layout-content {
  width: 87%;
  padding: 14px;
  min-height: auto !important;
  margin: auto;
  border-radius: 5px;
  overflow: scroll;
}
#phoneNumber-57_country_selector,
#phoneNumber-57_phone_number {
  border-radius: 0 !important;
}
h1 {
  color: black;
}
.flexxx form {
  justify-content: center;
  margin: auto;
}
.one-item-in-row {
  text-align: right;
  width: 80%;
  justify-content: start !important;
  padding: 0 14px;
}
.one-item-right {
  width: 49%;
}
.parent-submit {
  display: flex;
  width: 80%;
  padding: 0 14px;
  padding-top: 3%;
}
.admin-form {
  width: 70%;
  margin: auto;
  direction: rtl;
  text-align: right;
  margin-top: 50px;
}
.admin-form * {
  width: 80%;
}
.ivu-icon-ios-arrow-down {
  text-align: right !important;
}
.password {
  position: relative;
}
.password i {
  position: absolute;
  width: auto !important;
  left: 12px;
  top: 6px;
  font-size: 20px;
  cursor: pointer;
}
.form-date {
  width: 40%;
  text-align: right;
  padding: 0 17px;
  margin-bottom: 20px;
}
.form-date label {
  display: block;
}

.coupon span {
  display: inline-block !important;
}
</style>
<template>
  <div class="flexxx">
    <div class="question-form-title">
      <div class="right-side">
        <h3>تواصل معنا</h3>
      </div>
      <div class="left-side">
        <Button type="info" to="/admin/contact-us">رجوع</Button>
      </div>
    </div>
    <form ref="form" :model="form" id="calls-form" class="flexxx">
      <div class="question-form">
        <label for="">الاسم : </label>
        <Input v-model="form.name" />
      </div>
      <div class="question-form">
        <label for="">الايميل : </label>
        <Input v-model="form.email" />
      </div>
      <div class="question-form">
        <label for="">الرسالة : </label>
        <textarea v-model="form.message" />
      </div>
    </form>
  </div>
</template>
<script>
export default {
  created() {
    this.callApi(
      "get",
      "/api/admin/contact-us/" + this.$route.params.data
    ).then((res) => {
      if (res.status == 200) {
        this.form.name = res.data.name;
        this.form.email = res.data.email;
        this.form.message = res.data.message;
      }
    });
  },
  updated() {},
  data() {
    return {
      form: {
        name: "",
        email: "",
        message: "",
      },
    };
  },
  methods: {

  },
};
</script>
