
<template>
  <div class="comments-wrap d-flex m-10">
    <div class="border-bottom p-0">
      <div class="d-flex space-between">
        <div class="d-flex">
          <img :src="comment.user.user_data.avatar" alt="" class="" />

          <div class="speciality">
            <h4>
              {{
                comment.user.user_data.firstName +
                " " +
                comment.user.user_data.lastName
              }}
            </h4>
            <h5>{{ comment.user.user_data.specialization }}</h5>
          </div>
        </div>
        <span
          data-toggle="modal"
          data-target="#exampleModal"
          @click="showDeleteCommentDialog(comment, index)"
          class="delete-comment"
          v-if="canDelete"
          >حذف</span
        >
      </div>
      <div class="mt-5">
        <p class="p-10" style="margin: 0px 50px">
          {{ comment.content }}
        </p>
        <div class="left">
          <span style="color: gray; font-size: x-small">
            {{ comment.created_at }}</span
          >
        </div>
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
.comments-wrap {
  margin: 15px;
}
.comments-wrap > div {
  width: 99%;
  min-width: 70%;
  border-radius: 3px;
  /* border: 0.5px solid #ebe4e4; */
}
.comments-wrap img {
  width: 45px;
  height: 45px;
  margin-left: 9px;
  border-radius: 15px;
}

.delete-comment {
  color: #a6a0a0;
  font-weight: bold;
  cursor: pointer;
  font-size: x-small;
}
.delete-comment:hover {
  color: #000;
}

@media (max-width: 767px) {
  .comments-wrap img {
    width: 40px;
    height: 40px;
    margin-left: 7px;
  }
}
</style>
