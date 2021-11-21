async function callApi(method, url, dataObj) {
    try {
        return await axios({
            method: method,
            url: url,
            data: dataObj
        })
    } catch (e) {
        return e.response
    }
}

export default {
    async register(context,payload){
        const resp = await callApi("POST", "/register",payload);
        if (resp.status != 200) {
            const error = new Error('fail to register');
            throw error;
        }
        context.commit('register',payload);
    },
    async registerFirstStep(context,payload){
        const resp = await callApi("POST", "/register",payload);
        if (resp.status != 200) {
            const error = new Error('fail to register');
            throw error;
        }
        console.log('resp',resp);
        context.commit('register',payload);
    }
}
