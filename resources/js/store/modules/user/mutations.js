export default {
    setUser(state,payload){
        state.phone = payload.phone
        state.type = payload.type
        state.token = payload.token
    },
    setCountryCode(state,countryCode) {
        state.countryCode = countryCode
    },
    // login(state,payload){
    //     state.is_verify = payload.is_verify;
    // },
}