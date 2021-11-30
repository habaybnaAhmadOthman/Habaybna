import { userType, callApi,logIn,logOut ,sanctum} from "../../common";
export default {
    async getCountryCode(context) {
        const resp = await callApi("GET", "/get-user-country");
        if (resp.status != 200) {
            const error = new Error("fail to get country code");
            throw error;
        }
        const countryCode = resp.data.data.countryCode
        context.commit('setCountryCode',countryCode)
    },
    async registerFirstStep(context, payload) {
        await axios.get("/sanctum/csrf-cookie");
        const resp = await callApi("POST", "register", payload);
        if (resp.status != 201) {
            const error = new Error("fail to register");
            throw error;
        }

        logIn();
        context.commit("login");
        context.commit("type",payload.type);
        userType(payload.type)
    },
    async completeRegistration({context,getters}, payload) {
        let type = getters.type

        if (!type) {
            type = window.location.pathname.slice(1).split('-')[0]
        }
        const resp = await callApi(
            "POST",
            `api/${type}-complete-register`,
            payload
        );
        if (resp.status != 200) {
            const error = new Error(`fail to complete registration as ${type}`);
            throw error;
        }
        // return interests
        return resp.data.intrest
    },
     async login(context, payload){
        await axios.get("/sanctum/csrf-cookie");
        const resp = await callApi("POST", "login", payload);

        if (resp.status != 200) {
            const error = new Error("يرجى التحقق من الحقول المدخلة");
            throw error;
        }
        // const token = 'resp.data.userData.token';
        // const userId = resp.data.userData.id;

        // logInWithToken(token,userId);
        logIn();
        context.commit("login");
        context.commit("type",resp.data.userData.role);
        userType(resp.data.userData.role)
    },
    test(){
        sanctum();
        axios.get('/api/profile').then((res)=>{
            console.log(res);
        }).catch((err)=>{
            console.log(err);
        })
    },
    async logout(context){
        const resp = await callApi("POST", "logoutt");
        if (resp.status != 200) {
            const error = new Error("fail to logout");
            throw error;
        }
        logOut();
        context.commit("logout");
    },
    // ******** interests
    async addInterests(_, interests){
        const resp = await callApi("POST", "/store-user-interests", interests);
        if (resp.status != 200) {
            const error = new Error("fail to add interests");
            throw error;
        }
    },
    // ******** userProfile
    async getProfileData() {
        const resp = await callApi("GET", "/api/get-profile-data");
        if (resp.status != 200) {
            const error = new Error("fail to get profile data");
            throw error;
        }
        return resp.data
    },
    async updateProfileData() {
        const resp = await callApi("POST", "/api/update-profile-data");
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
    },
    // ******** userProfile ::: password
    async changePassword() {
        const resp = await callApi("POST", "/api/set-new-password");
        if (resp.status != 200) {
            const error = new Error("fail to change password");
            throw error;
        }
    }
};
