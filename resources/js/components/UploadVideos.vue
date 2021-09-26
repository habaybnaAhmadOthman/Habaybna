<template>
  <Collapse v-model="value1">
    <Panel name="1">
      Videos List
      <p slot="content">
        史蒂夫·乔布斯（Steve
        Jobs），1955年2月24日生于美国加利福尼亚州旧金山，美国发明家、企业家、美国苹果公司联合创办人。
      </p>
    </Panel>
    <Panel name="2">
        Add video
          <div class="card" slot="content">
            <div class="card-body">
              <form @submit="formSubmit" enctype="multipart/form-data">
                <div class="form-group">
                  <strong>Video Title:</strong>

                  <input
                    type="text"
                    class="form-control"
                    v-model="form.videoTitle"
                    name="title"
                  />
                </div>
                <div class="form-group">
                  <strong>Video Discription:</strong>
                  <ckeditor
                    :editor="form.editor"
                    v-model="form.videoDescription"
                    :config="form.editorConfig"
                  ></ckeditor>
                </div>
                <div class="form-group">
                  <strong>Video cover photo:</strong>
                  <input
                    name="coverImage"
                    type="file"
                    class="form-control"
                    @change="uploadCoverImage"
                  />
                </div>
                <div class="form-group">
                  <strong>Video:</strong>
                  <input
                    name="video"
                    type="file"
                    class="form-control"
                    @change="uploadvideo"
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
                      <i
                        class="icon wb-check text-active"
                        aria-hidden="true"
                      ></i>
                      Published
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
                      Unpublished
                    </label>
                  </div>
                </div>
                <button class="btn btn-outline-dark float-right">
                  Upload Video
                </button>
              </form>
            </div>
          </div>
    </Panel>
  </Collapse>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  data() {
    return {
      form: {
        videoTitle: "",
        videoDescription: "",
        editor: ClassicEditor,
        editorConfig: {
          // The configuration of the editor.
        },
        coverImage: "",
        video: "",
        is_publish: false,
        course_id: "",
      },
      value1: '1'
    };
  },
  created() {
    this.getCourseId();
  },
  methods: {
    getCourseId() {
      this.form.course_id = this.$router.currentRoute.params.data;

      console.log(this.form);
    },
    uploadCoverImage(event) {
      this.form.coverImage = event.target.files[0];
    },
    uploadvideo(event) {
      this.form.video = event.target.files[0];
    },
    formSubmit(e) {
      let self = this.$router;
      e.preventDefault();
      let formData = new FormData();
      formData.append("title", this.form.videoTitle);
      formData.append("description", this.form.videoDescription);
      formData.append("coverImage", this.form.coverImage);
      formData.append("video", this.form.video);
      formData.append("is_publish", this.form.is_publish);
      formData.append("course_id", this.form.course_id);
      const config = {
        headers: {
          "content-type": "multipart/form-data",
          Accept: "application/json",
        },
      };
      axios
        .post("/admin/course/upload-video", formData)
        .then((response) => {
          if (response.status == 200) {
            console.log(response);
          }
        })
        .catch((error) => {
          return 404;
        });
    },
  },
};
</script>
