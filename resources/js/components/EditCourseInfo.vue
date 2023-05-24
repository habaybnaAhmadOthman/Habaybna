<style>
/* .card {
        text-align: right;
    } */
.ivu-notice-icon {
  left: 0 !important;
  font-size: 30px !important;
}
.ivu-notice-title {
  color: #5cbf6c !important;
}
.cover-image {
  margin: auto;
  width: 100%;
}
.ivu-notice-custom-content {
  position: relative;
  padding: 0 5px;
}
.ivu-notice-notice {
  text-align: right !important;
  padding: 0;
  color: lawngreen !important;
}
.custom label {
  display: inline-block !important;
}
</style>
<template>
  <div class="profile">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><strong>تعديل معلومات الدورة</strong></div>
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
              <div class="form-group admin-control">
                <div class="">
                  <div class="w-100">
                    <label class="form-control-label">فئة الدورة</label>
                    <multiselect
                      v-model="tags"
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
              <div class="mb-15">
                <strong>وصف الدورة</strong>
                <textarea name="" id="courseDescription" cols="30" rows="10"></textarea>
              </div>
              <div class="mb-15">
                <strong>ماذا سوف نتعلم</strong>
                <textarea name="" id="watWeLearn" cols="30" rows="10"></textarea>
              </div>

              <div class="form-group">
                <strong>صورة غلاف الدورة</strong>
                <img class="cover-image" :src="form.coverImage" alt="" />
                <input
                  name="coverImage"
                  type="file"
                  class="form-control"
                  @change="uploadCoverImage"
                />
              </div>
              <div class="form-group">
                <strong>الفيديو الترويجي للدورة</strong>
                <!-- <video ref="videoPlayer" controls  seeking="true">
                  <source :src="form.promoVideo ? form.promoVideo : ''" type="video/mp4" />
                  <source src="movie.ogg" type="video/ogg" />
                  Your browser does not support the video tag.
                </video> -->
                <input
                  name="promoVideo"
                  type="text"
                  class="form-control"
                  v-model="form.promoVideo"
                />
              </div>
              <div class="form-group custom">
                <label> حالة الدورة : </label>

                <div class="form-group">
                  <input
                    type="radio"
                    id="is_publish_1"
                    value="1"
                    v-model="form.is_publish"
                  />
                  <label> انشر الدورة </label>

                  <input
                    type="radio"
                    id="is_publish_2"
                    value="0"
                    v-model="form.is_publish"
                  />

                  <label> لا تنشر الدورة </label>
                </div>
              </div>
              <div class="form-group custom">
                <label> نوع الدورة : </label>
                <div class="from-group">
                  <input
                    type="radio"
                    id="is_free_1"
                    autocomplete="off"
                    value="1"
                    v-model="form.is_free"
                  />
                  <label> مجانية </label>
                  <input
                    type="radio"
                    id="is_free_2"
                    autocomplete="off"
                    value="0"
                    v-model="form.is_free"
                  />
                  <label> مدفوعة </label>
                </div>
              </div>
              <div class="form-group">
                <label>سعر الدورة :</label>
                <input
                  type="number"
                  class="form-control"
                  v-model="form.coursePrice"
                  name="price"
                />
              </div>
              <div class="question-form">
                <label> نسبة الخصم</label>
                <input
                  type="number"
                  v-model="form.discount"
                  name="discount"
                  class="form-control"
                  :disabled="form.is_free == 1 ? true : false"
                  placeholder="100 يعني free"
                />
              </div>
              <div class="form-group admin-control">
                <div class="">
                  <div class="w-100">
                    <label class="form-control-label">مقدمي الدورة</label>
                    <multiselect
                      v-model="SpecialistTags"
                      :options="specialists"
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
                :style="{ float: 'right' }"
                type="info"
                ghost
                :loading="loading"
                @click="formSubmit"
              >
                <span v-if="!loading">تعديل</span>
                <span v-else>تعديل...</span>
              </Button>
              <Button
                :style="{ float: 'left' }"
                type="info"
                to="/admin/courses"
              >
                رجوع
              </Button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import Editor from "ckeditor5-custom-build/build/ckeditor";
