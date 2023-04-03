<style >
td {
  direction: rtl;
  text-align: right;
}
.ivu-tag span {
  font-size: 16px;
}

.status {
  cursor: pointer;
}
.title {
  text-align: right;
}
.title h2,
h3 {
  width: fit-content;
  color: #343a40;
  display: inline;
}
.title h3 {
  color: darkgrey;
}
.title a {
  float: left;
}
</style>
<template>
  <!-- <Table border :columns="columns7" :data="data6"></Table> -->
  <div>
    <div class="title">
      <h2>ادارة المستخدمين</h2>
      <h3>- الاهالي</h3>
      <Button :to="'/admin/parent/create'" type="primary" size="large" ghost
        >انشاء حساب اهالي</Button
      >
    </div>
    <Button type="success" size="large" ghost v-on:click="exportToExcel()">
      export bio to excel</Button
    >
    <div class="search-wrapper">
      <Input
        type="text"
        v-model="keyword"
        placeholder=" ابحث عن الاسم او رقم الهاتف أو الايميل"
      />
    </div>
    <table class="table" id="table1">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th class="sortted" scope="col" v-on:click="sortTable('name')">
            الاسم الكامل
          </th>
          <th scope="col">الهاتف</th>
          <th scope="col">الدولة</th>
          <th scope="col">الايميل</th>
          <th scope="col" class="sortted" v-on:click="sortTable('status')">
            الحالة
          </th>
          <th class="sortted" scope="col" v-on:click="sortTable('gender')">
            الجنس
          </th>
          <th scope="col">وضع الخصوصية</th>
          <th class="sortted" scope="col" v-on:click="sortTable('date')">
            تاريخ التسجيل
          </th>

          <th scope="col">الاجراءات</th>
        </tr>
      </thead>
      <tbody v-if="parents && parents.data">
        <tr v-for="(parent, index) in filterlist" :key="index">
          <th scope="row">{{ index + 1 }}</th>
          <td>
            {{ parent.user_data.firstName + " " + parent.user_data.lastName }}
          </td>
          <td class="phone-td">{{ parent.phone }}</td>
          <td class="phone-td">{{ parent.country }}</td>
          <td>{{ parent.email }}</td>
          <td class="status">
            <Button
              type="success"
              ghost
              v-if="parent.user_data.status"
              v-on:click="changeStatus(index, parent.user_data.user_id)"
            >
              <span>نشط</span>
            </Button>
            <Button
              type="error"
              ghost
              v-if="!parent.user_data.status"
              v-on:click="changeStatus(index, parent.user_data.user_id)"
            >
              <span>غير نشط</span>
            </Button>
          </td>
          <td>{{ parent.user_data.gender == "m" ? "ذكر" : "انثى" }}</td>
          <td>{{ parent.user_data.private_mode ? "نشط" : "غير نشط" }}</td>
          <td>{{ parent.created_at.slice(0, 10) }}</td>

          <td>
            <Button
              :to="'/admin/parent/' + parent.user_data.user_id"
              type="dashed"
              size="small"
              >عرض</Button
            >
            <!-- <Button type="dashed" size="small">courses</Button>
            <Button type="dashed" size="small">calls</Button> -->
            <Button @click="deleteDaialog(parent.user_data.user_id, index)">
              <Icon size="20" color="red" type="md-trash" />
            </Button>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="parents && parents.data" class="pagination">
      <Pagination
        :data="parents.data"
        @pagination-change-page="getResults"
      ></Pagination>
    </div>

    <table class="table" id="table" style="display: none">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">الاسم الكامل</th>
          <th scope="col">الهاتف</th>
          <th scope="col">الدولة</th>
          <th scope="col">الايميل</th>
          <th scope="col">السيرة الذاتية</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in exportData" :key="index">
          <th scope="row">{{ index + 1 }}</th>
          <td>
            {{ user.parent.firstName + " " + user.parent.lastName }}
          </td>
          <td class="phone-td">{{ user.phone }}</td>
          <td class="">{{ user.country }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.parent.why_to_join }}</td>
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
      parents: {},
      dialogDelete: false,
      modal_loading: false,
      idDeleteUser: "",
      indexDeleteUser: "",
      keyword: "",
      loading: false,
      exportData: "",
    };
  },
  //   async created() {
  //     this.getResults();
  //   },
  methods: {
    async getResults(page) {
        
      if (typeof page === "undefined") {
        page = 1;
      }
      await this.callApi(
        "get",
        "/api/admin/get-parents-data?page=" + page
      ).then((resp) => {
        this.parents = resp;
      });
    },
    exportToExcel() {
      this.callApi("get", "/api/admin/export-parent-excel").then((resp) => {
        this.exportData = resp.data;
        // console.log("resp:", this.exportData.data);
        /* generate workbook object from table */
        this.export();
      });
    },
    export() {
      setTimeout(() => {
        var wb = XLSX.utils.table_to_book(document.getElementById("table"));
        /* generate file and force a download*/
        XLSX.writeFile(wb, "parents bio.xlsx");
      }, 1500);
    },
    deleteDaialog(id, index) {
    //   this.dialogDelete = true;
    //   this.idDeleteUser = id;
    //   this.indexDeleteUser = index;
    },
    del(index) {
      this.modal_loading = true;
      const resp = this.$store.dispatch("admin/deleteUser", this.idDeleteUser);
      setTimeout(() => {
        this.modal_loading = false;
        this.dialogDelete = false;
        this.$Message.success("تم حذف المستخدم");
      }, 1500);
      this.parents.data.data.splice(index, 1);
    },
    changeStatus(i, id) {
      this.loading = true;

      const resp = this.$store.dispatch("admin/changeStatus", id);
      setTimeout(() => {
        this.$Message.success("تم تغيير الحالة");
        this.parents.data.data[i].user_data.status =
          !this.parents.data.data[i].user_data.status;
        this.loading = false;
      }, 1000);
    },
    sortTable(type) {
    //   console.log(type);
      if (type == "name") {
        // console.log(this.parents.data.data);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.parents.data.data.sort((a, b) =>
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
        return this.parents.data.data.sort((a, b) =>
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
        return this.parents.data.data.sort((a, b) =>
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
        return this.parents.data.data.sort((a, b) =>
          isAscending
            ? a.user_datacreated_at > b.user_datacreated_at
              ? 1
              : b.user_datacreated_at > a.user_datacreated_at
              ? -1
              : 0
            : a.user_datacreated_at < b.user_data.created_at
            ? 1
            : b.user_datacreated_at < a.user_datacreated_at
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
      if (this.parents && this.parents.data)
        return this.parents.data.data.filter((other) => {
            if (other.parent) {
            //   console.log('zz',other);
            let byName =
              other.user_data.firstName
                .toLowerCase()
                .indexOf(this.keyword.toLowerCase()) > -1;

            let lastName =
              other.user_data.lastName
                .toLowerCase()
                .indexOf(this.keyword.toLowerCase()) > -1;

            let byPhone =
              other.phone.toLowerCase().indexOf(this.keyword.toLowerCase()) >
              -1;

            let byEmail =
              other.email.toLowerCase().indexOf(this.keyword.toLowerCase()) >
              -1;
            if (byName === true) {
              return byName;
            } else if (lastName === true) {
              return lastName;
            } else if (byPhone === true) {
              return byPhone;
            } else if (byEmail === true) {
              return byEmail;
            }
          }
        });
    },
  },
};
</script>
