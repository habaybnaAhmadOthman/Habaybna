<template>
    <form @submit.prevent="register" class="pt-100 p-side-30 mt-30">
        <div :class="{'invalid': !email.isValid}" class="form-group">
            <input placeholder="email" id="email" @blur="checkValidity" v-model.trim="email.val" />
            <p>please enter a correct email</p>
        </div>
        <div class="form-group" :class="{invalid: !password.isValid}">
            <input type="password" id="password" @blur="checkValidity" v-model.trim="password.val" />
            <p>this field is required</p>
        </div>
        <button>Register</button>
        <router-link to="/login">Login instead</router-link>
    </form>
</template>

<script>
export default {
    data() {
        return {
            email: {
                val: '',
                isValid: true
            },
            password: {
                val: '',
                isValid: true
            },
            formIsValid: true
        };
    },
    methods: {
        checkValidity(e){
            if (e.target.value != '') {
                this[e.target.id].isValid = true
            } else {
                this[e.target.id].isValid = false
            }
            if (e.target.id == 'email' && !e.target.value.includes('@')) {
                this[e.target.id].isValid = false
            }
        },
        validateForm() {
            this.formIsValid = true;
            if (!this.email.val.includes("@") || this.email.val == "") {
                this.email.isValid = false;
                this.formIsValid = false;
            }
            if (this.password.val == "") {
                this.password.isValid = false;
                this.formIsValid = false;
            }
        },
        register() {
            this.validateForm()
            if (!this.formIsValid) {
                return;
            }
        }
    }
};
</script>

<style scoped>
.form-group p {
    display: none;
}
.form-group.invalid p {
    display: block;
}
</style>
