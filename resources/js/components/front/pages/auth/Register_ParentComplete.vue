<template>
    <div>
        <RegisterTemplate>
            <CompleteParent @complete-registration="registrationDone" v-if="!showInterestScreen && type == 'parent'"></CompleteParent>
            <CompleteOthers @complete-registration="registrationDone" v-else-if="!showInterestScreen"></CompleteOthers>
            <WelcomeScreen v-else @submit-interests="addInterests"></WelcomeScreen>
        </RegisterTemplate>
        <alert-dialog
            :show="!!error"
            :title="error"
            @close="closeModal"
        ></alert-dialog>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
    </div>
</template>

<script>
// // forms
import CompleteParent from "./../../views/auth/CompleteParent.vue";
import CompleteOthers from "./../../views/auth/CompleteOthers.vue";
import WelcomeScreen from "./../../views/auth/WelcomeScreen.vue";

export default {
    components: {
        RegisterTemplate,
        OtpForm,
        CodeForm,
        CompleteParent,
        CompleteOthers,
        WelcomeScreen,
    },
    data() {
        return {
            isLoading: false,
            showInterestScreen:false,
            phoneNumber: "",
            type: "",
            code: "",
            error: null
        };
    },

    methods: {
        closeModal() {
            this.error = null;
        },
        async registrationDone(userData){
            this.isLoading = true;
            try {
                await this.$store.dispatch("user/register",{
                    ...userData,
                    type:this.type,
                    phone: this.phoneNumber
                });
                this.showInterestScreen = true
            } catch (e) {
                this.showErrorMessage("حدث خطأ ما")
            }
            this.isLoading = false;
        },
        addInterests(interests){
            try {
                this.$store.dispatch("user/register",{
                    interests
                });
                this.$router.replace('/')
            } catch (e) {
                this.showErrorMessage("حدث خطأ ما")
            }
        },
        showErrorMessage(msg) {
            this.error = msg;
        }
    }
};
</script>