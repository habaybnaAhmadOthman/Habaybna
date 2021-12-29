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
.ck p {
  display: block !important;
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
    <div :style="{display:'inline-block', width:'100%'}">
      <Button  type="info" :style="{float:'left'}" ghost to="/admin/courses">
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
      <Panel name="2">
        أضف حلقة
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
              </div>
              <div class="form-group">
                <strong>وصف الحلقة</strong>
                <ckeditor
                  :editor="form.editor"
                  v-model="form.videoDescription"
                  :config="form.editorConfig"
                ></ckeditor>
              </div>
              <!-- <div class="form-group">
              <strong>Video cover photo:</strong>
              <input
                name="coverImage"
                type="file"
                class="form-control"
                @change="uploadCoverImage"
              />
            </div> -->
              <div class="form-group">
                <strong>تحميل فيديو الحلقة</strong>
                <input
                  name="video"
                  type="file"
                  class="cdk-ed form-control"
                  @change="uploadvideo"
                />
              </div>
              <div class="form-group">
                <RadioGroup v-model="form.is_publish" vertical>
                  <Radio label="true">
                    <span>نشر</span>
                  </Radio>
                  <Radio label="false">
                    <span>عدم النشر</span>
                  </Radio>
                </RadioGroup>
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
      </Panel>
    </Collapse>
  </div>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  data() {
    return {
      form: {
        id: "",
        videoTitle: "",
        videoDescription: "",
        editor: ClassicEditor,
        editorConfig: {
          enterMode: "br",
        },
        // coverImage: "",
        video: "",
        is_publish: "true",
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
    };
  },
  created() {
    this.getCourseId();
    this.getCourseVideos();
    // console.log('zzzzz',this.allVideos);
  },
  methods: {
    getCourseId() {
      this.form.course_id = this.$router.currentRoute.params.data;
    },
    // uploadCoverImage(event) {
    //   this.form.coverImage = event.target.files[0];
    // },
    uploadvideo(event) {
      this.form.video = event.target.files[0];
    },
    async formSubmit(e) {
      this.loading = true;
      let self = this.$router;
      e.preventDefault();
      this.form.is_publish = Boolean(this.form.is_publish);
      console.log("type", typeof this.form.is_publish);
      let formData = new FormData();
      formData.append("title", this.form.videoTitle);
      formData.append("description", this.form.videoDescription);
      //   formData.append("coverImage", this.form.coverImage);
      formData.append("video", this.form.video);
      formData.append("is_publish", this.form.is_publish);
      formData.append("course_id", this.form.course_id);
      this.isUpdate ? formData.append("video_id", this.form.id) : "";
      //   const config = {
      //     headers: {
      //       "content-type": "multipart/form-data",
      //       Accept: "application/json",
      //     },
      //   };
      console.log("form data", this.form.is_publish);
      if (!this.isUpdate) {
        // alert("add");
        const resp = await this.$store.dispatch("admin/uploadVideo", formData);
        console.log(resp);
        this.allVideos.videos = resp.videos;
        this.$Message.success("Video Uploaded success");

        this.form.videoTitle = "";
        this.form.videoDescription = "";
        this.form.video = "";
        this.form.videoTitle = "";
        this.loading = false;

        // axios
        //   .post("/admin/course/upload-video", formData)
        //   .then((response) => {
        //     if (response.status == 200) {
        //       this.allVideos.videos = response.data.videos;
        //       this.$Message.success("Video Uploaded success");

        //       this.form.videoTitle = "";
        //       this.form.videoDescription = "";
        //       this.form.video = "";
        //       this.form.videoTitle = "";
        //     }
        //     this.loading = false;
        //   })
        //   .catch((error) => {
        //     return 404;
        //   });
      } else {
        axios
          .post("/admin/course/update-video/" + this.form.id, formData)
          .then((response) => {
            if (response.status == 200) {
              this.allVideos.videos = response.data.videos;
              this.$Message.success("Video Uploaded success");

              this.form.videoTitle = "";
              this.form.videoDescription = "";
              this.form.video = "";
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
    },
    getCourseVideos() {
      console.log(this.form.course_id);
      axios
        .get("/api/admin/getCourseVideos/" + this.form.course_id)
        .then((response) => {
          this.allVideos.videos = response.data.videos;
          this.allVideos.count = response.data.count;
          this.allVideos.haveVideos = response.data.haveVideos;
          this.allVideos.courseTitle = response.data.courseInfo["title"];
          console.log(this.allVideos);
        })
        .catch((error) => {
          return "404";
        });
    },
    editVideo(i) {
      let video = this.allVideos.videos[i];
      console.log(video);
      this.form.id = video.id;
      this.form.videoTitle = video.title;
      this.form.videoDescription = video.description;
      this.form.is_publish = video.status;
      this.value1 = "2";
      this.isUpdate = true;
    },
  },
};
</script>
