<style >
td,
tr,
th {
  direction: rtl;
  text-align: right;
  padding: 10px !important;
  text-align: center !important;
  vertical-align: middle !important;
}
.coupon-table {
  padding: 0 2px;
  overflow-x: scroll;
}
</style>
<template>
  <div>
    <div class="title">
      <h2>تواصل معنا</h2>
      <!-- <Button :to="'/admin/calls/create'" type="primary" size="large" ghost
        >انشاء حزمة مكالمات</Button
      > -->
    </div>
    <!-- <Table border :columns="columns7" :data="data6"></Table> -->
    <div class="search-wrapper">
      <Input type="text" v-model="keyword" placeholder="ابحث عن اسم مستخدم" />
    </div>
    <div class="coupon-table">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th class="sortted" v-on:click="sortTable('name')">اسم المرسل</th>
            <th class="sortted" v-on:click="sortTable('status')">الايميل</th>
            <th>الرسالة</th>
            <th>التاريخ</th>
            <th>الاجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(call_package, index) in filteredList" :key="index">
            <th scope="row">{{ index + 1 }}</th>
            <td>{{ call_package.name }}</td>
            <td>{{ call_package.email }}</td>
            <td>{{ call_package.message }}</td>

            <td>
              {{
                new Date(call_package.created_at).toISOString().split("T")[0]
              }}
            </td>
            <td>
              <Button
                :to="'/admin/contact-us/' + call_package.id"
                type="dashed"
                size="small"
                >عرض</Button
              >
              <Button @click="deleteDaialog(call_package.id, index)">
                <Icon size="20" color="red" type="md-trash" />
              </Button>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="packages" class="pagination">
        <Pagination
          :data="packages"
          @pagination-change-page="getResults"
        ></Pagination>
      </div>
    </div>
    <Modal v-model="dialogDelete" width="360">
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
    </Modal>
  </div>
</template>
<script>
import LaravelVuePagination from "laravel-vue-pagination";

export default {
  components: {
    Pagination: LaravelVuePagination,
  },
  data() {
    return {
      packages: "",
      dialogDelete: false,
      modal_loading: false,
      idDeleteUser: "",
      indexDeleteUser: "",
      keyword: "",
      ascending: false,
    };
  },
  async mounted() {
    this.getResults();
  },
  methods: {
    getResults(page) {
      if (typeof page === "undefined") {
        page = 1;
      }
      const resp = this.callApi(
        "get",
        "/api/admin/contact-us/all-messages?page=" + page
      ).then((res)=>{
          if(res.status == 200) {
              this.packages = res.data
              console.log('package : ',this.packages);
          }
      })

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
      this.callApi(
        "post",
        "/api/admin/contact-us/delete/" + this.idDeleteUser
      ).then((res)=>{
          if(res.status == 200) {
                    setTimeout(() => {
        this.modal_loading = false;
        this.dialogDelete = false;
        this.$Message.success("تم حذف الرسالة  ");
      }, 1500);
      this.packages.data.splice(index, 1);
          }
      })

    },

    sortTable(type) {
      if (type == "name") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.packages.data.sort((a, b) =>
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
        return this.packages.data.sort((a, b) =>
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
      if (this.packages && this.packages.data)
        return this.packages.data.filter((call_package) => {
          return call_package.name
            .toLowerCase()
            .includes(this.keyword.toLowerCase());
        });
    },
  },
};
</script>
