<template>
  <div class="d-flex">
    <div class="w-60 pt-20 pb-10 table-border-l p-side-10">
        <p>اليوم</p>
    </div>
    <div class="flex-1 pt-20 pb-10 table-border-l p-side-10">
      <p>الوقت</p>
    </div>
    <div class="remove-col flex-all p-side-10">
        <img class="remove-icon pointer" src="/images/trash-bin.png" width="40" height="40">
    </div>
  </div>
</template>

<script>
  export default {
    
  }
</script>

<style scoped>
.remove-col {
  width:60px;
}
.table-border {
  border: 1px solid #F2F2F2;
}
.table-border-t {
  border-top: 1px solid #F2F2F2;
}
.table-border-b {
  border-bottom: 1px solid #F2F2F2;
}
.table-border-l {
  border-left: 1px solid #F2F2F2;
}
</style>