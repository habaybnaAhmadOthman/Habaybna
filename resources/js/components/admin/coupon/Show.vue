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
}
.form-date label {
  display: block;
}
.users-list {
  width: 100%;
  text-align: right;
  padding: 0 15px;
}
.users-list label {
  height: 12px !important;
}
</style>
<template>
  <div class="flexxx">
    <div class="question-form-title">
      <div class="right-side">
        <h3>الكوبونات - انشاء كوبون</h3>
      </div>
      <div class="left-side">
        <Button type="info" to="/admin/coupons">رجوع</Button>
      </div>
    </div>
    <form ref="form" :model="form" id="coupon-form" class="flexxx">
      <div class="question-form">
        <label for="">كود الكوبون : </label>
        <Input
          v-model="form.code"
          placeholder="اكتب رمز الكوبون من 10 احرف وارقام"
        />
        <span class="error" v-if="!this.formValidation.code">
          يجب ان يحتوي الكود على 4-25 احرف او ارقام
        </span>
        <span class="error" v-if="usedCode"> هذا الرمز مستخدم </span>
      </div>
      <div class="question-form">
        <label for="">الاستخدام : </label>
        <Select
          v-model="form.usage"
          :label-in-value="true"
          placeholder=" هذا الكوبون مخصص ل :  "
        >
          <Option value="Call"> كوبون مكالمات</Option>
          <Option value="Users"> كوبون مخصص لمستخدمين</Option>
          <Option value="Course"> كوبون دورة تدريبية</Option>
        </Select>
        <span class="error" v-if="!this.formValidation.usage">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="question-form">
        <label for="">نوع الكوبون : </label>
        <Select v-model="form.type" placeholder="هل هو كوبون خصم ام مجاني">
          <Option value="discount"> خصم</Option>
          <Option value="free"> مجاني</Option>
        </Select>
        <span class="error" v-if="!this.formValidation.type">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="question-form">
        <label for="">الحد الاقصى للاستخدام : </label>
        <Input
          type="number"
          v-model="form.max_usage"
          placeholder="الحد الاقصى لاستخدام الكوبون"
        />
        <span class="error" v-if="!this.formValidation.max_usage">
 الحد الادنى للاستخدام (1)
 </span>
      </div>
      <div class="question-form">
        <label for=""> نسبة الخصم ( % ) : </label>
        <Input
          type="number"
          v-model="form.discount_perc"
          placeholder="100 يعني مجاني"
          :disabled="form.type == 'free' ? true : false"
        />
        <span class="error" v-if="!this.formValidation.discount_perc">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="question-form coupon">
        <label for=""> حالة الكوبون : </label>
        <RadioGroup v-model="form.status">
          <Radio label="1">
            <span>فعّال</span>
          </Radio>
          <Radio label="0">
            <span>غير فعّال</span>
          </Radio>
        </RadioGroup>
        <span class="error" v-if="!this.formValidation.status">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="form-date">
        <label for=""> تاريخ البدء : </label>
        <DatePicker
          v-model="form.coupone_durations.start_date"
          type="date"
          placeholder="حدد تاريخ بدء الصلاحية"
          style="width: 100%"
        ></DatePicker>
        <!-- <span
          class="error"
          v-if="!this.formValidation.coupone_duration.start_date"
        >
          * يجب تعبئة هذا الحقل
        </span> -->
      </div>
      <div class="form-date">
        <label for=""> تاريخ الانتهاء : </label>

        <DatePicker
          v-model="form.coupone_durations.end_date"
          type="date"
          placeholder="حدد تاريخ انتهاء الصلاحية"
          style="width: 100%"
        ></DatePicker>
        <!-- <span
          class="error"
          v-if="!this.formValidation.coupone_duration.end_date"
        >
          * يجب تعبئة هذا الحقل
        </span> -->
      </div>
      <!-- <div class="form-date">
        <label for="">
          تاريخ التفعيل: {{ form.coupone_durations.start_date }}
        </label>
        <label for="">
          تاريخ الانتهاء: {{ form.coupone_durations.end_date }}
        </label>
        <DatePicker
          v-model="form.coupone_duration"
          type="daterange"
          placeholder="حدد تاريخ انتهاء الصلاحية"
          style="width: 100%"
        ></DatePicker>
        <span class="error" v-if="!this.formValidation.coupone_duration">
          * يجب تعبئة هذا الحقل
        </span>
      </div> -->
      <div class="parent-submit">
        <Button type="primary" @click="submitForm('form')">حفظ</Button>
      </div>
    </form>
    <Modal v-model="modal1"  @on-ok="ok">
      <div class="users-list">
        <label for="">المستخدمين : </label>
        <Select
          multiple
          v-model="coupon_users.user_id"
          :label-in-value="true"
          placeholder=" هذا الكوبون مخصص ل :  "
        >
          <Option
            v-for="(user, index) in users"
            :key="index"
            :value="user.user_id"
          >
            {{ user.user_name }}
          </Option>
        </Select>
        <span class="error" v-if="!this.formValidation.usage">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
    </Modal>
  </div>
