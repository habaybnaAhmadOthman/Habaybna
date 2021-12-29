<style>
.radio label {
  display: inline-block !important;
  margin: 2px;
}
.error {
  font-size: 16px !important;
  color: red;
}
</style>
<template>
  <div class="profile">
    <div class="row justify-content-center"></div>
    <div class="col-md-8">
      <div class="card">
        <div :style="{ display: 'inline-block', width: '100%' }">
          <Button
            type="info"
            :style="{ float: 'left' }"
            ghost
            to="/admin/courses"
          >
            رجوع
          </Button>
          <div class="card-header">معلومات عن الدورة</div>
          <div class="card-body">
            <form @submit="formSubmit" enctype="multipart/form-data">
              <div class="form-group">
                <strong>عنوان الدورة</strong>

                <input
                  type="text"
                  class="form-control"
                  v-model="form.courseTitle"
                  name="title"
                  required
                />
                <span class="error" v-if="!this.formValidation.courseTitle">
                  * يجب تعبئة هذا الحقل
                </span>
              </div>
              <!-- <div class="form-group">
                <strong>فئة الدورة</strong>
                <select class="form-control" v-model="form.courseCategory">
                  <option
                    v-for="(category, index) in categories"
                    :key="index"
                    :value="category.id"
                  >
                    {{ category.title }}
                  </option>
                </select>
              </div> -->
              <div class="form-group admin-control">
                <div class="">
                  <div class="w-100">
                    <label class="form-control-label">فئة الدورة</label>
                    <multiselect
                      v-model="form.courseCategory"
                      :options="categories"
                      :searchable="true"
                      :close-on-select="false"
                      :multiple="true"
                      :taggable="true"
                      label="title"
                      track-by="title"
                      placeholder="يرجى إختيار فئة الدورة"
                      required
                    ></multiselect>
                    <span
                      class="error"
                      v-if="!this.formValidation.courseCategory"
                    >
                      * يجب اختيار واحد على الاقل
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <strong> وصف الدورة</strong>
                <ckeditor
                  :editor="form.editor"
                  v-model="form.courseDescription"
                  :config="form.editorConfig"
                ></ckeditor>
                <span
                  class="error"
                  v-if="!this.formValidation.courseDescription"
                >
                  * يجب تعبئة هذا الحقل
                </span>
              </div>
              <div class="form-group">
                <strong>ماذا سوف نتعلم</strong>
                <ckeditor
                  :editor="form.editor"
                  v-model="form.watWeLearn"
                  :config="form.editorConfig"
                ></ckeditor>
                <span class="error" v-if="!this.formValidation.watWeLearn">
                  * يجب تعبئة هذا الحقل
                </span>
              </div>
              <div class="form-group">
                <strong>صورة غلاف الدورة</strong>
                <input
                  name="coverImage"
                  type="file"
                  class="form-control"
                  @change="uploadCoverImage"
                />
                <span class="error" v-if="!this.formValidation.coverImage">
                  * يجب تعبئة هذا الحقل
                </span>
              </div>
              <div class="form-group">
                <strong>فيديو ترويجي للدورة</strong>
                <input
                  name="promoVideo"
                  type="file"
                  class="form-control"
                  @change="uploadPromoVideo"
                />
                <span class="error" v-if="!this.formValidation.promoVideo">
                  * يجب تعبئة هذا الحقل
                </span>
              </div>
              <div class="form-group">
                <div class="form-group radio" :style="{ margin: '10px' }">
                  <label> حالة الدورة : </label>
                  <input
                    type="radio"
                    id="is_publish_1"
                    value="1"
                    v-model="form.is_publish"
                  />
                  <label for="is_publish_1"> انشر الدورة </label>

                  <input
                    type="radio"
                    id="is_publish_2"
                    value="0"
                    v-model="form.is_publish"
                  />
                  <label for="is_publish_2"> لا تنشر الدورة </label>
                </div>
              </div>
              <div class="form-group" :style="{ margin: '10px' }">
                <div class="from-group radio">
                  <label>نوع الدورة : </label>
                  <label>
                    <input
                      type="radio"
                      id="is_free_1"
                      autocomplete="off"
                      value="1"
                      v-model="form.is_free"
                    />

                    مجانية
                  </label>
                  <label>
                    <input
                      type="radio"
                      id="is_free_2"
                      autocomplete="off"
                      value="0"
                      v-model="form.is_free"
                    />
                    مدفوعة
                  </label>
                </div>
              </div>
              <div class="form-group">
                <strong>سعر الدورة</strong>
                <input
                  type="number"
                  class="form-control"
                  v-model="form.coursePrice"
                  name="price"
                />
                <span class="error" v-if="!this.formValidation.coursePrice">
                  * يجب تعبئة هذا الحقل
                </span>
              </div>
              <div class="form-group admin-control">
                <div class="">
                  <div class="w-100">
                    <label class="form-control-label">مقدمي الدورة</label>
                    <multiselect
                      v-model="form.tags"
                      :options="form.specialistsList"
                      :searchable="true"
                      :close-on-select="false"
                      :multiple="true"
                      :taggable="true"
                      label="firstName"
                      track-by="user_id"
                      placeholder="يرجى إختيار مقدمي الدورة"
                    ></multiselect>
                    <span class="error" v-if="!this.formValidation.tags">
                      * يجب اختيار واحد على الاقل
                    </span>
                  </div>
                </div>
              </div>
              <Button
                :style="{ float: 'left' }"
                type="info"
                ghost
                :loading="loading"
                @click="formSubmit"
              >
                <span v-if="!loading">التالي</span>
                <span v-else>Creating...</span>
              </Button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";
