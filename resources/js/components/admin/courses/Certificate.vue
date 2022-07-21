<style>
.logos-remove {
  /* opacity: 0.7; */
  padding: 0 2px;
  background: #ff002fbf;
  color: #fff;
  cursor: pointer;
  z-index: 99;
  width: 45%;
  margin: auto;
  text-align: center;
  border-radius: 5px;
}
.img-wrapper {
  display: flex;
  flex-direction: column-reverse;
}
.logo-card {
  display: flex;
  flex-wrap: wrap;
  align-items: flex-start;
  flex-direction: row;
  max-height: 100vh;
}
.logo-card img {
  position: relative;
  margin: 10px;
  box-shadow: 3px 3px 8px 0px rgba(0, 0, 0, 0.3);
  height: 120px;
  width: 120px;
}
input[type="file"] {
  padding: 10px;
  background: #2d2d2d;
}
.content-container {
  /* display: flex; */
  padding: 2em;
}
.cont-wrapper {
  background-color: #fff;
  list-style-type: none;
  padding: 0 14px;
  border-radius: 3px;
  margin: auto;
  max-width: 75%;
}
.wrapper-row {
  display: flex;
  padding: 0.5em;
}
.wrapper-row-cke {
  display: block;
}
.wrapper-row-cke textarea {
  min-height: 50vh;
}
.wrapper-row > label {
  padding: 0.5em 1em 0.5em 0;
}
.wrapper-row > input {
  flex: 2;

  padding: 0.5em 1em 0.5em 0;
}
</style>
<template>
  <div class="content-container">
    <form @submit="formSubmit" enctype="multipart/form-data">
      <ul class="cont-wrapper">
        <li class="wrapper-row">
          <input
            name=""
            placeholder="عنوان الدورة"
            v-model="course_title"
            disabled
            required
          />
        </li>
        <li class="wrapper-row">
          <input
            name=""
            placeholder="مدة الدورة"
            v-model="course_length"
            disabled
          />
        </li>
        <div class="logo-card">
          <div class="img-wrapper" v-for="(logo, index) in logos" :key="index">
            <span class="logos-remove" @click="removeLogo(logo, index)"
              >حذف</span
            >
            <img :src="logo.url" alt="" />
          </div>
        </div>

        <li class="wrapper-row">
          <label for=""> اضف شعارات اخرى :</label>
          <input name="coverImage" type="file" @change="uploadCoverImage" />
          <!-- <input type='file' @change="readURL" /> -->
        </li>

        <li class="wrapper-row">
          <input class="ivu-btn ivu-btn-info" type="submit" value="حفظ" />
        </li>
      </ul>
    </form>
  </div>
</template>

<script>
export default {
  async created() {
    this.course_id = this.$router.currentRoute.params.data;
    if (this.course_id) {
      this.getData();
    }
  },
  data() {
    return {
      course_id: [],

      logos: null,
      course_title: null,
      course_length: null,
      uploaded_logos: null,
    };
  },

  methods: {
    async getData() {
      const resp = await this.callApi(
        "get",
        "/api/admin/course-certificate/" + this.course_id
      ).then((res) => {
        this.course_title = res.data.course_title;
        this.course_length = res.data.length;
        this.logos = res.data.logos;
      });
    },
    async removeLogo($logo, index) {
      const resp = await this.callApi(
        "post",
        "/api/admin/delete-certificate",
        $logo
      ).then((res) => {
        if (res.status == 200) {
          setTimeout(() => {

            this.$Message.success("تم الحذف ");
            this.logos.splice(index, 11)
          }, 1500);
        }
      });
      console.log(index);
    },

    uploadCoverImage(event) {
      console.log(event.target.files);

      this.uploaded_logos = event.target.files[0];
    },

    async formSubmit(e) {
      e.preventDefault();

      let Obj = new FormData();
      Obj.append("logos", this.uploaded_logos);
      Obj.append("course_id", this.course_id);

      let resp = await this.$store
        .dispatch("admin/createUpdateCertificate", Obj)
        .then((res) => {
          if (res.status == 200) {
            this.logos = res.data;
          }
        });
    },
  },
  mounted() {},
};
</script>

