<?php
require_once __DIR__ . '/db.php';

$kwaiPixels = db_get_active_kwai_pixels();
$pixelIds = array_column($kwaiPixels, 'pixel_id');

header('Content-Type: application/javascript; charset=utf-8');
?>
<?php if (count($pixelIds) > 0): ?>
<script>
!function(e,t){"object"==typeof exports&&"object"==typeof module?module.exports=t():"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?exports.install=t():e.install=t()}(window,(function(){return function(e){var t={};function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}return n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(o,r,(function(t){return e[t]}).bind(null,r));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=0)}([function(e,t,n){"use strict";var o=this&&this.spreadArray||function(e,t,n){if(n||2===arguments.length)for(var o,r=0,i=t.length;r<i;r++)!o&&r in t||(o||(o=Array.prototype.slice.call(t,0,r)),o[r]=t[r]);return e.concat(o||Array.prototype.slice.call(t))};Object.defineProperty(t,"__esModule",{value:!0});var r=function(e,t,n){var o,i=e.createElement("script");i.type="text/javascript",i.async=!0,i.src=t,n&&(i.onerror=function(){r(e,n)});var a=e.getElementsByTagName("script")[0];null===(o=a.parentNode)||void 0===o||o.insertBefore(i,a)};!function(e,t,n){e.KwaiAnalyticsObject=n;var i=e[n]=e[n]||[];i.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"];var a=function(e,t){e[t]=function(){for(var n=[],r=0;r<arguments.length;r++)n[r]=arguments[r];var i=o([t],n,!0);e.push(i)}};i.methods.forEach((function(e){a(i,e)})),i.instance=function(e){var t,n=(null===(t=i._i)||void 0===t?void 0:t[e])||[];return i.methods.forEach((function(e){a(n,e)})),n},i.load=function(e,o){var a="//s15-def.ap4r.com/kos/s101/nlav11187/pixel/events.js";i._i=i._i||{},i._i[e]=[],i._i[e]._u=a,i._t=i._t||{},i._t[e]=+new Date,i._o=i._o||{},i._o[e]=o||{};var c="?sdkid=".concat(e,"&lib=").concat(n);r(t,a+c,"https://s16-11187.ap4r.com/kos/s101/nlav11187/pixel/events.js"+c)}}(window,document,"kwaiq")}])}));
(function() {
    var pixelIds = <?= json_encode($pixelIds) ?>;
    var clickIdKeys = ['click_id', 'ttclid', 'sck', 'kwai_clickid', 'ksclid', 'clickId'];
    var foundClickId = null;
    
    for (var i = 0; i < clickIdKeys.length; i++) {
        var params = new URLSearchParams(window.location.search);
        var value = params.get(clickIdKeys[i]);
        if (value) {
            foundClickId = value;
            break;
        }
    }
    
    if (foundClickId) {
        var date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = 'kwai_clickid=' + foundClickId + ';expires=' + date.toUTCString() + ';path=/';
        try { localStorage.setItem('kwai_clickid', foundClickId); } catch(e) {}
    }
    
    for (var j = 0; j < pixelIds.length; j++) {
        if (typeof kwaiq !== 'undefined' && kwaiq.load) {
            kwaiq.load(pixelIds[j]);
        }
    }
    
    // Nao sobrescreve funcoes ja definidas por kwai-pixel.js.php
    if (typeof window.kwaiTrackContentView === 'undefined') {
        window.kwaiTrackContentView = function() {
            if (window.kwaiq && window.kwai_pixel_id) kwaiq.instance(window.kwai_pixel_id).track('contentView');
        };
        window.kwaiTrackPlaceOrder = function(v) {
            setTimeout(function() {
                if (window.kwaiq && window.kwai_pixel_id) kwaiq.instance(window.kwai_pixel_id).track('placeOrder', { value: v, currency: 'BRL' });
            }, 500);
        };
        window.kwaiTrackPurchase = function(v) {
            setTimeout(function() {
                if (window.kwaiq && window.kwai_pixel_id) kwaiq.instance(window.kwai_pixel_id).track('purchase', { value: v, currency: 'BRL' });
            }, 500);
        };
    }
})();
</script>
<?php endif; ?>