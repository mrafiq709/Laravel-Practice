# Instructions

```
npx create-react-app push-notification-web
```

## Details:

```
npm install --save firebase react-bootstrap bootstrap
```

## Files to update:

1. Copy _.env.example => .env_ and update with FCM keys

2. Create file _src/firebase.js_

```javascript
import firebase from "firebase";

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
```

3. Update **_App.js_**

```javascript
import React from "react";
import logo from "./logo.svg";
import "./App.css";
import firebase from "./firebase";
import "bootstrap/dist/css/bootstrap.min.css";

function App() {
  React.useEffect(() => {
    const msg = firebase.messaging();
    msg
      .requestPermission()
      .then(() => {
        return msg.getToken();
      })
      .then((data) => {
        console.warn("token", data);
      });
  });

  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
      </header>
    </div>
  );
}

export default App;
```

4. Create file _public/firebase-messaging-sw.js_

```javascript
importScripts("https://www.gstatic.com/firebasejs/3.5.0/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/3.5.0/firebase-messaging.js");

firebase.initializeApp({
  messagingSenderId: "34761076205", // Update with your firebase messagingSenderId
});

const initMessaging = firebase.messaging();

function receivePushNotification(event) {
  console.log("[Service Worker] Push Received.");

  console.log(event.data.json());

  const { image, tag, url, title, text } = event.data.json().data;

  const options = {
    data: url,
    body: text,
    icon: image,
    vibrate: [200, 100, 200],
    tag: tag,
    image: image,
    badge: "https://spyna.it/icons/favicon.ico",
    actions: [
      {
        action: "Detail",
        title: "View",
        icon: "https://via.placeholder.com/128/ff0000",
      },
    ],
  };
  event.waitUntil(self.registration.showNotification(title, options));
}

function openPushNotification(event) {
  console.log(
    "[Service Worker] Notification click Received.",
    event.notification.data
  );

  event.notification.close();
  event.waitUntil(clients.openWindow(event.notification.data));
}

self.addEventListener("push", receivePushNotification);
self.addEventListener("notificationclick", openPushNotification);
```

## Run

```
npm install
npm start
```

Get the token from console log
and try to send push notification from firebase website

##### Refernces

1. https://blog.logrocket.com/push-notifications-with-react-and-firebase/
2. https://itnext.io/react-push-notifications-with-hooks-d293d36f4836
