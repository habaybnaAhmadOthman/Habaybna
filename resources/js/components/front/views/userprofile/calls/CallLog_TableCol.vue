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
        <span class="do">{{data.childStatus}}</span>
        <span class="mo">حالة الطفل</span>
      </p>
      <p class="font-13 w-50-p"><span class="mo">{{data.childStatus}}<br></span>{{data.childAge}} سنة</p>
    </div>

    <!-- وضع الطفل -->
    <div>
      <p class="bold"><span class="do">{{data.childSituation}}</span><span class="mo">وضع الطفل</span></p>
      <p class="font-13 -p"><span class="mo">{{data.childSituation}}</span></p>
    </div>
    <!-- عمر الطفل عند معرفة حالته -->
    <div>
      <p class="bold"><span class="do">{{data.discoveredAge}}</span><span class="mo">عمر الطفل عند معرفة حالته</span></p>
      <p class="font-13 -p"><span class="mo">{{data.discoveredAge}}</span></p>
    </div>

    <!-- problem -->
    <div>
      <span class="mo bold">المشكلة</span>
      <p class="two-line -p">{{data.problem}}</p>
    </div>

    <!-- problem -->
    <div>
      <span class="mo bold">رابط المكالمة</span>
      <p class="blue pointer" @click="copyLinkToClipboard">نسخ الرابط</p>
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
    copyLinkToClipboard(){
      const self = this
      navigator.clipboard.writeText(this.data.callLink).then(function() {
        self.$store.commit('alertDialogMsg','تم نسخ الرابط')
      }, function(err) {
        console.error('Async: Could not copy text: ', err);
      });
    },
    addRecommendation(){
      const {id} = this.data
      this.$emit('add-recommendation',id)
    },
    showFullRecommendation(){
      this.$emit('show-recommendation',{msg: this.data.recommendation,callID: this.data.id})
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
      flex-basis: 122px;
    flex-grow: 0;
    flex-shrink: 0;
    text-align: center;
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
    flex-basis: inherit;
    flex-grow: unset;
    flex-shrink: unset;
  }
  .w-50-p {
    text-align: left;
  }
}
</style>