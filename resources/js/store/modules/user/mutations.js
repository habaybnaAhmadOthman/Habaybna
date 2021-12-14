export default {
    setUser(state, payload) {
        state.firstName = payload.firstName || null;
        state.lastName = payload.lastName || null;
        state.type = payload.type || null;
        state.avatar = payload.avatar || null;
        state.token = payload.token || null;
        state.loggedIn = true;
        state.is_verify = true;
    },
    clearUser(state) {
        state.firstName = null;
        state.lastName = null;
        state.type = null;
        state.avatar = null;
        state.token = null;
        state.loggedIn = false;
        state.is_verify = false;
    },
    type(state,userType) {
        state.type = userType;
    },
    openAvatarModal(state,isOpen) {
        state.openAvatarModal = isOpen;
    },
    login(state) {
        state.loggedIn = true;
        state.is_verify = true;
    },
    userAvatar(state,src){
        state.avatar = src
    },
    setCountryCode(state, countryCode) {
        state.countryCode = countryCode || state.countryCode;
    }
    // login(state,payload){
    //     state.is_verify = payload.is_verify;
    // },
};
