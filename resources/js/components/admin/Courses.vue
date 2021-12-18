<style>
.cat {
  border: 0.5px solid #9e9696b5;
  padding: 0px 3px;
  margin: 0 1.5px;
  color: blueviolet;
  font-size: 13px;
  border-radius: 4px;
}
</style>
<template>
  <!-- <Table border :columns="columns7" :data="data6"></Table> -->
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">العنوان</th>
        <th scope="col">الفئة</th>
        <th scope="col">السعر</th>
        <th scope="col">حالة الدورة</th>
        <th scope="col">نوع الدورة</th>
        <th scope="col"> عدد الدروس</th>
        <th scope="col">مدة الدورة</th>
        <th scope="col">الأجراءات</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(course, index) in data6" :key="course.id">
        <th scope="row">1</th>
        <td>{{ course.courseTitle }}</td>
        <td>
          <span class="cat" v-for="cat in course.courseCategory" :key="cat.id">
            {{ cat.title }}
          </span>
        </td>
        <td>{{ course.coursePrice }}</td>
        <td>{{ course.publish }}</td>
        <td>{{ course.free }}</td>
        <td>{{ course.videos_count }}</td>
        <td>{{ course.course_length }}</td>
        <td>
          <Button
            :to="'/admin/course-edit/' + course.course_id"
            type="dashed"
            size="small"
            >تعديل</Button
          >
          <Button
            :to="'/admin/uploadVideos/' + course.course_id"
            type="dashed"
            size="small"
            >الدروس</Button
          >
          <Button
            :to="'/admin/course-quiz/' + course.course_id"
            type="dashed"
            size="small"
            >الاختبار</Button
          >
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
    const resp = await this.callApi("get", "/api/admin/onlineCourse");
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
