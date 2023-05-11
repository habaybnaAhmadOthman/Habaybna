
<template>
  <div class="create-post__text-wrap flex-1">
    <textarea
      @input="handleChange"
      aria-label="Write something about you..."
      name="post-text"
      v-model="content"
      id="create-post-txt"
      :placeholder="placeholder"
      @keyup.enter="auto_grow"
    ></textarea>
  </div>
</template>

<script>
export default {
  props: ["placeholder", "type", "status","emptyCommentInput"],
  created() {

  },
  data() {
    return {
      content: "",
    };
  },
  methods: {
    handleChange(event, index) {
      if (this.type == "post") {
        this.$emit("handelPublishPost", event.target.value);
        if (this.status) {
          event.target.value = "";
        }
      } else {
        this.$emit("handelPublishComment", event.target.value);

      }
    },
    auto_grow(event) {
      event.target.style.height = event.target.scrollHeight + "px";
    },
  },
    watch: {
    // whenever question changes, this function will run

    emptyCommentInput(newStatus, oldStatus) {
      if (this.emptyCommentInput){
          this.content = ""
      }
    }
  },

  computed: {},
};
</script>

<style scoped>
.create-post__text-wrap > textarea {
height: 45px;
    /* max-height: 200px; */
    font-size: 16px;
    color: #757a91;
    resize: none;
    overflow: hidden;
    border: 0.5px solid #ebe4e454;
    padding: 5px 6px;
    border-radius: 3px;
    width: 80%;
}
.create-post__text-wrap > textarea::placeholder {
  margin-top: 20px;
}
@media (max-width: 767px) {
  .create-post__text-wrap > textarea {
    width: 100%;
  padding: 6px 6px;


  }
}
</style>
