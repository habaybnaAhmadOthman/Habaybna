import { isLoggedIn, callApi,logIn,logOut ,logInWithToken,sanctum,local_userID} from "../../common";
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
        const resp = await callApi("POST", "/register", payload);
        if (resp.status != 201) {
            const error = new Error("fail to register");
            throw error;
        }
        const token = resp.data.userData.token;
        const userId = resp.data.userData.user.id;

        logInWithToken(token,userId);
        context.commit("login",token,userId);
    },
    async completeRegistration({context,getters}, payload) {
        let type = getters.type

        if (!type) {
            type = window.location.pathname.slice(1).split('-')[0]
        }
        const resp = await callApi(
            "POST",
            `/${type}-complete-register`,
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
        const resp = await callApi("POST", "/api/login", payload);
        
        if (resp.status != 200) {
            const error = new Error("يرجى التحقق من الحقول المدخلة");
            throw error;
        }
        const token = resp.data.userData.token;
        const userId = resp.data.userData.user.id;

        logInWithToken(token,userId);
        context.commit("login",token,userId);
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
        sanctum();
        const resp = await callApi("POST", "/api/logoutt",{id:local_userID()});
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
    async getProfileData(){
        const resp = await callApi("GET", "/api/get-profile-data");
        if (resp.status != 200) {
            const error = new Error("fail to get profile data");
            throw error;
        }
        return resp.data
    },
    async updateProfileData() {
        const resp = await callApi("PUT", "/api/update-profile-data");
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
    }
};
