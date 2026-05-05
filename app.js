/**
 * Kwai Ads Tracker - Frontend JavaScript
 * Integração S2S + Frontend para Kwai Ads
 * Compatible com todos os navegadores modernos
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

    /**
     * Carrega configuração do servidor
     */
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

    /**
     * Normaliza o clickid removendo caracteres inválidos
     */
    function normalizeClickId(raw) {
        if (!raw) return null;
        return raw.toString().replace(/[^a-zA-Z0-9\-_]/g, '').substring(0, 256);
    }

    /**
     * Captura clickid da URL
     */
    function captureKwaiClickId() {
        var params = new URLSearchParams(window.location.search);
        
        // Priority (strict): clickid > kwai_clickid > click_id
        var priorityKeys = ['clickid', 'kwai_clickid', 'click_id'];
        for (var p = 0; p < priorityKeys.length; p++) {
            var pv = params.get(priorityKeys[p]);
            if (pv) return normalizeClickId(pv);
        }

        // Optional custom key comes after the official priority keys
        if (KWAITRACK_CONFIG.customClickIdKey) {
            var customValue = params.get(KWAITRACK_CONFIG.customClickIdKey);
            if (customValue) return normalizeClickId(customValue);
        }

        for (var i = 0; i < KWAITRACK_CONFIG.clickIdKeys.length; i++) {
            var key = KWAITRACK_CONFIG.clickIdKeys[i];
            if (priorityKeys.indexOf(key) !== -1) continue;
            var value = params.get(key);
            if (value) return normalizeClickId(value);
        }
        
        return null;
    }

    /**
     * Obtém clickid do cookie
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
     */
    function persistKwaiClickId(clickId) {
        if (!clickId) return false;

        var expires = new Date();
        expires.setTime(expires.getTime() + (180 * 24 * 60 * 60 * 1000));

        document.cookie = KWAITRACK_CONFIG.cookieName + '=' + clickId + 
            ';expires=' + expires.toUTCString() + 
            ';path=/' + 
            ';SameSite=Lax';

        try {
            localStorage.setItem(KWAITRACK_CONFIG.cookieName, clickId);
        } catch (e) {}
        
        return true;
    }

    /**
     * Envia evento para o backend
     */
    function trackKwai(eventName, payload) {
        payload = payload || {};

        var clickId = captureKwaiClickId() || getKwaiClickId();
        if (clickId && !payload.clickId) {
            payload.clickId = clickId;
        }

        var data = {
            event: eventName,
            clickId: payload.clickId || null,
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
     * Rastreia mudança de página (SPA/hash routes)
     * Mantém o hook para futuras integrações, mas não dispara ContentView
     * para evitar duplicidade ao abrir telas internas como formulário.
     */
    function trackPageChange(pageName, hash) {
        return {
            page: pageName,
            hash: hash || window.location.hash || ''
        };
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

            var path = (window.location.pathname || '').toLowerCase();
            if (path === '/quiz' || path.indexOf('/quiz/') === 0) {
                return;
            }

            var contentViewKey = 'kwai_contentview_sent_' + window.location.pathname + window.location.search;
            var contentViewSent = false;

            function sendInitialContentView() {
                if (contentViewSent) return;
                contentViewSent = true;
                trackKwai('ContentView', {
                    page: window.location.pathname,
                    url: window.location.href
                });
            }

            try {
                if (!sessionStorage.getItem(contentViewKey)) {
                    sendInitialContentView();
                    sessionStorage.setItem(contentViewKey, '1');
                }
            } catch (e) {
                sendInitialContentView();
            }
        });
    }

    /**
     * Router para SPA com hash
     */
    function setupHashRouter() {
        var lastHash = window.location.hash;

        function checkHash() {
            var currentHash = window.location.hash;
            if (currentHash !== lastHash) {
                lastHash = currentHash;
                var pageName = currentHash.replace('#', '') || 'home';
                trackPageChange(pageName, currentHash);
            }
        }

        window.addEventListener('hashchange', checkHash);
        
        // Primeira verificação
        if (window.location.hash) {
            var pageName = window.location.hash.replace('#', '') || 'home';
            trackPageChange(pageName, window.location.hash);
        }
    }

    // API pública
    window.getKwaiClickId = getKwaiClickId;
    window.persistKwaiClickId = persistKwaiClickId;
    window.captureKwaiClickId = captureKwaiClickId;
    window.trackKwai = trackKwai;
    window.trackKwaiPageChange = trackPageChange;
    window.kwaiTrackContentView = function() {
        trackKwai('ContentView', {
            page: window.location.pathname,
            url: window.location.href
        });
    };
    window.kwaiTrackFormSubmit = function(v) {
        trackKwai('EventFormSubmit', { value: v, currency: 'BRL', page: 'checkout_form' });
    };
    window.kwaiTrackAddToCart = function(v) {
        trackKwai('AddToCart', { value: v, currency: 'BRL', page: 'pix_generated' });
    };
    window.kwaiTrackPurchase = function(v) {
        trackKwai('Purchase', { value: v, currency: 'BRL', page: 'purchase_confirmed' });
    };

    // Inicialização
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initKwai();
            setupHashRouter();
        });
    } else {
        initKwai();
        setupHashRouter();
    }

})(window);