export default {
  components: { Multiselect },

  async created() {
    const resp = await this.callApi("get", "/api/admin/course-init-data");
    if (resp.status == 200) {
      console.log(resp.data.categories);
      this.categories = resp.data.categories;
      this.form.specialistsList = resp.data.specialists;
    }
  },
  data() {
    return {
      form: {
        tags: "",
        tagsValid: true,
        specialistsList: [],
        courseTitle: "",
        courseCategory: "",
        courseDescription: "",
        editor: ClassicEditor,
        watWeLearn: "",
        editorConfig: {
          enterMode: "br",
        },
        coverImage: "",
        promoVideo: "",
        coursePrice: "",
        is_publish: false,
        is_free: false,
      },
      categories: [],
      loading: false,
      formValidation: {
        tags: true,
        courseTitle: true,
        courseCategory: true,
        courseDescription: true,
        watWeLearn: true,
        coverImage: true,
        promoVideo: true,
        coursePrice: true,
      },
      isValidToSubmit: true,
    };
  },

  methods: {
    uploadCoverImage(event) {
      this.form.coverImage = event.target.files[0];
    },
    uploadPromoVideo(event) {
      this.form.promoVideo = event.target.files[0];
    },
    async formSubmit(e) {
      this.validatForm();
      console.log("form.tags", this.isValidToSubmit);
      if (this.isValidToSubmit) {
        this.loading = true;
        let self = this.$router;

        let tagIDs = [];
        this.form.tags.forEach((item) => tagIDs.push(item.user_id));

        let CategorytagIDs = [];
        this.form.courseCategory.forEach((item) =>
          CategorytagIDs.push(item.id)
        );
        console.log(this.form.tags, "tags");

        e.preventDefault();
        let formData = new FormData();
        formData.append("title", this.form.courseTitle);
        formData.append("category", CategorytagIDs);
        formData.append("description", this.form.courseDescription);
        formData.append("watWeLearn", this.form.watWeLearn);
        formData.append("coverImage", this.form.coverImage);
        formData.append("promoVideo", this.form.promoVideo);
        formData.append("is_publish", this.form.is_publish);
        formData.append("is_free", this.form.is_free);
        formData.append("price", this.form.coursePrice);
        formData.append("specialists", tagIDs);

        let resp = await this.$store.dispatch(
          "admin/storeCourseInfo",
          formData
        );
        console.log("resp", resp, resp.course_id);
        this.$Message.success("تم انشاء الدورة");
        self.push({
          name: "UploadVideo",
          params: { data: resp.data.course_id },
        });
        this.loading = false;
      }
    },
    validatForm() {
      console.log("xxxx");
      if (this.form.courseTitle == "") {
        this.formValidation.courseTitle = false;
      } else {
        this.formValidation.courseTitle = true;
      }
      if (this.form.courseDescription == "") {
        this.formValidation.courseDescription = false;
      } else {
        this.formValidation.courseDescription = true;
      }
      if (this.form.watWeLearn == "") {
        this.formValidation.watWeLearn = false;
      } else {
        this.formValidation.watWeLearn = true;
      }
      if (this.form.coverImage == "") {
        this.formValidation.coverImage = false;
      } else {
        this.formValidation.coverImage = true;
      }
      if (this.form.promoVideo == "") {
        this.formValidation.promoVideo = false;
      } else {
        this.formValidation.promoVideo = true;
      }
      //   if (this.form.promoVideo == "") {
      //     this.formValidation.promoVideo = false;
      //   } else {
      //     this.formValidation.courseTitle = true;
      //   }
      if (this.form.coursePrice == "") {
        this.formValidation.coursePrice = false;
      } else {
        this.formValidation.coursePrice = true;
      }
      if (this.form.courseCategory.length < 1) {
        this.formValidation.courseCategory = false;
      } else {
        this.formValidation.courseCategory = true;
      }
      if (this.form.tags.length < 1) {
        this.formValidation.tags = false;
      } else {
        this.formValidation.tags = true;
      }
      for (const prob in this.formValidation) {
        if (Object.hasOwnProperty.call(this.formValidation, prob)) {
          const element = this.formValidation[prob];
          if (!element) {
            this.isValidToSubmit = false;
            this.$Message.error("يرجى التحقق من الحقول");

            break;
          }
        }
      }
    },
  },
};
</script>
<style>
.ck-editor__editable {
  min-height: 300px;
}
</style>
