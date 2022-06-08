<style>
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
.content-cover-image {
  align-items: flex-start;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}
</style>
<template>
  <div class="content-container">
    <form @submit="formSubmit" enctype="multipart/form-data">
      <ul class="cont-wrapper">
        <li class="wrapper-row title">
          <h2>تعديل المحتوى</h2>
          <Button
            :to="'/admin/content-new'"
            type="primary"
            size="large"
            ghost
            >رجوع</Button
          >
        </li>
        <li class="wrapper-row">
          <input
            name=""
            placeholder="عنوان المقال"
            v-model="form.title"
            required
          />
        </li>
        <li class="wrapper-row">
          <multiselect
            v-model="form.categories"
            :options="categories"
            :searchable="true"
            :close-on-select="false"
            :multiple="true"
            :taggable="true"
            label="title"
            track-by="title"
            placeholder="  يرجى إختيار فئة المقال"
            required
          ></multiselect>
        </li>
        <li class="wrapper-row">
          <div class="content-cover-image">
            <label for=""> صورة الغلاف :</label>
            <img :src="form.coverImage" alt="" />
            <input
              name="coverImage"
              type="file"
              @change="uploadCoverImage"
              :required="form.coverImage == '' ? true : false"
            />
          </div>
        </li>
        <li class="wrapper-row">
          <multiselect
            v-model="form.author"
            :options="authorsList"
            :searchable="true"
            :close-on-select="true"
            :taggable="true"
            label="firstName"
            track-by="firstName"
            placeholder="اختر كاتب للمقال"
            :multiple="false"
            required
          ></multiselect>
        </li>
        <li class="wrapper-row-cke">
          <textarea
            name=""
            id="courseDescription"
            cols="30"
            rows="10"
          ></textarea>
        </li>
        <li class="wrapper-row">
          <label for=""> هل تريد نشر المقال : </label>
          <label for="">
            <input type="radio" v-model="form.status" value="1" required />نعم
          </label>
          <label for="">
            <input type="radio" v-model="form.status" value="0" required />لا
          </label>
        </li>
        <li class="wrapper-row">
          <label for=""> تاريخ نشر المقال :</label>
          <span v-if="form.publishDate !== 'null'">
            {{ form.publishDate }}</span
          >
          <input type="date" v-model="form.publishDay" required />
        </li>
        <li class="wrapper-row">
          <input class="ivu-btn ivu-btn-info" type="submit" value="حفظ" />
        </li>
      </ul>
    </form>
  </div>
</template>

<script>
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import Editor from "ckeditor5-custom-build/build/ckeditor";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";
import initEditor from "../../../components/front/mixins/initEditor";
export default {
  components: { Multiselect },
  mixins: [initEditor],
  async created() {
    const resp = await this.callApi("get", "/api/admin/course-init-data");
    if (resp.status == 200) {
      this.categories = resp.data.categories;
      this.authorsList = resp.data.specialists;
    }
  },
  updated() {},
  data() {
    return {
      categories: [],
      authorsList: [],

      form: {
        id: null,
        coverImage: "",
        categories: [],
        author: null,
        title: null,
        publishDay: null,
        courseDescription: null,
        status: 0,
        video: null,
      },
    };
  },

  methods: {
    uploadCoverImage(event) {
      this.form.coverImage = event.target.files[0];
    },
    setDate(date) {
      var today = new Date(date);
      var dd = String(today.getDate()).padStart(2, "0");
      var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
      var yyyy = today.getFullYear();

      return (today = yyyy + "-" + mm + "-" + dd);
    },

    async formSubmit(e) {
      e.preventDefault();
      let tagIDs = [];
      this.form.categories.forEach((item) => tagIDs.push(item.id));

      let Obj = new FormData();
      Obj.append("id", this.form.id);
      Obj.append("title", this.form.title);
      Obj.append("image", this.form.coverImage);
      Obj.append("categories", tagIDs);
      Obj.append("author", this.form.author.user_id);
      Obj.append(
        "content",
        this.form.courseDescription
          .getData()
          .replaceAll("srcset", "src")
          .replaceAll(' 0w"', '"')
      );
      Obj.append("publishDate", this.form.publishDay);
      Obj.append("status", this.form.status);

      let resp = await this.$store;
      // .dispatch("admin/content-new/edit", Obj)
      // .then((res) => {
      //   if (res.status == 200) {
      //     this.$Message.success("تم تعديل المحتوى");
      //   }
      // });
      this.callApi("post", "/api/admin/content-new/edit", Obj).then((res) => {
        if (res.status == 200) {
          console.log(res);
          this.$Message.success("تم تعديل المحتوى");
        }
      });
    },
  },
  mounted() {
    const self = this;
    var nID = this.$router.currentRoute.params.data;

    this.callApi("get", "/api/admin/content-new/" + nID).then((res) => {
      if (res.status == 200) {
        console.log("res", res);
        this.form.title = res.data.title;
        this.form.status = res.data.status;
        this.form.coverImage = res.data.cover_photo;
        this.form.categories = res.data.intrests;
        this.form.author = res.data.author;
        this.form.id = res.data.id;

        this.form.publishDay = this.setDate(
          res.data.created_at.substring(0, 10)
        );
        console.log(this.form.publishDay);
        this.initEditor(
          "#courseDescription",
          "form.courseDescription",
          function () {
            self.form.courseDescription.setData(res.data.content);
          }
        );
      }
    });
  },
};
</script>

