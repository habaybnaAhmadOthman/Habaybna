export default {
    loginModal(state,isOpen) {
        state.showLoginModal = isOpen
    },
    forceRefresh: state => state.forceRefresh += 1,
    alertDialogMsg: (state,message) => state.alertDialogMsg = message,
    isLoading: (state,isLoad) => state.isLoading = isLoad,
};
