
<template>
  <div class="comments-wrap d-flex mt-10">
    <img :src="comment.user.user_data.avatar" alt="" class="rounded" />
    <div class="bg-gray p-10">
      <div class="d-flex space-between">
        <h3>
          {{
            comment.user.user_data.firstName +
            " " +
            comment.user.user_data.lastName
          }}
        </h3>
        <span
          data-toggle="modal"
          data-target="#exampleModal"
          @click="showDeleteCommentDialog(comment, index)"
          class="delete-comment"
          v-if="canDelete"
          >Delete</span
        >
      </div>
      <div class="d-flex space-between" >
        <p>
          {{ comment.content }}
        </p>
        <span style="color:gray;font-size: x-small"> {{ comment.created_at }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["comment", "index"],
  mounted() {},
  data() {
    return {
      content: "",
      showMoreComments: false,
    };
  },
  methods: {
    showDeleteCommentDialog(comment, index) {
      if (confirm("هل أنت متأكد من حذف التعليق؟!")) {
        // Save it!
        this.callApi(
          "delete",
          "/api/posts/" + comment.post_id + "/comment",
          comment
        ).then((resp) => {
          if (resp.status == 200) {
            this.$emit("handelDeletedComment", index);
          } else {
            alert("somthing wronge");
          }
        });
      } else {
        // Do nothing!
      }
      //   console.log('comment, index',comment, index);
      // show delete comment dialog
    },
  },

  computed: {
    canDelete() {
      return this.$store.getters["user/userData"].id == this.comment.user_id;
    },
  },
};
</script>

<style scoped>
.comments-wrap > div {
  width: 85%;
  min-width: 85%;
  border-radius: 16px;
}
.comments-wrap img {
  width: 50px;
  height: 50px;
  margin-left: 10px;
}
.comments-wrap p {
  border-radius: 16px;
}
.delete-comment {
  color: #a6a0a0;
  font-weight: bold;
  cursor: pointer;
}
.delete-comment:hover {
  color: #000;
}
</style>
