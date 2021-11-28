export default {
    setUser(state, payload) {
        state.phone = payload.phone;
        state.type = payload.type;
        state.token = payload.token;
    },
    login(state) {
        state.loggedIn = true;
    },
    logout(state) {
        state.loggedIn = false;
    },
    setCountryCode(state, countryCode) {
        state.countryCode = countryCode || state.countryCode;
    }
    // login(state,payload){
    //     state.is_verify = payload.is_verify;
    // },
};
