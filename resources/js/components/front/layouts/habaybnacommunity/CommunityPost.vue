<template>
  <section class="create-post">
    <form
      @submit.prevent
      id="create-post-form"
      class="create-post__form"
      action=""
    >
      <div class="post-header d-flex">
        <div class="d-flex ">
          <img
            class="create-post__avatar"
            :src="post.user.user_data.avatar"
            alt=""
          />
          <div>
            <h6>{{ fullName }}</h6>
            <span class="d-block font-12" style="color: gray">{{
              post.created_at
            }}</span>
          </div>
        </div>
        <ul class="option" @click="showMenu = !showMenu">
          <li>.</li>
          <li>.</li>
          <li>.</li>
        </ul>
        <ul v-if="showMenu" class="options-menu">
          <li
            v-if="isLoggedIn"
            :class="`${canDelete ? '' : 'noclick'}`"
            @click="showDeleteCommentDialog()"
          >
            حذف
          </li>
          <!-- <li v-if="isLoggedIn" @click="reportPost()">تبليغ</li> -->
        </ul>
      </div>
      <div class="create-post__text-wrap mt-10">
        <p class="post-content">
          {{ post.content }}
        </p>
      </div>
      <div class="d-flex comment-input">
        <!-- @handelPublishPost="handelPublishPost" -->

        <div class="d-block">
          <div v-if="isLoggedIn && canMakeComment" style="width: 94%">
            <PostInput
              @handelPublishComment="handelPublishComment"
              :placeholder="'اكتب تعليق'"
              type="comment"
            />
          </div>
          <div v-if="canPublish" class="mt-10">
            <button
              class="create-post__submit d-block d-flex"
              type="submit"
              id="create-post-submit-btn"
              @click="publishComment(post)"
            >
              انشر
            </button>
          </div>
        </div>
        <div>
          <Comments
            v-for="(comment, index) in comments"
            :key="index"
            :comment="comment"
            :index="index"
            @handelDeletedComment="handelDeletedComment"
          />
        </div>
        <strong
          v-if="post.comments.length > 3 && show"
          @click="showMoreComments(index)"
          class="show-more font-18"
          >اظهر المزيد...!</strong
        >
        <!-- <div v-else-if="post.comments.length >= 1 && post.comments.length <= 3">
          <Comments
            v-for="(comment, index) in post.comments"
            :key="index"
            :comment="comment"
            :index="index"
          />
        </div> -->
      </div>
    </form>
  </section>
</template>
<script>
import PostInput from "./PostInput.vue";
import Comments from "./Comments.vue";

export default {
  props: ["post", "index"],
  components: {
    PostInput,
    Comments,
  },
  data() {
    return {
      content: "",
      canPublish: false,
      showMenu: false,
      show: true,
    };
  },

  methods: {
    handelPublishComment(content) {
      this.content = content;
      this.content !== ""
        ? (this.canPublish = true)
        : (this.canPublish = false);
    },
    publishComment(post) {
      let comment = {
        content: this.content,
        private_mood: false,
      };

      this.callApi(
        "post",
        "/api/posts/" + post.slug + "/comment",
        comment
      ).then((resp) => {
        this.post.comments = resp.data.comments;
      });
    },

    showDeleteCommentDialog() {
      if (confirm("هل أنت متأكد من حذف المنشور؟!")) {
        // Save it!
        this.callApi("delete", "/api/posts/" + this.post.slug).then((resp) => {
          if (resp.status == 200) {
            this.$emit("handelDeletedPost", this.index);
            this.showMenu = false;
          } else {
            alert("somthing wronge");
          }
        });
      } else {
        // Do nothing!
      }
    },
    // reportPost() {},

    showMoreComments(index) {
      this.show = false;
    },
    handelDeletedComment(index) {
      this.post.comments.splice(index, 1);
    },
  },
  mounted() {},
  computed: {
    isLoggedIn() {
      return this.$store.getters["user/isLoggedIn"];
    },
    canMakeComment() {
      return this.$store.getters["user/userData"].canMakeComment;
    },
    canDelete() {
      if (this.$store.getters["user/isLoggedIn"]) {
        return this.$store.getters["user/userData"].id == this.post.user_id;
      } else {
        return false;
      }
    },
    fullName() {
      return (
        this.post.user.user_data.firstName +
        " " +
        this.post.user.user_data.lastName
      );
    },
    comments() {
      return this.post.comments.length > 3 && this.show
        ? this.post.comments.slice(0, 3)
        : this.post.comments;
    },
    // showMoreCommentsButton() {
    //   return this.post.comments.length > 3 && !this.show;
    // },
  },
};
</script>

<style scoped>
.borderbottom {
  border-bottom: 2px solid #e6e6e6;
}

.show-more {
  text-align: center;
  width: 50%;
  margin: 20px auto;
  cursor: pointer;
  border-radius: 16px;
  border: 1px solid #e2dede;
  padding: 3px 0;
  transition: all 0.2s ease;
}
.show-more:hover {
  color: #cbb3cc;
  border: 1px solid #880093;
}
.option {
  position: relative;
}
.options-menu {
  position: absolute;
  left: 20px;
  top: 52px;
  box-shadow: 1px 3px 3px 0px #9b8d8d;
}
.options-menu li {
  background-color: #ffff;
  padding: 15px 35px;
}
.options-menu li:hover {
  background-color: #f4f4f4;
  cursor: pointer;
}
.option:hover {
  cursor: pointer;
}
.option li {
  line-height: 0.4;
  font-size: 24px;
}
.post-header {
  justify-content: space-between;
  /* padding-bottom: 10px; */
  color: #706868;
}
.post-header img {

}
li.noclick {
  pointer-events: none;
  color: #c5c4c4;
  cursor: not-allowed;
}
.comment-input {
  width: 100%;
  justify-content: content;
  flex-direction: column;
}
#create-post-submit-btn:hover {
  cursor: pointer;
}
.post-content{
text-align: -webkit-center;
    background: #f4f4f4;
    padding: 30px 16px;
    border-radius: 17px;
    font-size: x-large;
}
</style>


