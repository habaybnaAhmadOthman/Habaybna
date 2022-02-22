export default {
    loginModal(state,isOpen) {
        state.showLoginModal = isOpen
    },
    forceRefresh: state => state.forceRefresh += 1
};
