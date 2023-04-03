<template>
  <section class="create-post">
    <img class="create-post__avatar" :src="post.user.user_data.avatar" alt="" />

    <form
      @submit.prevent
      id="create-post-form"
      class="create-post__form"
      action=""
    >
      <div class="post-header d-flex">
        <h4>{{ fullName }}</h4>
        <ul class="option" @click="showMenu = !showMenu">
          <li>.</li>
          <li>.</li>
          <li>.</li>
        </ul>
        <ul v-if="showMenu" class="options-menu">
          <li
            v-if="isLoggedIn"
            :class="`${canDelete ? '' : 'noclick'}`"
            @click="deletePost()"
          >
            حذف
          </li>
          <li v-if="isLoggedIn" @click="reportPost()">تبليغ</li>
        </ul>
      </div>
      <div class="create-post__text-wrap">
        <p class="mb-20">
          {{ post.content }}
        </p>
      </div>
      <div class="create-post__text-wrap">
        <!-- @handelPublishPost="handelPublishPost" -->

        <PostInput
          @handelPublishComment="handelPublishComment"
          :placeholder="'اكتب تعليق'"
          type="comment"
        />
        <div v-if="canPublish" class="mt-10">
          <button
            class="create-post__submit"
            type="submit"
            id="create-post-submit-btn"
            @click="publishComment(post)"
          >
            انشر
          </button>
        </div>
        <div v-if="post.comments.length > 3">
          <Comments
            v-for="(comment, index) in post.comments.slice(0, 3)"
            :key="index"
            :comment="comment"
          />
        </div>
        <strong v-if="post.comments.length > 3" class="show-more font-18"
          >اظهر المزيد...!</strong
        >
        <div v-else-if="post.comments.length >= 1 && post.comments.length <= 3">
          <Comments
            v-for="(comment, index) in post.comments"
            :key="index"
            :comment="comment"
          />
        </div>
      </div>
    </form>
  </section>
</template>
<script>
import PostInput from "./PostInput.vue";
import Comments from "./Comments.vue";

export default {
  props: ["post"],
  components: {
    PostInput,
    Comments,
  },
  data() {
    return {
      content: "",
      canPublish: false,
      showMenu: false,
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

    deletePost() {
      console.log("delete");
    },
    reportPost() {},
  },
  mounted() {},
  computed: {
    isLoggedIn() {
      console.log(this.$store.getters["user/userData"], this.post);
      return this.$store.getters["user/isLoggedIn"];
    },
    canDelete() {
      if (this.$store.getters["user/isLoggedIn"]) {
        console.log(this.$store.getters["user/userData"]);
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
  border-bottom: 1px solid #e6e6e6;
  padding-bottom: 10px;
  color: #706868;
}
li.noclick {
  pointer-events: none;
  color: #c5c4c4;
  cursor: not-allowed;
}
</style>


