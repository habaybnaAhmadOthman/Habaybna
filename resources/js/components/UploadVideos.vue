<style>
.ivu-card {
  background-color: rgb(81 90 110) !important;
  color: #fff;
}
.ivu-card-head p {
  color: rgb(255 255 255 / 70%) !important;
  transition: all 0.3s ease-in-out;
  cursor: pointer;
}
.ivu-card-head p:hover {
  color: #fff !important;
}
.ivu-col-span-6 {
  padding: 2px !important;
}
.ivu-card-body {
  padding: 0 !important;
}
/* .ck p {
  display: inline-block !important;
} */
.ck-editor__editable {
  min-height: 150px !important;
}
.ck.ck-editor__editable_inline {
  text-align: right !important;
  direction: rtl !important;
}
.ck ol,
.ck ul {
  padding: 20px;
}
.ck li {
  list-style: inherit !important;
}
</style>
<template class="">
  <div class="profile">
    <div :style="{ display: 'inline-block', width: '100%' }">
      <Button type="info" :style="{ float: 'left' }" ghost to="/admin/courses">
        رجوع
      </Button>
    </div>
    <Collapse v-model="value1">
      <Panel name="1" v-if="allVideos.haveVideos">
        قائمة الحلقات ({{ allVideos.count }})

        <Row :gutter="16" slot="content">
          <Col
            span="6"
            class="video-list"
            v-for="(video, index) in allVideos.videos"
            :key="index"
          >
            <Card :bordered="false">
              <p
                @click="editVideo(index)"
                slot="title"
                :style="{ textAlign: 'right' }"
              >
                {{ video.title }}

                <Icon type="ios-build-outline" :style="{ float: 'left' }" />
              </p>
            </Card>
          </Col>
        </Row>
      </Panel>
      <Panel name="1" v-model="value1" v-else>
        قائمة الحلقات
        <h1 slot="content" class="text-center">لا يوجد حلقات 😢</h1>
      </Panel>
    </Collapse>

    <span> أضف حلقة </span>
    <div class="card" slot="content">
      <div class="card-body">
        <form @submit="formSubmit" enctype="multipart/form-data">
          <div class="form-group">
            <strong>عنوان الحلقة</strong>

            <input
              type="text"
              class="form-control"
              v-model="form.videoTitle"
              name="title"
            />
            <span class="error" v-if="!this.formValidation.videoTitle">
              * يجب تعبئة هذا الحقل
            </span>
          </div>
          <div class="">
            <strong>وصف الحلقة</strong>
            <textarea id="videoDescription"></textarea>
            <span class="error" v-if="!this.formValidation.videoDescription">
              * يجب تعبئة هذا الحقل
            </span>
          </div>
          <div v-if="isUpdate" class="form-group">
            <video ref="videoPlayer" controls autoplay seeking="true">
              <source :src="onLoad ? onLoad : ''" type="video/mp4" />
              <source src="movie.ogg" type="video/ogg" />
              Your browser does not support the video tag.
            </video>
          </div>
          <div class="form-group">
            <strong>رابط فيديو الحلقة :</strong>
            <input
              name="video"
              type="text"
              class="cdk-ed form-control"
              v-model="form.video"
            />
            <span class="error" v-if="!this.formValidation.video">
              * يجب تعبئة هذا الحقل
            </span>
          </div>
          <div class="form-group">
            <strong>  مدة الحلقة :</strong>
            <input
              name="length"
              type="text"
              class="cdk-ed form-control"
              v-model="form.length"
              placeholder="10:30"
            />
            <span class="error" v-if="!this.formValidation.length">
              * يجب تعبئة هذا الحقل
            </span>
          </div>
          <div class="form-group">
            <RadioGroup v-model="form.is_publish" vertical>
              <Radio label="1">
                <span>نشر</span>
              </Radio>
              <Radio label="0">
                <span>عدم النشر</span>
              </Radio>
            </RadioGroup>
            <span class="error" v-if="!this.formValidation.is_publish">
              * يجب تعبئة هذا الحقل
            </span>
          </div>
          <Button
            v-if="isUpdate"
            :style="{ float: 'right' }"
            type="info"
            :loading="loading"
            @click="formSubmit"
            class="publish"
          >
            <span v-if="!loading">تعديل</span>
            <span v-else>جاري التعديل...</span>
          </Button>
          <Button
            v-else
            :style="{ float: 'right' }"
            type="info"
            ghost
            :loading="loading"
            @click="formSubmit"
          >
            <span v-if="!loading">حفظ</span>
            <span v-else>حاري الحفظ...</span>
          </Button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Editor from "ckeditor5-custom-build/build/ckeditor";
