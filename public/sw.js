const CACHE = 'teams-v1';
const ASSETS = [
    '/',
    '/dashboard',
    '/riwayat',
    '/manifest.json',
];

// Install - cache aset penting
self.addEventListener('install', e => {
    e.waitUntil(
        caches.open(CACHE).then(c => c.addAll(ASSETS)).then(() => self.skipWaiting())
    );
});

// Activate - hapus cache lama
self.addEventListener('activate', e => {
    e.waitUntil(
        caches.keys().then(keys =>
            Promise.all(keys.filter(k => k !== CACHE).map(k => caches.delete(k)))
        ).then(() => self.clients.claim())
    );
});

// Fetch - network first, fallback ke cache
self.addEventListener('fetch', e => {
    // Skip non-GET dan request dari luar
    if (e.request.method !== 'GET') return;
    if (!e.request.url.startsWith(self.location.origin)) return;
    // Skip admin routes (tidak di-cache)
    if (e.request.url.includes('/admin/')) return;

    e.respondWith(
        fetch(e.request)
            .then(res => {
                // Simpan ke cache jika berhasil
                if (res.ok) {
                    const clone = res.clone();
                    caches.open(CACHE).then(c => c.put(e.request, clone));
                }
                return res;
            })
            .catch(() => caches.match(e.request))
    );
});

// Push notification (untuk notifikasi masa depan)
self.addEventListener('push', e => {
    const data = e.data?.json() || {};
    self.registration.showNotification(data.title || 'TEAMS', {
        body: data.body || 'Ada notifikasi baru',
        icon: '/icons/icon-192.png',
        badge: '/icons/icon-192.png',
    });
});
