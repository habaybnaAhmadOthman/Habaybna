<style scoped>
/* video::-webkit-media-controls-timeline {
    display: none;
} */

/* video::-webkit-media-controls-download-button {
    display:none;
   } */
/* .ivu-row {
       margin: 0 !important;
   } */
/* .layout {
  border: 1px solid #d7dde4; */
/* background: #f5f7f9; */
/* position: relative;
  border-radius: 4px;
  overflow: hidden;
  direction: rtl;
} */
.card-img-top {
  max-height: 100px;
}
.courses {
  cursor: pointer;
  margin: 5px 0 !important;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
}
.logout {
  position: absolute;
  top: 20px;
  right: 22px;
}
.nav-p {
  height: auto;
  padding: 10px;
  transition: all 0.3s ease-in-out;
  background-color: #2949a2f5;

  opacity: 0.2;
}
.nav-p:hover {
  opacity: 1;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  opacity: 0.8;
}
.logout-btn {
  border: none;
  color: #fff;
  font-size: 20px;
  transition: all 0.3s;
  background: none;
  opacity: 1;
}
.logout-btn:hover {
  color: #fff;
  opacity: 1;
}
/* .layout-header-bar { */
/* background: #fff; */
/* background-color: rgba(0, 0, 0, 0);
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  height: auto !important;
  padding: 0;
  line-height: 50px !important;
} */
/* .content-course {
  padding: 10px;
  margin-bottom: 50px;
} */
/* .wrapper-courses {
  margin: auto 15px;
  display: flex;
} */
/* .layout-course {
  align-items: center;
  background-color: rgba(0, 0, 0, 0);
  display: inline-block;
  width: 100%;
} */
.banner {
  background-image: url(/images/siteImgs/home-banner.jpg);
  height: 450px;
  background-size: cover;
  background-position: top;
  margin: 0 0 !important;
  opacity: 0.8;
  position: relative;
}
</style>
<template>
  <!-- <Layout>
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
            :style="{
              color: '#FFFF',
              padding: '15px',
              textAlign: 'center',
              backgroundColor: '#181e2aab',
              borderRadius: '5px',
            }"
          >
            All Courses
          </h3>
          <MenuItem v-for="(course, i) in courses" :key="i" name="1-1">
            <span v-on:click="getCourseVideos(i)">{{
              course.courseTitle
            }}</span>
            <Divider />
          </MenuItem>
        </Menu>
        <div slot="trigger"></div>
      </Sider> -->
  <!-- <Header class="layout-header-bar"> -->
  <!-- <Button type="warning" :style="{ float: 'right' }" @click="logoutUser()"> -->
  <div class="container">

    <div class="row banner">
      <button class="btn btn-primary logout" @click="logoutUser()">
        Logout
      </button>
    </div>
    <div class="row">
      <Divider orientation="left"> <h3>Discover our new courses</h3> </Divider>
    </div>
    <div class="row">
      <div
        class="col courses"
        v-for="(course, i) in courses"
        :key="i"
        @click="getCourseVideos(i)"
      >
        <div class="card" style="width: 18rem">
          <img
            class="card-img-top"
            :src="`storage/images/courseCoverImg/${course.cover_photo}`"
            alt="..."
          />
          <div class="card-body">
            <a :href="`/parent-dashboard/class-room/${course.id}`">
              <h5 class="card-title">{{ course.courseTitle }}</h5>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- </Header> -->

  <!-- <Content class="content-course">
        <Col span="6">
          <div class="wrapper-courses"> -->
  <!-- <Row :gutter="8">
      <Col span="4" v-for="(course, i) in courses" :key="i">
            <div :style="{ textAlign: 'center', padding: '15px', overflow:'hidden' }">
              <img
                :style="{ width: '190px', height:'150px' }"
                :src="`storage/images/courseCoverImg/${course.cover_photo}`"
              />
              <h3>{{ course.courseTitle }}</h3>
            </div>
      </Col>
    </Row> -->

  <!-- </div>
        </Col>
      </Content> -->

  <!-- </Layout> -->
</template>
<script>
export default {
    template:`



    `,
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
      console.log("XXXXXXXXX");
      this.videos = this.courses[i].videos;
      this.currentVideo.url =
        "storage/videos/promoVideo/" + this.courses[i].promo_video; //window.location.host +"/storage/videos/courseVideos/"+this.videos[i].url;
      this.currentVideo.coverImage =
        "storage/images/videoCoverImgs/" + this.courses[i].cover_photo;
      if (document.getElementById("videoo")) {
        let vid = document.getElementById("videoo");
        // vid.controlBar.progressControl.disable();
        console.log(vid);
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
    logoutUser() {
      axios({
        method: "post",
        url: "logoutt",
      }).then((resp) => {
        if (resp.status == 200) {
            location.href='/'
}
      });
    },
  },
  computed: {
    menuitemClasses: function () {
      return ["menu-item", this.isCollapsed ? "collapsed-menu" : ""];
    },
  },
};
</script>
