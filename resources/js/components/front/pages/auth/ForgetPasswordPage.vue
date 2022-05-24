<template>
    <div>
        <RegisterTemplate>
            <ForgetPasswordForm @save-form="login"> </ForgetPasswordForm>
        </RegisterTemplate>
<alert-dialog
            :show="!!error"
            :title="error"
            @close="closeModal"
        >
        </alert-dialog>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
    </div>
</template>

<script>
// // forms
import RegisterTemplate from "./../../views/auth/RegisterTemplate.vue";
import ForgetPasswordForm from "./../../views/auth/ForgetPasswordForm.vue";
import loadingMixin from './../../mixins/loading.js'
export default {
    mixins: [loadingMixin],
    components: {
        RegisterTemplate,
        ForgetPasswordForm
    },
    mounted(){

    },
    data() {
        return {
            type: "",
            code: "",
            isBanned: false,
        };
    },
    methods: {
        async login(data) {
            this.isLoading = true;
            this.isBanned = false
            try {
                const resp = await this.$store.dispatch("user/login", {
                    password: data.password,
                    phone: data.phone
                });
                
                const userType = this.$store.getters["user/type"]

                if (userType == 'admin') {
                    window.location.href = '/admin'
                } else {
                    this.$router.replace("/");
                }
            } catch (e) {
                if (e.message == 'تم إيقاف حسابك') { 
                    this.isBanned = true
                }
                
                this.showPopupMessage(e.message);
            }
            this.isLoading = false;
        }
    }
};
</script>
