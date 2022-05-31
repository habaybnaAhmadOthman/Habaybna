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
      <h2> التغطية الاعلامية</h2>
      <Button :to="'/admin/media-create'" type="primary" size="large" ghost
        >اضافة تغطية اعلامية</Button
      >
    </div>
    <!-- <Table border :columns="columns7" :data="data6"></Table> -->
    <div class="search-wrapper">
      <Input
        type="text"
        v-model="keyword"
        placeholder="ابحث عن  عنوان تغطية"
      />
    </div>
    <div class="coupon-table">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th class="sortted" v-on:click="sortTable('name')">عنوان التغطية</th>
            <th> الرابط</th>
            <th>الاجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(call_package, index) in filteredList" :key="index">
            <th scope="row">{{ index + 1 }}</th>
            <td style="maxWidth:200px">{{ call_package.title }}</td>

            <td style="maxWidth:200px"><a :href="call_package.url" target="_blank">{{ call_package.url }}</a> </td>
            <td>
              <Button
                :to="'/admin/media/' + call_package.id"
                type="dashed"
                size="small"
                >تعديل</Button
              >
              <Button @click="deleteDaialog(call_package.id, index)" >
                <Icon size="20" color="red" type="md-trash" />
              </Button>
            </td>
          </tr>
        </tbody>
      </table>
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
export default {
  data() {
    return {
      packages: [],
      dialogDelete: false,
      modal_loading: false,
      idDeleteUser: "",
      indexDeleteUser: "",
      keyword: "",
      ascending: false,
    };
  },
  async created() {
    const resp = await this.callApi("get", "/api/admin/media");
    // console.log(resp);
    if (resp.status == 200) {
      this.packages = resp.data;
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
      const resp = this.$store.dispatch("admin/deleteMediaCover", this.idDeleteUser);
      setTimeout(() => {
        this.modal_loading = false;
        this.dialogDelete = false;
        this.$Message.success("تم حذف التغطية  ");
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
      return this.packages.filter((media) => {
        return media.title.toLowerCase().includes(this.keyword.toLowerCase());
      });
    },
  },
};
</script>
