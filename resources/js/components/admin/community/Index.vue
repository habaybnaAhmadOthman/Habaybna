<template>
  <div class="community-admin d-flex text-right">
    <div class="community-admin-header d-flex justify-center my-4">
      <h2>مجتمع حبايبنا</h2>
    </div>
    <div
      class="community-admin-posts d-flex px-5 flex-column"
      v-for="(post, index) in posts"
      :key="index"
    >
      <div
        class="bg-blue border px-2 py-2 rounded text-white justify-content-between d-flex"
      >
        <p>{{ post.content }}</p>
        <span
          class="pointer border-right border-white pointer px-1"
          @click="showDeletePostDialog(index)"
          >Delete</span
        >
      </div>
      <div class="border bg-gray-2 px-2 py-2 rounded">
        <div
          class="border-bottom d-flex justify-content-between px-2 py-1"
          v-for="(comment, indexC) in post.comments"
          :key="indexC"
        >
          <div class="w-32">
            <span> {{ comment.content }}</span>
          </div>

          <div class="w-32">
            <span class="pointer">{{
              comment.status ? "منشور" : "غير منشور"
            }}</span>
          </div>
          <div class="w-32 text-left">
            <span
              class="pointer"
              @click="showDeleteCommentDialog(index, indexC)"
              >Delete</span
            >
          </div>
        </div>
        <div
          class="border-bottom d-flex justify-content-center px-2 py-4"
          v-if="post.comments.length == 0"
        >
          <span>لا يوجد تعليقات</span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import LaravelVuePagination from "laravel-vue-pagination";

export default {
  components: {
    Pagination: LaravelVuePagination,
  },
  data() {
    return {
      posts: [],
    };
  },
  created() {
    this.callApi("get", "/api/admin/community").then((res) => {
      if (res.status == 200) {
        this.posts = res.data;
      }
    });
  },
  methods: {
    showDeleteCommentDialog(index, indexC) {
      if (confirm("هل أنت متأكد من حذف التعليق؟!")) {
        // Save it!
        const comment = this.posts[index].comments[indexC];

        this.callApi(
          "delete",
          "/api/posts/" + this.posts[index].id + "/comment",
          comment
        ).then((resp) => {
          if (resp.status == 200) {
            this.posts[index].comments.splice(indexC, 1);
          } else {
            alert("somthing wronge");
          }
        });
      } else {
        // Do nothing!
      }
    },
    showDeletePostDialog(index) {
      if (confirm("هل أنت متأكد من حذف المنشور؟!")) {
        // Save it!
        this.callApi("delete", "/api/posts/" + this.posts[index].slug).then(
          (resp) => {
            if (resp.status == 200) {
              // this.$emit("handelDeletedPost", this.index);
              // this.showMenu = false;

              this.posts.splice(index, 1);
            } else {
              alert("somthing wronge");
            }
          }
        );
      } else {
        // Do nothing!
      }
    },
  },
};
</script>

<style scoped>
.community-admin {
  flex-direction: column;
}
</style>
