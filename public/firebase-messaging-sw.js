importScripts('https://www.gstatic.com/firebasejs/3.5.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.5.0/firebase-messaging.js');

firebase.initializeApp({
    messagingSenderId: "34761076205",
})

const initMessaging = firebase.messaging()

function receivePushNotification(event) {
  console.log("[Service Worker] Push Received.");

  console.log(event.data.json());

  const { data } = event.data.json().data;

  const options = {
    data: data,
    badge: "https://spyna.it/icons/favicon.ico",
    actions: [{ action: "Detail", title: "View", icon: "https://via.placeholder.com/128/ff0000" }]
  };
  
  if(JSON.parse(data).receiver_id === 2)
  {
    event.waitUntil(self.registration.showNotification(JSON.parse(data).title, options));
  }
}

function openPushNotification(event) {
  console.log("[Service Worker] Notification click Received.", event.notification.data);
  
  event.notification.close();
  event.waitUntil(clients.openWindow(JSON.parse(event.notification.data).link));
}

self.addEventListener("push", receivePushNotification);
self.addEventListener("notificationclick", openPushNotification);