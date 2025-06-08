import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js';
import { getDatabase } from 'https://www.gstatic.com/firebasejs/9.22.2/firebase-database.js';

const firebaseConfig = {
    apiKey: "AIzaSyBXgJzaeKW9VT42GWDUekLosTVNCNMKzCw",
    authDomain: "schoolapp-counseling.firebaseapp.com",
    databaseURL: "https://schoolapp-counseling-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "schoolapp-counseling",
    storageBucket: "schoolapp-counseling.firebasestorage.app",
    messagingSenderId: "1011035829400",
    appId: "1:1011035829400:web:c31c1f201ee8dec1f8cced"
};

const app = initializeApp(firebaseConfig);
const database = getDatabase(app);

export { database };