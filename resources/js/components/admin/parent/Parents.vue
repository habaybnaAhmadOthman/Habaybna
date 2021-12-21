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
            الاسم الاول
          </th>
          <th scope="col">الهاتف</th>
          <th scope="col">الايميل</th>
          <th scope="col" class="sortted" v-on:click="sortTable('status')">
            الحالة
          </th>
          <th class="sortted" scope="col" v-on:click="sortTable('gender')">
            الجنس
          </th>          <th scope="col">وضع الخصوصية</th>
          <th scope="col">الاجراءات</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(parent, index) in filteredList" :key="index">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ parent.firstName }}</td>
          <td>{{ parent.user.phone }}</td>
          <td>{{ parent.user.email }}</td>
          <td class="status">
            <Button
              type="success"
              ghost
              v-if="parent.status"
              v-on:click="changeStatus(index, parent.user_id)"
            >
              <span>نشط</span>
            </Button>
            <Button
              type="error"
              ghost
              v-if="!parent.status"
              v-on:click="changeStatus(index, parent.user_id)"
            >
              <span>غير نشط</span>
            </Button>
          </td>
          <td>{{ parent.gender == "m" ? "ذكر" : "انثى" }}</td>
          <td>{{ parent.private_mode ? "نشط" : "غير نشط" }}</td>
          <td>
            <Button
              :to="'/admin/parent/' + parent.user_id"
              type="dashed"
              size="small"
              >عرض</Button
            >
            <!-- <Button type="dashed" size="small">courses</Button>
            <Button type="dashed" size="small">calls</Button> -->
            <Button @click="deleteDaialog(parent.user_id, index)">
              <Icon size="20" color="red" type="md-trash" />
            </Button>
          </td>
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
export default {
  data() {
    return {
      parents: [],
      dialogDelete: false,
      modal_loading: false,
      idDeleteUser: "",
      indexDeleteUser: "",
      keyword: "",
      loading: false,
    };
  },
  async created() {
    const resp = await this.callApi("get", "/api/admin/get-parents-data");
    if (resp.status == 200) {
      this.parents = resp.data.parnets;
    }
  },
  methods: {
    deleteDaialog(id, index) {
      this.dialogDelete = true;
      this.idDeleteUser = id;
      this.indexDeleteUser = index;
    },
    del(index) {
      this.modal_loading = true;
      const resp = this.$store.dispatch("admin/deleteUser", this.idDeleteUser);
      setTimeout(() => {
        this.modal_loading = false;
        this.dialogDelete = false;
        this.$Message.success("تم حذف المستخدم");
      }, 1500);
      this.parents.splice(index, 1);
    },
    changeStatus(i, id) {
      this.loading = true;

      const resp = this.$store.dispatch("admin/changeStatus", id);
      setTimeout(() => {
        this.$Message.success("تم تغيير الحالة");
        this.parents[i].status = !this.parents[i].status;
        this.loading = false;
      }, 1000);
    },
    sortTable(type) {
      if (type == "name") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.parents.sort((a, b) =>
          isAscending
            ? a.firstName > b.firstName
              ? 1
              : b.firstName > a.firstName
              ? -1
              : 0
            : a.firstName < b.firstName
            ? 1
            : b.firstName < a.firstName
            ? -1
            : 0
        );
      }
      if (type == "status") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.parents.sort((a, b) =>
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
        return this.parents.sort((a, b) =>
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
      return this.parents.filter((other) => {
        return other.firstName
          .toLowerCase()
          .includes(this.keyword.toLowerCase());
      });
    },
  },
};
</script>
