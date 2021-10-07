<style scoped>
.logout {
  position: absolute;
  top: 20px;
  right: 22px;
}
ol {
    width: 100% !important;
}
#videoo {
  max-height: 100%;
  max-width: 100%;
}
.hideVideo {
  display: block;
  z-index: 999;
  margin-top: 10px;
  margin-left: 10px;
}

.banner {
  height: 450px;
  background-size: cover;
  background-position: top;
  margin: 0 0 !important;
  opacity: 0.8;
  padding: 7%;
  /*position: relative; */
}
#learn-wrapper p {
    width: 100% !important;
}
.wrapper {
  max-width: 52.2%;
  max-height: 95.3%;
}
.title-wrapper {
  width: 100%;
  direction: rtl;
  background-color: #80808080;
  color: #fff;
  font-size: 33px;
  font-weight: bold;
  margin: 1.5% 0;
}

li {
  cursor: pointer;
  padding: 4px 0 !important;
  transition: all 0.1s ease-in-out;
}
ul {
  text-align: right;
  list-style-type: arabic-indic;
  width: 50%;
  color: rgb(255, 255, 255);
  font-size: 17px;
  font-weight: 700;
  padding: 10px;
}
.lessons:hover {
  color: #fff;
  background-color: #0000005c;
  border-radius: 5px;
}
.disc-wrapper p {
  width: 100% !important;
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
    <div
      class="row banner d-flex justify-content-center"
      id="banner"
      :style="{ backgroundImage: img }"
    >
      <button class="btn btn-primary logout" @click="logoutUser()">
        Logout
      </button>
      <div class="wrapper d-flex justify-content-center">
        <video hidden id="hiddenVideo">
          <source src="" type="video/mp4" />
          <source src="" type="video/ogg" />
        </video>
        <video
          class="video-js"
          data-setup="{}"
          id="videoo"
          controls
          @play="play"
          @ended="onEnd()"
          :src="currentVideo.url"
        >
          <source src="" type="video/mp4" />
          <source src="" type="video/ogg" />
          Your browser does not support the video tag.
          <source type="video/mp4" :src="currentVideo.url" />
        </video>
      </div>
      <div
        class="row d-flex justify-content-center title-wrapper"
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
      <ul>
        <li
          @click="loadCurrentVideo(index)"
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
      console.log('xxxxxxzzzzz');
    // this.getLessonDouration();
  },
  mounted(){
      console.log('xxxxxxx');
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
      courseId: null,
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

          this.currentVideo.url = this.promoVideo;
          this.currentVideo.title = this.title;
          this.currentVideo.description = this.courseDescription;

          //   console.log('current=>',this.currentVideo);
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
    loadCurrentVideo(i) {
      let video = this.course.videos[i];

      if (typeof video !== "undefined") {
        this.currentVideo.url = "/storage/videos/courseVideos/" + video.url;
        this.currentVideo.title = video.title;
        this.currentVideo.description = video.description;
        window.scroll({top: 0, behavior: "smooth"})
        console.log("xxxxxx");
      }
    },
    getLessonDouration() {
    //   var trackDuration = new Array();

    //   var audioPlaylist = document.getElementById("hiddenVideo");
    //   // audioPlaylist.preload = "metadata";
    //   var arraySize = this.course.videos.length;

    //   for (let i = 0; i < arraySize; i++) {
    //     audioPlaylist.src = "/storage/videos/courseVideos/" + this.course.videos[i].url;
    //     console.log(audioPlaylist.src);
    //     audioPlaylist.addEventListener("loadedmetadata", function (e) {
    //         console.log(e.target.src);
    //         trackDuration.push(audioPlaylist.duration)
    //     });

    //     // trackDuration.push(duration)
    //   }

    //   console.log("xxx", trackDuration);

      //   let videos = this.course.videos;
      //   let player = document.getElementById("hiddenVideo");
      //   if (player) {
      //     let videoDurations = [];
      //     videos.forEach((v, index) => {
      //       console.log(index,v.url);
      //       player.src = "/storage/videos/courseVideos/" + v.url;
      //       player.addEventListener("loadedmetadata", function (e) {
      //           console.log('xxxxxx');
      //           console.log(e.target.src);

      //             // console.log(player.duration);
      //           var duration = new Date(player.duration * 1000).toISOString().substr(14, 5)
      //         //   console.log(duration);
      //       });
      //             // videoDurations.push(duration)

      //     });
      //     // console.log(videoDurations);
      //   }

      //   let d = document.getElementsByClassName("lessons");

      //   videos.forEach((element, index) => {
      //     let v = "/storage/videos/courseVideos/" + element.url;
      //     if (document.getElementById("videoo")) {
      //       let vid = document.getElementById("videoo");
      //       vid.src = v;
      //       vid.addEventListener("loadedmetadata", function () {
      //         for (var i = 0; i < d.length; i++) {
      //           // var elem = subDiv[i];
      //           // if(elem.id.indexOf(elementsId) === 0) {
      //           //     myArray.push(elem.id);
      //           if (index == i)
      //             d[i].getElementsByTagName("p")[0].innerHTML = (
      //               vid.duration / 60
      //             ).toFixed(2);
      //         }
      //         //    }
      //       });
      //     }
      //   });
    },
    play(){
        console.log('play');
    },
    onEnd(){
        console.log('ended Api');
    },
    playVideo(i) {
      this.currentVideo.url =
        "/storage/videos/courseVideos/" + this.course.videos[i].url; //window.location.host +"/storage/videos/courseVideos/"+this.videos[i].url;
      this.currentVideo.description = this.course.videos[i].description;
      if (document.getElementById("videoo")) {
        let vid = document.getElementById("videoo");
        vid.src = this.currentVideo.url;
        document.documentElement.scrollTop = 0
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

