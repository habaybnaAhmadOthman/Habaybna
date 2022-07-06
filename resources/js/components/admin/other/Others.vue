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
        <tr v-for="(other, index) in filteredList" :key="index">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ other.firstName + " " + other.lastName }}</td>
          <td class="phone-td">{{ other.user.phone }}</td>
          <td>{{ other.user.email }}</td>
          <td class="status">
            <Button
              type="success"
              ghost
              v-if="other.status"
              v-on:click="changeStatus(index, other.user_id)"
            >
              <span>نشط</span>
            </Button>
            <Button
              type="error"
              ghost
              v-if="!other.status"
              v-on:click="changeStatus(index, other.user_id)"
            >
              <span>غير نشط</span>
            </Button>
          </td>
          <td>{{ other.gender == "m" ? "ذكر" : "انثى" }}</td>
          <td>{{ other.specialization }}</td>
          <td>{{ other.created_at.slice(0, 10) }}</td>

          <td>
            <Button
              :to="'/admin/other/' + other.user_id"
              type="dashed"
              size="small"
              >عرض</Button
            >
            <!-- <Button type="dashed" size="small">courses</Button>
            <Button type="dashed" size="small">calls</Button> -->

            <Button @click="deleteDaialog(other.user_id, index)">
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
      others: [],
      dialogDelete: false,
      modal_loading: false,
      idDeleteUser: "",
      indexDeleteUser: "",
      keyword: "",
      ascending: false,
    };
  },
  async created() {
    const resp = await this.callApi("get", "/api/admin/get-others-data");
    console.log(resp, "others");
    if (resp.status == 200) {
      this.others = resp.data.others;
      console.log(this.others);
    }
  },
  methods: {
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
      this.others.splice(index, 1);
    },
    changeStatus(i, id) {
      this.loading = true;

      const resp = this.$store.dispatch("admin/changeStatus", id);
      setTimeout(() => {
        this.$Message.success("تم تغيير الحالة");
        this.others[i].status = !this.others[i].status;
        this.loading = false;
      }, 1000);
    },
    sortTable(type) {
      if (type == "name") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.others.sort((a, b) =>
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
        return this.others.sort((a, b) =>
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
      if (type == "date") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.others.sort((a, b) =>
          isAscending
            ? a.created_at > b.created_at
              ? 1
              : b.created_at > a.created_at
              ? -1
              : 0
            : a.created_at < b.created_at
            ? 1
            : b.created_at < a.created_at
            ? -1
            : 0
        );
      }
    },
  },
  computed: {
    filteredList() {
      return this.others.filter((other) => {
        return other.firstName
          .toLowerCase()
          .includes(this.keyword.toLowerCase());
      });
    },
  },
};
</script>