</template>
<script>
export default {
  created() {
    this.callApi("get", "/api/admin/coupons/" + this.$route.params.data).then(
      (res) => {
        if (res.status == 200) {
          this.form.coupon_id = res.data.id;
          this.form.code = res.data.code;
          this.form.usage = res.data.usage;
          this.form.type = res.data.type;
          this.form.max_usage = res.data.max_usage;
          this.form.discount_perc = res.data.discount_percentage;
          this.form.coupone_durations.start_date = res.data.start_date;
          this.form.coupone_durations.end_date = res.data.end_date;
          this.form.status = res.data.status;
        }
        console.log(this.form.coupone_durations);
      }
    );
  },
  updated() {},
  data() {
    return {
      modal1: false,
      user_mood: false,
      usersCoupon: false,
      usedCode: false,
      coupon_users: {
        user_id: [],
        coupon_id: "",
      },

      users: [],
      form: {
        coupon_id: "",
        code: "",
        usage: "",
        type: "",
        max_usage: "",
        discount_perc: "",
        coupone_durations: {
          start_date: "",
          end_date: "",
        },
        coupone_duration: "",
        status: "",
      },
      formValidation: {
        code: true,
        usage: true,
        type: true,
        max_usage: true,
        discount_perc: true,
        // coupone_duration:{
        //     start_date:true,
        //     end_date:true,
        // },
        status: true,
      },
      couponIsValid: true,
    };
  },
  methods: {
    ok() {
      this.$store
        .dispatch("admin/assignCouponToUsers", this.coupon_users)
        .then((res) => {
          this.$Message.success("تم انشاء كوبون خصم ");
          this.modal1 = false;
          this.$router.push("/admin/coupons");
        });
    },
    submitForm(name) {
        console.log(this.form.coupone_durations);
      this.validateForm();
      if (this.couponIsValid) {
        const Obj = this.form;
        this.$store.dispatch("admin/editCoupon", Obj).then((res) => {
          if (res.original == 409) {
            this.usedCode = true;
            this.$Message.error("هذا الرمز مستخدم");
          } else {
            if (this.form.usage == "Users") {
              this.coupon_users.coupon_id = res.id;
              const resp = this.$store
                .dispatch("admin/getAllUsers")
                .then((res) => {
                  this.users = res.data;
                  this.modal1 = true;
                });
            } else {
              this.$Message.success("تم تعديل كوبون خصم ");
            }
          }
        });

        // this.$router.push("/admin/coupons");
      }
    },
    validateForm() {
      if (!/^[a-zA-Z0-9]/.test(this.form.code) || this.form.code.length < 4 || this.form.code.length > 25) {
        this.formValidation.code = false;
      } else {
        this.formValidation.code = true;
      }
      if (!this.form.usage) {
        this.formValidation.usage = false;
      } else {
        this.formValidation.usage = true;
      }
      if (!this.form.type) {
        this.formValidation.type = false;
      } else {
        this.formValidation.type = true;
      }
      if (!this.form.max_usage || this.form.max_usage <= 0) {
        this.formValidation.max_usage = false;
      } else {
        this.formValidation.max_usage = true;
      }
      if (!this.form.discount_perc && this.form.type !== "free") {
        this.formValidation.discount_perc = false;
      } else {
        this.formValidation.discount_perc = true;
      }
      //   if (!this.form.coupone_duration) {
      //     this.formValidation.coupone_duration = false;
      //   } else {
      //     this.formValidation.coupone_duration = true;
      //   }
      if (!this.form.status) {
        this.formValidation.status = false;
      } else {
        this.formValidation.status = true;
      }

      for (const prob in this.formValidation) {
        if (Object.hasOwnProperty.call(this.formValidation, prob)) {
          const element = this.formValidation[prob];
          console.log(prob, element);
          if (!element) {
            console.log("false", prob);
            this.couponIsValid = false;
            break;
          }
          this.couponIsValid = true;
        }
      }
    },
  },
};
</script>
