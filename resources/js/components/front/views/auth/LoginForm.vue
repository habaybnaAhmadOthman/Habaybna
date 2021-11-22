<template>
    <div class="mobile-form p-side-50">
        <h2 class="main-color font-40 bold center mb-10">
            تسجيل دخول
        </h2>
        <form @submit.prevent="submitForm">
            <div
                class="form-group mb-30 relative"
                :class="{ invalid: !phone.isValid }"
            >
                <label class="font-20 main-color mb-10">اسم المستخدم</label>
                <input
                    @blur="checkValidity"
                    v-model.trim="phone.val"
                    id="phone"
                    class="form-control font-18 holder-center w-100 user-input"
                    placeholder="رقم الخلوي او البريد الالكتروني"
                />
                <p class="white mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <div
                class="form-group mb-15 relative"
                :class="{ invalid: !password.isValid }"
            >
                <label class="font-20 main-color mb-10">كلمة المرور</label>
                <input
                    class="form-control font-18 holder-center w-100 password-input"
                    @blur="checkValidity"
                    v-model.trim="password.val"
                    id="password"
                    placeholder="xxxxxx"
                />
                <p class="white mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <!-- <div class="form-group">
                <label class="checkbox main-color font-16">
                    <input type="checkbox" name="checkbox-checked" checked />
                    تذكرني
                </label>
            </div> -->
            <button
                class="btn mt-20 border-0 pointer flex-all white m-side-auto font-17"
            >
                تسجيل الدخول
            </button>
        </form>
    </div>
</template>

<script>
export default {
    emits: ["save-form"],
    data() {
        return {
            phone: {
                val: "",
                isValid: true
            },
            password: {
                val: "",
                isValid: true
            },
            formIsValid: true
        };
    },
    methods: {
        validateForm() {
            this.formIsValid = true;
            if (this.phone.val == "") {
                this.phone.isValid = false;
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
        submitForm() {
            this.validateForm();
            if (!this.formIsValid) {
                return;
            }
            
            this.$emit("save-form", {
                phone: this.phone.val,
                password: this.password.val
            });
        }
    }
};
</script>

<style scoped>
.user-input ,.password-input{
    background-image: url(/images/logo.png);
    background-repeat: no-repeat;
    background-size: 40px 40px;
    background-position: 20px center;
}
.password-input {
    background-image: url(/images/logo.png);
}
.form-control {
    padding-right: 20px;
    padding-left: 70px;
    height: 60px;
}
.checkbox {
    font-family: system-ui, sans-serif;
    font-weight: bold;
    line-height: 1.1;
    display: flex;
    cursor: pointer;
    align-items: center;
}
input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    margin: 0;
    width: 25px;
    height: 25px;
    border: 1px solid #660066;
    border-radius: 3px;
    transform: translateY(-0.075em);
    display: grid;
    place-content: center;
    margin-left: 12px;
}

input[type="checkbox"]::before {
    content: "";
    width: 15px;
    height: 15px;
    -webkit-clip-path: polygon(
        14% 44%,
        0 65%,
        50% 100%,
        100% 16%,
        80% 0%,
        43% 62%
    );
    clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
    transform: scale(0);
    transform-origin: bottom left;
    transition: 120ms transform ease-in-out;
    /* Windows High Contrast Mode */
    background-color: CanvasText;
}

input[type="checkbox"]:checked::before {
    transform: scale(1);
}
</style>
