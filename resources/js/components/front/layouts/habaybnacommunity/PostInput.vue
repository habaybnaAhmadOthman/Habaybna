
<template>
  <div class="create-post__text-wrap flex-1">

    <textarea
      @input="handleChange"
      aria-label="Write something about you..."
      name="post-text"
      v-model="content"
      id="create-post-txt"
      ouinput="this.parentNode.dataset.replicatedValue = this.value"
      :placeholder="placeholder"
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
    handleChange(event,index) {
      if (this.type == "post") {
        this.$emit("handelPublishPost", event.target.value);
        if (this.status) {
          console.log(this.status);
          event.target.value = "";
        }
      } else {
        this.$emit("handelPublishComment", event.target.value);
        console.log(index);
      }
    },
  },

  computed: {},
};
</script>

<style scoped>
.create-post__text-wrap > textarea {
  border: 1px solid #ebe4e4;
  padding: 9px 6px;
  border-radius: 17px;
}


</style>
