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
    // ******** interests ::: post
    async addInterests(_, interests){
        const resp = await callApi("POST", "/api/store-user-interests", interests);
        if (resp.status != 200) {
            const error = new Error("fail to add interests");
            throw error;
        }
    },
    // ******** retreive user data ::: get      
    async checkUserAuth(context) {
        const resp = await callApi("GET", "/api/check-user-authentication");
        if (resp.status == 404) {
            context.commit('setUser',{
                firstName: null,
                lastName: null,
                type: null,
                avatar: '/images/siteImgs/header/logo.png',
                loggedIn: false
            });
            return false;
        } 
        
        context.commit('setUser',{
            firstName: 'firstName',
            lastName: 'firstName',
            type: 'firstName',
            avatar: 'firstName',
            loggedIn: true
        })
        return true;
        
    },
    // ******** userProfile ::: get
    async getProfileData() {
        const resp = await callApi("GET", "/api/get-profile-data");
        if (resp.status != 200) {
            const error = new Error("fail to get profile data");
            throw error;
        }
        return resp.data
    },
    // ******** edit user profile ::: edit
    async updateProfileData({_,getters},payload) {
        const resp = await callApi("POST", `/api/edit-${getters.type}-profile-data`,payload);
        if (resp.status != 200) {
            const error = new Error("fail to update profile data");
            throw error;
        }
    },
    // ******** userProfile ::: password
    async changePassword(_,payload) {
        const resp = await callApi("POST", "/api/set-new-password",payload);
        if (!resp.data.status) {
            const error = new Error("كلمة المرور القديمة غير صحيحة");
            throw error;
        }
    },
    // ******** userProfile ::: private mode
    async privateMode(_,payload) {
        const resp = await callApi("POST", "/api/set-private-mode",{isPrivateMode: payload});
        if (!resp.data.status) {
            const error = new Error("هناك خطأ ما");
            throw error;
        }
    }
};
