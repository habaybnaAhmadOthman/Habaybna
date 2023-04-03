
<template>
  <div
  class="comments-wrap d-flex mt-10">
    <img
      :src="comment.user.user_data.avatar"
      alt=""
      class="rounded"
    />
    <div class="bg-gray p-10">
      <h3>
          {{comment.user.user_data.firstName + ' ' +comment.user.user_data.lastName}}</h3>
      <p>
          {{comment.content}}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["comment"],
  mounted() {
    },
  data() {
    return {
      content: "",
      showMoreComments:false,
    };
  },
  methods: {

  },

  computed: {


  },
};
</script>

<style scoped>
.comments-wrap>div{
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
</style>
