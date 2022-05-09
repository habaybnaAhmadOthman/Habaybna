export default {
    loginModal(state) {
        return state.showLoginModal;
    },
    forceRefresh:state => state.forceRefresh,
    alertDialogMsg:state => state.alertDialogMsg,
    isLoading:state => state.isLoading,
};
