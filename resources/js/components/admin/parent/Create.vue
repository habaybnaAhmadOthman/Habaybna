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
</style>
<template>
  <div class="flexxx">
    <div class="question-form-title">
      <div class="right-side">
        <h3>ادارة الاهالي - انشاء حساب</h3>
      </div>
      <div class="left-side">
        <Button type="info" to="/admin/parents">رجوع</Button>
      </div>
    </div>

    <Form
      ref="form"
      :model="form"
      :rules="ruleValidate"
      :label-width="80"
      class="flexxx"
    >
      <div class="question-form">
        <FormItem prop="firstName"
          >الاسم الاول
          <Input v-model="form.firstName" />
        </FormItem>
      </div>
      <div class="question-form">
        <FormItem prop="lastName"
          >اسم العائلة
          <Input v-model="form.lastName" />
        </FormItem>
      </div>
      <div class="question-form">
        <FormItem prop="phone"
          >رقم الهاتف
          <!-- <Input
            type="text"
            v-model="form.phone"
            number
            placeholder="962xxxxxxxxx"
          ></Input> -->
          <div class="form-group ltr mb-30">
            <VuePhoneNumberInput
              :translations="{
                countrySelectorLabel: 'رمز الدولة',
                phoneNumberLabel: 'رقم الهاتف',
              }"
              id="phoneNumber"
              :default-country-code="'JO'"
              v-on:update="countryChanged"
              bind="bindProps"
              v-model="phone"
            />
          </div>
          <!-- :default-country-code="countryCode" -->
        </FormItem>
      </div>
      <div class="question-form">
        <FormItem prop="relative">
          صلة القرابة
          <Select v-model="form.relative" placeholder="اختر صلة القرابة">
            <Option value="parent">أب / أم</Option>
            <Option value="brother">أخ / آخت</Option>
            <Option value="relative">أقرباء</Option>
          </Select>
        </FormItem>
      </div>
      <div class="question-form">
        <FormItem prop="gender">
          الجنس
          <Select v-model="form.gender" placeholder="اختر الجنس">
            <Option value="m">ذكر</Option>
            <Option value="f">انثى</Option>
          </Select>
        </FormItem>
      </div>
      <div class="question-form">
        <FormItem prop="mail">
          الايميل
          <Input v-model="form.mail" placeholder="البريد الالكتروني"></Input>
        </FormItem>
      </div>
      <div class="one-item-in-row">
        <div class="one-item-right">
          <FormItem prop="password">
            كلمة المرور
            <div class="password">
              <Input :type="toggolePassword.type" v-model="form.password">
              </Input>
              <Icon
                v-if="toggolePassword.type == 'text'"
                type="md-eye"
                v-on:click="setToggolePassword('password')"
              />
              <Icon
                v-if="toggolePassword.type == 'password'"
                type="md-eye-off"
                v-on:click="setToggolePassword('text')"
              />
            </div>
          </FormItem>
        </div>
      </div>
      <div class="parent-submit">
        <Button type="primary" @click="submitForm('form')">حفظ</Button>
      </div>
    </Form>
  </div>
</template>
<script>
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";

export default {
  updated() {
  },
  data() {
    const validatePassword = (role, value, callback) => {
      this.passwordCheck.has_minimum_lenth = this.form.password.length > 7;
      this.passwordCheck.has_number = /\d/.test(this.form.password);
      this.passwordCheck.has_lowercase = /[a-z]/.test(this.form.password);
      this.passwordCheck.has_uppercase = /[A-Z]/.test(this.form.password);
      this.passwordCheck.has_special = /[!@#\$%\^\&*\)\(+=._-]/.test(
        this.form.password
      );
      for (const key in this.passwordCheck) {
        if (Object.hasOwnProperty.call(this.passwordCheck, key)) {
          if (key == "has_minimum_lenth" && !this.passwordCheck[key]) {
            this.form.isValid = false;

            callback(new Error("يجب ان لا تقل كلمة السر عن 8 خانات"));
          } else if (key == "has_number" && !this.passwordCheck[key]) {
            this.form.isValid = false;

            callback(new Error("يجب ان تحتوي على ارقم "));
          } else if (key == "has_lowercase" && !this.passwordCheck[key]) {
            this.form.isValid = false;

            callback(new Error("يجب ان تحتوي على احرف صغيرة"));
          } else if (key == "has_uppercase" && !this.passwordCheck[key]) {
            this.form.isValid = false;

            callback(new Error("يجب ان تحتوي عىل احرف كبيرة"));
          } else if (key == "has_special" && !this.passwordCheck[key]) {
            this.form.isValid = false;

            callback(new Error("يجب ان تحتوي على رموز خاصة"));
          } else {
            this.form.isValid = true;
            callback();
          }
        }
      }
    };
    return {
              bindProps: {
        mode: "international",
        required: false,
        enabledCountryCode: true,
        enabledFlags: true,
        autocomplete: "off",
        name: "telephone",
        maxLen: 25,
        inputOptions: {
          showDialCode: true
        }
      },
        country:null,
      countryCode: "JO",
      phone:'',
      form: {
        firstName: "",
        lastName: "",
        phone: "",
        relative: "",
        gender: "",
        password: "",
        isValid: true,
        mail: "",
      },
      passwordCheck: {
        has_minimum_lenth: false,
        has_number: false,
        has_lowercase: false,
        has_uppercase: false,
        has_special: false,
      },

      ruleValidate: {
        firstName: [
          {
            required: true,
            message: "يرجى تعبئة الحقل",
            trigger: "blur",
          },
        ],
        lastName: [
          {
            required: true,
            message: "يرجى تعبئة الحقل",
            trigger: "blur",
          },
        ],
        relative: [
          {
            required: true,
            message: "يرجى تعبئة الحقل",
            trigger: "blur",
          },
        ],

        password: [{ validator: validatePassword, trigger: "blur" }],
        phone: [
          {
            required: true,
            message: "يرجى تعبئة الحقل",
            trigger: "blur",
          },
        ],
        gender: [
          {
            required: true,
            message: "يرجى تعبئة الحقل",
            trigger: "blur",
          },
        ],
        mail: [
          {
            required: true,
            message: "Mailbox cannot be empty",
            trigger: "blur",
          },
          { type: "email", message: "Incorrect email format", trigger: "blur" },
        ],
      },
      toggolePassword: {
        type: "password",
        btnText: "show",
      },
    };
  },
  methods: {
      countryChanged(country){
          if(country.isValid){
              this.form.phone =country.formattedNumber
          }
      },
    setToggolePassword(type) {
      this.toggolePassword.type = type;
    },
    submitForm(name) {
      this.$refs[name].validate((valid) => {
        if (valid) {
          const Obj = {
            firstName: this.form.firstName,
            lastName: this.form.lastName,
            relative: this.form.relative,
            phone: this.form.phone,
            gender: this.form.gender,
            email: this.form.mail,
            password: this.form.password,
          };
          const resp = this.$store.dispatch("admin/createParent", Obj);

          this.$Message.success("تم انشاء حساب أهل");
          this.$router.push("/admin/parents");
        } else {
          this.$Message.error("تحقق من الحقول المدخلة");
        }
      });
    },
  },
  components: { VuePhoneNumberInput },
};
</script>
