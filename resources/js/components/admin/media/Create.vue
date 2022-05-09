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
        <h3>التغطية الاعلامية - اضافة تغطية جديدة</h3>
      </div>
      <div class="left-side">
        <Button type="info" to="/admin/media">رجوع</Button>
      </div>
    </div>
    <form ref="form" :model="form" id="calls-form" class="flexxx">
      <div class="question-form">
        <label for=""> عنوان التغطية : </label>
        <Input
          v-model="form.title"
          placeholder="ادخل عنوانا للتغطية الاعلمية  "
        />
        <span class="error" v-if="!this.formValidation.title">
          * يجب تعبئة هذا الحقل
        </span>
        <span class="error" v-if="usedTitle"> هذا العنوان مستخدم </span>
      </div>

      <div class="question-form">
        <label for=""> الرابط : </label>
        <Input
          v-model="form.url"
          placeholder="ادخل الرابط للتغطية الاعلمية  "
        />
        <span class="error" v-if="!this.formValidation.url">
          * يجب تعبئة هذا الحقل
        </span>
      </div>

      <div class="one-item-in-row">
        <label>صورة غلاف التغطية</label>
        <input name="coverImage" type="file" @change="uploadCoverImage" />
        <span class="error" v-if="!this.formValidation.coverImage">
          * يجب تعبئة هذا الحقل
        </span>
      </div>

      <!-- <div class="form-date">
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
      </div> -->

      <!-- <div class="one-item-in-row">
        <label for=""> حالة التغطية : </label>
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
      </div> -->
      <div class="parent-submit">
        <Button type="primary" @click="submitForm('form')">حفظ</Button>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  created() {},
  updated() {},
  data() {
    return {
      usedTitle: false,
      form: {
        title: "",
        url: "",
        coverImage: null,
        start_date: "",
        // status: "",
      },
      formValidation: {
        title: true,
        url: true,
        coverImage: true,
        start_date: true,
        // status: true,
      },
      isValid: true,
    };
  },
  methods: {
    submitForm(name) {
      this.validateForm();
      if (this.isValid) {
        let formData = new FormData();
        formData.append("coverImage", this.form.coverImage);
        formData.append("url", this.form.url);
        formData.append("title", this.form.title);

        this.$store.dispatch("admin/createMedia", formData).then((res) => {
          if (res.status == 200) {
            setTimeout(() => {
              this.$Message.success("تم اضافة  التغطية   ");
              this.$router.push("/admin/media");
            }, 1500);
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
      if (!this.form.url) {
        this.formValidation.url = false;
      } else {
        this.formValidation.url = true;
      }
      if (!this.form.coverImage) {
        this.formValidation.coverImage = false;
      } else {
        this.formValidation.coverImage = true;
      }

      //   if (!this.form.package_durations.start_date) {
      //     this.formValidation.package_durations.start_date = false;
      //   } else {
      //     this.formValidation.package_durations.start_date = true;
      //   }

      //   if (!this.form.status) {
      //     this.formValidation.status = false;
      //   } else {
      //     this.formValidation.status = true;
      //   }

      for (const prob in this.formValidation) {
        if (Object.hasOwnProperty.call(this.formValidation, prob)) {
          const element = this.formValidation[prob];
          console.log(prob, element);
          if (!element) {
            console.log("false", prob);
            this.isValid = false;
            break;
          }
          this.isValid = true;
        }
      }
    },
    uploadCoverImage(event) {
        console.log(event.target.files[0]);

        this.form.coverImage = event.target.files[0];
        console.log(this.form.coverImage);

    },
  },
};
</script>
