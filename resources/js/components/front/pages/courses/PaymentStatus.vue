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
            axios({method:'GET', url:'/api/get-payment-status'})
            .then(res=>{
                console.log(res);
            })
        }
    }
};
</script>
<style scoped>

</style>
