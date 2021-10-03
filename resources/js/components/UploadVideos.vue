<style>
    .ivu-card {
        background-color: rgb(81 90 110) !important;
        color: #FFF;
    }
    .ivu-card-head p{
        color: rgb(255 255 255 / 70%) !important;
        transition: all 0.3s ease-in-out;   
        cursor: pointer;
    }
        .ivu-card-head p:hover {
        color:#FFF !important;
    }
    .ivu-col-span-6 {
        padding:2px !important;
    }
    .ivu-card-body {
    padding: 0 !important;
}

</style>
<template>
  <Collapse v-model="value1">
    <Panel name="1"   v-if="allVideos.haveVideos">
        video list ({{allVideos.count}})
        <strong class="float-right" :style="{paddingRight:'15px'}">{{allVideos.courseTitle}}</strong>
      <Row  :gutter="16" slot="content">
          <Col span="6" class="video-list" v-for="(video , index) in allVideos.videos" :key=index>
            <Card :bordered="false">
                <p slot="title">{{video.title}}</p>
            </Card>
        </Col>
      </Row>

    </Panel>
        <Panel name="1" v-model="value1"  v-else>
        video list
      <h1 slot="content" class="text-center" >Oh no videos for this course   😢</h1>

    </Panel>
    <Panel name="2" >
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
            <Button
              :style="{ float: 'right' }"
              type="info"
              ghost
              :loading="loading"
              @click="formSubmit"
            >
              <span v-if="!loading">Upload</span>
              <span v-else>Uploading...</span>
            </Button>
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
      value1: "1",
      loading:false,
      allVideos:{
         videos:"",
         count:0,
         haveVideos:false,
         courseTitle:"",
      }
    };
  },
  created() {
    this.getCourseId();
    this.getCourseVideos()
    // console.log('zzzzz',this.allVideos);
  },
  methods: {
    getCourseId() {
      this.form.course_id = this.$router.currentRoute.params.data;
    },
    uploadCoverImage(event) {
      this.form.coverImage = event.target.files[0];
    },
    uploadvideo(event) {
      this.form.video = event.target.files[0];
    },
    formSubmit(e) {
        this.loading = true;
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
            this.$Message.success("Video Uploaded success");

            this.form.videoTitle = "";
            this.form.videoDescription = "";
            this.form.video = "";
            this.form.videoTitle = "";
          }
            this.loading = false;

        })
        .catch((error) => {
          return 404;
        });
    },
    getCourseVideos(){
        console.log(this.form.course_id);
              axios
        .get("/admin/getCourseVideos/"+ this.form.course_id)
        .then((response) => {
            this.allVideos.videos = response.data.videos
            this.allVideos.count  = response.data.count
            this.allVideos.haveVideos  = response.data.haveVideos
            this.allVideos.courseTitle  = response.data.courseInfo['title']
            console.log(this.allVideos);
        })
        .catch((error) => {
          return '404';
        });
    }
  },
};
</script>
