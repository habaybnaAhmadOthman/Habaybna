export default {
    data() {
        return {
            isLoading: false,
            error: null
        };
    },
    methods: {
        closeModal() {
            this.error = null;
        },
        showPopupMessage(msg) {
            this.error = msg;
        }
    }
}