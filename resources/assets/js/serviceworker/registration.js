function urlB64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function registerServiceWorker()
{
    return navigator.serviceWorker.register('worker.js');
}

/**
 * Subscribe this user to the push notifications
 */
function subscribe(serviceWorkerRegistration)
{
    serviceWorkerRegistration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: urlB64ToUint8Array("BCVztw-67X3WgVIX0VopqqXvdCg22S8qNVn6-AUcxI3kgbrWN9gZVdbKKhV9EJCn09Xohkw86hZrKjXo5GJ-mMs")
    }).then(function(subscription) {
        // updateSubscriptionOnServer(subscription);
        console.log('user subscription status', subscription)
    }).catch(function(error) {
        console.error('Failed to subscribe the user: ', error);
    });
}

// Register the serviceworker
if ('serviceWorker' in navigator && 'PushManager' in window) {
    registerServiceWorker().then(function(workerRegistration) {
        // Ask for permission for push notifications
        workerRegistration.pushManager.getSubscription().then(function(subscription) {
            if (subscription !== null) {
                console.log('User is already subscribed to push notifications');
            } else {
                subscribe(workerRegistration);
            }
        });

    }).catch(function(error) {
        console.error('Service Worker Error', error);
    });
} else {
    console.log('Browser does not support service workers and pushmanager');
}

