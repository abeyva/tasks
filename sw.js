self.addEventListener("install", (event) => {
    event.waitUntil(
      caches.open("task-app-cache").then((cache) => {
        return cache.addAll([
          "/",
          "/dashboard.php",
          "/styles.css",
          "/images/twi.png",
          "/manifest.json"
        ]);
      })
    );
    self.skipWaiting();
  });
  
  self.addEventListener("fetch", (event) => {
    event.respondWith(
      caches.match(event.request).then((response) => {
        return response || fetch(event.request);
      })
    );
  });
  