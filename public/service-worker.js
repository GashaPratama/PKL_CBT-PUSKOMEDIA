const CACHE_NAME = "cbt-cache-v1";
const urlsToCache = [
  '/',
  '/siswa/dashboard',
  '/js/tailwind.js',
  '/js/crypto-js.min.js',
  '/offline.html',
  '/favicon.ico'
];

// Saat install: simpan file statis ke cache
self.addEventListener("install", event => {
  console.log("[SW] Installing Service Worker...");
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log("[SW] Caching static assets...");
        return cache.addAll(urlsToCache);
      })
  );
});

// Saat fetch: coba ambil dari jaringan dulu, jika gagal ambil dari cache
self.addEventListener("fetch", event => {
  console.log("[SW] Fetching:", event.request.url);
  event.respondWith(
    fetch(event.request)
      .then(response => {
        // Bisa juga menyimpan response ke cache di sini jika mau dynamic caching
        return response;
      })
      .catch(() => {
        return caches.match(event.request)
          .then(response => {
            // Jika tidak ada cache-nya juga, fallback ke offline.html
            return response || caches.match('/offline.html');
          });
      })
  );
});

// Saat activate: hapus cache lama jika ada
self.addEventListener("activate", event => {
  console.log("[SW] Activating new Service Worker...");
  event.waitUntil(
    caches.keys().then(cacheNames =>
      Promise.all(
        cacheNames.map(name => {
          if (name !== CACHE_NAME) {
            console.log("[SW] Deleting old cache:", name);
            return caches.delete(name);
          }
        })
      )
    )
  );
});
