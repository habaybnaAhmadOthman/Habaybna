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
    <div style="textAlign:right">
      <h2>انشاء توصية جديدة</h2>
      <br />
    </div>
    <form @submit="formSubmit" enctype="multipart/form-data">
      <ul class="cont-wrapper">
        <li class="wrapper-row">
          <multiselect
            v-model="form.type"
            :options="type"
            :searchable="true"
            :close-on-select="true"
            :taggable="true"
            label="type"
            placeholder="اختر  نوع التوصية"
            :multiple="false"
            required
          ></multiselect>
        </li>
        <li class="wrapper-row">
          <textarea
            v-model="form.content"
            cols="30"
            rows="10"
            class="form-control"
            required
          ></textarea>
        </li>
        <li class="wrapper-row">
          <label for=""> ادخل ترتيب للتوصية : </label>
          <label for="">
            <input
              type="number"
              v-model="form.order"
              placeholder="حدد ترتيب التوصية"
            />
          </label>
        </li>
        <li class="wrapper-row">
          <label for=""> هل تريد نشر التوصية : </label>
          <label for="">
            <input type="radio" v-model="form.status" value="1" required />نعم
          </label>
          <label for="">
            <input type="radio" v-model="form.status" value="0" required />لا
          </label>
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
  async created() {},
  updated() {
    console.log("update", this.form.type);
  },
  data() {
    return {
      type: [
        { type: "course", name: "دورات" },
        { type: "call", name: "مكالمات" },
        { type: "content", name: "محتوى" },
      ],

      form: {
        content: null,
        status: 0,
        type: "",
        order: 0,
      },
    };
  },

  methods: {
    async formSubmit(e) {
      e.preventDefault();

      let Obj = new FormData();
      Obj.append("type", this.form.type.type);
      Obj.append("content", this.form.content);
      Obj.append("status", this.form.status);
      Obj.append("order", this.form.order);

      let resp = await this.$store.dispatch("admin/createNewtestimonials", Obj);
      if (resp.status == 200) {
        setTimeout(() => {
          this.$Message.success("تم اضافة  التوصية   ");
          this.$router.push("/admin/testimonials");
        }, 1500);
      }
    },
  },
  mounted() {
    // this.initEditor(
    //   "#courseDescription",
    //   "form.courseDescription",
    //   function () {}
    // );
  },
};
</script>

