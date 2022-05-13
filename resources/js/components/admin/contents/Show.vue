<style>
.radio label {
  display: inline-block !important;
  margin: 2px;
}
.error {
  font-size: 16px !important;
  color: red;
}
</style>
<template>
  <div class="flexxx profile">
    <div class="question-form-title">
      <div class="right-side">
        <h3> المحتوى - انشاء محتوى</h3>
      </div>
      <div class="left-side">
        <Button type="info" to="/admin/courses">رجوع</Button>
      </div>
    </div>
    <form @submit="formSubmit" enctype="multipart/form-data" class="flexxx">
      <div class="question-form">
        <label for="contentTitle">عنوان المقال :</label>
        <input
          type="text"
          class="form-control"
          v-model="form.contentTitle"
          name="title"
          required
          id="contentTitle"
        />
        <span class="error" v-if="!this.formValidation.contentTitle">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <div class="question-form">
        <label>صورة الغلاف </label>
        <input
          name="coverImage"
          type="file"
          class="form-control"
          @change="uploadCoverImage"
        />
        <span class="error" v-if="!this.formValidation.coverImage">
          * يجب تعبئة هذا الحقل
        </span>
      </div>

      <div class="text-area">
        <label> وصف المقال</label>
        <!-- <ckeditor
          :editor="form.editor"
          v-model="form.courseDescription"
          :config="form.editorConfig"
        ></ckeditor> -->
        <textarea name="" id="courseDescription" cols="30" rows="10"></textarea>
        <!-- <span class="error" v-if="!this.formValidation.courseDescription">
          * يجب تعبئة هذا الحقل
        </span> -->
      </div>


      <div class="question-form">
        <label>   السمات</label>
        <input
          name="contTags"
          type="text"
          class="form-control"
          v-model="form.contTags"
        />
        <span class="error" v-if="!this.formValidation.contTags">
          * يجب تعبئة هذا الحقل
        </span>
      </div>
      <!-- <div class="question-form">
        <label> حالة المقال : </label>
        <input
          type="radio"
          id="is_publish_1"
          value="1"
          v-model="form.is_publish"
        />
        <label for="is_publish_1"> انشر المقال </label>

        <input
          type="radio"
          id="is_publish_2"
          value="0"
          v-model="form.is_publish"
        />
        <label for="is_publish_2"> لا تنشر المقال </label>
        <span class="error" v-if="!this.formValidation.is_publish">
          * يجب اختيار الحالة
        </span>
      </div> -->
      <div class="question-form">
        <label>   تاريخ النشر</label>
        <input
          name="publishDate"
          type="date"
          class="form-control"
          v-model="form.publishDate"
        />
        <span class="error" v-if="!this.formValidation.publishDate">
          * يجب تعبئة هذا الحقل
        </span>
      </div>


      <div class="question-form">
        <label>مقدمي المحتوى</label>
        <multiselect
          v-model="form.tags"
          :options="form.specialistsList"
          :searchable="true"
          :close-on-select="false"
          :multiple="true"
          :taggable="true"
          label="firstName"
          track-by="user_id"
          placeholder="يرجى إختيار مقدمي الدورة"
        ></multiselect>
        <span class="error" v-if="!this.formValidation.tags">
          * يجب اختيار واحد على الاقل
        </span>
      </div>
      <div class="parent-submit">
        <Button
          :style="{ float: 'left' }"
          type="info"
          ghost
          :loading="loading"
          @click="formSubmit"
        >
          <span v-if="!loading">التالي</span>
          <span v-else>Creating...</span>
        </Button>
      </div>
    </form>
  </div>
</template>

<script>
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import Editor from "ckeditor5-custom-build/build/ckeditor";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";
import initEditor from '../../../components/front/mixins/initEditor'
export default {
  components: { Multiselect },
  mixins: [initEditor],
  async created() {
    // const resp = await this.callApi("get", "/api/admin/course-init-data");
    // if (resp.status == 200) {
    //   this.categories = resp.data.categories;
    //   this.form.specialistsList = resp.data.specialists;
    // }
        this.callApi("get", "/api/admin/content/" + this.$route.params.data).then(
      (res) => {
        if (res.status == 200) {
          this.form.content_id = res.data.nid;
        //   this.form.contentTitle = res.data.title;
        //   this.form.courseDescription = res.data.body;
        //   this.form.coverImage = res.data.image;
        //   this.form.contTags = res.data.tags;
        //   this.form.is_publish = res.data.discount_percentage;
        //   this.form.coupone_durations.start_date = res.data.start_date;
        //   this.form.coupone_durations.end_date = res.data.end_date;
        //   this.form.status = res.data.status;
        }
      }
    );
    console.log('form',this.form);
  },
  data() {
    return {
      form: {
          content_id:null,
        tags: "",
        tagsValid: true,
        specialistsList: [],
        contentTitle: "",
        courseDescription: null,
        publishDate:null,
        editor: ClassicEditor,
        editorConfig: {
          enterMode: "br",
        },
        coverImage: "",
        contTags: "",
        is_publish: "",
      },
      categories: [],
      loading: false,
      formValidation: {
        contTags: true,
        contentTitle: true,
        courseDescription: true,
        coverImage: true,
        tags: true,
        is_publish: true,

      },
      isValidToSubmit: true,
    };
  },

  methods: {
    uploadCoverImage(event) {
      this.form.coverImage = event.target.files[0];
    },

    async formSubmit(e) {
    //   this.validatForm();
    //   if (this.isValidToSubmit) {
        console.log('1');
        this.loading = true;
        let self = this.$router;

        let tagIDs = [];
        // this.form.tags.forEach((item) => tagIDs.push(item.user_id));

        // let CategorytagIDs = [];
        // this.form.courseCategory.forEach((item) =>
        //   CategorytagIDs.push(item.id)
        // );
        e.preventDefault();
        // let formData = new FormData();
        // formData.append("title", this.form.contentTitle);
        // formData.append("category", CategorytagIDs);

        // formData.append("description", this.form.courseDescription.getData().replaceAll('srcset','src').replaceAll(" 0w\"","\""));
        // formData.append("id", this.form.content_id);
        console.log('2');

        let Obj = {
            'id':this.form.content_id,
            'desc':this.form.courseDescription
        }
        // formData.append("coverImage", this.form.coverImage);
        // formData.append("contTags", this.form.contTags);
        // formData.append("is_publish", this.form.is_publish);
        // formData.append("specialists", tagIDs);
        console.log('3',Obj);


        let resp = await this.$store.dispatch(
          "admin/editContent",
          Obj
        );
        console.log(resp,'zzzzzzzzzzzzzzzzzzzzzzz');
        this.$Message.success("تم انشاء المحتوى");

        this.loading = false;
    //   }
    },
    validatForm() {
    //   if (this.form.coursePrice == "" && !this.form.is_free) {
    //     this.formValidation.coursePrice = false;
    //   } else {
    //     this.formValidation.coursePrice = true;
    //   }

    //   for (const prob in this.formValidation) {
    //     if (Object.hasOwnProperty.call(this.formValidation, prob)) {
    //       const element = this.formValidation[prob];
    //       if (!element) {
    //         this.isValidToSubmit = false;
    //         this.$Message.error("يرجى التحقق من الحقول");

    //         break;
    //       }
    //     }
    //   }
    },
  },
  mounted() {
    const self = this;
    this.initEditor('#courseDescription','form.courseDescription',function(){
    });

  },
};
</script>
<style>
.flexxx .text-area {
  width: 77%;
  margin: 10px 0;
}
.text-area p {
  /* min-height: 90px !important; */
}
.question-form span {
  display: block !important ;
}
</style>
