<template>
<div>
    <form ref="form" method="post" :action="paymentData.RedirectURL" @submit.prevent="submitForm" class="payment-hidden-form">
        <input type="hidden" name="Amount" :value="paymentData.Amount">
        <input type="hidden" name="Channel" :value="paymentData.Channel">
        <input type="hidden" name="CurrencyISOCode" :value="paymentData.CurrencyISOCode">
        <input type="hidden" name="Language" :value="paymentData.Language">
        <input type="hidden" name="MerchantID" :value="paymentData.MerchantID">
        <input type="hidden" name="MessageID" :value="paymentData.MessageID">
        <input type="hidden" name="PaymentDescription" :value="paymentData.PaymentDescription">
        <input type="hidden" name="Quantity" :value="paymentData.Quantity">
        <input type="hidden" name="ResponseBackURL" :value="paymentData.ResponseBackURL">
        <input type="hidden" name="ThemeID" :value="paymentData.ThemeID">
        <input type="hidden" name="TransactionID" :value="paymentData.TransactionID">
        <input type="hidden" name="Version" :value="paymentData.Version">
        <input type="hidden" name="SecureHash" :value="paymentData.secureHash">
<!-- https://cms.habaybna.net/payments_checkout?data={%22Amount%22:%22105000%22,%22Channel%22:%220%22,%22CurrencyISOCode%22:400,%22Language%22:%22en%22,%22MerchantID%22:%228584098098%22
,%22MessageID%22:%221%22,%22PaymentDescription%22:%22coursepayment%22,%22Quantity%22:%221%22,%22
ResponseBackURL%22:%22https://cms.habaybna.net/paymentcourseresdata%22,%22ThemeID%22:%221000000001%22,%22TransactionID%22:77735544,%22Version%22:%222.0%22,%22SecureHash%22:%222488dd9647bb26b4887f1b4e71e85533eaa8cd0e2faaffc4ea343b2b70fa3047%22} -->
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
