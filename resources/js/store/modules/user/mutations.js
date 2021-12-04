export default {
    setUser(state, payload) {
        state.firstName = payload.firstName || null;
        state.lastName = payload.lastName || null;
        state.type = payload.type || null;
        state.avatar = payload.avatar || null;
        state.loggedIn = true;
    },
    clearUser(state) {
        state.firstName = null;
        state.lastName = null;
        state.type = null;
        state.avatar = null;
        state.loggedIn = false;
    },
    type(state,userType) {
        state.type = userType;
    },
    setCountryCode(state, countryCode) {
        state.countryCode = countryCode || state.countryCode;
    }
    // login(state,payload){
    //     state.is_verify = payload.is_verify;
    // },
};
