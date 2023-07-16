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
        <h3>المكالمات - انشاء حزمة مكالمات</h3>
      </div>
      <div class="left-side">
        <Button type="info" to="/admin/calls">رجوع</Button>
      </div>
    </div>
    <form ref="form" :model="form" id="calls-form" class="flexxx">
      <div class="question-form">
        <label for=""> عنوان الحزمة : </label>
        <Input v-model="form.title" placeholder="عنوان حزمة المكالمات  " />
        <span class="error" v-if="!this.formValidation.title">
          يجب ان يحتوي الكود على 10 احرف او ارقام
        </span>
        <span class="error" v-if="usedTitle"> هذا العنوان مستخدم </span>
      </div>
      <div class="question-form">
        <label for="">نوع الحزمة : </label>
        <Select v-model="form.type" placeholder="نوع الحزمة (مجانية / مدفوعة)">
          <Option value="paid"> مدفوعة</Option>
          <Option value="free"> مجانية</Option>
        </Select>
        <span class="error" v-if="!this.formValidation.type">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="question-form">
        <label for="">عدد المكالمات : </label>
        <Input
          type="number"
          v-model="form.call_count"
          placeholder="عدد المكالمات في الحزمة"
        />
        <span class="error" v-if="!this.formValidation.call_count">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="question-form">
        <label for=""> سعر الحزمة : </label>
        <Input
          type="number"
          v-model="form.price"
          placeholder="سعر الحزمة بالدولار "
          :disabled="form.type == 'free' ? true : false"
        />
        <span class="error" v-if="!this.formValidation.price">
          * يجب تعبئة هذا الحقل
        </span>
      </div>

      <div class="form-date">
        <label for=""> تاريخ البدء : </label>
        <DatePicker
          v-model="form.package_durations.start_date"
          type="date"
          placeholder="حدد تاريخ بدء الصلاحية"
          style="width: 100%"
        ></DatePicker>
        <span
          class="error"
          v-if="!this.formValidation.package_durations.start_date"
        >
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="form-date">
        <label for=""> تاريخ الانتهاء : </label>
        <DatePicker
          v-model="form.package_durations.end_date"
          type="date"
          placeholder="حدد تاريخ انتهاء الصلاحية"
          style="width: 100%"
        ></DatePicker>
        <span
          class="error"
          v-if="!this.formValidation.package_durations.end_date"
        >
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="one-item-in-row">
        <label for=""> حالة الحزمة : </label>
        <RadioGroup v-model="form.status">
          <Radio label="1">
            <span>فعّالة</span>
          </Radio>
          <Radio label="0">
            <span>غير فعّالة</span>
          </Radio>
        </RadioGroup>
        <span class="error" v-if="!this.formValidation.status">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="parent-submit">
        <Button type="primary" @click="submitForm('form')">حفظ</Button>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  created() {
    this.callApi(
      "get",
      "/api/admin/calls/package/" + this.$route.params.data
    ).then((res) => {
      if (res.status == 200) {
        this.form.title = res.data.title;
        this.form.id = res.data.id;
        this.form.type = res.data.type;
        this.form.call_count = res.data.calls_count;
        this.form.price = res.data.price;
        this.form.package_durations.start_date = res.data.start_date;
        this.form.package_durations.end_date = res.data.end_date;
        this.form.status = res.data.status ? "1" : "0";
      }
    });
  },
  updated() {},
  data() {
    return {
      usedTitle: false,
      form: {
        id: "",
        title: "",
        type: "",
        call_count: "",
        price: "",
        package_durations: {
          start_date: "",
          end_date: "",
        },
        status: "",
      },
      formValidation: {
        title: true,
        type: true,
        call_count: true,
        price: true,
        package_durations: {
          start_date: true,
          end_date: true,
        },
        status: true,
      },
      packageIsValid: true,
    };
  },
  methods: {
    submitForm(name) {
      this.validateForm();
      if (this.packageIsValid) {
        const Obj = this.form;
        this.$store.dispatch("admin/updateCallPackage", Obj).then((res) => {
          if (res.original == 409) {
            this.usedTitle = true;
            this.$Message.error("عنوان الحزمة مستخدم   ");
          } else {
            this.$Message.success("تم تعديل الحزمة  ");
            this.$router.push("/admin/calls");
          }
        });
      }
    },
    validateForm() {
      if (!this.form.title) {
        this.formValidation.title = false;
      } else {
        this.formValidation.title = true;
      }
      if (!this.form.type) {
        this.formValidation.type = false;
      } else {
        this.formValidation.type = true;
      }
      if (!this.form.call_count) {
        this.formValidation.call_count = false;
      } else {
        this.formValidation.call_count = true;
      }
      if (!this.form.price && this.form.type !== "free") {
        this.formValidation.price = false;
      } else {
        this.formValidation.price = true;
      }
      if (!this.form.package_durations.start_date) {
        this.formValidation.package_durations.start_date = false;
      } else {
        this.formValidation.package_durations.start_date = true;
      }
      if (!this.form.package_durations.end_date) {
        this.formValidation.package_durations.end_date = false;
      } else {
        this.formValidation.package_durations.end_date = true;
      }
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
            this.packageIsValid = false;
            break;
          }
          this.packageIsValid = true;
        }
      }
    },
  },
};
</script>
