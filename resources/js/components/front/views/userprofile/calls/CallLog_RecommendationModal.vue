<template>
  <normal-modal
    :show="show"
    :fixed="true"
    portal="recommendation-modal"
    @close="closeModal"
  >
    <div class="">
      <p class="font-24 yellow bold mb-20">إضافة توصية</p>
      <form>
        <div class="form-group" :class="{ 'invalid': !msg.isValid }">
          <textarea class="form-control" rows="7" placeholder="التوصية" 
          v-model="msg.val"
          ></textarea>
          <p class="red mt-5 font-12">هذا الحقل مطلوب</p>
        </div>
      </form>
      <div class="d-flex gap-20 mt-10-p btns-box">
        <button @click="closeModal" class="radius-60 gray dismiss-btn pointer flex-1">إلغاء</button>
        <button @click="submitForm(true)" class="radius-60 main-bg border-0 white font-18 pointer pt-15 pb-15 flex-1">حفظ</button>
      </div>
    </div>
  </normal-modal>
</template>

<script>
  import NormalModal from "../../../layouts/NormalModal.vue";
  export default {
    props: ['show','fixed','callID','specialistID'],
    emits: ['close','loading'],
    components: {NormalModal},
    data(){
      return {
        msg: {
          val: '',
          isValid: true
        }
      }
    },
    methods: {
      closeModal() {
        this.$emit("close", false);
      },
      submitForm() {
        this.msg.isValid = true
        if (this.msg.val == '') {
          this.msg.isValid = false;
          return false
        }
        this.$emit('loading',true)
        this.$store.dispatch('specialist/addRecommendation',{
          callID: this.callID,
          specialistID: this.specialistID,
          message: this.msg.val
        })

        this.msg.val = ''

        this.$store.commit('alertDialogMsg','تمت إضافة التوصية بنجاح')
        this.$emit("close", {recommendationAdded: true});
        this.$emit('loading',false)
      }
    }
  }
</script>

<style scoped>
.form-group  textarea.form-control{
  height: auto !important;
  font-size: 17px;
}
.dismiss-btn {
  background: transparent;
  border: 1px solid #dee2e6;
  color: #979797;
}
</style>