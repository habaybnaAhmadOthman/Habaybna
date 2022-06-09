<style>
.logos-remove {
    border: 1px solid gray;
    opacity: 0.7;
    position: absolute;
    right: 14px;
    top: 16px;
    padding: 0 2px;
    background: #ff002fbf;
    color: #FFF;
    cursor: not-allowed;
    z-index: 99;
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
  border: 3px solid #000;
  box-shadow: 3px 3px 8px 0px rgba(0, 0, 0, 0.3);
  max-width: 13vw;
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
  background-color: whitesmoke;
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
          <div style="position:relative" v-for="(logo, index) in logos" :key="index">
            <span class= "logos-remove">حذف</span>
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
    // readURL(event) {
    //     console.log(event.target.files);
    //   if (event.target.files && event.target.files) {
    //     var reader = new FileReader();

    //     reader.onload = function (e) {
    //       $("#blah").attr("src", e.target.result);
    //     };

    //     reader.readAsDataURL(event.target.files[0]);
    //   }
    // },
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

