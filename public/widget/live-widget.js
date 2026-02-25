(function () {
    function throttle(fn, delay) {
        let lastCall = 0;
        return function (...args) {
            const now = Date.now();
            if (now - lastCall >= delay) {
                lastCall = now;
                fn.apply(this, args);
            }
        };
    }
    /* ================= SAFE DOM READY ================= */
    function onDOMReady(cb) {
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", cb);
        } else {
            cb();
        }
    }

    /* ================= CONFIG ================= */

    const WEBSITE_DOMAIN = window.location.hostname;
    let currentUrl = window.location.href;
    const BASE_URL = "https://democustom-html.com/custom-backend/live-chat/public";

    let SESSION_ID = sessionStorage.getItem("chat_session_id");
    if (!SESSION_ID) {
        SESSION_ID = Math.random().toString(36).substring(2);
        sessionStorage.setItem("chat_session_id", SESSION_ID);
    }

    const PUSHER_KEY = "b28141d4a8de8eb2e3ed";
    const PUSHER_CLUSTER = "ap2";
    const API_URL = `${BASE_URL}/api/visitor-message`;

    const emojiScript = document.createElement("script");
    emojiScript.type = "module";
    emojiScript.innerHTML = `
        import { EmojiButton } from 'https://cdn.skypack.dev/@joeattardi/emoji-button';
        window.EmojiButton = EmojiButton;
    `;
    document.head.appendChild(emojiScript);

    /* ================= LOAD PUSHER ================= */

    const script = document.createElement("script");
    script.src = "https://js.pusher.com/8.4.0/pusher.min.js";

    script.onload = () => {
        onDOMReady(initChat);
    };

    document.head.appendChild(script);

    const notifySound = new Audio(
        // 'https://notificationsounds.com/storage/sounds/file-sounds-1150-pristine.mp3'
        `${BASE_URL}/assets/audio/notify.mp3`,
    );
    notifySound.volume = 0.6;

    /* ================= INIT ================= */

    function initChat() {
        let originalTitle = document.title;
        let blinkInterval = null;
        let CHAT_SETTINGS = {};

        // 🚫 FLAG to prevent API calls if brand not found
        let isBrandValid = false;

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
        if (document.getElementById("live-chat-btn")) return;

        const pusher = new Pusher(PUSHER_KEY, {
            cluster: PUSHER_CLUSTER,
            forceTLS: true,
        });

        /* ================= agent online/offline status ================= */
        let agentsOnline = false;

        const agentChannel = pusher.subscribe("agent-status");

        agentChannel.bind("agent-online", function(data){
            console.log("Agent online event received:", data, window.BRAND_ID);
            if(!window.BRAND_ID) return;
            console.log("Checking brand IDs:", data.brand_ids, window.BRAND_ID);

            if(data.brand_ids && data.brand_ids.includes(window.BRAND_ID)){
                agentsOnline = true;
                showChatUI();
                fetchChat(false); // ✅ now fetch chat
            }
        });

        agentChannel.bind("agent-offline", function(data){
            console.log("Agent offline event received:", data, window.BRAND_ID);
            if(!window.BRAND_ID) return;

            if(data.brand_ids && data.brand_ids.includes(window.BRAND_ID)){
                agentsOnline = false;
                showOfflineForm();
            }
        });

        /* ================= STYLES ================= */

        const style = document.createElement("style");
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
        }
        .emoji-picker__wrapper {
            z-index: 999999;
            transform: translate(1315px, -90px) !important;
            position: fixed !important;
        }
        .spinner {
            width:14px;
            height:14px;
            border:2px solid #fff;
            border-top:2px solid transparent;
            border-radius:50%;
            display:inline-block;
            animation:spin .6s linear infinite;
            margin-right:4px;
        }
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
        @media(max-width:1440px) {
        .emoji-picker__wrapper {
                transform: translate(710px, -90px) !important;
            }
        }
        @media(max-width:1199px) {
            .emoji-picker__wrapper {
                transform: translate(422px, -90px) !important;
            }
            #live-chat-box {
                width: 300px;
                height: 380px;
            }

        }
        @media(max-width:991px) {
            .emoji-picker__wrapper {
                transform: translate(198px, -90px) !important;
            }
        }

        @media(max-width:575px) {
            #live-chat-box {
                width: 100%;
                height: 500px;
                right: 0;
            }

            .emoji-picker__wrapper {
                transform: translate(0px, 150px) !important;
                z-index: 9999 !important;
            }
        }
        @media(max-width:400px) {
            .emoji-picker__wrapper {
                transform: translate(0px, 50px) !important;
                z-index: 9999 !important;
            }
        }
