<template>
    <div class="p-side-0-p">
        <div class="d-flex flex-wrap">
            <ul class="ks-cboxtags d-flex flex-wrap mb-35 w-100">
                <li v-for="(category,index) of filters" :key="category.id" :index="index" class="ml-10">
                    <input
                        @change="setFilter"
                        type="checkbox"
                        :id="category.id"
                        :value="category.val"
                    /><label class="center gray radius-60 font-18" :for="category.id">{{category.val}}</label>
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
        const categories = await this.$store.dispatch('courses/getCategories');
        if (categories) {
            categories.forEach((category)=>{
                // this.filters[category.id] = {id:category.id,val: category.title}
                this.filters.push({id:category.id,val: category.title,isChecked: false})
            });
        }
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
        padding: 11px 23px;
    white-space: nowrap;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all 0.3s;
    min-width: 110px;
    cursor: pointer;
    border: 1px solid #780d93;
}

ul.ks-cboxtags li input[type="checkbox"]:checked + label {
    background-color: #660066;
    color: #fff!important;
    transition: all 0.2s;
}

ul.ks-cboxtags li input[type="checkbox"] {
    display: absolute;
}
ul.ks-cboxtags li input[type="checkbox"] {
    position: absolute;
    opacity: 0;
}
@media (max-width: 767px) {
    ul.ks-cboxtags li label[data-v-3023a41f] {
        padding: 4px 14px;
        min-width: auto;
    }
}
</style>