import initEditor from "../components/front/mixins/initEditor";
export default {
  mixins: [initEditor],
  mounted() {
    this.initEditor(
      "#videoDescription",
      "form.videoDescription",
      function () {}
    );
  },
  data() {
    return {
      form: {
        id: "",
        videoTitle: "",
        videoDescription: null,
        editor: ClassicEditor,
        editorConfig: {
          enterMode: "br",
        },
        video: "",
        length:"",
        is_publish: "",
        course_id: "",
      },
      value1: "1",
      loading: false,
      allVideos: {
        videos: "",
        count: 0,
        haveVideos: false,
        courseTitle: "",
      },
      isUpdate: false,
      loadingUrl: "",
      onLoad: "",
      formValidation: {
        videoTitle: true,
        videoDescription: true,
        video: true,
        is_publish: true,
        length:true,
      },
      isFormValid: true,
    };
  },
  created() {
    this.getCourseId();
    this.getCourseVideos();
  },
  methods: {
    getCourseId() {
      this.form.course_id = this.$router.currentRoute.params.data;
    },
    // uploadvideo(event) {
    //   this.form.video = event.target.files[0];
    // },
    async formSubmit(e) {
      this.validatForm();
      if (this.isFormValid) {
        this.loading = true;
        let self = this.$router;
        e.preventDefault();
        this.form.is_publish = this.form.is_publish;
        let formData = new FormData();
        formData.append("title", this.form.videoTitle);
        formData.append(
          "description",
          this.form.videoDescription
            .getData()
            .replaceAll("srcset", "src")
            .replaceAll(' 0w"', '"')
        );
        formData.append("video", this.form.video);
        formData.append("length", this.form.length);
        formData.append("is_publish", this.form.is_publish);
        formData.append("course_id", this.form.course_id);
        this.isUpdate ? formData.append("video_id", this.form.id) : "";
        if (!this.isUpdate) {
          const resp = await this.$store.dispatch(
            "admin/uploadVideo",
            formData
          );
          this.allVideos.videos = resp.videos;
          this.$Message.success("Video Uploaded success");

          this.form.videoTitle = "";
          this.form.videoDescription.setData("");
          this.form.video = "";
          this.form.videoTitle = "";
          this.form.length = "";
          this.loading = false;
        } else {
          axios
            .post("/api/admin/course/update-video/" + this.form.id, formData)
            .then((response) => {
              if (response.status == 200) {
                this.allVideos.videos = response.data.videos;
                this.$Message.success("Video Uploaded success");

                this.form.videoTitle = "";
                this.form.videoDescription.setData("");
                this.form.video = "";
                this.form.length = "";
                this.form.videoTitle = "";
                this.getCourseVideos();
                this.isUpdate = false;
              }
              this.loading = false;
            })
            .catch((error) => {
              return 404;
            });
        }
      }
    },
    getCourseVideos() {
      axios
        .get("/api/admin/getCourseVideos/" + this.form.course_id)
        .then((response) => {
          this.allVideos.videos = response.data.videos;
          this.allVideos.count = response.data.count;
          this.allVideos.haveVideos = response.data.haveVideos;
          this.allVideos.courseTitle = response.data.courseInfo["title"];
        })
        .catch((error) => {
          return "404";
        });
    },
    editVideo(i) {
      this.isUpdate = true;
      //   this.initEditor('#videoDescription','form.videoDescription',function(){})

      let video = this.allVideos.videos[i];

      this.form.id = video.id;
      this.form.videoTitle = video.title;
      this.form.length = video.length;
      this.form.video = video.url;
      this.form.videoDescription.setData(video.description);
      this.loadingUrl = video.url;
      this.form.is_publish = video.status ? "1" : "0";
      this.value1 = "2";
      this.loadVideo();
    },
    validatForm() {
      if (this.form.videoTitle !== "") {
        this.formValidation.videoTitle = true;
      } else {
        this.formValidation.videoTitle = false;
      }

      if (this.form.videoDescription.getData() !== "") {
        this.formValidation.videoDescription = true;
      } else {
        this.formValidation.videoDescription = false;
      }

      if (this.form.length !== "") {
        this.formValidation.length = true;
      } else {
        this.formValidation.length = false;
      }

      if (this.form.video !== "" || this.isUpdate) {
        this.formValidation.video = true;
      } else {
        this.formValidation.video = false;
      }
      for (const prob in this.formValidation) {
        if (Object.hasOwnProperty.call(this.formValidation, prob)) {
          const element = this.formValidation[prob];
          if (!element) {
            this.isFormValid = false;
            break;
          }
          this.isFormValid = true;
        }
      }
    },
    loadVideo() {
      if (this.isUpdate) {
        this.onLoad = this.loadingUrl;
        // if (this.$refs.videoPlayer) {
        //   this.$refs.videoPlayer.load();
        //   this.$refs.videoPlayer.play();
        // }
      }
    },
  },
};
</script>
