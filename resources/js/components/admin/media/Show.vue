<style>
.media-cover-container {
  display: flex;
  border: 1px solid;
  min-height: 100vh;
      justify-content: space-around;

  /* flex-direction: column; */
}
.media-conver-img {
  /* min-height: 500px;
  min-width: 600px; */
  flex-direction: column;
  min-height: 20vh;
}
.media-conver-img img {
  /* max-width: 600px !important;*/
  max-height: 60vh !important;
  /* margin: auto; */
  /* flex-grow: 1; */
}
.media-cover-wrapper {
  display: flex;
  flex-direction: column;
  /* justify-content: center; */
  padding: 0 16px;
  margin: 7px;
}
.media-cover-wrapper input {
  margin: 10px;
  padding: 7px;
}
.media-cover-wrapper label {
  text-align: right;
}
.media-cover-container h2{
   text-align: right;
   margin: 20px 7px;
}
</style>
<template>
  <div class="media-cover-container">
    <div class="media-conver-img">
    <h2>التغطية الاعلامية - تعديل</h2>

      <img :src="mediaCover" alt="asd" />
    </div>
    <form @submit="formSubmit" enctype="multipart/form-data">
      <div class="media-cover-wrapper">
        <Button type="info" to="/admin/media">رجوع</Button>

        <label for="title">العنوان : </label>
        <input id="title" type="text" v-model="title" />
        <label for="url"> رابط التغطية : </label>
        <input id="url" type="text" v-model="url" />
        <label for="upload"> تحميل صورة جديدة : </label>
        <input
          id="upload"
          type="file"
          @change="uploadCoverImage"
        />
        <input type="submit" value="حفظ" />
      </div>
    </form>
  </div>
</template>
<script>
export default {
  created() {
    this.callApi(
      "get",
      "/api/admin/update-media/" + this.$route.params.data
    ).then((res) => {
      if (res.status == 200) {
        this.title = res.data.title;
        this.id = res.data.id;
        this.mediaCover = res.data.image;
        this.url = res.data.url;
        // this.status = res.data.status ? "1" : "0";
        console.log(this.title, this.id, this.url);
      }
    });
  },
  updated() {},
  data() {
    return {
      id: "",
      title: "",
      url: "",
      coverImage: "",
      mediaCover: "",
    };
  },
  methods: {
    uploadCoverImage(event) {
      this.coverImage = event.target.files[0];
    },
    formSubmit(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("id", this.id);
      formData.append("title", this.title);
      formData.append("url", this.url);
      formData.append("coverImage", this.coverImage);

      this.$store.dispatch("admin/updateMediaCover", formData).then((res) => {
          console.log(res);
       this.mediaCover = res.data.image
        this.url = res.data.url
        this.title = res.data.title
        this.$Message.success("تم تعديل التغطية  ");
      });
    },
  },
};
</script>
