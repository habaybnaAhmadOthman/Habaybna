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
    <!-- <div class="title">
      <h2>الكوبونات</h2>
      <Button :to="'/admin/coupons/create'" type="primary" size="large" ghost
        >انشاء كوبون</Button
      >
    </div> -->
    <!-- <Table border :columns="columns7" :data="data6"></Table> -->
    <div class="search-wrapper">
      <Input
        type="text"
        v-model="keyword"
        placeholder="ابحث عن رمز الكوبون"
      />
    </div>
    <div class="coupon-table">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th class="sortted" v-on:click="sortTable('name')">عنوان الدورة</th>
            <th>فئة الدورة</th>
            <th class="sortted" v-on:click="sortTable('status')">حالة الطلب</th>
            <th>
               مدة الدورة
            </th>
            <th>  سعر الدورة</th>
            <th> اسم المستخدم</th>
            <th> رقم الهاتف</th>
            <th>تاريخ الطلب</th>
            <th>الاجراءات</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr v-for="(coupon, index) in filteredList" :key="index">
            <th scope="row">{{ index + 1 }}</th>
            <td>{{ coupon.code }}</td>
            <td>{{ coupon.usage }}</td>
            <td>{{ coupon.type }}</td>
            <td class="status">
              <Button
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
              </Button>
            </td>
            <td>{{ coupon.max_usage }}</td>
            <td>{{ coupon.usage_count }}</td>
            <td>{{ coupon.discount_percentage }} %</td>
            <td>{{ coupon.start_date }}</td>
            <td>{{ coupon.end_date }}</td>
            <td>
              <Button
                :to="'/admin/coupon/' + coupon.id"
                type="dashed"
                size="small"
                >عرض</Button
              >
              <Button @click="deleteDaialog(coupon.id, index)">
                <Icon size="20" color="red" type="md-trash" />
              </Button>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
    <!-- <Modal v-model="dialogDelete" width="360">
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
    </Modal> -->
  </div>
</template>
<script>
export default {
  data() {
    return {
      orders: [],
      dialogDelete: false,
      modal_loading: false,
      idDeleteUser: "",
      indexDeleteUser: "",
      keyword: "",
      ascending: false,
    };
  },
  async created() {
    const resp = await this.callApi("get", "/api/admin/orders/courses");
    if (resp.status == 200) {
      this.orders = resp.data;
    }
  },
  methods: {
    deleteDaialog(id, index) {
        console.log(id, index);
      this.dialogDelete = true;
      this.idDeleteUser = id;
      this.indexDeleteUser = index;
    },
    del(index) {
      console.log(this.idDeleteUser);
      this.modal_loading = true;
      const resp = this.$store.dispatch("admin/deleteCoupon", this.idDeleteUser);
      setTimeout(() => {
        this.modal_loading = false;
        this.dialogDelete = false;
        this.$Message.success("Successfully delete");
      }, 1500);
      this.coupons.splice(index, 1);
    },
    changeStatus(i, id) {
      this.loading = true;
        console.log(i, id);
      const resp = this.$store.dispatch("admin/CouponChangeStatus", id);
      setTimeout(() => {
        this.$Message.success("تم تغيير الحالة");
        this.coupons[i].status = !this.coupons[i].status;
        this.loading = false;
      }, 1000);
    },
    sortTable(type) {
      if (type == "name") {
        //   console.log(this.ascending);
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
        //   console.log(this.ascending);
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
      return this.coupons.filter((coupon) => {
        return coupon.code.toLowerCase().includes(this.keyword.toLowerCase());
      });
    },
  },
};
</script>
