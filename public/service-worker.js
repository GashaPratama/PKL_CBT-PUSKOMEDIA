const CACHE_NAME = "cbt-cache-v2";
const urlsToCache = [
  '/',
  '/siswa/dashboard',
  '/offline.html',
  '/js/tailwind.js',
  '/js/crypto-js.min.js',
  '/favicon.ico',

];

// Install SW dan simpan file penting
self.addEventListener("install", event => {
  console.log("[SW] Installing Service Worker...");
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log("[SW] Caching static assets...");
        return cache.addAll(urlsToCache);
      })
  );
  self.skipWaiting();
});

// Aktivasi dan hapus cache lama
self.addEventListener("activate", event => {
  console.log("[SW] Activating Service Worker...");
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys.filter(key => key !== CACHE_NAME)
            .map(key => caches.delete(key))
      );
    })
  );
  self.clients.claim();
});

// Fetch handler
self.addEventListener("fetch", event => {
  const { request } = event;

  // Handle GET request saja
  if (request.method !== 'GET') return;

  event.respondWith(
    fetch(request)
      .then(response => {
        return response;
      })
      .catch(() => {
        return caches.match(request).then(cachedResponse => {
          // Jika halaman dashboard diminta dan offline, tampilkan cache dashboard
          if (request.url.includes('/siswa/dashboard')) {
            return caches.match('/siswa/dashboard');
          }
        });
      })
  );
});
