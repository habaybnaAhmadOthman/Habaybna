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
        showErrorMessage(msg) {
            this.error = msg;
        }
    }
}