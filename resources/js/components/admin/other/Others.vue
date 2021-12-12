<style >
    td,tr,th{
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
        <th scope="col"> التخصص</th>
        <th scope="col"> الاجراءات</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(other) in others" :key="other.id">
        <th scope="row">1</th>
        <td>{{ other.firstName }}</td>
        <td>{{ other.user.phone }}</td>
        <td>{{ other.user.email }}</td>
        <td>{{ other.status ? 'فعّال':'غير فعّال' }}</td>
        <td>{{ other.gender == 'm' ? 'ذكر':'انثى' }}</td>
        <td>{{ other.specialization }}</td>
        <td>
          <Button :to="'/admin/other/' + other.user_id"  type="dashed" size="small">show</Button>
          <Button  type="dashed" size="small">courses</Button>
          <Button  type="dashed" size="small">calls</Button>
          <Button :to="'/admin/delete/' + other.user_id"  type="dashed" size="small">delete</Button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
<script>
export default {
  data() {
    return {

      others: [],
    };
  },
  async created() {
    const resp = await this.callApi("get", "/api/admin/get-others-data");
    console.log(resp,'others');
    if (resp.status == 200) {
      this.others = resp.data.others;
      console.log(this.others);
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
