import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
const firebaseConfig = {
  apiKey: "AIzaSyBtT7zNSwVmFAexZjNi7WuHAyXGADSoMwc",
  authDomain: "habaybna-21237.firebaseapp.com",
  projectId: "habaybna-21237",
  storageBucket: "habaybna-21237.appspot.com",
  messagingSenderId: "759094603217",
  appId: "1:759094603217:web:ba601f8d8d7f7cd51e44f0"
};
// let appVerifier = this.appVerifier;
  const app = initializeApp(firebaseConfig);
  const auth = getAuth();

  
export default auth