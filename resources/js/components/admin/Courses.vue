<template>
  <!-- <Table border :columns="columns7" :data="data6"></Table> -->
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Category</th>
        <th scope="col">Price</th>
        <th scope="col">Publish</th>
        <th scope="col">Free</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(course, index) in data6" :key="course.id">
        <th scope="row">1</th>
        <td>{{ course.courseTitle }}</td>
        <td>{{ course.courseCategory }}</td>
        <td>{{ course.coursePrice }}</td>
        <td>{{ course.publish }}</td>
        <td>{{ course.free }}</td>
        <td>
          <Button :to="'/admin/course-edit/' + course.course_id"  type="dashed" size="small">Edit</Button>
          <Button :to="'/admin/uploadVideos/' + course.course_id"  type="dashed" size="small">Videos</Button>
          <Button :to="'/admin/course-quiz/' + course.course_id"  type="dashed" size="small">Quiz</Button>

        </td>
      </tr>
    </tbody>
  </table>
</template>
<script>
export default {
  data() {
    return {

      data6: "",
    };
  },
  async created() {
    const resp = await this.callApi("get", "/admin/onlineCourse");
    if (resp.status == 200) {
      console.log(resp.data);
      this.data6 = resp.data.courses;
      console.log(this.data6);
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
