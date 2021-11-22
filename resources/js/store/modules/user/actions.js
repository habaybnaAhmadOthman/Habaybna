async function callApi(method, url, dataObj) {
    try {
        return await axios({
            method: method,
            url: url,
            data: dataObj
        });
    } catch (e) {
        return e.response;
    }
}

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
        const resp = await callApi("POST", "/register", payload);
        if (resp.status != 201) {
            const error = new Error("fail to register");
            throw error;
        }

        context.commit("setUser", payload);
    },
    async completeRegistration({context,getters}, payload) {
        let type = getters.type
        type = 'parent'
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
        const resp = await callApi("POST", "/login", payload);
        if (resp.status != 200 || resp.status != 201) {
            const error = new Error("fail to login");
            throw error;
        }
        context.commit("setUser", payload);
    },
    
    
};
