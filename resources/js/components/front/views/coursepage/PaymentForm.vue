<template>
<div>
    <form ref="form" method="post" :action="'https://srstaging.stspayone.com/SmartRoutePaymentWeb/SRPayMsgHandler'" @submit.prevent="submitForm" class="payment-hidden-form">
        <input type="hidden" name="SecureHash" :value="paymentData.secureHash">
        <input type="hidden" name="MerchantID" :value="paymentData.MerchantID">
        <input type="hidden" name="Amount" :value="paymentData.Amount">
        <input type="hidden" name="CurrencyISOCode" :value="paymentData.CurrencyISOCode">
        <input type="hidden" name="Language" :value="paymentData.Language">
        <input type="hidden" name="MessageID" :value="paymentData.MessageID">
        <input type="hidden" name="TransactionID" :value="paymentData.TransactionID">
        <input type="hidden" name="ThemeID" :value="paymentData.ThemeID">
        <input type="hidden" name="ResponseBackURL" :value="paymentData.ResponseBackURL">
        <input type="hidden" name="Quantity" :value="paymentData.Quantity">
        <input type="hidden" name="Channel" :value="paymentData.Channel">
        <input type="hidden" name="Version" :value="paymentData.Version">
    </form>
    </div>
</template>

<script>
    export default {
        props: ['paymentData'],
        emits: ['clearPaymentData'],
        data:()=> ({

        }),
        methods: {
            submitForm() {
                this.$refs.form.submit();
                // const obj = {
                //     secureHash: this.paymentData.secureHash,
                //     MerchantID: this.paymentData.MerchantID,
                //     Amount: this.paymentData.Amount,
                //     CurrencyISOCode: this.paymentData.CurrencyISOCode,
                //     Language: this.paymentData.Language,
                //     MessageID: this.paymentData.MessageID,
                //     TransactionID: this.paymentData.TransactionID,
                //     ThemeID: this.paymentData.ThemeID,
                //     ResponseBackURL: this.paymentData.ResponseBackURL,
                //     Quantity: this.paymentData.Quantity,
                //     Channel: this.paymentData.Channel,
                //     Version: this.paymentData.Version
                // }
                // try {
                //     const resp =  await axios({
                //         method: 'POST',
                //         url: 'https://srstaging.stspayone.com/SmartRoutePaymentWeb/SRPayMsgHandler',
                //         data: JSON.stringify(obj)
                //     })
                //     this.$emit('clearPaymentData')
                // } catch (e) {
                //     console.log(e);
                // }

            }
        },
        mounted() {
            this.submitForm()
        }
    }
</script>

<style scoped>

</style>
