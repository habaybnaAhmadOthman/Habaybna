<template>
    <div>
        <component
            :is="activeComponent"
            @submitForm="submitForm"
            @open-password-dialog="showPasswordDialog"
        ></component>
        <ChangePassword
            v-if="showPasswordModal"
            @close-password-modal="showPasswordDialog"
        ></ChangePassword>
        <UserImage
            v-if="showUserImageModal"
            @close-image-modal="closeImageModal"
        ></UserImage>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
        <alert-dialog
            :show="!!error"
            :title="'تم الحفظ بنجاح'"
            @close="closeModal"
        ></alert-dialog>
    </div>
</template>
<script>
import parentAccount from "./myaccount/Parent.vue";
import specialistAccount from "./myaccount/Specialist.vue";
import otherAccount from "./myaccount/Other.vue";

import ChangePassword from "../../views/userprofile/myaccount/ChangePassword.vue";
import UserImage from "../../views/userprofile/myaccount/UserImage.vue";

import loadingMixin from "./../../mixins/loading.js";

import { userImageModalBus } from "./UserProfile_Template.vue";
export default {
    emits: ["submit-form"],
    mixins: [loadingMixin],
    components: {
        parentAccount,
        ChangePassword,
        specialistAccount,
        otherAccount,
        UserImage
    },
    async created() {
        const userType = await this.$store.getters["user/type"];
        // this.activeComponent = `${userType}Account`;
        this.activeComponent = `specialistAccount`;
    },
    data() {
        return {
            activeComponent: null,
            showPasswordModal: false,
            showUserImageModal: false
        };
    },
    mounted() {
        userImageModalBus.$on("openImageModal", () => {
            this.showUserImageModal = true;
        });
    },
    methods: {
        closeImageModal() {
            this.showUserImageModal = false;
        },
        async submitForm(data) {
            this.isLoading = true;
            // try {
            //     await this.$store.dispatch('updateProfileData',data)
            // } catch (e) {
            //     // this.showErrorMessage("حدث خطأ ما")
            //     console.log(e)
            // }
            console.log(data);
            setTimeout(() => {
                this.isLoading = false;
                this.error = true;
            }, 1000);
        },
        showPasswordDialog() {
            this.showPasswordModal = !this.showPasswordModal;
        }
    }
};
</script>
