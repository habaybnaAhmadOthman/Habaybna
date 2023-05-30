import {callApi} from "../../common";
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
        const resp = await callApi("POST", "api/register", payload);
        if (!resp || resp.status != 201) {
            const error = new Error("رقم الهاتف مستخدم، يرجى تجربة رقم آخر");
            throw error;
        }
    },
    async completeRegistration({_,getters,dispatch}, payload) {
        let type = getters.type

        if (!type) {
            type = window.location.pathname.slice(1).split('-')[0]
        }
        const resp = await callApi(
            "POST",
            `api/${type}-complete-register`,
            payload
        );
        if (resp.status == 203) {
            const error = new Error(`fail to complete registration as ${type}`);
            throw error;
        }
        dispatch('checkUserAuth')
        // return interests
        return resp.data.intrest
    },
    // ******** login :::
    async login(context, payload) {
        await axios.get("/sanctum/csrf-cookie");
        const resp = await callApi("POST", "api/login", payload);
        if (resp && resp.data && resp.data.status && resp.data.status == 403) {
            const error = new Error("تم إيقاف حسابك");
            throw error;
        }
        if (!resp  ||resp.status != 200) {
            const error = new Error("يرجى التأكد من الحقول المدخلة");
            throw error;
        }
        context.commit('clearUser');
        context.commit('clearAdmin');

        context.commit('setUser',{
            token: resp.data.token,
            id: resp.data.user.id,
        })
        axios.defaults.headers.common.Authorization = `Bearer ${resp.data.token}`;
        await context.dispatch('checkUserAuth')
    },
    // ******** login modal :::
    // !!!!!!!!!!!!!
    // check error handling
    async loginModal(context, payload) {
        await axios.get("/sanctum/csrf-cookie");
        const resp = await callApi("POST", "api/login", payload);
        if (resp && resp.data && resp.data.status && resp.data.status == 403) {
            const error = new Error("تم إيقاف حسابك");
            throw error;
        }
        if (!resp ||  resp.status != 200) {
            const error = new Error("يرجى التأكد من الحقول المدخلة");
            throw error;
        }
        context.commit('clearUser');
        context.commit('clearAdmin');
        context.commit('setUser',{
            token: resp.data.token,
            id: resp.data.userData.id,
        })
        axios.defaults.headers.common.Authorization = `Bearer ${resp.data.token}`;
        await context.dispatch('checkUserAuth')
    },
    async forgetPassword(context, payload) {
        // await axios.get("/sanctum/csrf-cookie");
        const resp = await callApi("POST", "/api/user/forget-password", payload);
        if (!resp || resp.status != 200) {
            const error = new Error("يرجى التأكد من الحقول المدخلة");
            throw error;
        }
    },
    // ******** logout :::
    async logout({commit,rootState,dispatch}){
        const resp = await callApi("POST", "logout");
        if (resp.status != 204) {
            const error = new Error("fail to logout");
            throw error;
        }
        rootState.showLoginModal = false;
        commit('clearUser');
        commit('clearAdmin');
        await dispatch('courses/getAllCourses',{}, {root:true})

    },
    //**** logout admin */
    async Adminlogout({commit,rootState}){
        const resp = await callApi("POST", "/logout");
        if (resp.status != 204) {
            const error = new Error("fail to logout");
            throw error;
        }
        rootState.showLoginModal = false;
        commit('clearAdmin');
    },
    // ******** logout modal :::
    async logoutModal({commit,rootState,dispatch}){
        const resp = await callApi("POST", "/logout");
        if (resp.status != 204) {
            const error = new Error("fail to logout");
            throw error;
        }
        rootState.showLoginModal = false;
        commit('clearUser');
        commit('clearAdmin');
        await dispatch('courses/getAllCourses',{}, {root:true})
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
    async checkUserAuth({commit,dispatch}) {
        const resp = await callApi("GET", "/api/check-user-authentication");
        if (resp.status == 404) {
            commit('clearUser');
            return false;
        }

        const obj = resp.data.userData;
        if (obj.role != 'admin') {
            commit('setUser',{
                firstName: obj.firstName,
                lastName: obj.lastName,
                type: obj.type,
                canMakeCalls: obj.can_make_call,
                canMakeComment: obj.can_make_comment,
                avatar: obj.avatar,
                id: obj.id,
                token:obj.token
                // notifications:obj.notifications
            })
            commit('setUserNotificatins',{
                notifications:obj.notifications
            })

            await dispatch('courses/getAllCourses',{}, {root:true})
        } else { // is admin

            commit('type',obj.role)
            commit('login')
        }
        return true

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

    // set notifications
    async setNotifications (context) {
        await callApi("get", "/api/user-notifications").then((resp) => {

            context.commit('setUserNotificatins',{
                notifications:resp.data
            })
          });

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
        const resp = await callApi("POST", "/api/user/forget-password/change-password",payload);
        if (payload.hasOwnProperty('type') && payload.type == 'forget') {
            if (!resp || resp == 'notVerify') {
                const error = new Error('حصل خطأ ما');
                throw error;
            }
        }
        if (!resp.data.status) {
            const error = new Error('كلمة المرور القديمة غير صحيحة');
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
    },
    // ******** userProfile ::: upload profile avatar
    async profileAvatar(_,payload) {
        const resp = await callApi("POST", "/api/edit-profile-image", payload);
        if (resp.status != 200) {
            const error = new Error("هناك خطأ ما");
            throw error;
        }
        return resp.data.url
    },

    async checkOtp(_,payload) {
        let url = '/api/check-otp'
        if (payload.hasOwnProperty('type') && payload.type == 'forget')
            url = '/api/user/forget-password/check-otp'

        const resp = await callApi("POST", url, payload);
        if (resp.status != 200) {
            const error = new Error("رمز التحقق غير صحيح");
            throw error;
        }
        if (!payload.hasOwnProperty('type'))
            return resp.data.url
    },

    // ******** get calls log ::: POST
    async getCallsLog(context,payload) {

        let queryFilters = `?page=${payload.page}`
        if (payload.filters && payload.filters.length > 0 && payload.filters != 'all') {
            // scheduled ==> 0
            // succeeded ==> 1
            // missed ==> 2
            const statuses = {
                "scheduled": '0',
                "succeeded": '1',
                "missed": '2',
            }

            queryFilters += `&filters=${statuses[payload.filters]}`
        }

        const resp = await callApi("GET", `/api/get-user-call-log${queryFilters}`);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to getCallsLog");
            throw error;
        }
        return resp.data
    },
};
