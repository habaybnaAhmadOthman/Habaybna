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
  <div class="d-flex flex-column p-10">
    <div class="d-flex justify-center mt-60">
      <h1>عرض جديد</h1>
    </div>
    <div>
      <Button class="ml-lg-5 mt-20" type="info" to="/admin/partners"
        >رجوع</Button
      >
    </div>
    <div class="d-flex justify-center mt-50">
      <form @submit="formSubmit" enctype="multipart/form-data">
        <div class="border media-cover-wrapper p-4 radius-5">
          <div class="d-flex flex-column">
            <label for="upload"> تحميل صورة جديدة : </label>
            <input
              id="upload"
              required
              type="file"
              @change="uploadCoverImage"
            />
          </div>
          <div class="d-flex flex-column mt-10">
            <label for="title">الحالة : </label>
            <div class="d-flex">
              <input type="radio" id="one" value="1" v-model="status" />
              <label for="one">نشر</label>
            </div>
            <div class="d-flex">
              <input type="radio" id="two" value="0" v-model="status" />
              <label for="two">غير منشور</label>
            </div>
          </div>
          <div class="d-flex flex-column">
            <label for="order"> الترتيب : </label>
            <input
              id="order"
              required
              type="number"
              min="0"
              v-model="order"
              placeholder="ادخل ترتيب الصوره في العرض"
            />
          </div>
          <div>
            <Button class="ml-lg-5 mt-20" type="info" @click="formSubmit"
              >حفظ</Button
            >
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      order: "",
      status: "0",
      coverImage: "",
    };
  },
  methods: {
    uploadCoverImage(event) {
      this.coverImage = event.target.files[0];
    },
    formSubmit(e) {
      if (this.order != "" && this.coverImage != "") {
        e.preventDefault();
        const formData = new FormData();
        formData.append("order", this.order);
        formData.append("status", this.status);
        formData.append("coverImage", this.coverImage);

        this.$store
          .dispatch("admin/createCommingSoon", formData)
          .then((res) => {
              if(res.status == 200){

                  this.$router.push("/admin/comming-soon");
              }
            // console.log(res.data.status);
            // this.status = res.data.status == "1" ? "1" : "0";
            // this.title = res.data.title;
            // this.$Message.success("تم اضافة شريك جديد  ");
          });
      }
      else{
          alert('جميع الحقول مطلوبه')
}
    },
  },
};
</script>
