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
</style>
<template>
  <div class="content-container">
    <form @submit="formSubmit" enctype="multipart/form-data">
      <ul class="cont-wrapper">
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
          <label for=""> صورة الغلاف :</label>
          <input
            id="coverImage"
            name="coverImage"
            type="file"
            @change="uploadCoverImage"
            required
          />
          <p style="color: red; display: block" v-if="imageError">
            {{ imageError }}
          </p>
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
          <input type="date" v-model="form.publishDay" required :max="date"/>
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
      date: new Date().toISOString().split("T")[0],
      categories: [],
      authorsList: [],

      form: {
        coverImage: "",
        categories: [],
        author: null,
        title: null,
        publishDay: null,
        courseDescription: null,
        status: 0,
      },
      imageError: null,
    };
  },

  methods: {
    uploadCoverImage(event) {
      this.form.coverImage = event.target.files[0];
      if (
        !this.form.coverImage ||
        this.form.coverImage.type.indexOf("image/") !== 0
      ) {
        this.imageError = "file type error image file allowd only";
        document.getElementById("coverImage").value = "";
        return;
      }

      if (this.form.coverImage.size > 3359048) {
        this.imageError = `The image size (${this.form.coverImage.size}) is too much (max is 3.5MB).`;
        document.getElementById("coverImage").value = "";
        return;
      }
    },

    async formSubmit(e) {
      e.preventDefault();
      let tagIDs = [];
      this.form.categories.forEach((item) => tagIDs.push(item.id));

      let Obj = new FormData();
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

      let resp = await this.$store
        .dispatch("admin/createNewArticle", Obj)
        .then((res) => {
          if (res.status == 200) {
            document.getElementById("coverImage").value = "";
            setTimeout(() => {
              this.$Message.success("تم انشاء المحتوى");
              this.$router.push("/admin/content-new");
            }, 1500);
          }
        });
    },
  },
  mounted() {
    this.initEditor(
      "#courseDescription",
      "form.courseDescription",
      function () {}
    );
  },
};
</script>

