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
export async function shuffle(a) {
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
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