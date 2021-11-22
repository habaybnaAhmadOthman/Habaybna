export default {
    data() {
        return {
            phoneNumber: {
                input: "",
                val: "",
                isValid: true,
                countryCode: "",
                obj:null,
                created: false
            }
        };
    },
    methods: {
        getPhoneVal(phoneNumberInput) {
            if (phoneNumberInput.isValid) {
                this.phoneNumber.val = phoneNumberInput.formattedNumber;
            } 
            this.phoneNumber.isValid = phoneNumberInput.isValid;
        },
        checkPhoneNumber(e) {
            if (!this.phoneNumber.created) {
                this.phoneNumber.isValid = true;
            }
            
        },
    }
}