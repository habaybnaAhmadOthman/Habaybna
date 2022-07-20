<template>
    <div>
        <RegisterTemplate>
            <LoginForm @save-form="login"> </LoginForm>
            <h3 class="mt-50 mt-20-p center light font-15 flex-all p-side-50 flex-wrap p-side-12-p w-100-p">
                <router-link class=" d-flex align-center font-15-p" to="/signup"
                    >هل تريد إنشاء حساب؟</router-link
                >
            </h3>
        </RegisterTemplate>
        <alert-dialog
            :show="!!error"
            :title="error"
            @close="closeModal"
        >
        <template v-if="isBanned" #actions>
            <router-link to="/contact-us" class="btn mb-10 ml-10">
                اضغط هنا للمتابعة
            </router-link>
        </template>
        </alert-dialog>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
    </div>
</template>

<script>
// // forms
import RegisterTemplate from "./../../views/auth/RegisterTemplate.vue";
import LoginForm from "./../../views/auth/LoginForm.vue";
import loadingMixin from './../../mixins/loading.js'
export default {
    mixins: [loadingMixin],
    components: {
        RegisterTemplate,
        LoginForm
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
                await this.$store.dispatch("user/login", {
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
