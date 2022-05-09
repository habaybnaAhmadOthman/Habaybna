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
      <h2>ادارة المحتوى</h2>
      <Button :to="'/admin/content/create'" type="primary" size="large" ghost
        >انشاء محتوى</Button
      >
    </div>
    <!-- <Table border :columns="columns7" :data="data6"></Table> -->
    <div class="search-wrapper">
      <Input
        type="text"
        v-model="keyword"
        placeholder="ابحث عن عنوان المحتوى"
      />
    </div>
    <div class="coupon-table">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th class="sortted" v-on:click="sortTable('name')">العنوان</th>
            <th class="sortted" v-on:click="sortTable('status')">الكاتب</th>
            <th>عدد الاعجابات</th>
            <th>السمات</th>
            <th>الحالة</th>
            <th>تاريخ النشر</th>
            <th>الاجراءات</th>
          </tr>
        </thead>
        <tbody v-if="coupons && coupons.data">
          <tr v-for="(coupon, index) in coupons.data" :key="index">
            <th scope="row">{{ index + 1 }}</th>
            <td style="maxwidth: 200px">{{ coupon.title }}</td>
            <td>{{ coupon.author }}</td>
            <td>{{ coupon.likes_count ? coupon.likes_count : 0 }}</td>
            <td style="maxwidth: 100px">{{ coupon.tags }}</td>
            <td class="status">
              <!-- <Button
                type="success"
                ghost
                v-if="coupon.status"
                v-on:click="changeStatus(index, coupon.id)"
              >
                <span>نشط</span>
              </Button>
              <Button
                type="error"
                ghost
                v-if="!coupon.status"
                v-on:click="changeStatus(index, coupon.id)"
              >
                <span>غير نشط</span>
              </Button> -->
              <Button type="success" ghost>
                <span>نشط</span>
              </Button>
            </td>
            <td>{{ coupon.start_date }}</td>
            <td>
              <Button
                :to="'/admin/content/' + coupon.nid"
                type="dashed"
                size="small"
                >عرض</Button
              >
              <Button @click="deleteDaialog(coupon.id, index)">
                <Icon size="20" color="red" type="md-trash" />
              </Button>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination
        :data="coupons"
        @pagination-change-page="getResults"
      ></Pagination>
    </div>
    <Modal v-model="dialogDelete" width="360">
      <p slot="header" style="color: #f60; text-align: center">
        <Icon type="ios-information-circle"></Icon>
        <span>حذف</span>
      </p>
      <div style="text-align: center">
        <p>هل انت متأكد من حذف الكوبون ؟</p>
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
      coupons: null,
      dialogDelete: false,
      modal_loading: false,
      idDeleteUser: "",
      indexDeleteUser: "",
      keyword: "",
      ascending: false,
    };
  },
  mounted() {
    // Fetch initial results
    this.getResults();
  },
  //   async created() {
  //     const resp = await this.callApi("get", "/api/admin/contents");
  //     if (resp.status == 200) {
  //       this.coupons = resp.data.data;
  //     }
  //   },
  methods: {
    deleteDaialog(id, index) {
      this.dialogDelete = true;
      this.idDeleteUser = id;
      this.indexDeleteUser = index;
    },
    del(index) {
      this.modal_loading = true;
      const resp = this.$store.dispatch(
        "admin/deleteCoupon",
        this.idDeleteUser
      );
      setTimeout(() => {
        this.modal_loading = false;
        this.dialogDelete = false;
        this.$Message.success("Successfully delete");
      }, 1500);
      this.coupons.splice(index, 1);
    },
    changeStatus(i, id) {
      this.loading = true;
      const resp = this.$store.dispatch("admin/CouponChangeStatus", id);
      setTimeout(() => {
        this.$Message.success("تم تغيير الحالة");
        this.coupons[i].status = !this.coupons[i].status;
        this.loading = false;
      }, 1000);
    },
    sortTable(type) {
      if (type == "name") {
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.coupons.sort((a, b) =>
          isAscending
            ? a.code > b.code
              ? 1
              : b.code > a.code
              ? -1
              : 0
            : a.code < b.code
            ? 1
            : b.code < a.code
            ? -1
            : 0
        );
      }
      if (type == "status") {
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.coupons.sort((a, b) =>
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
    async getResults(page) {
      console.log("xxxxxx");
      //   axios.get("example/results?page=" + page).then((response) => {
      //     this.coupons = response.data;
      //   });
      if (typeof page === "undefined") {
        page = 1;
      }
      const x = await this.callApi(
        "get",
        "/api/admin/contents?page=" + page
      ).then((resp) => {
        this.coupons = resp.data;
        console.log(this.coupons);
      });
    },
  },
  computed: {
    filteredList() {
      console.log(this.coupons);
      //   return this.coupons.filter((coupon) => {
      //     return coupon.title.toLowerCase().includes(this.keyword.toLowerCase());
      //   });
    },
  },
};
</script>
