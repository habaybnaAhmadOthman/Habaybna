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

export function isLoggedIn() {
    return localStorage.getItem("login") == "true";
}
export function logInWithToken(token) {
    localStorage.setItem("login", true);
    localStorage.setItem("token", token);
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}
export function logOut() {
    localStorage.removeItem("login");
    localStorage.removeItem('token')
}
export function sanctum() {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
}