`;
        document.head.appendChild(style);

        /* ================= UI ================= */

        const btn = document.createElement("div");
        btn.id = "live-chat-btn";
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

        const box = document.createElement("div");
        box.id = "live-chat-box";
        box.innerHTML = `
            <div style="padding:10px;background:#696cff;color:#fff">
                Live Support
            </div>

            <div id="live-chat-messages"></div>

            <!-- OFFLINE FORM -->
            <div id="offline-form" style="display:none;padding:10px;">
                <h4 style="margin:5px 0;">Leave a message</h4>

                <input id="offline-name" placeholder="Your name"
                    style="width:100%;padding:6px;margin-bottom:6px;border:1px solid #ddd;border-radius:4px;" />

                <input id="offline-email" placeholder="Your email"
                    style="width:100%;padding:6px;margin-bottom:6px;border:1px solid #ddd;border-radius:4px;" />

                <textarea id="offline-message" placeholder="Message"
                    style="width:100%;padding:6px;border:1px solid #ddd;border-radius:4px;"></textarea>

                <button id="offline-send"
                    style="margin-top:6px;width:100%;padding:8px;background:#696cff;color:#fff;border:none;border-radius:4px;">
                    <span id="offline-btn-text">Send</span>
                </button>
            </div>

            <!-- 👇 TYPING INDICATOR -->
            <div id="typing-indicator"
                style="font-size:12px;color:#888;padding:5px;display:none">
                Agent is typing...
            </div>

            <div id="chat-input-container" style="display:flex;align-items:center;border-top:1px solid #eee;">
                <button id="emoji-btn"
                    style="
                        background:none;
                        border:none;
                        font-size:20px;
                        cursor:pointer;
                        padding:8px;
                    ">😊</button>

                <input id="live-chat-input"
                    placeholder="Type message..."
                    style="flex:1;border:none;padding:10px;outline:none;"
                />

                <button id="send-btn"
                    style="
                        background:none;
                        border:none;
                        font-size:18px;
                        cursor:pointer;
                        padding:8px;
                        color:#696cff;
                    ">➤</button>
            </div>

        `;

        document.body.appendChild(btn);
        document.body.appendChild(box);

        btn.style.display = "none";
        box.style.display = "none";

        btn.onclick = () => {
            // 🚫 Prevent opening if brand is invalid
            if (!isBrandValid) {
                console.warn("Chat disabled: Brand not found");
                return;
            }

            const isOpen = box.style.display === "flex";
            box.style.display = isOpen ? "none" : "flex";

            if (window.AGENT_ONLINE !== false && window.ASSING_USER_IDS.length > 0) {

                fetch(`${BASE_URL}/api/visitor-chat-activity`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        session_id: SESSION_ID,
                        message: isOpen
                            ? "Visitor closed the chat"
                            : "Visitor opened the chat",
                    }),
                });

                if (!isOpen) {
                    fetch(`${BASE_URL}/api/visitor-read`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            session_id: SESSION_ID,
                            chat_id: window.CHAT_ID,
                        }),
                    });
                    // reset notifications
                    unreadCount = 0;
                    badge().style.display = "none";
                    stopTitleBlink();
                    scrollToBottom();
                }

            } else {
                console.warn("Agent offline, skipping API calls");
            }
        };

        const input = document.getElementById("live-chat-input");

        const emojiBtn = document.getElementById("emoji-btn");

        let picker = null;

        emojiBtn.addEventListener("click", async () => {
            if (!window.EmojiButton) return;

            if (!picker) {
                // Detect screen size
                const isMobile = window.innerWidth <= 480;
                const isTablet =
                    window.innerWidth <= 768 && window.innerWidth > 480;

                let styleProps = {};

                if (isMobile) {
                    styleProps = {
                        "--picker-width": "40px",
                        "--picker-height": "50px",
                        "--font-size": "10px",
                        "--input-font-size": "14px",
                        "--search-height": "25px",
                    };
                } else if (isTablet) {
                    styleProps = {
                        "--picker-width": "100px",
                        "--picker-height": "120px",
                        "--font-size": "10px",
                        "--input-font-size": "15px",
                        "--search-height": "30px",
                    };
                } else {
                    styleProps = {
                        "--font-size": "10px", // Emoji size
                        "--picker-height": "150px", // Picker height
                        "--picker-width": "120px", // Picker width
                        "--category-button-size": "15px", // Category icon size
                        "--search-height": "40px",
                    };
                }

                picker = new window.EmojiButton({
                    position: "top-end",
                    styleProperties: styleProps,
                });

                picker.on("emoji", (selection) => {
                    input.value += selection.emoji;
                    input.focus();
                });
            }

            picker.togglePicker(emojiBtn);
        });

        // Optional: Re-create picker on window resize
        window.addEventListener("resize", () => {
            if (picker) {
                picker.destroyPicker();
                picker = null;
            }
        });
        const messages = document.getElementById("live-chat-messages");

        if (!input || !messages) {
            console.error("Chat DOM not ready");
            return;
        }

        let unreadCount = 0;
        const badge = () => document.getElementById("chat-badge");

        function scrollToBottom() {
            setTimeout(() => {
                messages.scrollTop = messages.scrollHeight;
            }, 50);
        }

        const loadMoreBtn = document.createElement("button");
        loadMoreBtn.innerText = "Load More";
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

        function addMsg(
            text,
            from,
            createdAt = null,
            isNew = true,
            prepend = false,
            msgId = null,
        ) {
            const div = document.createElement("div");
            div.style.margin = "6px 0";
            div.style.textAlign = from == 3 ? "right" : "left";
            div.dataset.msgId = msgId ?? "";

            // Message background
            let bgColor =
                from == 3
                    ? CHAT_SETTINGS.primary_color || "#696cff"
                    : "#f1f1f1"; // visitor = purple, agent = grey
            let textColor = from == 3 ? "#fff" : "#000";

            // format timestamp
            let timeText = "";
            if (createdAt) {
                timeText = createdAt;
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
                    ${timeText ? `<div style="font-size:10px;color:#888;margin-top:2px;">${timeText}</div>` : ""}
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
            if (isNew && from != 3 && box.style.display !== "flex") {
                unreadCount++;
                badge().innerText = unreadCount;
                badge().style.display = "block";
                notifySound.play().catch(() => {});
                startTitleBlink(`(${unreadCount}) New message`);
            }

            badge().title =
                text.length > 30 ? text.substring(0, 30) + "..." : text;
        }

        /* ================= LOAD MORE LOGIC ================= */
        messages.prepend(loadMoreBtn);

        messages.addEventListener("scroll", () => {
            if (messages.scrollTop === 0 && !loadingOlder) {
                if (!earliestMessageId) return; // no more messages
                loadingOlder = true;

                fetchChat(true).finally(() => {
                    loadingOlder = false;
                });
            }
        });

        /* ================= SEND ================= */

        input.addEventListener("keydown", (e) => {
            // 🚫 Prevent typing if brand invalid
            if (!isBrandValid) return;

            let typingTimer = null;
            clearTimeout(typingTimer);

            fetch(`${BASE_URL}/api/visitor-typing`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    session_id: SESSION_ID,
                    chat_id: window.CHAT_ID,
                }),
            });

            typingTimer = setTimeout(() => {
                // optional: stop typing
            }, 1500);

            if (e.key === "Enter") {
                e.preventDefault();
                sendMessage();
            }
        });

        /* ================== INITIALIZE send btn ================== */
        const sendBtn = document.getElementById("send-btn");

        function sendMessage() {
            // 🚫 Prevent sending if brand invalid
            if (!isBrandValid) {
                console.warn("Cannot send message: Brand not found");
                return;
            }

            if (!input.value.trim()) return;

            fetch(API_URL, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    message: input.value,
                    session_id: SESSION_ID,
                    chat_id: window.CHAT_ID,
                }),
            });

            input.value = "";
        }

        sendBtn.addEventListener("click", sendMessage);

        /* ================= INIT VISITOR ================= */

        function getWebsiteDomain() {
            const { hostname, pathname } = window.location;

            // ✅ NOT localhost → normal domain
            if (hostname !== "localhost" && hostname !== "127.0.0.1") {
                return hostname;
            }

            // ✅ localhost → pick project name from path
            // /filter-cms/public/  → filter-cms
            // /xtend-hrms/         → xtend-hrms
            // /abc                 → abc
            const segments = pathname
                .split("/")
                .filter((seg) => seg && seg !== "public");

            return segments.length ? segments[0]+".com" : "localhost";
        }

        // 🚀 INIT VISITOR - MUST SUCCEED BEFORE OTHER APIS
        fetch(`${BASE_URL}/api/visitor-init`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                domain: getWebsiteDomain(),
                session_id: SESSION_ID,
                url: currentUrl,
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                // ✅ Brand found - enable chat
                if (data.success || data.status === "success") {
                    isBrandValid = true;
                    window.CHAT_ID = data.chat_id;
                    window.AGENT_ONLINE = data.agent_online;
                    window.BRAND_ID = data.brand_id;
                    // console.log(window.AGENT_ONLINE, window.BRAND_ID, window.CHAT_ID);

                    CHAT_SETTINGS = data.settings || {};
                    window.ASSING_USER_IDS = data.user_ids || [];
                    applyChatSettings();

                    if(window.AGENT_ONLINE || CHAT_SETTINGS.chat_enabled == 0 || window.ASSING_USER_IDS.length > 0){
                        fetchChat(false);
                    }else{
                        showOfflineForm(); // ⭐ show form
                    }
                } else if(data.status === "pending") {
                    isBrandValid = false;
                    console.warn("Chat waiting for admin approval");

                        const infoBtn = document.createElement("div");
                        infoBtn.id = "live-chat-btn";
                        infoBtn.style = `
                            position: fixed;
                            bottom: 20px;
                            right: 20px;
                            width: 60px;
                            height: 60px;
                            border-radius: 50%;
                            background: #ff9800;
                            color: #fff;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            font-size: 12px;
                            z-index: 9999;
                            cursor: default;
                        `;
                        infoBtn.innerText = "Pending";
                        document.body.appendChild(infoBtn);

                } else {
                    // ❌ Brand not found
                    console.error(
                        "Brand not found:",
                        data.message || data.error,
                    );
                    isBrandValid = false;

                    // Hide chat widget
                    btn.style.display = "none";
                    box.style.display = "none";
                }
            })
            .catch((err) => {
                // ❌ API error
                console.error("Visitor init failed:", err);
                isBrandValid = false;

                // Hide chat widget
                btn.style.display = "none";
                box.style.display = "none";
            });

        /* ================= LOAD CHAT + SUBSCRIBE ================= */

        let channel = null;
        const MESSAGES_PER_PAGE = 20; // load 20 messages at a time

        /* ====================== FETCH CHAT ====================== */
        function fetchChat(loadMore = false) {
            // 🚫 Don't fetch if brand is invalid
            if (!isBrandValid) {
                console.warn("Chat disabled: Brand not found");
                return Promise.resolve();
            }

            if (loadMore && loadingOlder) return Promise.resolve(); // prevent duplicate calls
            if (loadMore && !earliestMessageId) return Promise.resolve(); // no more messages

            if (loadMore) loadingOlder = true;

            const payload = {
                session_id: SESSION_ID,
                limit: MESSAGES_PER_PAGE,
            };
            if (loadMore) payload.before_id = earliestMessageId;

            return fetch(`${BASE_URL}/api/visitor-chat`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (!loadMore) {

                        if ((!data.messages || data.messages.length === 0) && CHAT_SETTINGS.welcome_message) {
                            setTimeout(() => {
                                addMsg(CHAT_SETTINGS.welcome_message, 1, null, false);
                            }, 400);
                        }
                        // INITIAL LOAD → latest to oldest
                        data.messages.forEach((msg) => {
                            if (msg.sender === null) return;
                            addMsg(
                                msg.message,
                                msg.role,
                                msg.formatted_created_at,
                                false,
                                false,
                                msg.id,
                            );
                        });

                        // unread count
                        unreadCount = data.unread_count;
                        if (unreadCount > 0) {
                            badge().innerText = unreadCount;
                            badge().style.display = "block";
                        }

                        // subscribe to pusher
                        channel = pusher.subscribe(`chat.${data.chat_id}`);
                        channel.bind("new-message", (data) => {
                            console.log(data);
                            if (data.sender === null) return;
                            addMsg(
                                data.message,
                                data.role,
                                data.formatted_created_at,
                                true,
                                false,
                                data.id,
                            );
                            if (box.style.display === "flex") {
                                fetch(`${BASE_URL}/api/visitor-read`, {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                    },
                                    body: JSON.stringify({
                                        session_id: SESSION_ID,
                                        chat_id: window.CHAT_ID,
                                    }),
                                });
                            }
                        });
                        channel.bind("typing", (data) => {
                            if (data.role != 3) {
                                const typing =
                                    document.getElementById("typing-indicator");
                                if (!typing) return;
                                typing.style.display = "block";
                                clearTimeout(window.typingTimeout);
                                window.typingTimeout = setTimeout(() => {
                                    typing.style.display = "none";
                                }, 1500);
                            }
                        });
                    } else {
                        // LOAD MORE → prepend oldest → newest
                        if (data.messages.length === 0) {
                            loadMoreBtn.innerText = "No more messages";
                            loadMoreBtn.disabled = true;
                            return;
                        }

                        // reverse messages so oldest comes first
                        data.messages.reverse().forEach((msg) => {
                            addMsg(
                                msg.message,
                                msg.role,
                                msg.formatted_created_at,
                                false,
                                true,
                                msg.id,
                            );
                        });
                    }
                })
                .finally(() => {
                    loadingOlder = false;
                });
        }

        /* ====================== SCROLL & LOAD MORE ====================== */
        loadMoreBtn.addEventListener("click", () => fetchChat(true));

        messages.addEventListener("scroll", () => {
            if (messages.scrollTop === 0) {
                fetchChat(true);
            }
        });

        function notifyPageChange() {
            // 🚫 Don't send if brand invalid
            if (!isBrandValid) return;

            const currentUrl = window.location.href;

            // check if we've already notified for this URL
            if (window.lastNotifiedUrl === currentUrl) return;
            window.lastNotifiedUrl = currentUrl;

            fetch(`${BASE_URL}/api/visitor-activity`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    session_id: SESSION_ID,
                    url: currentUrl,
                }),
                keepalive: true, // allows fetch on unload
            }).catch(() => {});
        }

        // page reload / close / navigate
        window.addEventListener("beforeunload", notifyPageChange);
        window.addEventListener("visibilitychange", () => {
            if (document.visibilityState === "hidden") {
                notifyPageChange();
            }
        });

        function sendHeartbeat() {
            // 🚫 Don't send if brand invalid
            if (!isBrandValid) return;

            if(!window.AGENT_ONLINE) return;

            if(!window.ASSING_USER_IDS.length > 0) return;

            fetch(`${BASE_URL}/api/visitor-heartbeat`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    session_id: SESSION_ID,
                }),
            }).catch(() => {});
        }

        ["click", "keydown", "mousemove", "scroll"].forEach((evt) => {
            window.addEventListener(evt, throttle(sendHeartbeat, 60000));
        });


        function applyChatSettings() {
            if (!CHAT_SETTINGS) return;

            const color = CHAT_SETTINGS.primary_color || "#696cff";

            const btn = document.getElementById("live-chat-btn");
            const box = document.getElementById("live-chat-box");
            const header = document.querySelector("#live-chat-box > div");
            const sendBtn = document.getElementById("send-btn");

            if (btn) btn.style.background = color;
            if (header) header.style.background = color;
            if (sendBtn) sendBtn.style.color = color;

            /* ✅ CHAT POSITION FIX */
            const position = CHAT_SETTINGS.chat_position || "right";

            if (position === "left") {
                btn.style.left = "20px";
                btn.style.right = "auto";

                box.style.left = "20px";
                box.style.right = "auto";
            } else {
                btn.style.right = "20px";
                btn.style.left = "auto";

                box.style.right = "20px";
                box.style.left = "auto";
            }

            /* 🔊 Sound enable/disable */
            if (CHAT_SETTINGS.sound_enabled == 0) {
                notifySound.volume = 0;
            }

            /* 🚫 Chat disable */
            if (CHAT_SETTINGS.chat_enabled == 0) {
                btn.style.display = "none";
                box.style.display = "none";

                return;
            }

            btn.style.display = "flex";
        }

        function showOfflineForm(){
            document.getElementById("live-chat-messages").style.display = "none";
            document.getElementById("typing-indicator").style.display = "none";
            document.getElementById("chat-input-container").style.display = "none";
            document.getElementById("offline-form").style.display = "block";
        }

        function showChatUI(){
            document.getElementById("live-chat-messages").style.display = "block";
            document.getElementById("offline-form").style.display = "none";
            document.getElementById("chat-input-container").style.display = "flex";
        }

        document.addEventListener("click", function(e) {
            if(e.target.id === "offline-send") {

                const btn = document.getElementById("offline-send");
                const btnText = document.getElementById("offline-btn-text");
                const name = document.getElementById("offline-name").value;
                const email = document.getElementById("offline-email").value;
                const msg = document.getElementById("offline-message").value;
                const formBox = document.getElementById("offline-form");

                if (!msg) return alert("Message required");

                // ✅ Disable button + show spinner
                btn.disabled = true;
                btnText.innerHTML = `<span class="spinner"></span> Sending...`;

                fetch(`${BASE_URL}/api/offline-message`, {
                    method:"POST",
                    headers:{"Content-Type":"application/json"},
                    body: JSON.stringify({
                        session_id: SESSION_ID,
                        name,
                        email,
                        message: msg,
                        chat_id: window.CHAT_ID,
                        brand_id: window.BRAND_ID,
                    })
                })
                .then(res => res.json())
                .then(data => {
                    // ✅ Success UI inside widget
                    formBox.innerHTML = `
                        <div style="text-align:center;padding:20px;">
                            <div style="font-size:40px;">✅</div>
                            <h4 style="margin:10px 0;">Message Sent</h4>
                            <p style="font-size:13px;color:#666;">
                                Thanks! We will get back to you soon.
                            </p>
                        </div>
                    `;
                })
                .catch(() => {
                    // ❌ Error → reset button
                    btn.disabled = false;
                    btnText.innerHTML = "Send";
                    console.log("Something went wrong");
                });
            }
        });
    }
})();
