export default {
    created() {
        this.getUserCountry();
    },
    data() {
        return {
            phoneNumber: {
                input: "",
                val: "",
                isValid: true,
                countryCode: "",
                obj:null,
                created: false
            },
            countryCode:'',
        };
    },
    methods: {
        async getUserCountry() {
            await this.$store.dispatch("user/getCountryCode");
            this.countryCode = this.$store.getters["user/countryCode"];
        },
        getPhoneVal(phoneNumberInput) {
            if (phoneNumberInput.isValid) {
                this.phoneNumber.val = phoneNumberInput.formattedNumber;
            } 
            this.phoneNumber.isValid = phoneNumberInput.isValid;
        },
        checkPhoneNumber() {
            if (this.phoneNumber.created == false) {
                this.phoneNumber.isValid = true;
                // this.phoneNumber.created = true;
            }
        }
    }
}