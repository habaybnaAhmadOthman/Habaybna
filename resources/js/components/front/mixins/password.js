export default {
    data() {
        return {
            password: {
                val: "",
                isValid: true,
                show: false,
                has_minimum_lenth: false,
                has_number: false,
                has_lowercase: false,
                has_uppercase: false,
                has_special: false
            }
        };
    },
    methods: {
        passwordCheck() {
            this.password.has_minimum_lenth = this.password.val.length > 5;
            // this.password.has_number = /\d/.test(this.password.val);
            // this.password.has_lowercase = /[a-z]/.test(this.password.val);
            // this.password.has_uppercase = /[A-Z]/.test(this.password.val);
            // this.password.has_special = /[!@#\$%\^\&*\)\(+=._-]/.test(
            //     this.password.val
            // );

            if (
                !this.password.has_minimum_lenth 
                // !this.password.has_number ||
                // !this.password.has_lowercase ||
                // !this.password.has_uppercase ||
                // !this.password.has_special
            ) {
                this.password.isValid = false;
            } else {
                this.password.isValid = true;
            }
        },
        passwordVisibility() {
            this.password.show = !this.password.show;
        }
    }
}