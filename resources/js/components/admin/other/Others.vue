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
      <h3>- الأخصائيين</h3>
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
          <th scope="col">الاسم الاول</th>
          <th scope="col">الهاتف</th>
          <th scope="col">الايميل</th>
          <th scope="col">الحالة</th>
          <th scope="col">الجنس</th>
          <th scope="col">التخصص</th>
          <th scope="col">الاجراءات</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(other, index) in filteredList" :key="index">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ other.firstName }}</td>
          <td>{{ other.user.phone }}</td>
          <td>{{ other.user.email }}</td>
          <td>{{ other.status ? "فعّال" : "غير فعّال" }}</td>
          <td>{{ other.gender == "m" ? "ذكر" : "انثى" }}</td>
          <td>{{ other.specialization }}</td>
          <td>
            <Button
              :to="'/admin/other/' + other.user_id"
              type="dashed"
              size="small"
              >عرض</Button
            >
            <!-- <Button type="dashed" size="small">courses</Button>
            <Button type="dashed" size="small">calls</Button> -->

            <Button @click="deleteDaialog(other.user_id, index)">حذف</Button>
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
  },
  computed: {
    filteredList() {
      return this.others.filter((other) => {
        return other.firstName
          .toLowerCase()
          .includes(this.keyword.toLowerCase())
          
      })
    },
  },
};
</script>
