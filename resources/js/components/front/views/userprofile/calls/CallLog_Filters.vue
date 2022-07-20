<template>
  <div class="d-flex align-center mb-25">
      <p class="font-20 gray ml-20 nowrap">تصنيف المكالمات حسب الحالة</p>
      <div class="d-flex align-center space-between gap-10 filter-btns w-100 mr-30">
          <button @click="changeFilter" :class="{'active': filters.all.checked}" class="all-btn radius-5 pointer" id="all">الكل</button>
          <button @click="changeFilter" :class="{'active': filters.scheduled.checked}" class="yellow-btn radius-5 pointer" id="scheduled">مجدولة</button>
          <button @click="changeFilter" :class="{'active': filters.succeeded.checked}" class="green-btn radius-5 pointer" id="succeeded">ناجحة</button>
          <button @click="changeFilter" :class="{'active': filters.missed.checked}" class="red-btn radius-5 pointer" id="missed">فائتة</button>
      </div>
  </div>
</template>

<script>
  export default {
    props: ['filters'],
    emits: ['filter-changed'],
    methods: {
      changeFilter(e){
        const {id} = e.target;
        let updatedFilters = {...this.filters};
        for (const key in updatedFilters) {
          if (key == id)
            updatedFilters[key].checked = true
          else
            updatedFilters[key].checked = false
        }
        this.$emit('filter-changed',updatedFilters)
      }
    }
  }
</script>

<style scoped>
.filter-btns button{
  min-width: 100px;
  background: transparent;
  padding: 5px;
  transition: .3s;
}
.all-btn {
  color: #000;
  border: 1px solid #000;
}
.all-btn:hover,.all-btn.active {
  color: #fff;
  background: #000;
}
.yellow-btn {
  color: #E67E22;
  border: 1px solid #E67E22;
}
.yellow-btn:hover,.yellow-btn.active {
  background: #F1C40F61;
}
.green-btn {
  color: #27AE60;
  border: 1px solid #27AE60;
}
.green-btn:hover,.green-btn.active {
  background: #2ECC717A;
}
.red-btn {
  color: #C0392B;
  border: 1px solid #C0392B;
}
.red-btn:hover,.red-btn.active {
  background: #E74C3C7A;
}
</style>