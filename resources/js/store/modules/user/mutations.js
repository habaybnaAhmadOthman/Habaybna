export default {
    setUser(state, payload) {
        state.firstName = payload.firstName;
        state.lastName = payload.lastName;
        state.type = payload.type;
        state.avatar = payload.avatar;
        state.loggedIn = payload.loggedIn;
    },
    login(state) {
        state.loggedIn = true;
    },
    type(state,userType) {
        state.type = userType;
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
