/**
 * Kwai Ads Tracker - Frontend JavaScript
 * Compatible with all modern browsers and legacy (IE11+)
 */

(function(window) {
    'use strict';

    var KWAITRACK_CONFIG = {
        endpoint: '/checkout/includes/kwai_client.php',
        cookieName: 'kwai_clickid',
        clickIdKeys: ['clickid', 'kwai_clickid', 'click_id', 'sck', 'ttclid', 'ksclid'],
        customClickIdKey: null,
        configLoaded: false
    };

    function loadConfigFromServer(callback) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/checkout/config-api.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var config = JSON.parse(xhr.responseText);
                    if (config.click_id_param) {
                        KWAITRACK_CONFIG.customClickIdKey = config.click_id_param;
                        localStorage.setItem('click_id_param', config.click_id_param);
                    }
                } catch(e) {}
            }
            KWAITRACK_CONFIG.configLoaded = true;
            if (callback) callback();
        };
        xhr.onerror = function() {
            var stored = localStorage.getItem('click_id_param');
            if (stored) KWAITRACK_CONFIG.customClickIdKey = stored;
            KWAITRACK_CONFIG.configLoaded = true;
            if (callback) callback();
        };
        xhr.send();
    }

    window.setClickIdParam = function(param) {
        if (param) {
            KWAITRACK_CONFIG.customClickIdKey = param;
            localStorage.setItem('click_id_param', param);
        }
    };

    var stored = localStorage.getItem('click_id_param');
    if (stored) KWAITRACK_CONFIG.customClickIdKey = stored;

    /**
     * Captura clickid da URL
     * @return {string|null}
     */
    function captureKwaiClickId() {
        var params = new URLSearchParams(window.location.search);
        
        if (KWAITRACK_CONFIG.customClickIdKey) {
            var customValue = params.get(KWAITRACK_CONFIG.customClickIdKey);
            if (customValue) return customValue;
        }
        
        for (var i = 0; i < KWAITRACK_CONFIG.clickIdKeys.length; i++) {
            var key = KWAITRACK_CONFIG.clickIdKeys[i];
            var value = params.get(key);
            
            if (value) {
                return value;
            }
        }
        
        return null;
    }

    /**
     * Obtém clickid do cookie
     * @return {string|null}
     */
    function getKwaiClickId() {
        var name = KWAITRACK_CONFIG.cookieName + '=';
        var decoded = decodeURIComponent(document.cookie);
        var ca = decoded.split(';');
        
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        
        return null;
    }

    /**
     * Persiste clickid em cookie e localStorage
     * @param {string} clickId
     */
    function persistKwaiClickId(clickId) {
        if (!clickId) return;

        var expires = new Date();
        expires.setTime(expires.getTime() + (180 * 24 * 60 * 60 * 1000));

        document.cookie = KWAITRACK_CONFIG.cookieName + '=' + clickId + 
            ';expires=' + expires.toUTCString() + 
            ';path=/' + 
            ';SameSite=Lax';

        try {
            localStorage.setItem(KWAITRACK_CONFIG.cookieName, clickId);
        } catch (e) {}
    }

    /**
     * Envia evento para o backend
     * @param {string} eventName
     * @param {object} payload
     */
    function trackKwai(eventName, payload) {
        payload = payload || {};

        var clickId = captureKwaiClickId() || getKwaiClickId();
        if (clickId && !payload.clickId) {
            payload.clickId = clickId;
        }

        var data = {
            event: eventName,
            value: payload.value || null,
            config: {
                url: payload.url || window.location.href,
                page_name: payload.page || window.location.pathname,
                properties: payload.properties || null
            }
        };

        if (window.fetch) {
            window.fetch(KWAITRACK_CONFIG.endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
                keepalive: true
            }).catch(function() {});
        } else {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', KWAITRACK_CONFIG.endpoint, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(JSON.stringify(data));
        }
    }

    /**
     * Inicializa o tracker
     */
    function initKwai() {
        loadConfigFromServer(function() {
            var clickId = captureKwaiClickId();
            
            if (clickId) {
                persistKwaiClickId(clickId);
            }

            trackKwai('ContentView', {
                page: window.location.pathname,
                url: window.location.href
            });
        });
    }

    /**
     * Rastreia quando muda de hash/route (SPA)
     * @param {string} pageName
     */
    function trackPageChange(pageName) {
        trackKwai('ContentView', {
            page: pageName,
            url: window.location.href
        });
    }

    window.getKwaiClickId = getKwaiClickId;
    window.persistKwaiClickId = persistKwaiClickId;
    window.captureKwaiClickId = captureKwaiClickId;
    window.trackKwai = trackKwai;
    window.trackKwaiPageChange = trackPageChange;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initKwai);
    } else {
        initKwai();
    }

    if (window.location.hash) {
        window.addEventListener('hashchange', function() {
            var hash = window.location.hash.replace('#', '');
            if (hash) {
                trackPageChange(hash);
            }
        });
    }

})(window);