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
.show-users {
  color: #00a1ff;
  cursor: pointer;
  font-weight: bold;
}
.user-card {
  display: flex;
}
.user-card > span {
  border: 1px solid rgb(206, 202, 202);
  border-radius: 3px;
  padding: 0px 8px;
  font-size: 23px;
  margin: 6px 3px;
  opacity: 0.7;
  transition: all 0.1s ease;
}
.user-card > span:hover {
  opacity: 1;
  cursor: pointer;
}
</style>
<template>
  <div>
    <div class="title">
      <h2>الكوبونات</h2>
      <Button :to="'/admin/coupons/create'" type="primary" size="large" ghost
        >انشاء كوبون</Button
      >
    </div>
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
            <th class="sortted" v-on:click="sortTable('name')">كود الكوبون</th>
            <th>الاستخدام</th>
            <th>نوع الكوبون</th>
            <th class="sortted" v-on:click="sortTable('status')">الحالة</th>
            <th>الحد الاعلى للاستخدام</th>
            <th>عدد الاستخدامات الحالي</th>
            <th>نسبة الخصم</th>
            <th>تاريخ التفعيل</th>
            <th>تاريخ الانتهاء</th>
            <th>الاجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(coupon, index) in filteredList" :key="index">
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
            <td>
              {{ coupon.usage_count }}
              <p
                v-if="coupon.users_promo_codes.length > 0"
                class="show-users"
                @click="dialogShowPromoUsers(coupon.id, index)"
              >
                عرض المستخدمين
              </p>
            </td>
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
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <Pagination
          v-if="coupons"
          :data="coupons"
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
    <Modal v-model="showPromoUsers" width="450">
      <p slot="header" style="color: #00a1ff; text-align: center">
        <Icon type="ios-user-circle"></Icon>
        <span style="fontsize: 27px">المستخدمون</span>
      </p>
      <div class="coupon-user-list">
        <table class="table">
          <thead>
            <tr>
              <th>اسم المستخدم</th>
              <th>الاستخادم</th>
              <th>الدورة التدريبية\الاخصائي</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="(user, index) in userList" :key="index">
              <td>
                {{
                  user.user.user_data.firstName +
                  " " +
                  user.user.user_data.lastName
                }}
              </td>
              <td>
                {{ user.usage }}
              </td>
              <td v-if="user.usage == 'Course'">
                {{ user.course.courseTitle }}
              </td>
              <td v-else>
                {{
                  " الاخصائي" +
                  " " +
                  user.specialist.firstName +
                  " " +
                  user.specialist.lastName
                }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div slot="footer"></div>
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
      coupons: {},
      dialogDelete: false,
      showPromoUsers: false,
      modal_loading: false,
      idDeleteUser: "",
      indexDeleteUser: "",
      keyword: "",
      ascending: false,
      userList: null,
    };
  },
    // async created() {
    // this.getResults();

        // console.log('xxxxxxx');
    //   const resp = await this.callApi("get", "/api/admin/coupons");
    //   if (resp.status == 200) {
    //     this.coupons = resp.data;
    //   }
    // },
  methods: {

    getResults(page) {
      if (typeof page === "undefined") {
        page = 1;
      }
      const resp = this.callApi("get", "/api/admin/coupons?page=" + page).then(
        (res) => {
          if (res.status == 200) {
            this.coupons = res.data;
      console.log('1', this.coupons);
          }
        }
      );
    },
    deleteDaialog(id, index) {
      this.dialogDelete = true;
      this.idDeleteUser = id;
      this.indexDeleteUser = index;
    },
    dialogShowPromoUsers(id, index) {
      this.userList = this.coupons.data[index].users_promo_codes;
      this.showPromoUsers = true;
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
        return this.coupons.data.sort((a, b) =>
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
        return this.coupons.data.sort((a, b) =>
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
  },
  async mounted() {
      console.log('mounted');
    this.getResults();
  },
  computed: {
    filteredList() {
      return this.coupons.data ? this.coupons.data.filter((coupon) => {

        return coupon.code.toLowerCase().includes(this.keyword.toLowerCase());
      }) : '';
    },
  },
};
</script>
