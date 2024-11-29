// service-worker.js
self.addEventListener('install', event => {
    event.waitUntil(
      caches.open('meu-pwa-cache').then(cache => {
        return cache.addAll([
          '/',
          '/index.php',
          '/css/styles.css',
          // Adicione os arquivos que quer que funcionem offline
        ]);
      })
    );
  });
  
  self.addEventListener('fetch', event => {
    event.respondWith(
      caches.match(event.request).then(response => {
        return response || fetch(event.request);
      })
    );
  });
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/service-worker.js').then(registration => {
        console.log('Service Worker registrado:', registration);
      }).catch(error => {
        console.error('Falha ao registrar o Service Worker:', error);
      });
    });
  }
    