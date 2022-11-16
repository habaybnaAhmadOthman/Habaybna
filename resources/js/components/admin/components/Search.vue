
<template>
  <div class="admin-search">
    <input type="text" v-model="keyWord" :placeholder="placeholder" />
    <button class="btn btn-success btn-sm" @click="getSearchResult">بحث</button>
  </div>
</template>
<script>
export default {
  emits: [],
  props: ["type","placeholder"],
  data() {
    return {
      keyWord: "",
    };
  },
  created() {},
  methods: {
    async getSearchResult() {
           await this.callApi("get", "/api/admin/get-"+this.type+"-data?keyWord=" + this.keyWord).then(
        (resp) => {
          this.$emit('searchResult',resp)
        }
      );
    },
  },
};
</script>

<style scoped>
.admin-search {
  display: flex;
  justify-content: center;
  margin: 7px 0;
}
.admin-search input{
  width: 30%;
  margin: 0 6px;
  border-radius: 10px;
  padding: 0 4px;
}
.admin-search button{
    background-color: #343a40;
}
</style>
