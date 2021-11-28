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

export function logIn() {
    localStorage.setItem("login", true);
}
export function logOut() {
    localStorage.removeItem('login')
}