import initEditor from '../components/front/mixins/initEditor'
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";
export default {
  components: { Multiselect },
  mixins: [initEditor],
  data() {
    return {
      courseId: null,
      form: {
        courseTitle: "",
        courseCategory: [],
        courseDescription: null,
        editor: Editor.ClassicEditor,
        watWeLearn: null,
        editorConfig: {
          // The configuration of the editor.
        },
        coverImage: "",
        promoVideo: "",
        is_publish: false,
        is_free: false,
        discount: "",
      },
      tags: "",
      categories: [],
      SpecialistTags: "",
      specialists: [],

      loading: false,
    };
  },

  methods: {
    uploadCoverImage(event) {
      this.form.coverImage = event.target.files[0];
    },
    // uploadPromoVideo(event) {
    //   this.form.promoVideo = event.target.files[0];
    // },
    formSubmit(e) {
      this.loading = true;
      let self = this.$router;
      e.preventDefault();
      let tagIDs = [];
      let specIDs = [];
      this.tags.forEach((item) => tagIDs.push(item.id));
      this.SpecialistTags.forEach((item) => specIDs.push(item.user_id));
      let formData = new FormData();
      formData.append("title", this.form.courseTitle);
      formData.append("category", tagIDs);
      formData.append("specialists", specIDs);
      formData.append("description", this.form.courseDescription.getData().replaceAll('srcset','src').replaceAll(" 0w\"","\""));
      formData.append("watWeLearn", this.form.watWeLearn.getData().replaceAll('srcset','src').replaceAll(" 0w\"","\""));
      formData.append("coverImage", this.form.coverImage);
      formData.append("promoVideo", this.form.promoVideo);
      formData.append("is_publish", this.form.is_publish);
      formData.append("is_free", this.form.is_free);
      formData.append("price", this.form.coursePrice);
      formData.append("discount", this.form.discount);
      const config = {
        headers: {
          "content-type": "multipart/form-data",
          Accept: "application/json",
        },
      };
      axios
        .post("/api/admin/edit-course/" + this.courseId, formData)
        .then((response) => {
          if (response.status == 200) {
            // this.$Message.success("Course Updated success");
            this.success();
            this.loading = false;
          }
        })
        .catch((error) => {
          return 404;
        });
    },
    success(nodesc) {
      this.$Notice.success({
        title: "تم حفظ التغييرات بنجاح",
      });
    },
    async loadPageData(){
      const resp = await this.callApi("get", "/api/admin/course-init-data");
      if (resp.status == 200) {
        this.categories = resp.data.categories;
        this.specialists = resp.data.specialists;
        var course_id = this.$router.currentRoute.params.data;

        axios.get("/api/admin/edit-course/" + course_id).then((resp) => {
          if (resp.status == 200) {
            this.tags = resp.data.coursecat;
            this.SpecialistTags = resp.data.courseProviders;
            this.courseId = course_id;
            this.form.courseTitle = resp.data.course.courseTitle;
            this.form.courseCategory = resp.data.course.category_id;
            this.form.courseDescription.setData(resp.data.course.courseDescription);
            this.form.watWeLearn.setData(resp.data.course.whatWeLearn);
            this.form.is_publish = resp.data.course.is_publish;
            this.form.is_free = resp.data.course.is_free;
            this.form.coursePrice = resp.data.course.price;
            this.form.coverImage = resp.data.course.cover_photo;
            this.form.promoVideo = resp.data.course.promo_video;
            this.form.discount = resp.data.course.discount;

            // this.$refs.videoPlayer.load()
          }
        });
      }
    }
  },
  mounted() {
    const self = this;
    this.initEditor('#courseDescription','form.courseDescription',function(){
      self.initEditor('#watWeLearn','form.watWeLearn',function(){
        self.loadPageData();
      });
    });

  },
};
</script>
