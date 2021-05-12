import firebase from 'firebase';

const firebaseConfig = {
  apiKey: process.env.REACT_APP_FCM_WEB_API_KEY,
  authDomain: process.env.REACT_APP_FCM_WEB_AUTH_DOMAIN,
  projectId: process.env.REACT_APP_FCM_WEB_PROJECT_ID,
  storageBucket: process.env.REACT_APP_FCM_WEB_STORAGE_BUCKET,
  messagingSenderId: process.env.REACT_APP_FCM_WEB_MESSAGING_SENDER_ID,
  appId: process.env.REACT_APP_FCM_WEB_APP_ID,
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

export default firebase;