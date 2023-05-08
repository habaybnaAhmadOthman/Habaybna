
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
  props: ["placeholder", "type", "status"],
  mounted() {},
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
        console.log(index);
      }
    },
    auto_grow(event) {
      event.target.style.height = event.target.scrollHeight + "px";
    },
  },

  computed: {},
};
</script>

<style scoped>
.create-post__text-wrap > textarea {
  height: 37px;
  /* max-height: 200px; */
  font-size: 16px;
  color: #757a91;
  resize: none;
  overflow: hidden;
  border: 0.5px solid #ebe4e4;
  padding: 2px 6px;
  border-radius: 17px;
  width: 80%;
}
.create-post__text-wrap > textarea::placeholder {
  margin-top: 20px;
}
@media (max-width: 767px) {
  .create-post__text-wrap > textarea {
    width: 100%;
  }
}
</style>
