(function() {
    var trackEndpoint = '/checkout/track.php';
    var sessionCookie = 'analytics_sid';
    var sessionId = getCookie(sessionCookie) || generateId();
    
    if (!getCookie(sessionCookie)) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = sessionCookie + '=' + sessionId + ';expires=' + expires.toUTCString() + ';path=/';
    }
    
    var state = detectState();
    var data = {
        session_id: sessionId,
        page: window.location.pathname,
        state: state,
        country: 'BR',
        referrer: document.referrer
    };
    
    if (window.fetch) {
        fetch(trackEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        }).catch(function() {});
    }
    
    setInterval(function() {
        fetch(trackEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ session_id: sessionId, page: window.location.pathname, state: state, alive: true })
        }).catch(function() {});
    }, 30000);
    
    function getCookie(name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
    }
    
    function generateId() {
        return Math.random().toString(36).substring(2) + Date.now().toString(36);
    }
    
    function detectState() {
        var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        var stateMap = {
            'America/Sao_Paulo': 'SP',
            'America/Rio_Branco': 'AC',
            'America/Maceio': 'AL',
            'America/Belem': 'PA',
            'America/Brasilia': 'DF',
            'America/Campo_Grande': 'MS',
            'America/Cuiaba': 'MT',
            'America/Fortaleza': 'CE',
            'America/Goiania': 'GO',
            'America/João_Pessoa': 'PB',
            'America/Manaus': 'AM',
            'America/Natal': 'RN',
            'America/Porto_Velho': 'RO',
            'America/Recife': 'PE',
            'America/Rio_Branco': 'AC',
            'America/Salvador': 'BA',
            'America/Santarem': 'PA',
            'America/São_Luís': 'MA',
            'America/Vitória': 'ES',
            'America/Aracaju': 'SE',
            'America/Belo_Horizonte': 'MG',
            'America/Boa_Vista': 'RR',
            'America/Campeche': 'SC',
            'America/Caracas': 'XX',
            'America/Caxias': 'MA',
            'America/Caxias_do_Sul': 'RS',
            'America/Curitiba': 'PR',
            'America/Erechim': 'RS',
            'America/Florianopolis': 'SC',
            'America/Gloria_dOeste': 'MT',
            'America/Maringa': 'PR',
            'America/Palmas': 'TO',
            'America/Ponta_Pora': 'MS',
            'America/Porto_Alegre': 'RS',
            'America/Sao_Goncalo': 'RJ',
            'America/Teresina': 'PI'
        };
        
        var lang = navigator.language || navigator.userLanguage;
        if (lang && lang.startsWith('pt')) {
            return timeZone ? (stateMap[timeZone] || 'SP') : 'SP';
        }
        return 'SP';
    }
})();