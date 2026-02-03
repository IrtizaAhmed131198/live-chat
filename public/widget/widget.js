(function () {

    /* ================= SAFE DOM READY ================= */
    function onDOMReady(cb) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', cb);
        } else {
            cb();
        }
    }

    /* ================= CONFIG ================= */

    const WEBSITE_DOMAIN = window.location.hostname;

    let SESSION_ID = sessionStorage.getItem('chat_session_id');
    if (!SESSION_ID) {
        SESSION_ID = Math.random().toString(36).substring(2);
        sessionStorage.setItem('chat_session_id', SESSION_ID);
    }

    const PUSHER_KEY = '6d2b8f974bbba728216c';
    const PUSHER_CLUSTER = 'ap1';
    const API_URL = 'http://localhost/live-chat/public/api/visitor-message';

    /* ================= LOAD PUSHER ================= */

    const script = document.createElement('script');
    script.src = 'https://js.pusher.com/8.4.0/pusher.min.js';

    script.onload = () => {
        onDOMReady(initChat);
    };

    document.head.appendChild(script);

    /* ================= INIT ================= */

    function initChat() {

        // ❗ Prevent duplicate widget
        if (document.getElementById('live-chat-btn')) return;

        const pusher = new Pusher(PUSHER_KEY, {
            cluster: PUSHER_CLUSTER,
            forceTLS: true
        });

        /* ================= STYLES ================= */

        const style = document.createElement('style');
        style.innerHTML = `
        #live-chat-btn {
            position: fixed; bottom: 20px; right: 20px;
            background: #696cff; color: #fff;
            width: 60px; height: 60px;
            border-radius: 50%; cursor: pointer;
            display:flex; align-items:center; justify-content:center;
            font-size:22px; z-index:9999;
        }
        #live-chat-box {
            position: fixed; bottom: 90px; right: 20px;
            width: 320px; height: 420px;
            background: #fff; border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,.2);
            display:none; flex-direction:column;
            z-index:9999;
        }
        #live-chat-messages {
            flex:1; padding:10px; overflow-y:auto;
            font-family: Arial;
        }
        #live-chat-input {
            border:none; border-top:1px solid #eee;
            padding:10px; width:100%;
            outline:none;
        }`;
        document.head.appendChild(style);

        /* ================= UI ================= */

        const btn = document.createElement('div');
        btn.id = 'live-chat-btn';
        btn.innerHTML = '💬';

        const box = document.createElement('div');
        box.id = 'live-chat-box';
        box.innerHTML = `
            <div style="padding:10px;background:#696cff;color:#fff">
                Live Support
            </div>
            <div id="live-chat-messages"></div>
            <input id="live-chat-input" placeholder="Type message..." />
        `;

        document.body.appendChild(btn);
        document.body.appendChild(box);

        btn.onclick = () => {
            box.style.display = box.style.display === 'flex' ? 'none' : 'flex';
        };

        const input = document.getElementById('live-chat-input');
        const messages = document.getElementById('live-chat-messages');

        if (!input || !messages) {
            console.error('Chat DOM not ready');
            return;
        }

        function addMsg(text, from) {
            const div = document.createElement('div');
            div.style.margin = '6px 0';
            div.style.textAlign = from == 3 ? 'right' : 'left';
            div.innerHTML = `
                <span style="padding:6px 10px;border-radius:6px;background:#f1f1f1;display:inline-block">
                    ${text}
                </span>
            `;
            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;
        }

        /* ================= SEND ================= */

        input.addEventListener('keydown', e => {
            if (e.key === 'Enter' && input.value.trim()) {

                fetch(API_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        message: input.value
                    })
                });

                addMsg(input.value, 3);
                input.value = '';
            }
        });

        /* ================= INIT VISITOR ================= */

        fetch('http://localhost/live-chat/public/api/visitor-init', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                domain: WEBSITE_DOMAIN,
                session_id: SESSION_ID
            })
        });

        /* ================= LOAD CHAT + SUBSCRIBE ================= */

        let channel = null;

        fetch('http://localhost/live-chat/public/api/visitor-chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ session_id: SESSION_ID })
        })
        .then(res => res.json())
        .then(data => {

            if (!data.chat_id) return;

            data.messages.forEach(msg => {
                addMsg(msg.message, msg.user.role);
            });

            channel = pusher.subscribe(`chat.${data.chat_id}`);
            channel.bind('new-message', data => {
                addMsg(data.message, data.user.role);
            });
        });
    }

})();
