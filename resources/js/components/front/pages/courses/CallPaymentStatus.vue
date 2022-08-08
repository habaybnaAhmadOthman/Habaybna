<template>
    <div class="course-page">

            <div v-if="success">
                <h1>success payment</h1>
            </div>
            <div v-if="faild">
                <h1>faild payment</h1>

            </div>

    </div>
</template>

<script>

export default {
    created() {
        this.checkStatus()

    },

    data() {
        return {
            faild:false,
            success:false
        }
    },

    methods: {
        checkStatus(){
            this.isLoading(true)
            axios({method:'GET', url:'/api/get-call-payment-status'})
            .then(res=>{
                var paymentStatus = true
                if (res.data.approval_code == 'null' ) {
                    paymentStatus = false
                }
                this.$router.replace(`/specialist/slug?payment=${paymentStatus}`);
                this.isLoading(false)
            })
        },
        isLoading(status) {
            this.$store.commit('isLoading',status)
        }
    }
};
</script>
<style scoped>

</style>
