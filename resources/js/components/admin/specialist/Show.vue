<style>
.profile {
  direction: rtl;
  text-align: right;
}
</style>
<template>
  <div class="profile">
    <div class="question-form-title">
      <div class="right-side">
        <h3>الاخصائيين - تعديل أخصائي</h3>
      </div>
      <div class="left-side">
        <Button type="info" to="/admin/specialist">رجوع</Button>
      </div>
    </div>
    <form @submit.prevent="submitForm" class="card-body">
      <div class="form-group mb-0-p">
        <label class="form-control-label">الاسم كامل</label>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group m-0-i">
              <input
                class="form-control"
                placeholder="الإسم الأول"
                id="firstName"
                v-model="firstName"
                disabled
              />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group m-0-i">
              <input
                class="form-control"
                placeholder="العائلة"
                id="lastName"
                v-model="lastName"
                disabled
              />
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mb-0-p">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group m-0-i">
              <label class="form-control-label">البريد الإلكتروني</label>
              <input
                class="form-control"
                placeholder="البريد الإلكتروني"
                id="email"
                v-model="email"
                disabled
              />
            </div>
          </div>
          <div class="col-md-4">
            <label class="form-control-label">رقم الهاتف</label>
            <div class="">
              <input
                class="form-control plaintext"
                placeholder="رقم الهاتف"
                id="phoneNumber"
                v-model="phoneNumber"
                disabled
              />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group m-0-i">
              <label class="form-control-label">الجنس</label>
              <input
                class="form-control plaintext"
                placeholder="الجنس"
                id="gender"
                :value="gender.parsed"
                disabled
              />
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mb-0-p">
        <div class="row">
          <div class="col-md-4">
            <!-- speciality -->
            <div
              class="form-group m-0-i"
              :class="{ invalid: !specialization.isValid }"
            >
              <label class="form-control-label">التخصص</label>
              <select
                class="form-control w-100"
                v-model="specialization.val"
                id="specialization"
                @blur="checkValidity"
              >
                <option value="no" disabled hidden>التخصص</option>
                <option value="التربية الخاصة">التربية الخاصة</option>
                <option value="النطق واللغة">النطق واللغة</option>
                <option value="العلاج الوظيفي">العلاج الوظيفي</option>
                <option value="العلاج الطبيعي">العلاج الطبيعي</option>
                <option value="تحليل السلوك">تحليل السلوك</option>
                <option value=" علم النفس الاكلينيكي">
                  علم النفس الاكلينيكي
                </option>
                <option value=" صعوبات التعلم">صعوبات التعلم</option>
                <option value="التدخل المبكر">التدخل المبكر</option>
                <option value="الإرشاد الأسري">الإرشاد الأسري</option>
                <option value="تحليل السلوك التطبيقي">
                  تحليل السلوك التطبيقي
                </option>
              </select>
              <p class="main-color mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
          </div>
          <div class="col-md-4">
            <!-- work place -->

            <label class="form-control-label">مكان العمل</label>
            <input
              class="form-control"
              placeholder="مكان العمل"
              id="workPlace"
              v-model="workPlace.val"
            />
          </div>
        </div>
      </div>
      <div class="form-group mb-0-p">
        <div class="row">
          <div class="col-md-4">
            <label class="form-control-label">سنة الميلاد</label>
            <input
              class="form-control plaintext"
              placeholder="الجنس"
              :value="birthdate.val"
            />
          </div>
        </div>
      </div>
      <div class="form-group mb-0-p">
        <div class="row">
          <div class="col-md-4">
            <label class="form-control-label">التحصيل العلمي</label>
            <select class="form-control" id="education" v-model="education.val">
              <option value="no" disabled hidden>التحصيل العلمي</option>
              <option value="school">ثانوية عامة</option>
              <option value="diploma">دبلوم</option>
              <option value="Bachelor">بكالوريوس</option>
              <option value="master">ماجستير</option>
              <option value="doctorate">دكتوراه</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-control-label">المسمى الوظيفي</label>
            <input
              class="form-control"
              placeholder="المسمى الوظيفي"
              v-model.trim="jobTitle.val"
            />
          </div>
          <div class="col-md-4">
            <label class="form-control-label">سنوات الخبرة</label>
            <input
              type="number"
              class="form-control"
              placeholder="سنوات الخبرة"
              v-model.trim="experience.val"
            />
          </div>
        </div>
      </div>
      <div class="form-group admin-control">
        <div class="">
          <div class="w-100">
            <label class="form-control-label">الإهتمامات</label>
            <multiselect
              v-model="tags"
              :options="interestsList"
              :searchable="true"
              :close-on-select="false"
              :multiple="true"
              :taggable="true"
              label="title"
              track-by="title"
              placeholder="يرجى إختيار الإهتمامات"
            ></multiselect>
            <p class="main-color mt-5 font-12" v-if="!tagsValid">
              لا يمكنك ترك هذا الحقل فارغ
            </p>
          </div>
        </div>
      </div>

      <div class="w-100 form-group">
        <label class="form-control-label"
          >ما هي الاضطرابات التي تعمل معها ؟ ( 150 كلمة )</label
        >
        <textarea
          rows="5"
          type="text"
          class="form-control trans"
          placeholder="ما هي الاضطرابات التي تعمل معها ؟ "
          id="whyToJoin"
          @blur="checkValidity"
          v-model.trim="whyToJoin.val"
        ></textarea>
      </div>

      <div class="">
        <div class="d-flex">
          <button class="btn-2 flex-all font-20 ml-20">حفظ</button>
          <!-- <button
                        class="btn-3 radius-12"
                        @click.prevent="showPasswordDialog"
                    >
                        تغيير كلمة المرور
                    </button> -->
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

