<template>
  <div class="course-page">
    <div v-if="success">
      <h1>success payment</h1>
    </div>
    <div v-if="faild">
      <h1>faild payment</h1>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    this.checkStatus();
  },

  data() {
    return {
      faild: false,
      success: false,
    };
  },

  methods: {
    checkStatus() {
      this.isLoading(true);
      axios({ method: "GET", url: "/api/get-call-payment-status" }).then(
        (res) => {
          if (res.data.status == "faild") {
            this.$router.replace(`/specialist/${res.data.slug}?payment=false`);
            this.isLoading(false);
          } else {
            this.$router.replace(
              `/specialist/${res.data.slug}?payment=true&apt-id=${res.data.appo_id}`
            );
            this.isLoading(false);
          }
        }
      );
    },
    isLoading(status) {
      this.$store.commit("isLoading", status);
    },
  },
};
</script>
<style scoped>
</style>
