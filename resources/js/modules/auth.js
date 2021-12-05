import axios from "axios";
import router from '../router';
import store from "../store/index.js";

axios.interceptors.response.use(undefined, function (error) {
  if (error) {
    const originalRequest = error.config; 
    if (error.response.status === 401 && !originalRequest._retry) {
        originalRequest._retry = true;
        console.log('session end');
        localStorage.removeItem("login")
        store.commit('user/clearUser')
        return router.push('/signin')
    }
  }
})
