export async function callApi(method, url, dataObj) {
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

export function logIn() {
    localStorage.setItem("login", true);
}

export function logOut() {
    localStorage.removeItem("login");
}
export function sanctum() {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
}
