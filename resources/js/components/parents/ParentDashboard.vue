<style scoped>
/* video::-webkit-media-controls-timeline {
    display: none;
} */

   /* video::-webkit-media-controls-download-button {
    display:none;
   } */
.layout {
  border: 1px solid #d7dde4;
  background: #f5f7f9;
  position: relative;
  border-radius: 4px;
  overflow: hidden;
}
.layout-header-bar {
  background: #fff;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
}
.menu-item span {
  display: inline-block;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  vertical-align: bottom;
  transition: width 0.2s ease 0.2s;
}
.menu-item i {
  transform: translateX(0px);
  transition: font-size 0.2s ease, transform 0.2s ease;
  vertical-align: middle;
  font-size: 16px;
}
.collapsed-menu span {
  width: 0px;
  transition: width 0.2s ease;
}
.collapsed-menu i {
  transform: translateX(5px);
  transition: font-size 0.2s ease 0.2s, transform 0.2s ease 0.2s;
  vertical-align: middle;
  font-size: 22px;
}
</style>
<template>
  <div class="layout">
    <Layout>
      <Sider
        breakpoint="md"
        collapsible
        :collapsed-width="78"
        v-model="isCollapsed"
      >
        <Menu
          active-name="1-2"
          theme="dark"
          width="auto"
          :class="menuitemClasses"
          v-if="courses"
        >
         <h3
            :style="{color:'#FFFF',
            padding:'15px',
            textAlign:'center',
            backgroundColor:'#181e2aab',
            borderRadius:'5px',
            }"
         >All Courses</h3>
          <MenuItem v-for="(course, i) in courses" :key="i" name="1-1">
            <span v-on:click="getCourseVideos(i)">{{
              course.courseTitle
            }}</span>
            <Divider />
          </MenuItem>
        </Menu>
        <div slot="trigger"></div>
      </Sider>
      <Layout>
        <Header class="layout-header-bar"> </Header>
        <Content
          v-if="videos"
          :style="{ margin: '20px', background: '#fff', minHeight: '220px' }"
        >
          <Row>
            <Col
              span="24"
              style="text-align: center; background-color: #ebebeb"
            >
              <!-- <div
                @click="playVideo(i)"
                style="background-color: blue; margin-top: 5px; color: #fff"
              >
                {{ video.id }}
              </div> -->
              <carousel
                :per-page="1"
                :loop="true"
                :autoplay="true"
                :minSwipeDistance="12"
                :paginationPadding="5"
                paginationColor="#0000004a"
                :perPage="3"
              >
                <slide v-for="(video, i) in videos" :key="i">
                  <img
                    :src="'storage/images/courseCoverImg/' + video.cover_image"
                    alt=""
                    :style="{ width: '150px', height: '150px' }"
                    @click="playVideo(i)"
                  />
                  <p>{{video.title}}</p>
                </slide>
              </carousel>
            </Col>
          </Row>
          <Row>
            <Col span="24" style="text-align: center">
              <div class="player-container">
                <!-- <vue-core-video-player :src="currentVideo.url"></vue-core-video-player> -->
                <video
                    :poster="currentVideo.coverImage"
                  id="videoo"
                  controls
                  preload="none"
                  :style="{ maxWidth: '700px', width: '100%', height: 'auto' }"
                >
                </video>
              </div>
            </Col>
          </Row>
        </Content>
      </Layout>
    </Layout>
  </div>
</template>
<script>
export default {
  created() {
    this.getCourses();

  },
  data() {
    return {
      isCollapsed: false,
      courses: [],
      videos: [],
      currentVideo: {
        url: "",
        coverImage: "",
        description: "",
      },
      value2: 0,
      url: "",
    };
  },
  methods: {
    getCourses() {
      try {
        axios({
          method: "get",
          url: "/parent/all-courses",
        }).then((resp) => {
          if (resp.status == 200) {
            this.courses = resp.data.courses;
          }
        });
      } catch (e) {
        return e.response;
      }
    },
    getCourseVideos(i) {
      this.videos = this.courses[i].videos;
      this.currentVideo.url =
        "storage/videos/promoVideo/" + this.courses[i].promo_video; //window.location.host +"/storage/videos/courseVideos/"+this.videos[i].url;
       this.currentVideo.coverImage =
        "storage/images/videoCoverImgs/" + this.courses[i].cover_photo;
      if (document.getElementById("videoo")) {

        let vid = document.getElementById("videoo");
        // vid.controlBar.progressControl.disable();
        console.log(vid)
        vid.src = this.currentVideo.url;
        if (vid) {
        //   vid
        //     .play()
        //     .then(function () {
        //       console.log("played!");
        //     })
        //     .catch(function (error) {
        //       console.log("did not play.");
        //       console.log(error);
        //     });
        }
      }
    },
    playVideo(i) {
      this.currentVideo.url =
        "storage/videos/courseVideos/" + this.videos[i].url; //window.location.host +"/storage/videos/courseVideos/"+this.videos[i].url;
      this.currentVideo.coverImage = this.videos[i].cover_image;
      this.currentVideo.description = this.videos[i].description;
      if (document.getElementById("videoo")) {
        let vid = document.getElementById("videoo");
        vid.src = this.currentVideo.url;
        if (vid) {
          vid
            .play()
            .then(function () {
              console.log("played!");
            })
            .catch(function (error) {
              console.log("did not play.");
              console.log(error);
            });
        }
      }
    },
  },
  computed: {
    menuitemClasses: function () {
      return ["menu-item", this.isCollapsed ? "collapsed-menu" : ""];
    },
  },
};
</script>
