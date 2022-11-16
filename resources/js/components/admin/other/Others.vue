<style >
td,
tr,
th {
  direction: rtl;
  text-align: right;
}
</style>
<template>
  <div>
    <div class="title">
      <h2>ادارة المستخدمين</h2>
      <h3>- الاخرون</h3>
      <Button :to="'/admin/other/create'" type="primary" size="large" ghost
        >انشاء حساب اخر</Button
      >
    </div>
    <!-- <Table border :columns="columns7" :data="data6"></Table> -->
    <Button type="success" size="large" ghost v-on:click="exportToExcel()">
      export bio to excel</Button
    >
    <div class="search-wrapper">
      <Input
        type="text"
        v-model="keyword"
        placeholder="ابحث عن الاسم او رقم الهاتف"
      />
    </div>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th class="sortted" scope="col" v-on:click="sortTable('name')">
            الاسم الكامل
          </th>
          <th scope="col">الهاتف</th>
          <th scope="col">الايميل</th>
          <th scope="col" class="sortted" v-on:click="sortTable('status')">
            الحالة
          </th>
          <th class="sortted" scope="col" v-on:click="sortTable('gender')">
            الجنس
          </th>
          <th scope="col">التخصص</th>
          <th class="sortted" scope="col" v-on:click="sortTable('date')">
            تاريخ التسجيل
          </th>
          <th scope="col">الاجراءات</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(other, index) in filterlist" :key="index">
          <th scope="row">{{ index + 1 }}</th>
          <td>
            {{ other.user_data.firstName + " " + other.user_data.lastName }}
          </td>
          <td class="phone-td">{{ other.phone }}</td>
          <td>{{ other.email }}</td>
          <td class="status">
            <Button
              type="success"
              ghost
              v-if="other.user_data.status"
              v-on:click="changeStatus(index, other.id)"
            >
              <span>نشط</span>
            </Button>
            <Button
              type="error"
              ghost
              v-if="!other.user_data.status"
              v-on:click="changeStatus(index, other.id)"
            >
              <span>غير نشط</span>
            </Button>
          </td>
          <td>{{ other.user_data.gender == "m" ? "ذكر" : "انثى" }}</td>
          <td>{{ other.user_data.specialization }}</td>
          <td>{{ other.user_data.created_at.slice(0, 10) }}</td>

          <td>
            <Button
              :to="'/admin/other/' + other.id"
              type="dashed"
              size="small"
              >عرض</Button
            >
            <!-- <Button type="dashed" size="small">courses</Button>
            <Button type="dashed" size="small">calls</Button> -->

            <Button @click="deleteDaialog(other.id, index)">
              <Icon size="20" color="red" type="md-trash" />
            </Button>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="others && others.data" class="pagination">
      <Pagination
        :data="others.data"
        @pagination-change-page="getResults"
      ></Pagination>
    </div>
    <table class="table" id="table" style="display: none">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">الاسم الكامل</th>
          <th scope="col">الهاتف</th>
          <th scope="col">الايميل</th>
          <th scope="col">السيرة الذاتية</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(specialist, index) in filterlist" :key="index">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ specialist.firstName + " " + specialist.lastName }}</td>
          <td class="phone-td">{{ specialist.phone }}</td>
          <td>{{ specialist.email }}</td>
          <td>{{ specialist.why_to_join }}</td>
        </tr>
      </tbody>
    </table>
    <Modal v-model="dialogDelete" width="360">
      <p slot="header" style="color: #f60; text-align: center">
        <Icon type="ios-information-circle"></Icon>
        <span>حذف</span>
      </p>
      <div style="text-align: center">
        <p>هل انت متأكد من حذف المستخدم؟</p>
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
import * as XLSX from "xlsx";
import LaravelVuePagination from "laravel-vue-pagination";

