<template>
    <div class="header-margin">
        <div class="container soft-bg radius-12 pt-30 pb-30 mb-30">
            <AuthHeader></AuthHeader>
            <div class="p-side-30 mt-50 w-50 m-side-auto">
                <OtpForm @phone-registered="gotPhone" v-if="!showCodeForm" @error-happen="showErrorMessage" ></OtpForm>
                <CodeForm @complete-registration-form="gotCode" v-else-if="!showCompleteForm"></CodeForm>
                <CompleteRegistration v-else></CompleteRegistration>
            </div>
        </div>
        <alert-dialog
            :show="!!error"
            :title="error"
            @close="closeModal"
        ></alert-dialog>
    </div>
</template>

<script>
// page header
import AuthHeader from "./../../layouts/header/AuthHeader.vue";
// forms
import OtpForm from "./../../views/auth/OtpForm.vue";
import CodeForm from "./../../views/auth/CodeForm.vue";
import CompleteRegistration from "./../../views/auth/CompleteRegistration.vue";

export default {
    components: {
        AuthHeader,
        OtpForm,
        CodeForm,
        CompleteRegistration
    },
    data() {
        return {
            showCodeForm: false,
            showCompleteForm: false,
            error: null
        };
    },
    

    methods: {
        closeModal() {
            this.error = null;
        },
        gotPhone(){
            this.showCodeForm = true
        },
        gotCode(){
            this.showCodeForm = true
        },
        showErrorMessage(msg){
            this.error = msg;
        }
        // // add phone number styling
        // getStyleDirection() {
        //     if (!this.phoneNumber.style) {
        //         var css =
        //                 ".vti__dropdown-list { right: 0; }.vti__dropdown-item {display:flex;align-items:center;}",
        //             head =
        //                 document.head ||
        //                 document.getElementsByTagName("head")[0],
        //             style = document.createElement("style");

        //         head.appendChild(style);

        //         style.type = "text/css";
        //         style.appendChild(document.createTextNode(css));
        //     }
        // },
        
    }
};
</script>

<style scoped>
.soft-bg {
    background: #eff5ff;
}
</style>
