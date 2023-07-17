<style  scoped>
.admin-subscribers h1 {
  font-size: 28px;
  font-weight: 500;
  letter-spacing: 0;
  line-height: 1.5em;
  padding-bottom: 15px;
  position: relative;
  color: #777;
}
.box-info {
  display: flex;
  border: 1px solid #aaa;
  border-top-style: none;
  padding: 0 16px;
}
.box-info-header {
  height: 1px;
  width: 100%;
  background: #aaa;
  flex: 1;
}
.admin-subscribers h1:before {
  content: "";
  position: absolute;
  right: 0;
  bottom: 0;
  height: 5px;
  width: 55px;
  background-color: #777;
}
.admin-subscribers h1:after {
  content: "";
  position: absolute;
  right: 0;
  bottom: 2px;
  height: 1px;
  width: 95%;
  max-width: 255px;
  background-color: #333;
}
.subscribers-pagination ul li {
  border: 2px solid #aaa;
  min-width: 30px;
  text-align: center;
  font-size: 20px;
  cursor: pointer;
  margin: 0 4px;
}
.active-paginate {
  background-color: #aaa;
  color: #fff;
  border: 4px;
  font-weight: bold;
}
.subscribers-table {
  min-height: 300px;
}
.subscribers-pagination .hr {
  margin: 10px 20px;
  height: 1px;
  background-color: #aaa;
}
.shubscribers-header {
  margin-top: 20px;
  min-height: 150px;
  background-color: gainsboro;
  border: 1.5px solid darkgray;
  border-radius: 4px;
}
.shubscribers-header .search {
  width: 33%;
  text-align: right;
}
.shubscribers-header .search input {
  border: none;
  min-height: 40px;
  border-radius: 5px;
  align-items: baseline;
}
</style>
<template>
  <div class="admin-subscribers mx-5">
    <div class="subscribers-title mt-40 pr-10">
      <h1>
        حساب الطفل :
        {{
          child.name != "null" ? child.name : " بدون اسم"
        }}
      </h1>
    </div>
    <div class=" mt-50">
        <div class="text-center" >


            <img v-if="child.photo != 'default.jpg' " :src="child.photo" class="radius-60 w-10" alt="">
            <img v-else :src="`/images/avatars/${child.photo}`" class="radius-60 w-10" alt="">

        </div>
    </div>
    <div class="subscribers-table mt-20">
      <!-- <p>ألاسم : {{child.name !="null" || child.name !="" ? child.name : " بدون اسم"}}</p> -->
      <div class="align-items-end d-flex">
        <label class="mb-0 ml-10 mr-10" for="">معلومات الطفل</label>
        <div class="box-info-header"></div>
      </div>
      <div class="box-info">
        <div class="col-6  m-3 text-right">
          <h2 class="mb-25">
            الاسم :
            {{
              child.name != "null"
                ? child.name
                : " بدون اسم"
            }}
          </h2>
          <h2 class="mb-25">
            الجنس :
            {{ child.gender == "f" ? "انثى" : " ذكر" }}
          </h2>
          <h2 class="mb-25">
            الحالة :
            {{ child.status ? "نشظ" : "  غير نشط" }}
          </h2>
        </div>
        <div class="col-6  m-3 text-right">
          <h2 class="mb-25">
            العمر :
            {{ child.dob.age }}
          </h2>
          <h2 class="mb-25">
            تاريخ الوالدة :
            {{ child.dob.dob }}
          </h2>
        </div>
      </div>
    </div>
    <div class="subscribers-table">
      <!-- <p>ألاسم : {{child.name !="null" || child.name !="" ? child.name : " بدون اسم"}}</p> -->
      <div class="align-items-end d-flex">
        <label class="mb-0 ml-10 mr-10" for=""> الاهتمامات </label>
        <div class="box-info-header"></div>
      </div>
      <div class="box-info">
        <div class="col-6 mt-5 text-right">
          <h2 v-for="(one, index) in child.interests" :key="index" class="mb-25">
            {{
             index+1 + ' - '+ one.title

            }}
          </h2>

        </div>
        <div class="border-right col-6 mt-3 text-right">
          <label class="border-bottom mb-20" for=""> * معلومات اخرى :</label>
          <p>
              {{child.other_info != "null" ? child.child_info : "لا يوجد معلومات اخرى"}}
          </p>
        </div>
      </div>
    </div>
    <div class="subscribers-pagination justify-center">
    </div>
  </div>
</template>
<script>
export default {
  created() {
    console.log();
    this.getData();
  },
  data() {
    return {
      child: {},
      ActivePagIndex: 1,
    };
  },
  methods: {
    getData() {
      this.callApi("GET", `/api/admin/child/${this.$route.params.data}`).then(
        (resp) => {
          console.log(resp);
          if (resp.status === 200) {
            this.child = resp.data;
            console.log(this.child);
          }
        }
      );
    },
  },
};
</script>













