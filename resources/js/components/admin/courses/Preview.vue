<style>
.admin-class-room {
  margin: 0;
  padding: 0;
  text-align: center;
}
.admin-class-room-banner {
  width: 100%;
  min-height: 170px;
  border-radius: 4px;
}
.admin-class-room-banner img {
  width: 100%;
  height: 170px;
}
.banner-promo-video {
  text-align: center;
  margin-top: 10px;
}
.banner-promo-video video {
  width: 90%;
  height: 300px;
}
.course-title {
  text-align: right;
  flex: 40%;
}
.course-title p {
  font-size: 27px;
}
.course-title li {
  margin: 0px 5px;
  background: #9c27b0;
  padding: 0 3px;
  border-radius: 4px;
  color: #fff;
  font-size: 13px;
}
.course-info {
  display: flex;
  padding: 7px 16px;
  margin-top: 17px;
  border: 1px solid #cdc6c6;
  text-align: center;
  border-radius: 4px;
  align-items: center;
}
.provider-card img {
  width: 40px;
  border-radius: 50%;
  height: 40px;
}
.provider-card p {
  font-size: 16px;
}
.provider-card li {
  margin: 5px;
}
.provider-card {
  text-align: center;
  flex: 40%;
}
.other-info {
  text-align: right;
  /* padding: 0 45px; */
  flex: 20%;
}
.course-info ul {
  display: flex;
}
.course-content {
  display: flex;
}
.course-desc-all {
  flex: 70;
}
.course-desc {
  margin: 15px 0;
  text-align: right;
  padding: 7px 16px;
}
.course-desc p {
  padding: 0px 12px;
}
.course-videos {
  flex: 30;
  margin: 15px 0;
  text-align: right;
  padding: 7px 16px;
  border-radius: 5px;
}
.course-videos ul {
  padding: 4px 10px;
}
.video-length {
  display: flex;
  justify-content: space-between;
  background: #e5e5e5;
  padding: 2px 5px;
  margin: 2px 0;
  border-radius: 5px;
  transition: all 0.4s;
}
.video-length:hover {
  cursor: pointer;
  background-color: #4b00829e;
  color: #fff;
}
</style>
<template>
  <div v-if="courseInfo" class="admin-class-room">
    <div class="admin-class-room-banner">
      <div class="banner-cover-image">
        <img :src="courseInfo ? courseInfo.cover_photo : ''" alt="" />
      </div>
      <div class="banner-promo-video">
        <video ref="videoPlayer" controls>
          <source :src="onLoad ? onLoad : ''" type="video/mp4" />
          <source src="movie.ogg" type="video/ogg" />
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
    <div class="course-info">
      <div class="course-title">
        <p>
          {{ courseInfo.title }}
        </p>
        <ul v-if="categories">
          <li v-for="(category, index) in categories" :key="index">
            <span>
              {{ category.title }}
            </span>
          </li>
        </ul>
      </div>
      <div class="provider-card">
        <ul v-if="courseProviders">
          <li v-for="(provider, index) in courseProviders" :key="index">
            <img :src="provider.avatar" alt="" />
            <p>{{ provider.firstName }}</p>
            <p>{{ provider.specialization }}</p>
          </li>
        </ul>
      </div>
      <div class="other-info">
        <p>سعر الدورة : {{ courseInfo.price }} د.أ</p>
        <p>
          حالة الدورة : {{ courseInfo.is_publish ? "منشورة" : "غير منشورة" }}
        </p>
        <p>نوع الدورة : {{ courseInfo.is_free ? "مجانية" : "مدفوعة" }}</p>
        <p>مدة الدورة : {{ courseInfo.duration }} ساعة</p>
        <p>عدد الدروس : {{ courseInfo.duration }} درس</p>
      </div>
    </div>
    <div class="course-content">
      <div class="course-desc-all">
        <div class="course-desc">
          <h4>وصف الدورة :</h4>
          <div v-html="courseInfo.description"></div>
        </div>
        <hr />
        <div class="course-desc">
          <h4>ماذا سوف نتعلم :</h4>
          <div v-html="courseInfo.what_we_learn"></div>
        </div>
      </div>
      <div v-if="videos.length > 0" class="course-videos">
        <h4>الدروس :</h4>
        <ul>
          <li
            v-for="(video, index) in videos"
            :key="index"
            class="video-length"
            v-on:click="playVideo(index)"
          >
            {{ video.title }} <span>{{ video.length }}</span>
          </li>
        </ul>
      </div>
      <div v-else class="course-videos">
        <h4>الدروس :</h4>
        <div :style="{ textAlign: 'center' }">
          <span :style="{ color: 'red', display: 'block',margin:'10px 0' }">
            لا يوجد دروس في هذه الدورة
          </span>
          <!-- <Button
            :to="'/admin/uploadVideos/' + coures_id ? course_id : ''"
            type="success"
            size="large"
          >
            اضف فيديو
          </Button> -->
          <!-- <a :href="'/job/' + r.id"> -->

        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  created() {
    this.course_id = this.$route.params.data;
    const resp = this.$store
      .dispatch("admin/previewCourse", this.course_id)
      .then((res) => {
        this.courseInfo = res.course.course_info;
        this.courseProviders = res.course.providers;
        this.categories = res.course.categories;
        this.videos = res.course.videos;
        this.onLoad = this.courseInfo.promo_video;
      });
  },
  data() {
    return {
      course_id: null,
      courseInfo: null,
      courseProviders: null,
      categories: null,
      onLoad: null,
    };
  },
  methods: {
    playVideo(index) {
      console.log(this.$refs.videoPlayer);
      this.onLoad = this.videos[index].url;
      this.$refs.videoPlayer.load();
      this.$refs.videoPlayer.play();
    },
  },
};
</script>
