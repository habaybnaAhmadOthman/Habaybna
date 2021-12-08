<template>
    <div class="container-fluid">
        <div class="d-flex flex-wrap">
            <ul class="ks-cboxtags d-flex flex-wrap justify-center mb-50 w-100">
                <li v-for="(category,index) of filters" :key="category.id" :index="index" class="ml-10 mb-10">
                    <input
                        @change="setFilter"
                        type="checkbox"
                        :id="category.id"
                        :value="category.val"
                    /><label class="center gray radius-12" :for="category.id">{{category.val}}</label>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
  emits: ['change-filter'],
  data(){
    return {
      filters: []
    }
  },
  created(){
      this.getCategories();
  },
  methods:{
    async getCategories(){
        const categories = await  this.$store.getters['courses/categories'];
        categories.forEach((category)=>{
            // this.filters[category.id] = {id:category.id,val: category.title}
            this.filters.push({id:category.id,val: category.title,isChecked: false})
        });
    },
    setFilter(e) {
    //   const inputID = e.target.id;
      const isActive = e.target.checked;
      const index = +e.target.parentNode.getAttribute('index');
      this.filters[index].isChecked = isActive;
    //   const updateFilters = {
    //     ...this.filters,
    //     [inputID] : isActive
    //   }
    //   this.filters = updateFilters;
      this.$emit('change-filter',this.filters)
    }
  }
}
</script>

<style scoped>
ul.ks-cboxtags li label {
    display: inline-block;
    background-color: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(139, 139, 139, 0.3);
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all 0.3s;
    min-width: 110px;
}

ul.ks-cboxtags li label {
    padding: 8px 12px;
    cursor: pointer;
}

ul.ks-cboxtags li input[type="checkbox"]:checked + label {
    border: 2px solid #660066;
    background-color: #660066;
    color: #fff;
    transition: all 0.2s;
}

ul.ks-cboxtags li input[type="checkbox"] {
    display: absolute;
}
ul.ks-cboxtags li input[type="checkbox"] {
    position: absolute;
    opacity: 0;
}
</style>
