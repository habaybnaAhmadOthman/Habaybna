<template>
    <div>
        <component
            :is="activeComponent"
            @submitForm="submitForm"
            @open-password-dialog="showPasswordDialog"
            :years="birthDateYears"
            @loading="triggerLoading"
        ></component>
        <ChangePassword
            :show="showPasswordModal"
            @alert-password-modal="alertPasswordDialog"
            @close-password-modal="showPasswordDialog"
        ></ChangePassword>
        <UserImage
            :show="showUserImageModalGlobal"
            @loading="triggerLoading"
            @popup-alert="openAlertDialog"
        ></UserImage>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
        <alert-dialog
            :show="!!error"
            :title="error"
            @close="closeModal"
        ></alert-dialog>
        <alert-dialog
            :show="!!alertDialog"
            :title="alertDialog"
            @close="closeAlertDialog">
        </alert-dialog>
    </div>
</template>
<script>
import parentAccount from "./myaccount/Parent.vue";
import specialistAccount from "./myaccount/Specialist.vue";
import otherAccount from "./myaccount/Other.vue";

import ChangePassword from "../../views/userprofile/myaccount/ChangePassword.vue";
import UserImage from "../../views/userprofile/myaccount/UserImage.vue";

import loadingMixin from "./../../mixins/loading.js";
import years from '../../../../modules/years';


export default {
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
            userAvatar: null,
            birthDateYears: null,
            alertDialog: null,
        };
    },
    mounted() {
        this.birthDateYears = years
    },
    computed: {
        showUserImageModalGlobal(){
            return this.$store.getters['user/openAvatarModal']
        }
    },
    methods: {
        triggerLoading(show){
            this.isLoading = show;
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
        },
        openAlertDialog(paramName,message){
            if (paramName == "showUserImageModal") {
                this.$store.commit('user/openAvatarModal',false);
            } else {
                this[paramName] = false;
            }
            this.alertDialog = message;
        },
        closeAlertDialog(){
            this.alertDialog = null
        }
    }
};
</script>
