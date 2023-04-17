<template>
  <section class="create-post">
    <img class="create-post__avatar" :src="getAvatar" alt="" />

    <div id="create-post-form" class="create-post__form">
      <PostInput
        @handelPublishPost="handelPublishPost"
        :placeholder="'انشر سؤال او استفسار ....!'"
        type="post"
      />
      <div class="create-post__media-wrap" id="create-post-media-wrap"></div>
      <div class="create-post__buttons">
        <button
          class="create-post__submit"
          type="submit"
          :disabled="canPublish ? false : true"
          id="create-post-submit-btn"
          @click="publishPost"
        >
          Publish
        </button>
      </div>
    </div>
  </section>
</template>
<script>
import PostInput from "./PostInput.vue";
export default {
  // props:['canPublish'],
  components: {
    PostInput,
  },
  data() {
    return {
      content: "",
      canPublish: false,
    };
  },
  methods: {
    handelPublishPost(content) {
      this.content = content;
      this.content !== ""
        ? (this.canPublish = true)
        : (this.canPublish = false);
    },
    publishPost() {
      if (this.isLoggedIn) {
        let post = {
          content: this.content,
          private_mood: false,
        };
        this.callApi("post", "/api/posts", post).then((resp) => {
          if (resp.status == 200) {
            this.$emit("handelNewPost", resp.data);

          }
        });
      }
    },
  },
  computed: {
    isLoggedIn() {
      return this.$store.getters["user/isLoggedIn"];
    },
    getAvatar() {
      return this.$store.getters["user/userData"].avatar;
    },
  },
};
</script>
<style scoped>
</style>
