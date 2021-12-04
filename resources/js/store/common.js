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

// export function isLoggedIn() {
//     return localStorage.getItem("login") == "true";
// }
export function logIn() {
    localStorage.setItem("login", true);
}
// export function userType(type) {
//     localStorage.setItem("type", type);
// }
// export function logInWithToken(token,userID) {
//     localStorage.setItem("login", true);
//     localStorage.setItem("token", token);
//     localStorage.setItem("userID", userID);
//     window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
// }
export function logOut() {
    localStorage.removeItem("login");
}
export function sanctum() {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`
}