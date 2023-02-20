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
.media-cover-container h2 {
  text-align: right;
  margin: 20px 7px;
}
</style>
<template>
  <div class="media-cover-container">
    <div class="media-conver-img">
      <h2>الشركاء - تعديل</h2>

      <img :src="mediaCover" alt="asd" />
    </div>
    <form @submit="formSubmit" enctype="multipart/form-data">
      <div class="media-cover-wrapper">
        <Button type="info" to="/admin/partners">رجوع</Button>

        <label for="title">الأسم : </label>
        <input id="title" type="text" v-model="title" />

        <label for="title">الحالة : </label>
        <div class="row">
          <input type="radio" id="one" value="1" v-model="status" />
          <label for="one">نشر</label>
          <input type="radio" id="two" value="0" v-model="status" />
          <label for="two">غير منشور</label>
        </div>

        <label for="upload"> تحميل صورة جديدة : </label>
        <input id="upload" type="file" @change="uploadCoverImage" />
        <input type="submit" value="حفظ" />
      </div>
    </form>
  </div>
</template>
<script>
export default {
  mounted() {
    this.callApi(
      "get",
      "/api/admin/update-partner/" + this.$route.params.data
    ).then((res) => {
      if (res.status == 200) {
        this.title = res.data.title;
        this.id = res.data.id;
        this.mediaCover = res.data.image;
        // this.status = res.data.status;
        this.status = res.data.status =="1" ? "1" : "0";
        console.log(this.title, res.data.status, this.mediaCover);
      }
    });
  },
  updated() {},
  data() {
    return {
      id: "",
      title: "",
      status: "",
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
        formData.append("status", this.status);
      formData.append("coverImage", this.coverImage);

      this.$store.dispatch("admin/updatePartner", formData).then((res) => {
        console.log(res.data.status);
        this.mediaCover = res.data.image;
        this.status = res.data.status=="1" ? "1" : "0"
        this.title = res.data.title;
        this.$Message.success("تم تعديل الشركاء  ");
      });
    },
  },
};
</script>
