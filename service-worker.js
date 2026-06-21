self.addEventListener('install', event => {
    event.waitUntil(
        caches.open('bKhaborPwa').then(cache => {
            return cache.addAll([
        "./assets/vendors/bootstrap3.7/css/bootstrap.min.css",
        "./assets/vendors/datepicker/bootstrap-datepicker.min.css",
        "./assets/vendors/fontawesome6/css/fontawesome.css",
        "./assets/vendors/fontawesome6/css/brands.css",
        "./assets/vendors/fontawesome6/css/solid.css",
        "./assets/vendors/flex-gallery/flexslider.css",
        "./assets/vendors/custom/custom.css",
        "./assets/vendors/jquery/jquery-3.7.1.min.js",
        "./assets/vendors/bootstrap3.7/js/bootstrap.min.js",
        "./assets/vendors/loadscroll/jQuery.loadScroll.js",
        "./assets/vendors/flex-gallery/jquery.flexslider.js",
        "./assets/vendors/datepicker/bootstrap.min.js"
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

importScripts("https://clientcdn.pushengage.com/sdks/service-worker.js");