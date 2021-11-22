export default {
    setUser(state,payload){
        state.phone = payload.phone
        state.type = payload.type
        state.token = payload.token
    },
    setCountryCode(state,countryCode) {
        state.countryCode = countryCode
    }
    // parentCompleteRegistration(state,payload){
    //     state.phone = payload.phone
    //     state.type = payload.type
    //     console.log(state);
    // },
}