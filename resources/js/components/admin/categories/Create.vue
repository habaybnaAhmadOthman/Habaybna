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
      <h1> تصنيف جديد </h1>
    </div>
    <div>
      <Button class="ml-lg-5 mt-20" type="info" to="/admin/categories"
        >رجوع</Button
      >
    </div>
    <div class="d-flex justify-center mt-50">
      <form @submit="formSubmit" enctype="multipart/form-data">
        <div class="border media-cover-wrapper p-4 radius-5">
          <div class="d-flex flex-column mt-10">
            <label for="title">العنوان : </label>
            <div class="d-flex">
              <input type="text" id="one" value="1" v-model="title" />
            </div>
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
      title: "",
      status: "0",
    };
  },
  methods: {

    formSubmit(e) {
      if (this.title != "" ) {
        e.preventDefault();

        this.callApi ("POST",
            '/api/admin/categories/store',
            {title :this.title, status :this.status}
        ).then(res=>{
            console.log(res);
            if(res.status == 200 ){
                this.$router.push('/admin/categories')
            }
        })

      } else {
        alert("جميع الحقول مطلوبه");
      }
    },
  },
};
</script>
