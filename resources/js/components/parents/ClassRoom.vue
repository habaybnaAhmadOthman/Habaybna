<style scoped>

.logout {
  position: absolute;
  top: 20px;
  right: 22px;
}

.banner {
  height: 450px;
  background-size: cover;
  background-position: top;
  margin: 0 0 !important;
  opacity: 0.8;
  position: relative;
}
.video-wrapper {
  margin: auto 25px;
}
.title-wrapper {
  min-width: 30%;
}
.title-wrapper p {
  padding: 16px;
  direction: rtl;
  padding: 16px;
  font-size: 21px;
  font-weight: bold;
  color: #fff;
  background-color: #f85c4f33;
  border-radius: 15px;
}
p {
  text-align: center !important;
}
.lessons {
  cursor: pointer;
  padding: 7px 7px 7px 7px;
  text-align: right;
  transition: all 0.1s ease-in-out;
}
.lessons:hover {
  color: #fff;
  background-color: #0000005c;
  border-radius: 5px;
}
.disc-wrapper {
  font-size: 18px;
  margin: 10px auto;
  width: 100%;
  border: 2px solid #be269b7a;
  padding: 10px;
  border-radius: 10px;
  color: #fff;
  direction: rtl;
}
.disc-wrapper p {
  width: 100% !important;
}
#duration {
  float: left;
}
</style>
<template>
  <div class="container">
    <div class="row banner" id="banner" :style="{ backgroundImage: img }">
      <button class="btn btn-primary logout" @click="logoutUser()">
        Logout
      </button>
      <div class="video-wrapper">
        <video id="videoo" width="320" height="240" controls controlsList="nodownload">
          <source src="" type="video/mp4" />
          <source src="" type="video/ogg" />
          Your browser does not support the video tag.
        </video>
      </div>
      <div
        class="align-self-center title-wrapper"
        :style="{ direction: 'rtl' }"
      >
        <p>{{ title }}</p>
      </div>
    </div>
    <div class="row">
      <Divider orientation="right"> <h3>عن الدورة التدريبية</h3> </Divider>
    </div>
    <div class="row text-right disc-wrapper" v-html="courseDescription"></div>
    <div class="row">
      <Divider orientation="right">
        <h3>ماذا سنتعلم في هذا المساق</h3>
      </Divider>
    </div>
    <div
      class="row text-right disc-wrapper"
      id="learn-wrapper"
      v-html="whatWeLearn"
    ></div>
    <div class="row">
      <Divider orientation="right"> <h3>دروس المساق</h3> </Divider>
    </div>

    <div class="row" :style="{ direction: 'rtl', padding: '10px' }">
      <ul :style="{ listStyleType: 'none', width: '60%', color: '#fff' }">
        <li
          @click="playVideo(index)"
          class="lessons"
          v-for="(lesson, index) in course.videos"
          :key="index"
        >
          <p id="duration"></p>
          <div>{{ lesson.title }} <i class="fas fa-lock"></i></div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    var path = this.$router.currentRoute.path;
    var n = path.lastIndexOf("/");
    var course_id = path.substring(n + 1);
    this.getCourseVideos(course_id);
  },
  updated() {
    var learnWraper = document.getElementById("learn-wrapper");
    learnWraper.firstChild.style.width = "100%";
    learnWraper.getElementsByTagName("ol")[0].style.margin = "10px 20px";
    let video = document.getElementsByTagName("video")[0];
    this.getLessonDouration(this.course.videos);
    if (document.getElementById("videoo")) {
        console.log('xxxxxxxxxxxxxxx');
      let vid = document.getElementById("videoo");
      console.log('promo',this.promoVideo);
      vid.src = this.promoVideo;
        console.log('src', vid.scr);
    }
  },
  data() {
    return {
      haveVideos: false,
      count: 0,
      course: "",
      img: "",
      title: "",
      promoVideo: "",
      courseDescription: "",
      whatWeLearn: "",
      currentVideo: {
        url: "",
        title: "",
        description: "",
      },
    };
  },
  methods: {
    getCourseVideos(id) {
      axios
        .get("/parent/getCourseVideos/" + id)
        .then((response) => {
          this.count = response.data.count;
          this.haveVideos = response.data.haveVideos;
          this.course = response.data.course;
          this.title = response.data.course.courseTitle;
          this.courseDescription = response.data.course.courseDescription;
          this.whatWeLearn = response.data.course.whatWeLearn;
          this.promoVideo =
            "/storage/videos/promoVideo/" + response.data.course.promo_video;
          var bgimg =
            "/storage/images/courseCoverImg/" + this.course.cover_photo;

          this.img = "url('" + bgimg + "')";

          //   if (document.getElementById("videoo")) {
          //     let vid = document.getElementById("videoo");
          //     vid.src = this.promoVideo;
          //     if (vid) {
          //       vid
          //         .play()
          //         .then(function () {
          //           console.log("played!");
          //         })
          //         .catch(function (error) {
          //           console.log("did not play.");
          //           console.log(error);
          //         });
          //     }
          //   }
        })
        .catch((error) => {
          console.log();
          return "404";
        });
    },
    getLessonDouration(videos = []) {
      let d = document.getElementsByClassName("lessons");

      videos.forEach((element, index) => {
        let v = "/storage/videos/courseVideos/" + element.url;
        if (document.getElementById("videoo")) {
          let vid = document.getElementById("videoo");
          vid.src = v;
          vid.addEventListener("loadedmetadata", function () {
            for (var i = 0; i < d.length; i++) {
              // var elem = subDiv[i];
              // if(elem.id.indexOf(elementsId) === 0) {
              //     myArray.push(elem.id);
              if (index == i)
                d[i].getElementsByTagName("p")[0].innerHTML = (
                  vid.duration / 60
                ).toFixed(2);
            }
            //    }
          });
        }
      });
    },
    playVideo(i) {
      this.currentVideo.url =
        "/storage/videos/courseVideos/" + this.course.videos[i].url; //window.location.host +"/storage/videos/courseVideos/"+this.videos[i].url;
      this.currentVideo.description = this.course.videos[i].description;
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
};
</script>

