<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/kwai_config.php';

$kwai_pixel_id = kwai_get_pixel_id();
$kwai_ativo = kwai_is_enabled() ? '1' : '0';

header('Content-Type: application/javascript; charset=utf-8');

if (!$kwai_pixel_id || $kwai_ativo !== '1') {
    echo '/* Kwai Pixel: não configurado ou inativo */';
    exit;
}
?>
(function() {
    var pid = <?= json_encode($kwai_pixel_id) ?>;
    if (!pid) return;

    window.kwai_pixel_id = pid;

    // SDK stub oficial Kwai
    !function(e,t,n){
        e.KwaiAnalyticsObject=n;
        var i=e[n]=e[n]||[];
        i.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"];
        var a=function(e,t){e[t]=function(){var m=Array.prototype.slice.call(arguments);e.push([t].concat(m))}};
        i.methods.forEach(function(e){a(i,e)});
        i.instance=function(e){var r=(i._i&&i._i[e])||[];i.methods.forEach(function(e){a(r,e)});return r};
        i.load=function(e,o){
            var u="//s15-def.ap4r.com/kos/s101/nlav11187/pixel/events.js";
            i._i=i._i||{};i._i[e]=[];i._i[e]._u=u;
            i._t=i._t||{};i._t[e]=+new Date;
            i._o=i._o||{};i._o[e]=o||{};
            var c="?sdkid="+e+"&lib="+n;
            var s=t.createElement("script");s.type="text/javascript";s.async=true;s.src=u+c;
            var f=t.getElementsByTagName("script")[0];f.parentNode.insertBefore(s,f);
        };
    }(window, document, "kwaiq");

    kwaiq.load(pid);

    function sendEvent(eventName, properties) {
        if (window.kwaiq && window.kwai_pixel_id) {
            if (properties !== undefined) {
                kwaiq.track(eventName, properties);
            } else {
                kwaiq.track(eventName);
            }
        }
    }

    window.kwaiTrackContentView = function() {
        sendEvent('contentView');
    };

    window.kwaiTrackInitiateCheckout = function(v) {
        setTimeout(function() {
            if (v !== undefined && v !== null) {
                sendEvent('initiatedCheckout', { value: v, currency: 'BRL' });
            } else {
                sendEvent('initiatedCheckout');
            }
        }, 300);
    };

    window.kwaiTrackFormSubmit = function(v) {
        setTimeout(function() {
            if (v !== undefined && v !== null) {
                sendEvent('eventFormSubmit', { value: v, currency: 'BRL' });
            } else {
                sendEvent('eventFormSubmit');
            }
        }, 300);
    };

    window.kwaiTrackAddToCart = function(v) {
        setTimeout(function() {
            if (v !== undefined && v !== null) {
                sendEvent('addToCart', { value: v, currency: 'BRL' });
            } else {
                sendEvent('addToCart');
            }
        }, 300);
    };

    window.kwaiTrackPlaceOrder = function(v) {
        setTimeout(function() {
            sendEvent('placeOrder', { value: v, currency: 'BRL' });
        }, 500);
    };

    window.kwaiTrackPurchase = function(v) {
        setTimeout(function() {
            sendEvent('purchase', { value: v, currency: 'BRL' });
        }, 500);
    };
})();
