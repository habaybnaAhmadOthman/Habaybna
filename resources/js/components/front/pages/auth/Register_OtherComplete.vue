<template>
    <div>
        <RegisterTemplate :padding="'pt-30'">
            <CompleteOther
                @complete-registration="submitForm"
                v-if="!showInterestScreen"
            ></CompleteOther>
            <WelcomeScreen
                v-else
                @submit-interests="addInterests"
                :interestsList="interests"
            ></WelcomeScreen>
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
import RegisterTemplate from "./../../views/auth/RegisterTemplate.vue";
// // forms
import CompleteOther from "./../../views/auth/CompleteOther.vue";
import WelcomeScreen from "./../../views/auth/WelcomeScreen.vue";


export default {
    components: {
        RegisterTemplate,
        CompleteOther,
        WelcomeScreen
    },
    data() {
        return {
            isLoading: false,
            showInterestScreen: false,
            interests: [],
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
        async submitForm(userData) {
            this.isLoading = true;
            try {
                let obj = {
                    fristName: userData.fristName,
                    lastName: userData.lastName,
                    password: userData.password,
                    email: userData.email,
                    gender: userData.gender,
                    empolyment: userData.empolyment,
                    whyToJoin: userData.whyToJoin
                }
                this.interests = await this.$store.dispatch("user/completeRegistration",obj);
                this.showInterestScreen = true;
            } catch (e) {
                this.showErrorMessage("حدث خطأ ما");
            }
            this.isLoading = false;
        },
        addInterests(interests) {
            try {
                this.$store.dispatch("user/addInterests",interests);
                this.$router.replace("/profile");
            } catch (e) {
                this.showErrorMessage("حدث خطأ ما");
            }
        },
        showErrorMessage(msg) {
            this.error = msg;
        }
    }
};
</script>
