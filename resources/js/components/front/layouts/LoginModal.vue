<template>
    <aside>
        <div v-if="showModal" class="w-100 h-100 backdrop" @click="closeLoginModal"></div>
        <transition name="modal">
            <dialog
                class="login-modal"
                v-if="showModal"
                open
            >
                <img src="/images/close-icon.svg" @click="closeLoginModal" class="close-modal-icon" width="24" height="24">

                <form class="login-form" @submit.prevent="submitForm">
                    <p class="font-27 bold pr-10 main-color mb-40">تسجيل الدخول</p>
                    <div class="input-box mb-20" :class="{ invalid: !email.isValid }">
                        <input id="email" @blur="checkValidity" v-model.trim="email.val" type="text" placeholder="اسم المستخدم">
                        <p class="main-color mt-5 font-12 req">هذا الحقل مطلوب</p>
                    </div>
                    <div class="input-box mb-20" :class="{ invalid: !password.isValid }">
                        <input id="password" @blur="checkValidity" type="password" v-model.trim="password.val" placeholder="كلمة السر">
                        <p class="main-color mt-5 font-12 req">هذا الحقل مطلوب</p>
                    </div>
                    <div class="d-flex space-between mb-40">
                        <router-link class="main-color font-20 bold" to="/">هل نسيت كلمة السر؟</router-link>
                        <p class="black-2 bold font-20">هل أنت مستخدم جديد؟ <router-link class="main-color pr-10" to="/register">سجل من هنا</router-link></p>
                    </div>
                    <input type="submit" class="main-bg white submit-btn font-20 bold flex-all pointer" value="تسجيل دخول">
                </form>
            </dialog>
        </transition>
         <alert-dialog
            :show="!!error"
            :title="error"
            @close="closeModal"
        ></alert-dialog>
        <div v-if="isLoading">
            <loading-spinner></loading-spinner>
        </div>
    </aside>
</template>

<script>
import loadingMixin from '../mixins/loading'
export default {
    mixins: [loadingMixin],
    computed: {
        showModal(){
            return this.$store.getters['loginModal']
        }
    },
    data:()=> ({
        email: {
            val: "",
            isValid: true
        },
        password: {
            val: "",
            isValid: true
        },
        formIsValid: true
    }),
    methods: {
        closeLoginModal() {
            this.$store.commit('loginModal',false)
        },
        validateForm() {
            this.formIsValid = true;
            
            if (this.email.val == "") {
                this.email.isValid = false;
                this.formIsValid = false;
            }
            if (this.password.val == "") {
                this.password.isValid = false;
                this.formIsValid = false;
            }
        },
        checkValidity(e) {
            if (e.target.value != "") {
                this[e.target.id].isValid = true;
            } else {
                this[e.target.id].isValid = false;
            }
        },
        async submitForm() {
            this.validateForm();
            if (!this.formIsValid) {
                return;
            }
            this.isLoading = true;
            try {
                await this.$store.dispatch("user/loginModal", {
                    password: this.password.val,
                    phone: this.email.val
                });
                const userType = this.$store.getters["user/type"]

                if (userType == 'admin') {
                    window.location.href = '/admin'
                } else {
                    this.$router.replace("/");
                }
            } catch (e) {
                this.showPopupMessage(e.message);
            }
            this.isLoading = false;
        }
    }
};
</script>

<style scoped>
.backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
    background-color: rgba(0, 0, 0, 0.75);
}
dialog {
    position: fixed;
    top: 3%;
    left: 10%;
    z-index: 1000;
    right: 0;
    left: 0;
    margin: auto;
    width: 900px;
    height: 582px;
    background: #FAFAFA;
    box-shadow: 0px 3px 6px #00000029;
    border: 1px solid #707070;
    border-radius: 10px;
    overflow-y: auto;
}

.modal-enter-active {
    animation: modal 0.3s ease-out;
}

.modal-leave-active {
    animation: modal 0.3s ease-in reverse;
}
.close-modal-icon {
    position: absolute;
    top: 35px;
    right: 40px;
    cursor: pointer;
}
.login-form {
    padding: 90px 150px 100px 150px;
}
.input-box input {
    background: #FFFFFF 0% 0% no-repeat padding-box;
    box-shadow: 0px 1px 3px #00000029;
    border: 1px solid #C6C6C6;
    border-radius: 10px;
    height: 60px;
    color: #939598;
    font-size: 20px;
    padding: 20px;
    width: 100%;
}
.submit-btn {
    width: 100%;
    border-radius: 25px;
    border: 0;
    height: 60px;
}
@keyframes modal {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
@media (max-width: 767px) {
    dialog {
        top: 5%;
    }
}
.req {
    display: none;
}
.input-box.invalid .req {
    display: block;
}
</style>
