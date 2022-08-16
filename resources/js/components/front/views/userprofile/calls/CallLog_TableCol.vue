<template>
  <div class="log-col">
    <!-- date -->
    <div>
      <p class="bold">{{dayName}}</p>
      <p class="font-13">{{dayDate}}<br><span class="mo">{{timeInterval}}</span></p>
    </div>

    <!-- time -->
    <div class="bold do">{{timeInterval}}</div>

    <!-- child -->
    <div>
      <p class="bold">
        <span class="do">{{data.children}}</span>
        <span class="mo">الطفل</span>
      </p>
      <p class="font-13 w-50-p"><span class="mo">{{data.children}}<br></span>{{data.illness}}</p>
    </div>

    <!-- parent -->
    <div>
      <p class="bold"><span class="do">{{data.parent}}</span><span class="mo">ولي الأمر</span></p>
      <p class="font-13 -p"><span class="mo">{{data.parent}}<br></span>{{data.country}}</p>
    </div>

    <!-- problem -->
    <div>
      <span class="mo bold">المشكلة</span>
      <p class="two-line -p">{{data.problem}}</p>
    </div>

    <!-- problem -->
    <div>
      <span class="mo bold">رابط المكالمة</span>
      <router-link class="blue -p" :to="data.callLink">{{data.callLink}}</router-link>
    </div>

    <!-- call status -->
    <div class="call-status">
      <span class="mo bold">حالة المكالمة</span>
      <p>{{callStatus}}</p>
    </div>

    <!-- recommendation -->
    <div class="recommendation">
      <span class="mo bold">التوصية</span>
      <p class="w-50-p" v-if="data.callStatus == 'scheduled'">لايمكن الكتابة إلا بعد أن تصبح ناجحة</p>
      <p @click="addRecommendation" class="main-color bold pointer w-50-p" v-else-if="data.callStatus == 'succeeded' && data.recommendation == ''">إضافة توصية</p>
      <p @click="showFullRecommendation" class="main-color bold pointer w-50-p" v-else-if="data.callStatus == 'succeeded' && data.recommendation != ''">{{data.recommendation}}</p>
      <p class="w-50-p" v-else>لا يمكنك إضافة توصية</p>
    </div>
  </div>
</template>

<script>
export default {
  emits: ['add-recommendation','show-recommendation'],
  props: ["data"],
  computed: {
    timeInterval() {
      return new Date(this.data.date).toLocaleTimeString("en-US", {
        hour: "2-digit",
        minute: "2-digit",
      });
    },
    dayName() {
      return new Date(this.data.date).toLocaleDateString("ar-EG", {
        weekday: "long",
      });
    },
    dayDate(){
      return new Date(this.data.date).toLocaleDateString('en-GB').replaceAll('/','.')
    },
    callStatus(){
      if (this.data.callStatus == 'scheduled')
        return 'مجدولة'
      if (this.data.callStatus == 'missed')
        return 'فائتة'
      
      return 'ناجحة'
    }
  },
  methods: {
    addRecommendation(){
      const {id} = this.data
      this.$emit('add-recommendation',id)
    },
    showFullRecommendation(){
      this.$emit('show-recommendation',this.data.recommendation)
    }
  },
  mounted() {},
};
</script>

<style scoped>
.log-col {
  padding: 10px 5px 10px 0;
  display: flex;
  align-items: center;
}
.log-col > div {
  flex: 1;
  font-size: 14px;
  padding: 0 5px;
  /* text-align: center; */
}
@media (max-width: 767px) {
  .log-col {
    background: #fff;
    border-radius: 12px;
    flex-direction: column;
    align-items: baseline;
    padding: 15px;
    gap: 15px;
    margin-bottom: 25px;
  }
  .log-col > div {
    display: flex;
    justify-content: space-between;
    width: 100%;
  }
  .w-50-p {
    text-align: left;
  }
}
</style>