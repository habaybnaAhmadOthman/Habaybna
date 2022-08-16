<style >
td,
tr,
th {
  direction: rtl;
  text-align: right;
  /* padding: 10px !important; */
  text-align: center !important;
  vertical-align: middle !important;
}
td > select{
    width: auto;
}
.coupon-table {
  padding: 0 2px;
  overflow-x: scroll;
}
.call-title {
  text-align: right;
  margin: 25px 5px;
  /* background: red; */
  padding: 16px;
}
.calls-filters-taps {
  /* background: blue; */
  padding: 7px;
  margin: 30px 0;
}
</style>
<template>
  <div>
    <div class="call-title">
      <h2>طلبات المكالمات</h2>
      <div class="calls-filters-taps">
        <button class="btn btn-success">جميع المكالمات</button>
        <button class="btn btn-success">مكالمات جديدة</button>
      </div>
    </div>
    <!-- <Table border :columns="columns7" :data="data6"></Table> -->
    <div class="search-wrapper">
      <!-- <Input
        type="text"
        v-model="keyword"
        placeholder="ابحث عن  عنوان الحزمة"
      /> -->
    </div>
    <div class="">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th class="sortted" v-on:click="sortTable('name')">
              تاريخ المكالمة
            </th>
            <th>وقت المكالمة</th>
            <th>الاخصائي</th>
            <th>طالب المكالمة</th>
            <th class="sortted" v-on:click="sortTable('status')">
              حالة المكالمة
            </th>
            <th>رابط المكالمة</th>

            <th>الاجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(appointment, index) in appointments" :key="index">
            <th scope="row">{{ index + 1 }}</th>
            <td>{{ new Date(appointment.appointment).toLocaleDateString('ar-EG') }}</td>
            <td>{{ new Date(appointment.appointment).toLocaleTimeString('ar-EG')}}</td>
            <td>ريم فرنجي</td>
            <td>احمد عبيدات</td>
            <td class="status">
              <select name="" id="">
                <option :selected = "appointment.calls_status == '0' ? true : false " value="0">مجدولة</option>
                <option value="1">ناجحة</option>
                <option value="2">فائتة</option>
              </select>
            </td>
            <td>
              <!-- <Button
                :to="'/admin/calls/package/' + call_package.id"
                type="dashed"
                size="small"
                >عرض</Button
              >
              <Button @click="deleteDaialog(call_package.id, index)">
                <Icon size="20" color="red" type="md-trash" />
              </Button> -->
              رابط المكالمة
            </td>
            <td>{{ appointment.appointment }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- <Modal v-model="dialogDelete" width="360">
      <p slot="header" style="color: #f60; text-align: center">
        <Icon type="ios-information-circle"></Icon>
        <span>حذف</span>
      </p>
      <div style="text-align: center">
        <p>هل انت متأكد من حذف الحزمة ؟</p>
      </div>
      <div slot="footer">
        <Button
          type="error"
          size="large"
          long
          :loading="modal_loading"
          @click="del(indexDeleteUser)"
          >حذف</Button
        >
      </div>
    </Modal> -->
  </div>
</template>
<script>
export default {
  data() {
    return {
      appointments: [],
      //   packages: [],
      //   dialogDelete: false,
      //   modal_loading: false,
      //   idDeleteUser: "",
      //   indexDeleteUser: "",
      //   keyword: "",
      //   ascending: false,
    };
  },
  async created() {
    this.getResults();
  },
  methods: {
    getResults() {
      const resp = this.callApi(
        "get",
        "/api/admin/get-calls-appointments"
      ).then((res) => {
        if (res.status == 200) {
            this.appointments = res.data.data;
            console.log(this.appointments);
        }
      });
    },
    deleteDaialog(id, index) {
      console.log(id, index);
      this.dialogDelete = true;
      this.idDeleteUser = id;
      this.indexDeleteUser = index;
    },
    del(index) {
      console.log(this.idDeleteUser);
      this.modal_loading = true;
      const resp = this.$store.dispatch(
        "admin/deleteCallPackge",
        this.idDeleteUser
      );
      setTimeout(() => {
        this.modal_loading = false;
        this.dialogDelete = false;
        this.$Message.success("تم حذف الحزمة  ");
      }, 1500);
      this.packages.splice(index, 1);
    },
    changeStatus(i, id) {
      this.loading = true;
      console.log(i, id);
      const resp = this.$store.dispatch("admin/callPackageChangeStatus", id);
      setTimeout(() => {
        this.$Message.success("تم تغيير الحالة");
        this.packages[i].status = !this.packages[i].status;
        this.loading = false;
      }, 1000);
    },
    sortTable(type) {
      if (type == "name") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.packages.sort((a, b) =>
          isAscending
            ? a.title > b.title
              ? 1
              : b.title > a.title
              ? -1
              : 0
            : a.title < b.title
            ? 1
            : b.title < a.title
            ? -1
            : 0
        );
      }
      if (type == "status") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.packages.sort((a, b) =>
          isAscending
            ? a.status > b.status
              ? 1
              : b.status > a.status
              ? -1
              : 0
            : a.status < b.status
            ? 1
            : b.status < a.status
            ? -1
            : 0
        );
      }
      if (type == "gender") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.others.sort((a, b) =>
          isAscending
            ? a.gender > b.gender
              ? 1
              : b.gender > a.gender
              ? -1
              : 0
            : a.gender < b.gender
            ? 1
            : b.gender < a.gender
            ? -1
            : 0
        );
      }
    },
  },
  computed: {
    filteredList() {
      return this.packages.filter((call_package) => {
        return call_package.title
          .toLowerCase()
          .includes(this.keyword.toLowerCase());
      });
    },
  },
};
</script>
