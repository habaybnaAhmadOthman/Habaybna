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
      <tr v-for="(specialist) in specialists" :key="specialist.id">
        <th scope="row">1</th>
        <td>{{ specialist.firstName }}</td>
        <td>{{ specialist.user.phone }}</td>
        <td>{{ specialist.user.email }}</td>
        <td>{{ specialist.status ? 'فعّال':'غير فعّال' }}</td>
        <td>{{ specialist.gender == 'm' ? 'ذكر':'انثى' }}</td>
        <td>{{ specialist.specialization }}</td>
        <td>
          <Button :to="'/admin/specialist/' + specialist.user_id"  type="dashed" size="small">show</Button>
          <Button  type="dashed" size="small">courses</Button>
          <Button  type="dashed" size="small">calls</Button>
          <Button :to="'/admin/delete/' + specialist.user_id"  type="dashed" size="small">delete</Button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
<script>
export default {
  data() {
    return {

      specialists: [],
    };
  },
  async created() {
    const resp = await this.callApi("get", "/api/admin/get-specialists-data");
    console.log(resp,'xx');
    if (resp.status == 200) {
      this.specialists = resp.data.specialists;
      console.log(this.specialists);
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
