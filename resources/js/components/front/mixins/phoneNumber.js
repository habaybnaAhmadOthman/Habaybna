export default {
    data() {
        return {
            phoneNumber: {
                input: "",
                val: "",
                isValid: true,
                countryCode: "",
                style: false,
                created: false
            }
        };
    },
    methods: {
        getPhoneVal(phoneNumberInput) {
            if (phoneNumberInput.isValid) {
                this.phoneNumber.val = phoneNumberInput.formattedNumber;
                this.phoneNumber.isValid = true;
            }
        },
        checkPhoneNumber(e) {
            if (!this.phoneNumber.created) {
                this.phoneNumber.isValid = true;
            }
        },
    }
}