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
        const resp = await callApi("POST", "https://habaybna-21237-default-rtdb.firebaseio.com/users.json",payload);
        if (resp.status != 200) {
            const error = new Error('fail to register');
            throw error;
        }
        context.commit('register',payload);
    }
}