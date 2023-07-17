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
      <h1>حسابات الأطفال</h1>
    </div>

    <div class="subscribers-table mt-20">
      <table class="table">
        <thead class="thead-light">
          <th>الاسم</th>
          <th>الجنس</th>
          <th> العمر</th>
          <th>حساب الوالد</th>
          <th>الاجراءات</th>
        </thead>
        <tbody>
          <tr v-for="(one, index) in children.data" :key="index">
            <td>{{ one.name !="null" ? one.name : 'بدون اسم' }}</td>
            <td :style="one.gender=='f' ? 'color:#ff6a84':'color:#009dff'">{{ one.gender =='f'?'أنثى':'ذكر' }}</td>
            <td>{{ one.dob.age }}</td>
            <td>
              <router-link :to="`parent/${one.user_id}`">
                اذهب الي حساب الاهالي
              </router-link>
            </td>
            <td>
              <a :href="`child/${one.id}`">  عرض المزيد </a>|
              <a href=""> حذف </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="subscribers-pagination justify-center">
      <div class="hr"></div>
      <ul class="d-flex justify-center">
        <li
          v-for="index in children.last_page"
          :key="index"
          :class="`${
            index == children.current_page ? 'active-paginate' : ''
          }  `"
          @click="page = getData('?page=' + index)"
        >
          {{ index }}
        </li>
      </ul>
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
      children: [],
      ActivePagIndex: 1,
    };
  },
  methods: {
    getData(page) {
      console.log(page);
      this.callApi("GET", `/api/admin/children${page}`).then((resp) => {
        console.log(resp);
        if (resp.status === 200) {
          this.children = resp.data;
        }
      });
    },
  },
};
</script>













