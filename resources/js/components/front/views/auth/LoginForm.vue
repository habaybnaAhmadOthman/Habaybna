<template>
    <div class="mobile-form pt-10 p-side-50">
        <h2 class="main-color font-40 bold center mb-50">
            تسجيل دخول
        </h2>
        <form @submit.prevent="submitForm">
            <div class="form-group mb-30 relative">
                <label class="font-30 main-color mb-10">اسم المستخدم</label>
                <input class="form-control font-18 holder-center w-100 user-input"  placeholder="رقم الخلوي او البريد الالكتروني" >
                <p class="white mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <div class="form-group mb-30 relative">
                <label class="font-30 main-color mb-10">كلمة المرور</label>
                <input class="form-control font-18 holder-center w-100 user-input"  placeholder="xxxxxx" >
                <p class="white mt-5 font-12">هذا الحقل مطلوب</p>
            </div>
            <div class="form-group mb-30">
                <label class="checkbox">
                    <input type="checkbox" name="checkbox-checked" checked />
                    Checkbox - checked
                </label>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            phoneNumber: {
                val: "",
                isValid: true
            },
            formIsValid: true
        };
    },
    methods: {
        validateForm() {
            this.formIsValid = true;
            if (this.phoneNumber.val == "") {
                this.phoneNumber.isValid = false;
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

            let phoneNumber = this.phoneNumber.val;
            this.$emit("send-otp", { phoneNumber });
        }
    }
}
</script>

<style scoped>
.user-input {
    background-image: url(/images/logo.png);
    background-repeat: no-repeat;
    background-size: 40px 40px;
    background-position: 20px center;
}
.form-control {
    padding-right: 20px;
    padding-left: 70px;
    height: 60px
}
.checkbox {
  font-family: system-ui, sans-serif;
  font-size: 2rem;
  font-weight: bold;
  line-height: 1.1;
  display: grid;
  grid-template-columns: 1em auto;
  gap: 0.5em;
  cursor: pointer;
}
input[type=checkbox] {
  -webkit-appearance: none;
  -moz-appearance: none;
       appearance: none;
  background-color: transparent;
  margin: 0;
  width: 25px;
  height: 25px;
  border: 1px solid currentColor;
  border-radius: 3px;
  transform: translateY(-0.075em);
  display: grid;
  place-content: center;
}

input[type=checkbox]::before {
  content: "";
  width: 15px;
  height: 15px;
  -webkit-clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
          clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
  transform: scale(0);
  transform-origin: bottom left;
  transition: 120ms transform ease-in-out;
  box-shadow: inset 1em 1em var(--form-control-color);
  /* Windows High Contrast Mode */
  background-color: CanvasText;
}

input[type=checkbox]:checked::before {
  transform: scale(1);
}
</style>
