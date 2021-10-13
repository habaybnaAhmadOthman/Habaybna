<template>
  <div class="container" >
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">About the course</div>
          <div class="card-body">
            <form @submit="formSubmit" enctype="multipart/form-data">
              <div class="form-group">
                <strong>Course Title:</strong>

                <input
                  type="text"
                  class="form-control"
                  v-model="form.courseTitle"
                  name="title"
                />
              </div>
              <div class="form-group">
                <strong>Course category:</strong>
                <select class="form-control" v-model="form.courseCategory">
                  <option
                    v-for="(category, index) in categories"
                    :key="index"
                    :value="category.id"
                  >
                    {{ category.title }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <strong>Course Discription:</strong>
                <ckeditor
                  :editor="form.editor"
                  v-model="form.courseDescription"
                  :config="form.editorConfig"
                ></ckeditor>
              </div>
              <div class="form-group">
                <strong>What we learn :</strong>
                <ckeditor
                  :editor="form.editor"
                  v-model="form.watWeLearn"
                  :config="form.editorConfig"
                ></ckeditor>
              </div>
              <div class="form-group">
                <strong>Course cover photo:</strong>
                <input
                  name="coverImage"
                  type="file"
                  class="form-control"
                  @change="uploadCoverImage"
                />
              </div>
              <div class="form-group">
                <strong>Course promo video:</strong>
                <input
                  name="promoVideo"
                  type="file"
                  class="form-control"
                  @change="uploadPromoVideo"
                />
              </div>
              <div class="form-group">
                <div class="btn-group" data-toggle="buttons" role="group">
                  <label class="btn btn-outline btn-success">
                    <input
                      type="radio"
                      id="is_publish_1"
                      value="1"
                      v-model="form.is_publish"
                    />
                    <i class="icon wb-check text-active" aria-hidden="true"></i>
                    Published
                  </label>
                  <label class="btn btn-outline btn-danger">
                    <input
                      type="radio"
                      id="is_publish_2"
                      value="0"
                      v-model="form.is_publish"
                    />
                    <i class="icon wb-check text-active" aria-hidden="true"></i>
                    Unpublished
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div class="btn-group" data-toggle="buttons" role="group">
                  <label class="btn btn-outline btn-primary">
                    <input
                      type="radio"
                      id="is_free_1"
                      autocomplete="off"
                      value="1"
                      v-model="form.is_free"
                    />
                    <i class="icon wb-check text-active" aria-hidden="true"></i>
                    Free
                  </label>
                  <label class="btn btn-outline btn-secondary">
                    <input
                      type="radio"
                      id="is_free_2"
                      autocomplete="off"
                      value="0"
                      v-model="form.is_free"
                    />
                    <i class="icon wb-check text-active" aria-hidden="true"></i>
                    paid
                  </label>
                </div>
              </div>
              <div class="form-group">
                <strong>Course Price:</strong>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.coursePrice"
                  name="price"
                />
              </div>
              <Button
                :style="{ float: 'right' }"
                type="info"
                ghost
                :loading="loading"
                @click="formSubmit"
              >
                <span v-if="!loading">Update</span>
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
export default {
  async created() {
    const resp = await this.callApi("get", "/admin/course-category");
    if (resp.status == 200) {
      this.categories = resp.data.categories;
      var course_id = this.$router.currentRoute.params.data;

      axios.get("/admin/edit-course/" + course_id).then((resp) => {
        if (resp.status == 200) {
            this.courseId = course_id
          console.log(resp.data.course.courseTitle);
          this.form.courseTitle = resp.data.course.courseTitle;
          this.form.courseCategory = resp.data.course.category_id;
          this.form.courseDescription = resp.data.course.courseDescription;
          this.form.watWeLearn = resp.data.course.whatWeLearn;
          this.form.is_publish = resp.data.course.is_publish;
          this.form.is_free = resp.data.course.is_free;
          this.form.coursePrice = resp.data.course.price;
        }
      });
    }
  },
  data() {
    return {
        courseId:null,
      form: {
        courseTitle: "",
        courseCategory: "",
        courseDescription: "",
        editor: ClassicEditor,
        watWeLearn: "",
        editorConfig: {
          // The configuration of the editor.
        },
        coverImage: "",
        promoVideo: "",
        is_publish: false,
        is_free: false,
      },
      categories: "",
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
    formSubmit(e) {
      this.loading = true;
      let self = this.$router;
      e.preventDefault();
      let formData = new FormData();
      formData.append("title", this.form.courseTitle);
      formData.append("category", this.form.courseCategory);
      formData.append("description", this.form.courseDescription);
      formData.append("watWeLearn", this.form.watWeLearn);
      formData.append("coverImage", this.form.coverImage);
      formData.append("promoVideo", this.form.promoVideo);
      formData.append("is_publish", this.form.is_publish);
      formData.append("is_free", this.form.is_free);
      formData.append("price", this.form.coursePrice);
      const config = {
        headers: {
          "content-type": "multipart/form-data",
          Accept: "application/json",
        },
      };
      axios
        .post("/admin/edit-course/"+this.courseId, formData)
        .then((response) => {
          if (response.status == 200) {
            this.$Message.success("Course Updated success");


            this.loading = false;
          }
        })
        .catch((error) => {
          return 404;
        });
    },
  },
};
</script>
