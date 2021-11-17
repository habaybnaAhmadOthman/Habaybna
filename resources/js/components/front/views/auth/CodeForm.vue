<template>
    <form @submit.prevent="submitCode">
        
        <div class="form-group" :class="{ invalid: !code.isValid }">
            <input class="bg-white border-0 radius-5 w-100 p-10 pointer form-control trans" placeholder="أدخل رمز التحقق" id="code" @blur="checkValidity" v-model.trim="code.val" />
            <p class="main-color mt-5 font-12">هذا الحقل مطلوب</p>
        </div>
        <button class="btn w-100 mt-30 bold font-20" id="sign-in-button">التالي</button>
        <h2 class="main-color mt-50 light font-17">هل أنت عضو في حبايبنا؟ <router-link class="pr-5" to="/signin">تسجيل الدخول</router-link></h2>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
    </form>
</template>

<script>
export default {
    emits: ['error-happen','complete-registration-form'],
    data() {
        return {
            isLoading: false,
            code: {
                val: "",
                isValid: true,
                showForm: false
            },
            error: null
        };
    },
    methods: {
        checkValidity(e) {
            if (e.target.value != "") {
                this[e.target.id].isValid = true;
            } else {
                this[e.target.id].isValid = false;
            }
        },
        async submitCode() {
            if (this.code.val == "") {
                this.code.isValid = false;
                return;
            }
            this.isLoading = true;
            await window.confirmationResult
                .confirm(this.code.val)
                .then(result => {
                    // User signed in successfully.
                    const user = result.user;
                    this.$emit('complete-registration-form')
                    // ...
                })
                .catch(error => {
                    this.$emit('error-happen',"حدث خطأ ما")
                });
            this.isLoading = false;
        }
    }
};
</script>

<style scoped>
.form-group p {
    display: none;
}
.form-group.invalid p {
    display: block;
}
.form-control {
    border: 1px solid #606;
    height: 52px;
}
.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgb(121 106 238 / 25%);
}
</style>