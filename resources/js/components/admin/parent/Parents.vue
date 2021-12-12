<style >
    td{
        direction: rtl;
        text-align: right;
    }
</style>
<template>
  <!-- <Table border :columns="columns7" :data="data6"></Table> -->
  <table class="table">
    <thead class="thead-dark">
      <tr >
        <th scope="col">#</th>
        <th scope="col">الاسم الاول</th>
        <th scope="col">الهاتف</th>
        <th scope="col">الايميل</th>
        <th scope="col">الحالة</th>
        <th scope="col">الجنس</th>
        <th scope="col">وضع الخصوصية</th>
        <th scope="col"> الاجراءات</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(parent) in parents" :key="parent.id">
        <th scope="row">1</th>
        <td>{{ parent.firstName }}</td>
        <td>{{ parent.user.phone }}</td>
        <td>{{ parent.user.email }}</td>
        <td>{{ parent.status ? 'فعّال':'غير فعّال' }}</td>
        <td>{{ parent.gender == 'm' ? 'ذكر':'انثى' }}</td>
        <td>{{ parent.private_mode ?'نشط':'غير نشط' }}</td>
        <td>
          <Button :to="'/admin/parent/' + parent.user_id"  type="dashed" size="small">show</Button>
          <Button  type="dashed" size="small">courses</Button>
          <Button  type="dashed" size="small">calls</Button>
          <Button :to="'/admin/delete/' + parent.user_id"  type="dashed" size="small">delete</Button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
<script>
export default {
  data() {
    return {

      parents: [],
    };
  },
  async created() {
    const resp = await this.callApi("get", "/api/admin/get-parents-data");
    if (resp.status == 200) {
      this.parents = resp.data.parnets;
      console.log(this.parnets);
    }
  },
  methods: {
    show(index) {
      this.$Modal.info({
        title: "User Info",
        content: `Name：${this.data6[index].name}<br>Age：${this.data6[index].age}<br>Address：${this.data6[index].address}`,
      });
    },
    remove(index) {
      this.data6.splice(index, 1);
    },
  },
};
</script>
