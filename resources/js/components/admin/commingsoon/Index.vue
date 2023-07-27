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
  min-height: 500px;
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
  <div class="admin-subscribers">
    <div class="subscribers-title mt-40 pr-10">
      <h1> دورات تعرض قريبا</h1>
      <Button :to="'/admin/comming-soon/create'" type="primary" size="large" ghost
        >اضافة +</Button
      >
    </div>

    <div class="subscribers-table mt-20">
      <table class="table">
        <thead class="thead-light">
          <th>الترتيب</th>
          <th>الصورة</th>
          <th>الحالة</th>
          <th>الاجراءات</th>
        </thead>
        <tbody>
          <tr v-for="(one, index) in commingsoon.data" :key="index">
            <td>{{ one.order }}</td>
            <td class="w-25">
                <img  :src="one.path" alt="">
            </td>
            <td :class="one.status? 'text-green-500' : 'red'" >{{ one.status ? 'نشط' : 'غير نشط' }}</td>

            <td>
              <!-- <a :href="`child/${one.id}`"> عرض المزيد </a>| -->
              <a  href="" class="red"> حذف </a> &nbsp| &nbsp
              <a  :href="'comming-soon/'+one.id"> عرض </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>
<script>
export default {
  created() {
    this.getData("?page=1");
  },
  data() {
    return {
      commingsoon: [],
      ActivePagIndex: 1,
    };
  },
  methods: {
    getData(page) {
      console.log(page);
      this.callApi("GET", `/api/admin/comming-soon${page}`).then((resp) => {
        console.log(resp);
        if (resp.status === 200) {
          this.commingsoon = resp.data;
          console.log(this.commingsoon);
        }
      });
    },
  },
};
</script>













