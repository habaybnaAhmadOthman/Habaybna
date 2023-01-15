<template>
  <div class="search-form d-flex">
    <form @submit.prevent="getResults">
      <div style="position: relative">
        <input type="text" v-model="keyWord" placeholder="البحث" name="q" />
        <!-- <router-link
          class=""
          :to="`/search-results?keyWord=${keyWord}`"
        > -->
          <img
            src="images/siteImgs/icons8-search.svg"
            @click="getResults"
            alt=""
          />
        <!-- </router-link> -->
      </div>
    </form>
  </div>
</template>

<script>
export default {
  props: [],
  data() {
    return {
      keyWord: null,
    };
  },
  computed: {},
  methods: {


        



    getResults() {
        if(this.keyWord !== null){
            console.log(this.keyWord);

            this.$router.push({ path: "/search-results", query: { page:1,keyWord: this.keyWord } });
        }
    //   console.log(this.keyWord);
    //   const resp = this.callApi(
    //     "get",
    //     "/api/get-search-result/?keyWord=" + this.keyWord
    //   ).then((res) => {
    //     if (res.status == 200) {
    //       console.log("1", res);
    //     }
    //   });
    // },
    }
  },
};
</script>

<style scoped>
.search-form form {
  width: 100%;
  margin: 20px 0;
}
.search-form input {
  position: relative;
  flex: 1;
  padding: 10px 8px;
  font-size: 1.5rem;
  border-radius: 31px;
  width: 100%;
  color: #6e6d6d;
  border: 1px solid #6e6d6d;
}
.search-form img {
  position: absolute;
  left: 0.3rem;
  top: 0.5rem;
}
.search-form img:hover {
  cursor: pointer;
}

@media (max-width: 767px) {
  .search-form input {
padding: 14px 15px;
    font-size: 0.9rem;
  }
  .search-form img {
left: 0.3rem;
    top: 1rem;
    width: 27px;
  }
}
</style>
