<template>
    <div>
        <RegisterTemplate>
            <CompleteSpecialist
                @complete-registration="submitForm"
                v-if="!showInterestScreen"
            ></CompleteSpecialist>
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
import CompleteSpecialist from "./../../views/auth/CompleteSpecialist.vue";
import WelcomeScreen from "./../../views/auth/WelcomeScreen.vue";


export default {
    components: {
        RegisterTemplate,
        CompleteSpecialist,
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
                    firstName: userData.firstName,
                    lastName: userData.lastName,
                    password: userData.password,
                    email: userData.email,
                    gender: userData.gender,
                    relative: userData.relative
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
                this.$router.replace("/user-profile");
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
