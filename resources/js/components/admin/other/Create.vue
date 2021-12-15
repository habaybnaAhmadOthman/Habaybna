<style>
h1 {
  color: black;
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
</style>
<template>
  <div class="profile">
    <h1>انشاء حساب اخرون</h1>
    <div class="admin-form">
      <Form ref="form" :model="form" :rules="ruleValidate" :label-width="80">
        <FormItem prop="firstName"
          >الاسم الاول
          <Input v-model="form.firstName" />
        </FormItem>
        <FormItem prop="lastName"
          >اسم العائلة
          <Input v-model="form.lastName" />
        </FormItem>
        <FormItem prop="phone"
          >رقم الهاتف
          <Input
            type="text"
            v-model="form.phone"
            number
            placeholder="962xxxxxxxxx"
          ></Input>
        </FormItem>
        <FormItem prop="employment">
          التخصص
          <Select v-model="form.employment">
            <Option value="no" disabled hidden>مجال العمل</Option>
            <Option value="قطاع التعليم">قطاع التعليم</Option>
            <Option value="قطاع الصحة">قطاع الصحة</Option>
            <Option value="منظمات المجتمع المدني">
              منظمات المجتمع المدني
            </Option>
            <Option value="القطاع الحكومي">القطاع الحكومي</Option>
            <Option value="القطاع الخاص">القطاع الخاص</Option>
            <Option value="مجال الإعلام">مجال الإعلام</Option>
            <Option value="عمل حر">عمل حر</Option>
            <Option value="التدريب والإستشارات">التدريب والإستشارات</Option>
            <Option value="طلاب جامعية">طلاب جامعة</Option>
            <Option value="طالب مدرسة">طالب مدرسة</Option>
            <Option value="ربة منزل">ربة منزل</Option>
            <Option value="لا أعمل">لا أعمل</Option>
          </Select>
        </FormItem>

        <FormItem prop="gender">
          الجنس
          <Select v-model="form.gender">
            <Option value="m">ذكر</Option>
            <Option value="f">انثى</Option>
          </Select>
        </FormItem>
        <FormItem prop="mail">
          الايميل
          <Input v-model="form.mail" placeholder="البريد الالكتروني"></Input>
        </FormItem>
        <FormItem prop="password">
          كلمة المرور
          <Input type="password" v-model="form.password"></Input>
        </FormItem>
        <Button type="primary" @click="submitForm('form')">حفظ</Button>
      </Form>
    </div>
  </div>
</template>
<script>
export default {
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
      countryCode: "JO",
      form: {
        firstName: "",
        lastName: "",
        phone: "",
        employment: "",
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
        employment: [
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
            type: "integer",
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
    };
  },
  methods: {
    submitForm(name) {

      this.$refs[name].validate((valid) => {
        if (valid) {
          const Obj = {
            firstName: this.form.firstName,
            lastName: this.form.lastName,
            employment: this.form.employment,
            phone: this.form.phone,
            gender: this.form.gender,
            email: this.form.mail,
            password: this.form.password,
          };
          const resp = this.$store.dispatch("admin/createOther", Obj);

          this.$Message.success(" تم انشاء حساب اخر ");
          this.$router.push("/admin/others");
        } else {
          this.$Message.error("تحقق من الحقول المدخلة");
        }
      });
    },
  },
};
</script>
