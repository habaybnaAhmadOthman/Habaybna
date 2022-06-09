<style>
.cat {
  border: 0.5px solid #9e9696b5;
  padding: 0px 3px;
  margin: 0 1.5px;
  color: blueviolet;
  font-size: 13px;
  border-radius: 4px;
}
.sortted {
  text-decoration: solid underline rgb(255, 255, 255) 4px;
  cursor: pointer;
}
</style>
<template>
  <!-- <Table border :columns="columns7" :data="courses"></Table> -->

  <div>
    <div class="title">
      <h2>ادارة الدورات التدريبة</h2>
      <Button :to="'/admin/course-create'" type="primary" size="large" ghost
        >انشاء دورة تدريبية</Button
      >
      <div class="search-wrapper">
        <Input
          type="text"
          v-model="keyword"
          placeholder="ابحث عن عنوان الدورة"
        />
      </div>
    </div>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th class="sortted" scope="col" v-on:click="sortTable('title')">
            العنوان
          </th>
          <th scope="col">الفئة</th>
          <th class="sortted" scope="col" v-on:click="sortTable('price')">
            السعر
          </th>
          <th scope="col">حالة الدورة</th>
          <th scope="col">نوع الدورة</th>
          <th scope="col">عدد الدروس</th>
          <th scope="col">مدة الدورة</th>
          <th scope="col">الأجراءات</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(course, index) in filteredList" :key="index">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ course.courseTitle }}</td>
          <td>
            <span
              class="cat"
              v-for="cat in course.courseCategory"
              :key="cat.id"
            >
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
              :to="'/admin/course/preview/' + course.course_id"
              type="dashed"
              size="small"
              ><Icon type="md-eye"
            /></Button>
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
            <Button
              :to="'/admin/course-certificate/' + course.course_id"
              type="dashed"
              size="small"
              >الشهادة</Button
            ><Icon
              size="20"
              color="red"
              type="md-trash"
              @click="deleteDaialog(course.course_id, index)"
            />
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
        <p>هل انت متأكد من حذف الدورة ؟</p>
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
      courses: [],
      keyword: "",
      ascending: false,
      dialogDelete: false,
      modal_loading: false,
      idDeleteUser: "",
      indexDeleteUser: "",
    };
  },
  async created() {
    const resp = await this.callApi("get", "/api/admin/onlineCourse");
    if (resp.status == 200) {
      this.courses = resp.data.courses;
    }
  },
  methods: {
    show(index) {
      this.$Modal.info({
        title: "User Info",
        content: `Name：${this.courses[index].name}<br>Age：${this.courses[index].age}<br>Address：${this.courses[index].address}`,
      });
    },

    deleteDaialog(id, index) {
      this.dialogDelete = true;
      this.idDeleteUser = id;
      this.indexDeleteUser = index;
    },
    del(index) {
      console.log(this.idDeleteUser);
      this.modal_loading = true;
      let obj = {
        id: this.idDeleteUser,
      };
      const resp = this.$store.dispatch("admin/deleteCourse", obj);
      setTimeout(() => {
        this.modal_loading = false;
        this.dialogDelete = false;
        this.courses.splice(index, 1);

        this.$Message.success("Successfully delete");
      }, 1500);
    },
    sortTable(type) {
      if (type == "title") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.courses.sort((a, b) =>
          isAscending
            ? a.courseTitle > b.courseTitle
              ? 1
              : b.courseTitle > a.courseTitle
              ? -1
              : 0
            : a.courseTitle < b.courseTitle
            ? 1
            : b.courseTitle < a.courseTitle
            ? -1
            : 0
        );
      }
      if (type == "price") {
        //   console.log(this.ascending);
        let isAscending = this.ascending;
        this.ascending = !this.ascending;
        return this.courses.sort((a, b) =>
          isAscending
            ? a.coursePrice > b.coursePrice
              ? 1
              : b.coursePrice > a.coursePrice
              ? -1
              : 0
            : a.coursePrice < b.coursePrice
            ? 1
            : b.coursePrice < a.coursePrice
            ? -1
            : 0
        );
      }
    },
    // filteredList(e) {
    //   console.log(e);
    //   return this.courses.filter((course) => {
    //     console.log("filter", course);
    //     return course.courseTitle
    //       .toLowerCase()
    //       .includes(this.keyword.toLowerCase());
    //   });
    // },
  },
  computed: {
    filteredList() {
      return this.courses.filter((other) => {
        return other.courseTitle
          .toLowerCase()
          .includes(this.keyword.toLowerCase());
      });
    },
  },
};
</script>
