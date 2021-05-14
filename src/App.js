import React, { useEffect } from 'react';
import logo from './logo.svg';
import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';

import firebase from './firebase';

function App() {

  const getMessagingObject = () => {
    // [START messaging_get_messaging_object]
    return firebase.messaging();
    // [END messaging_get_messaging_object]
  }

  const requestPermission = () => {
    // [START messaging_request_permission]
    Notification.requestPermission().then((permission) => {
      if (permission === 'granted') {
        console.log('Notification permission granted.');
        // Retrieve a registration token for use with FCM.
        const msg = getMessagingObject();
        getToken(msg);
      } else {
        console.log('Unable to get permission to notify.');
      }
    });
    // [END messaging_request_permission]
  }

  const getToken = (msg) => {
    // [START messaging_get_token]
    // Get registration token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    msg.getToken({ vapidKey:'BFXuXLgGn_GKsSzdapd8prRjMWVjgI3tf4ULHXBvCHurNe5THBUT2AkmpgCu4zw4Gx_klZPjAwS9yFoUvqWlmQE'}).then((currentToken) => {
      if (currentToken) {
        // Send the token to your server and update the UI if necessary
        console.log('token:' + currentToken);
      } else {
        // Show permission request UI
        console.log('No registration token available. Request permission to generate one.');
      }
    }).catch((err) => {
      console.log('An error occurred while retrieving token. ', err);
    });
    // [END messaging_get_token]
  }

  useEffect(() => {
    requestPermission();
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