export default {
  emits: ["submit-form", "open-password-dialog"],
  components: { Multiselect },
  props: ["years"],
  mounted() {
    this.getProfileData();
  },
  data() {
    return {
      tags: "",
      tagsValid: true,
      interestsList: [],
      firstName: "",
      lastName: "",
      email: "",
      phoneNumber: "",
      gender: {
        val: "no",
        parsed: null,
      },
      specialization: {
        val: "no",
        isValid: true,
      },
      education: {
        val: "no",
        isValid: true,
      },
      whyToJoin: {
        val: "",
        isValid: true,
      },
      jobTitle: {
        val: "",
        isValid: true,
      },
      workPlace: {
        val: "",
        isValid: true,
      },
      experience: {
        val: "",
        isValid: true,
      },
      birthdate: {
        val: "",
        isValid: true,
      },
      formIsValid: true,
    };
  },
  methods: {
    async getProfileData() {
      const obj = await this.$store.dispatch(
        "admin/getSpecialisDataAdmin",
        this.$route.params.data
      );
      const data = obj.userData;
      this.firstName = data.firstName;
      this.lastName = data.lastName;
      this.phoneNumber = data.phone;
      this.email = data.email;
      this.birthdate.val = new Date(data.dob).getFullYear();
      this.specialization.val = data.specialization || "no";
      this.workPlace.val = data.work_place;
      this.jobTitle.val = data.job_title;
      this.experience.val = data.experience;
      this.gender.val = data.gender;
      this.gender.parsed = data.gender == "f" ? "أنثى" : "ذكر";
      this.whyToJoin.val = data.disorders_work_with;
      this.interestsList = data.interestsList;
      this.tags = data.interests;
      this.education.val = data.edu_level || "no";
    },
    // showPasswordDialog() {
    //     this.$emit("open-password-dialog");
    // },
    validateForm() {
      this.formIsValid = true;
      this.tagsValid = true;
      if (this.tags.length < 1) {
        this.tagsValid = false;
        this.formIsValid = false;
      }
    },
    checkValidity(e) {
      if (e.target.value != "") {
        this[e.target.id].isValid = true;
      } else {
        this[e.target.id].isValid = false;
      }
    },
    submitForm() {
      // this.validateForm();
      // if (!this.formIsValid) {
      //     return;
      // }
      let educationValue = this.education.val;
      if (educationValue == "no") {
        educationValue = "";
      }

      let tagIDs = [];
      this.tags.forEach((item) => tagIDs.push(item.id));
      this.$store.dispatch("admin/editSpecialistData", {
        firstName: this.firstName,
        lastName: this.lastName,
        phone: this.phoneNumber,
        email: this.email,
        dob: this.birthdate.val,
        specialization: this.specialization.val,
        workPlace: this.workPlace.val,
        jobTitle: this.jobTitle.val,
        experience: this.experience.val,
        gender: this.gender.val,
        whyToJoin: this.whyToJoin.val,
        education: educationValue,
        interests: tagIDs,
      });
      this.$Message.success("تم التعديل بنجاح ");
    },
  },
};
</script>
<style scoped>
.profile textarea {
  height: auto !important;
}
</style>
