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

    const notifySound = new Audio(
        'https://notificationsounds.com/storage/sounds/file-sounds-1150-pristine.mp3'
    );
    notifySound.volume = 0.6;

    /* ================= INIT ================= */

    function initChat() {

        let originalTitle = document.title;
        let blinkInterval = null;

        function startTitleBlink(text) {
            if (blinkInterval) return;

            blinkInterval = setInterval(() => {
                document.title =
                    document.title === originalTitle ? text : originalTitle;
            }, 1000);
        }

        function stopTitleBlink() {
            clearInterval(blinkInterval);
            blinkInterval = null;
            document.title = originalTitle;
        }

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
        btn.innerHTML = `
            💬
            <span id="chat-badge"
                title=""
                style="
                    position:absolute;
                    top:6px;
                    right:6px;
                    background:red;
                    color:white;
                    font-size:12px;
                    padding:2px 6px;
                    border-radius:50%;
                    display:none;
                ">
                0
            </span>
        `;

        const box = document.createElement('div');
        box.id = 'live-chat-box';
        box.innerHTML = `
            <div style="padding:10px;background:#696cff;color:#fff">
                Live Support
            </div>

            <div id="live-chat-messages"></div>

            <!-- 👇 TYPING INDICATOR -->
            <div id="typing-indicator"
                style="font-size:12px;color:#888;padding:5px;display:none">
                Agent is typing...
            </div>

            <input id="live-chat-input" placeholder="Type message..." />
        `;

        document.body.appendChild(btn);
        document.body.appendChild(box);

        btn.onclick = () => {
            const isOpen = box.style.display === 'flex';
            box.style.display = isOpen ? 'none' : 'flex';

            fetch('http://localhost/live-chat/public/api/visitor-chat-activity', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    session_id: SESSION_ID,
                    message: isOpen
                        ? 'Visitor closed the chat'
                        : 'Visitor opened the chat'
                })
            });


            if (!isOpen) {
                fetch('http://localhost/live-chat/public/api/visitor-read', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        session_id: SESSION_ID,
                        chat_id: window.CHAT_ID,
                    })
                });
                // reset notifications
                unreadCount = 0;
                badge().style.display = 'none';
                stopTitleBlink();
                scrollToBottom();
            }
        };

        const input = document.getElementById('live-chat-input');
        const messages = document.getElementById('live-chat-messages');

        if (!input || !messages) {
            console.error('Chat DOM not ready');
            return;
        }

        let unreadCount = 0;
        const badge = () => document.getElementById('chat-badge');

        function scrollToBottom() {
            setTimeout(() => {
                messages.scrollTop = messages.scrollHeight;
            }, 50);
        }

        const loadMoreBtn = document.createElement('button');
        loadMoreBtn.innerText = 'Load More';
        loadMoreBtn.style.cssText = `
            width:100%;
            padding:6px;
            border:none;
            background:#f1f1f1;
            cursor:pointer;
            font-size:12px;
        `;
        messages.prepend(loadMoreBtn);

        /* ====================== MESSAGE ADD & SCROLL ====================== */
        let earliestMessageId = null;
        let loadingOlder = false;

        function addMsg(text, from, createdAt = null, isNew = true, prepend = false, msgId = null) {
            const div = document.createElement('div');
            div.style.margin = '6px 0';
            div.style.textAlign = from == 3 ? 'right' : 'left';
            div.dataset.msgId = msgId ?? '';

            // Message background
            let bgColor = from == 3 ? '#696cff' : '#f1f1f1'; // visitor = purple, agent = grey
            let textColor = from == 3 ? '#fff' : '#000';

            // format timestamp
            let timeText = '';
            if (createdAt) {
                const date = new Date(createdAt);
                const hours = date.getHours().toString().padStart(2, '0');
                const minutes = date.getMinutes().toString().padStart(2, '0');
                const day = date.getDate().toString().padStart(2, '0');
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const year = date.getFullYear();
                timeText = `${day}/${month}/${year} ${hours}:${minutes}`;
            }

            div.innerHTML = `
                <div style="display:inline-block; max-width:80%; text-align:left;">
                    <span style="
                        padding:6px 10px;
                        border-radius:6px;
                        background:${bgColor};
                        color:${textColor};
                        display:inline-block;
                        word-wrap: break-word;
                    ">
                        ${text}
                    </span>
                    ${timeText ? `<div style="font-size:10px;color:#888;margin-top:2px;">${timeText}</div>` : ''}
                </div>
            `;

            if (prepend) {
                const oldScrollHeight = messages.scrollHeight;
                messages.insertBefore(div, messages.firstChild.nextSibling); // after Load More button
                messages.scrollTop = messages.scrollHeight - oldScrollHeight;
            } else {
                messages.appendChild(div);
                scrollToBottom();
            }

            if (msgId && (!earliestMessageId || msgId < earliestMessageId)) {
                earliestMessageId = msgId;
            }

            // 🔔 Notifications
            if (isNew && from != 3 && box.style.display !== 'flex') {
                unreadCount++;
                badge().innerText = unreadCount;
                badge().style.display = 'block';
                notifySound.play().catch(() => {});
                startTitleBlink(`(${unreadCount}) New message`);
            }

            badge().title = text.length > 30 ? text.substring(0, 30) + '...' : text;
        }

        /* ================= LOAD MORE LOGIC ================= */
        messages.prepend(loadMoreBtn);

        messages.addEventListener('scroll', () => {
            if (messages.scrollTop === 0 && !loadingOlder) {
                if (!earliestMessageId) return; // no more messages
                loadingOlder = true;

                fetchChat(true).finally(() => {
                    loadingOlder = false;
                });
            }
        });

        /* ================= SEND ================= */

        input.addEventListener('keydown', e => {
            let typingTimer = null;
            clearTimeout(typingTimer);

            fetch('http://localhost/live-chat/public/api/visitor-typing', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    session_id: SESSION_ID,
                    chat_id: window.CHAT_ID
                })
            });

            typingTimer = setTimeout(() => {
                // optional: stop typing
            }, 1500);

            if (e.key === 'Enter' && input.value.trim()) {

                fetch(API_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        message: input.value,
                        session_id: SESSION_ID,
                        chat_id: window.CHAT_ID // 🔥 REQUIRED
                    })
                });

                // addMsg(input.value, 3); // visitor
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
        const MESSAGES_PER_PAGE = 20; // load 20 messages at a time

        /* ====================== FETCH CHAT ====================== */
        function fetchChat(loadMore = false) {
            if (loadMore && loadingOlder) return Promise.resolve(); // prevent duplicate calls
            if (loadMore && !earliestMessageId) return Promise.resolve(); // no more messages

            if (loadMore) loadingOlder = true;

            const payload = {
                session_id: SESSION_ID,
                limit: MESSAGES_PER_PAGE
            };
            if (loadMore) payload.before_id = earliestMessageId;

            return fetch('http://localhost/live-chat/public/api/visitor-chat', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (!loadMore) {
                    // INITIAL LOAD → latest to oldest
                    data.messages.forEach(msg => {
                        if (msg.sender === null) return;
                        addMsg(msg.message, msg.role, msg.created_at, false, false, msg.id);
                    });

                    // unread count
                    unreadCount = data.unread_count;
                    if (unreadCount > 0) {
                        badge().innerText = unreadCount;
                        badge().style.display = 'block';
                    }

                    // subscribe to pusher
                    channel = pusher.subscribe(`chat.${data.chat_id}`);
                    channel.bind('new-message', data => {
                        if (data.sender === null) return;
                        addMsg(data.message, data.role, data.created_at, true, false, data.id);
                        if (box.style.display === 'flex') {
                            fetch('http://localhost/live-chat/public/api/visitor-read', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({
                                    session_id: SESSION_ID,
                                    chat_id: window.CHAT_ID
                                })
                            });
                        }
                    });
                    channel.bind('typing', data => {
                        if (data.role != 3) {
                            const typing = document.getElementById('typing-indicator');
                            if (!typing) return;
                            typing.style.display = 'block';
                            clearTimeout(window.typingTimeout);
                            window.typingTimeout = setTimeout(() => {
                                typing.style.display = 'none';
                            }, 1500);
                        }
                    });

                } else {
                    // LOAD MORE → prepend oldest → newest
                    if (data.messages.length === 0) {
                        loadMoreBtn.innerText = 'No more messages';
                        loadMoreBtn.disabled = true;
                        return;
                    }

                    // reverse messages so oldest comes first
                    data.messages.reverse().forEach(msg => {
                        addMsg(msg.message, msg.role, msg.created_at, false, true, msg.id);
                    });
                }
            })
            .finally(() => {
                loadingOlder = false;
            });
        }

        /* ====================== SCROLL & LOAD MORE ====================== */
        loadMoreBtn.addEventListener('click', () => fetchChat(true));

        messages.addEventListener('scroll', () => {
            if (messages.scrollTop === 0) {
                fetchChat(true);
            }
        });

        // initial fetch
        fetchChat(false);

    }

})();
