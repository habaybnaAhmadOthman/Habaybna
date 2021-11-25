import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";

// const firebaseConfig = {
//   apiKey: "AIzaSyBtT7zNSwVmFAexZjNi7WuHAyXGADSoMwc",
//   authDomain: "habaybna-21237.firebaseapp.com",
//   projectId: "habaybna-21237",
//   storageBucket: "habaybna-21237.appspot.com",
//   messagingSenderId: "759094603217",
//   appId: "1:759094603217:web:ba601f8d8d7f7cd51e44f0"
// };
const firebaseConfig = {
    apiKey: "AIzaSyA6X4boucs3IhgeMEU_5q_uLcljaARVJ6c",
    authDomain: "smsnew-5b990.firebaseapp.com",
    projectId: "smsnew-5b990",
    storageBucket: "smsnew-5b990.appspot.com",
    messagingSenderId: "656328220671",
    appId: "1:656328220671:web:c039281b2c2e0eb41551ca",
    measurementId: "G-TDED180GFL"
};
const app = initializeApp(firebaseConfig);
const auth = getAuth();

export default auth;
