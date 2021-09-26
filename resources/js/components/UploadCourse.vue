<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Upload online course</div>
          <div class="card-body">
            <div v-if="success != ''" class="alert alert-success" role="alert">
              {{ success }}
            </div>
            <form @submit="formSubmit" enctype="multipart/form-data">
              <strong>Course Title:</strong>
              <input type="text" class="form-control" v-model="courseTitle" />
              <strong>Video Title:</strong>
              <input type="text" class="form-control" v-model="videTitle" />
              <strong>File:</strong>
              <input
                type="file"
                class="form-control"
                v-on:change="onFileChange"
              />
              <strong>Discription:</strong>
              <ckeditor
                :editor="editor"
                v-model="editorData"
                :config="editorConfig"
              ></ckeditor>
              <button class="btn btn-success">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      name: "",
      file: "",
      success: "",
      editor: ClassicEditor,
      editorData: "<p>Content of the editor.</p>",
      editorConfig: {
        // The configuration of the editor.
      },
    };
  },
  methods: {
    onFileChange(e) {
      console.log(e.target.files[0]);
      this.file = e.target.files[0];
    },
    formSubmit(e) {
      e.preventDefault();
      let currentObj = this;

      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let formData = new FormData();
      formData.append("file", this.file);

      axios
        .post("/formSubmit", formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
        })
        .catch(function (error) {
          currentObj.output = error;
        });
    },
  },
};
</script>
