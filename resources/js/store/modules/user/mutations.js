export default {
    setUser(state, payload) {
        state.phone = payload.phone;
        state.type = payload.type;
        state.token = payload.token;
    },
    login(state,token,id) {
        state.loggedIn = true;
        state.token = token;
        state.userID = id;
    },
    logout(state) {
        state.loggedIn = false;
        state.token = null;
        state.userID = null;
    },
    setCountryCode(state, countryCode) {
        state.countryCode = countryCode || state.countryCode;
    }
    // login(state,payload){
    //     state.is_verify = payload.is_verify;
    // },
};