export default {
  components: {
    Pagination: LaravelVuePagination,
  },
  data() {
    return {
      others: [],
      dialogDelete: false,
      modal_loading: false,
      idDeleteUser: "",
      indexDeleteUser: "",
      keyword: "",
      ascending: false,
    };
  },
  //   async created() {
  //     const resp = await this.callApi("get", "/api/admin/get-others-data");
  //     console.log(resp, "others");
  //     if (resp.status == 200) {
  //       this.others = resp.data.others;
  //       console.log(this.others);
  //     }
  //   },
  methods: {
    async getResults(page) {
      if (typeof page === "undefined") {
        page = 1;
      }
      await this.callApi("get", "/api/admin/get-others-data?page=" + page).then(
        (resp) => {
          this.others = resp;
          console.log(this.others);
        }
      );
    },
    exportToExcel() {
      /* generate workbook object from table */
      var wb = XLSX.utils.table_to_book(document.getElementById("table"));
      /* generate file and force a download*/
      XLSX.writeFile(wb, "others bio.xlsx");
    },
    deleteDaialog(id, index) {
      this.dialogDelete = true;
      this.idDeleteUser = id;
      this.indexDeleteUser = index;
    },
    del(index) {
      console.log(this.idDeleteUser);
      this.modal_loading = true;
      const resp = this.$store.dispatch("admin/deleteUser", this.idDeleteUser);
      setTimeout(() => {
        this.modal_loading = false;
        this.dialogDelete = false;
        this.$Message.success("Successfully delete");
      }, 1500);
      this.others.data.data.splice(index, 1);
    },
    changeStatus(i, id) {
      this.loading = true;

      const resp = this.$store.dispatch("admin/changeStatus", id);
      setTimeout(() => {
        this.$Message.success("تم تغيير الحالة");
        this.others.data.data[i].user_data.status = !this.others.data.data[i].user_data.status;
        this.loading = false;
      }, 1000);
    },
    sortTable(type) {
      if (type == "name") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.others.data.data.sort((a, b) =>
          isAscending
            ? a.user_data.firstName > b.user_data.firstName
              ? 1
              : b.user_data.firstName > a.user_data.firstName
              ? -1
              : 0
            : a.user_data.firstName < b.user_data.firstName
            ? 1
            : b.user_data.firstName < a.user_data.firstName
            ? -1
            : 0
        );
      }
      if (type == "status") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.others.data.data.sort((a, b) =>
          isAscending
            ? a.user_data.status > b.user_data.status
              ? 1
              : b.user_data.status > a.user_data.status
              ? -1
              : 0
            : a.user_data.status < b.user_data.status
            ? 1
            : b.user_data.status < a.user_data.status
            ? -1
            : 0
        );
      }
      if (type == "gender") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.others.data.data.sort((a, b) =>
          isAscending
            ? a.user_data.gender > b.user_data.gender
              ? 1
              : b.user_data.gender > a.user_data.gender
              ? -1
              : 0
            : a.user_data.gender < b.user_data.gender
            ? 1
            : b.user_data.gender < a.user_data.gender
            ? -1
            : 0
        );
      }
      if (type == "date") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.others.data.data.sort((a, b) =>
          isAscending
            ? a.user_data.created_at > b.user_data.created_at
              ? 1
              : b.user_data.created_at > a.user_data.created_at
              ? -1
              : 0
            : a.user_data.created_at < b.user_data.created_at
            ? 1
            : b.user_data.created_at < a.user_data.created_at
            ? -1
            : 0
        );
      }
    },
  },
  mounted() {
    this.getResults();
  },
  computed: {
    filterlist() {
      if (this.others && this.others.data)
        return this.others.data.data.filter((other) => {
          let byName =
            other.user_data.firstName
              .toLowerCase()
              .indexOf(this.keyword.toLowerCase()) > -1;

          let lastName =
            other.user_data.lastName
              .toLowerCase()
              .indexOf(this.keyword.toLowerCase()) > -1;

          let byPhone =
            other.phone.toLowerCase().indexOf(this.keyword.toLowerCase()) > -1;

          let byEmail =
            other.email.toLowerCase().indexOf(this.keyword.toLowerCase()) > -1;
          if (byName === true) {
            return byName;
          } else if (lastName === true) {
            return lastName;
          } else if (byPhone === true) {
            return byPhone;
          } else if (byEmail === true) {
            return byEmail;
          }
          console.log(byName, byPhone);
        });
    },
  },
};
</script>
