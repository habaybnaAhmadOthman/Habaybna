<template>
  <div class="d-flex table-border-b day-name" :class="dayNameEn">
    <div class="w-60 pt-20 pb-10 table-border-l p-side-10 day-label relative d-flex align-center">
        <p>{{dayName}}</p>
    </div>
    <div class="flex-1 pt-20 pb-10 table-border-l p-side-10">
      <p>{{timeInterval}}</p>
    </div>
    <div class="remove-col flex-all p-side-10">
        <img @click="removeCol" class="remove-icon pointer" src="/images/trash-bin.png" width="40" height="40">
    </div>
  </div>
</template>

<script>
  export default {
    props: ['data'],
    emits: ['remove'],
    computed: {
      timeInterval(){
        return new Date(this.data).toLocaleTimeString('en-US',{
          hour:  "2-digit",
          minute: "2-digit",
        })
      },
      dayName(){
        return new Date(this.data).toLocaleDateString('ar-EG',{weekday:'long'})
      },
      dayNameEn(){
        return new Date(this.data).toLocaleDateString('en-US',{weekday:'long'})
      },

    },
    methods: {
      removeCol(){
        this.$emit('remove',this.data)
      }
    }
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
.day-name .day-label:before{
  content: '';
  width: 20px;
  height: 20px;
  border-radius: 50%;
  display: inline-block;
  margin-left: 12px;
}
.day-name.Saturday .day-label:before {
    background: #607d8b;
}
.day-name.Sunday .day-label:before {
    background: #9c27b0;
}
.day-name.Monday .day-label:before {
    background: #6ad500;
}
.day-name.Tuesday .day-label:before {
    background: #a384ff;
}
.day-name.Wednesday .day-label:before {
    background: #009688;
}
.day-name.Thursday .day-label:before {
    background: #03a9f4;
}
.day-name.Friday .day-label:before {
    background: #ff9f02;
}
.day-name {
  transition: .3s;
}
.day-name:hover {
  background: #e6e6e6;
}
</style>