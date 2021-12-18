<template>
  <div class="profile">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
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
                />
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
                    ></multiselect>
                    <p class="main-color mt-5 font-12" v-if="!form.tagsValid">
                      لا يمكنك ترك هذا الحقل فارغ
                    </p>
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
              </div>
              <div class="form-group">
                <strong>ماذا سوف نتعلم</strong>
                <ckeditor
                  :editor="form.editor"
                  v-model="form.watWeLearn"
                  :config="form.editorConfig"
                ></ckeditor>
              </div>
              <div class="form-group">
                <strong>صورة غلاف الدورة</strong>
                <input
                  name="coverImage"
                  type="file"
                  class="form-control"
                  @change="uploadCoverImage"
                />
              </div>
              <div class="form-group">
                <strong>فيديو ترويجي للدورة</strong>
                <input
                  name="promoVideo"
                  type="file"
                  class="form-control"
                  @change="uploadPromoVideo"
                />
              </div>
              <div class="form-group">
                <div class="btn-group" data-toggle="buttons" role="group">
                  <strong> حالة الدورة </strong>

                  <div class="form-group" :style="{ margin: '10px' }">
                    <label class="btn btn-outline btn-success">
                      <input
                        type="radio"
                        id="is_publish_1"
                        value="1"
                        v-model="form.is_publish"
                      />
                      <i
                        class="icon wb-check text-active"
                        aria-hidden="true"
                      ></i>
                      انشر الدورة
                    </label>
                    <label class="btn btn-outline btn-danger">
                      <input
                        type="radio"
                        id="is_publish_2"
                        value="0"
                        v-model="form.is_publish"
                      />
                      <i
                        class="icon wb-check text-active"
                        aria-hidden="true"
                      ></i>
                      لا تنشر الدورة
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group" :style="{ margin: '10px' }">
                <div class="btn-group" data-toggle="buttons" role="group">
                  <strong>نوع الدورة</strong><br />
                  <div class="from-group">
                    <label class="btn btn-outline btn-primary">
                      <input
                        type="radio"
                        id="is_free_1"
                        autocomplete="off"
                        value="1"
                        v-model="form.is_free"
                      />
                      <i
                        class="icon wb-check text-active"
                        aria-hidden="true"
                      ></i>
                      مجانية
                    </label>
                    <label class="btn btn-outline btn-secondary">
                      <input
                        type="radio"
                        id="is_free_2"
                        autocomplete="off"
                        value="0"
                        v-model="form.is_free"
                      />
                      <i
                        class="icon wb-check text-active"
                        aria-hidden="true"
                      ></i>
                      مدفوعة
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <strong>سعر الدورة</strong>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.coursePrice"
                  name="price"
                />
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
                    <p class="main-color mt-5 font-12" v-if="!form.tagsValid">
                      لا يمكنك ترك هذا الحقل فارغ
                    </p>
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
          enterMode:"br"
        },
        coverImage: "",
        promoVideo: "",
        is_publish: false,
        is_free: false,
      },
      categories: [],
      loading: false,
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
      this.loading = true;
      let self = this.$router;

      let tagIDs = [];
      this.form.tags.forEach((item) => tagIDs.push(item.user_id));

      let CategorytagIDs = [];
      this.form.courseCategory.forEach((item) => CategorytagIDs.push(item.id));
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

      let resp =await this.$store.dispatch("admin/storeCourseInfo", formData);
      this.$Message.success("Course Created success");
      console.log(resp);
      self.push({
        name: "UploadVideo",
        params: { data: resp.course_id },
      });
      this.loading = false;

      //   const config = {
      //     headers: {
      //       "content-type": "multipart/form-data",
      //       Accept: "application/json",
      //     },
      //   };
      //   axios
      // .post("/admin/storeCourseInfo", formData)
      // .then((response) => {
      //   if (response.status == 200) {
      //     this.$Message.success("Course Created success");

      // self.push({
      //   name: "UploadVideo",
      //   params: { data: response.data.course_id },
      // });
      //     this.loading = false;
      //   }
      // })
      // .catch((error) => {
      //   return 404;
      // });
    },
  },
};
</script>
<style>
.ck-editor__editable {
  min-height:300px;
}
</style>
