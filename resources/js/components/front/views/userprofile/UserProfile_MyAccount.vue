<template>
    <div>
        <component
            :is="activeComponent"
            @submitForm="submitForm"
            @open-password-dialog="showPasswordDialog"
        ></component>
        <ChangePassword
            :show="showPasswordModal"
            @alert-password-modal="alertPasswordDialog"
            @close-password-modal="showPasswordDialog"
        ></ChangePassword>
        <UserImage
            :show="showUserImageModal"
            @close-image-modal="closeImageModal"
            :user-avatar="userAvatar"
        ></UserImage>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
        <alert-dialog
            :show="!!error"
            :title="error"
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
        this.activeComponent = `${userType}Account`;
    },
    data() {
        return {
            activeComponent: null,
            showPasswordModal: false,
            showUserImageModal: false,
            userAvatar: null
        };
    },
    mounted() {
        userImageModalBus.$on("openImageModal", avatarSrc => {
            this.showUserImageModal = true;
            this.userAvatar = avatarSrc;
        });
    },
    methods: {
        closeImageModal() {
            this.showUserImageModal = false;
        },
        async submitForm(data) {
            this.isLoading = true;
            try {
                await this.$store.dispatch("user/updateProfileData", data);
                this.showPopupMessage("تم الحفظ بنجاح");
            } catch (e) {
                this.showPopupMessage("حدث خطأ ما")
            }
            this.isLoading = false;
        },
        showPasswordDialog() {
            this.showPasswordModal = !this.showPasswordModal;
        },
        alertPasswordDialog(isShow) {
            this.showPasswordModal = false;
            if (isShow) {
                this.showPopupMessage("تم تغيير كلمة المرور بنجاح");
            } else {
                this.showPopupMessage("كلمة المرور القديمة غير صحيحة");
            }
        }
    }
};
</script>
