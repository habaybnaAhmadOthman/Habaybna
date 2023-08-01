<template>
  <div>
    <h2 class="title-line mb-20 mo p-side-12-p mt-20-p">قريبا</h2>
    <div class="company-banner relative pt-25 pb-55 pt-20-p pb-10-p">
      <div class="container z-1 p-side-12-p">
        <div class="w-85 w-100-p">
          <h2 class="title-line mb-40 do">قريبا</h2>
          <hooper :itemsToShow="1.1" :rtl="true" :progress="true" :autoPlay="true" :playSpeed="2000">>
            <slide
            style="margin: 0 3px"
              v-for="(slide, indx) in commingsoon"
              :key="indx"
              :index="indx"
            >
              <img :src="slide.path" />
            </slide>
          </hooper>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Hooper, Slide } from "hooper";
import "hooper/dist/hooper.css";

export default {
  components: {
    Hooper,
    Slide,
  },
  created() {
    this.callApi("GET", `/api/courses/comming-soon`).then((resp) => {
      console.log("cate", resp);
      if (resp.status === 200) {
        this.commingsoon = resp.data;
      }
    });
  },
  data() {
    return {
      commingsoon: [],
    };
  },
};
</script>
<style scoped>
.hooper  {
  margin: 0 10px;
  height: 250px;
}
.hooper img {
    width:100% !important ;
     height:250px
}

@media (max-width: 767px) {
.hooper  {
  height: 200px;
}
.hooper img {
    width:100% !important ;
     height:200px
}
}
</style>>

</style>
