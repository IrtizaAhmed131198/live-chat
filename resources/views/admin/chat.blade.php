@extends('admin.layout.app')

@section('css')
<style>
    .chat-history-body {
        overflow-y: auto !important;
        scroll-behavior: smooth !important;
    }

    .chat-system-message {
        justify-content: center !important;
    }

    .app-chat .app-chat-history .chat-history-body .chat-history .chat-message:not(:last-child) {
        margin-bottom: 1rem !important;
    }

</style>
@endsection

@section('content')
    <!-- Content wrapper -->
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="app-chat card overflow-hidden">
            <div class="row g-0">
                <!-- Sidebar Left -->
                <div class="col app-chat-sidebar-left app-sidebar overflow-hidden" id="app-chat-sidebar-left">
                    <div
                        class="chat-sidebar-left-user sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-6 pt-12">
                        <div class="avatar avatar-xl avatar-online chat-sidebar-avatar">
                            <img src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('assets/images/default.png')  }}"
                                alt="Avatar" class="rounded-circle">
                        </div>
                        <h5 class="mt-4 mb-0">{{ auth()->user()->name ?? 'Guest' }}</h5>
                        <span>{{ auth()->user()->isRole() ?? 'Unknown Role' }}</span>
                        <i class="icon-base bx bx-x icon-lg cursor-pointer close-sidebar" data-bs-toggle="sidebar"
                            data-overlay="" data-target="#app-chat-sidebar-left"></i>
                    </div>
                    <div class="sidebar-body px-6 pb-6 ps">
                        <div class="my-6">
                            <div class="maxLength-wrapper">
                                <label for="chat-sidebar-left-user-about"
                                    class="text-uppercase text-body-secondary mb-1">About</label>
                                <textarea id="chat-sidebar-left-user-about"
                                    class="form-control chat-sidebar-left-user-about maxLength-example" rows="3"
                                    maxlength="120">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</textarea>
                                <small id="textarea-maxlength-info" class="maxLength label-success">100/120</small>
                            </div>
                        </div>
                        <div class="my-6">
                            <p class="text-uppercase text-body-secondary mb-1">Status</p>
                            <div class="d-grid gap-2 pt-2 text-heading ms-2">
                                <div class="form-check form-check-success">
                                    <input name="chat-user-status" class="form-check-input" type="radio" value="active"
                                        id="user-active" checked="">
                                    <label class="form-check-label" for="user-active">Online</label>
                                </div>
                                <div class="form-check form-check-warning">
                                    <input name="chat-user-status" class="form-check-input" type="radio" value="away"
                                        id="user-away">
                                    <label class="form-check-label" for="user-away">Away</label>
                                </div>
                                <div class="form-check form-check-danger">
                                    <input name="chat-user-status" class="form-check-input" type="radio" value="busy"
                                        id="user-busy">
                                    <label class="form-check-label" for="user-busy">Do not Disturb</label>
                                </div>
                                <div class="form-check form-check-secondary">
                                    <input name="chat-user-status" class="form-check-input" type="radio" value="offline"
                                        id="user-offline">
                                    <label class="form-check-label" for="user-offline">Offline</label>
                                </div>
                            </div>
                        </div>
                        <div class="my-6">
                            <p class="text-uppercase text-body-secondary mb-1">Settings</p>
                            <ul class="list-unstyled d-grid gap-4 ms-2 pt-2 text-heading">
                                <li class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="icon-base bx bx-lock-alt me-1"></i>
                                        <span class="align-middle">Two-step Verification</span>
                                    </div>
                                    <div class="form-check form-switch mb-0 me-1">
                                        <input type="checkbox" class="form-check-input" checked="">
                                    </div>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="icon-base bx bx-bell me-1"></i>
                                        <span class="align-middle">Notification</span>
                                    </div>
                                    <div class="form-check form-switch mb-0 me-1">
                                        <input type="checkbox" class="form-check-input">
                                    </div>
                                </li>
                                <li>
                                    <i class="icon-base bx bx-user me-1"></i>
                                    <span class="align-middle">Invite Friends</span>
                                </li>
                                <li>
                                    <i class="icon-base bx bx-trash me-1"></i>
                                    <span class="align-middle">Delete Account</span>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex mt-6">
                            <button class="btn btn-primary w-100" data-bs-toggle="sidebar" data-overlay=""
                                data-target="#app-chat-sidebar-left"><i
                                    class="icon-base bx bx-log-out icon-sm me-2"></i>Logout</button>
                        </div>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar Left-->
                <!-- Chat & Contacts -->
                <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end"
                    id="app-chat-contacts">
                    <div class="sidebar-header px-6 border-bottom d-flex align-items-center">
                        <div class="d-flex align-items-center me-6 me-lg-0">
                            <div class="flex-shrink-0 avatar avatar-online me-4 profile-av-2" data-bs-toggle="sidebar"
                                data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-right">
                                <img class="user-avatar rounded-circle cursor-pointer"
                                    src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('assets/images/default.png')  }}"
                                    alt="Avatar">
                            </div>
                            <div class="flex-grow-1 input-group input-group-merge rounded-pill">
                                <span class="input-group-text" id="basic-addon-search31"><i
                                        class="icon-base bx bx-search icon-sm"></i></span>
                                <input type="text" class="form-control chat-search-input" placeholder="Search..."
                                    aria-label="Search..." aria-describedby="basic-addon-search31">
                            </div>
                        </div>
                        <i class="icon-base bx bx-x icon-lg cursor-pointer position-absolute top-50 end-0 translate-middle d-lg-none d-block"
                            data-overlay="" data-bs-toggle="sidebar" data-target="#app-chat-contacts"></i>
                    </div>
                    <div class="sidebar-body ps ps--active-y">
                        <!-- Chats -->
                        <ul class="list-unstyled chat-contact-list py-2 mb-0" id="chat-list">
                            <li class="chat-contact-list-item chat-contact-list-item-title mt-0">
                                <h5 class="text-primary mb-0">Chats</h5>
                            </li>
                            @forelse ($chats as $chat)
                                @php
                                    $count = $chat->messages()->where('is_read', false)->where('sender', '!=', auth()->id())->count();
                                    $lastMessage = $chat->messages()
                                        ->whereNotNull('sender')
                                        ->latest()
                                        ->value('message');
                                @endphp

                                <li class="chat-contact-list-item mb-1 {{ request('chatId') == $chat->id ? 'active' : '' }}">

                                    <a class="d-flex align-items-center chat-user"
                                        href="{{ route('admin.chat.show', $chat->id) }}"
                                        data-chat-id="{{ $chat->id }}"
                                        data-user-id="{{ $chat->visitor->id }}"
                                        data-chat-status="{{ $chat->status }}"
                                        data-name="{{ $chat->visitor->name }}"
                                        data-email="{{ $chat->visitor->email }}"
                                        data-phone="{{ $chat->visitor->phone ?? '-' }}"
                                        data-role="{{ $chat->visitor->isRole() ?? 'User' }}"
                                        data-ipaddress="{{ $chat->main_visitor->ip_address ?? '-' }}"
                                        data-country="{{ $chat->main_visitor->country ?? '-' }}"
                                        data-city="{{ $chat->main_visitor->city ?? '-' }}"
                                        data-device="{{ $chat->main_visitor->device ?? '-' }}"
                                        data-browser="{{ $chat->main_visitor->browser ?? '-' }}"
                                        data-os="{{ $chat->main_visitor->os ?? '-' }}"
                                        data-avatar="{{ $chat->visitor->image ? asset($chat->visitor->image) : asset('assets/images/default.png') }}">

                                        <div class="flex-shrink-0 avatar avatar-online profile-av-1">
                                            <img src="{{ $chat->visitor->image ? asset($chat->visitor->image) : asset('assets/images/default.png')  }}"
                                                alt="Avatar"
                                                class="rounded-circle">
                                        </div>

                                        <div class="chat-contact-info flex-grow-1 ms-4">

                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="chat-contact-name text-truncate m-0 fw-normal">
                                                    {{ $chat->visitor->name }}
                                                </h6>

                                                @if(in_array(auth()->user()->role, [1, 2]))
                                                    <span class="badge bg-danger ms-2 unread-badge"
                                                        style="display: {{ $count > 0 ? 'inline-block' : 'none' }}">
                                                        {{ $count }}
                                                    </span>
                                                @endif

                                                <small class="chat-contact-list-item-time">
                                                    {{ optional($chat->updated_at)->diffForHumans() }}
                                                </small>
                                            </div>

                                            <small class="chat-contact-status text-truncate last-message">
                                                {{ $lastMessage ?? 'No messages yet' }}
                                            </small>

                                        </div>
                                    </a>

                                </li>

                            @empty
                                <li class="chat-contact-list-item chat-list-item-0">
                                    <h6 class="text-body-secondary mb-0">No Chats Found</h6>
                                </li>
                            @endforelse

                        </ul>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; height: 447px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 198px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Chat conversation -->
                <div class="col app-chat-conversation d-flex align-items-center justify-content-center flex-column"
                    id="app-chat-conversation">
                    <div class="bg-label-primary p-8 rounded-circle">
                        <i class="icon-base bx bx-message-alt-detail icon-48px"></i>
                    </div>
                    <p class="my-4">Select a contact to start a conversation.</p>
                    <button class="btn btn-primary app-chat-conversation-btn" id="app-chat-conversation-btn">Select
                        Contact</button>
                </div>
                <!-- /Chat conversation -->
                <!-- Chat History -->
                <div class="col app-chat-history d-none" id="app-chat-history">

                </div>
                <!-- /Chat History -->
                <!-- Sidebar Right -->
                <div class="col app-chat-sidebar-right app-sidebar overflow-hidden" id="app-chat-sidebar-right" data-bs-toggle="sidebar">
                    <div class="sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-6 pt-12">
                        <div class="avatar avatar-xl avatar-online chat-sidebar-avatar">
                            <img src="" alt="Avatar" class="rounded-circle" id="sidebar-avatar">
                        </div>
                        <h5 class="mt-4 mb-0" id="sidebar-name"></h5>
                        <span id="sidebar-role"></span>
                        <i class="icon-base bx bx-x icon-lg cursor-pointer close-sidebar d-block"
                            data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-sidebar-right"></i>
                    </div>
                    <div class="sidebar-body p-6 pt-0 ps">
                        <div class="my-6">
                            <p class="text-uppercase mb-1 text-body-secondary">Personal Information</p>
                            <ul class="list-unstyled d-grid gap-4 mb-0 ms-2 py-2 text-heading">
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-envelope"></i>
                                    <span class="align-middle ms-2" id="sidebar-email">-</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-phone-call"></i>
                                    <span class="align-middle ms-2" id="sidebar-phone">-</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-map"></i>
                                    <span class="align-middle ms-2" id="sidebar-ip-address">-</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-flag"></i>
                                    <span class="align-middle ms-2" id="sidebar-country">-</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-building"></i>
                                    <span class="align-middle ms-2" id="sidebar-city">-</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-desktop"></i>
                                    <span class="align-middle ms-2" id="sidebar-device">-</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-browser"></i>
                                    <span class="align-middle ms-2" id="sidebar-browser">-</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-laptop"></i>
                                    <span class="align-middle ms-2" id="sidebar-os">-</span>
                                </li>
                            </ul>
                        </div>
                        {{-- Options same raho --}}
                    </div>
                </div>
                <!-- /Sidebar Right -->
                <div class="app-overlay"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="module">
    import { EmojiButton } from 'https://cdn.skypack.dev/@joeattardi/emoji-button';

    const picker = new EmojiButton({
        position: 'top-start',
        theme: 'auto'
    });

    let activeInput = null;

    // 🔹 When emoji selected
    picker.on('emoji', selection => {
        if (!activeInput) return;

        const start = activeInput.selectionStart;
        const end = activeInput.selectionEnd;
        const text = activeInput.value;

        // Insert emoji at cursor position
        activeInput.value =
            text.slice(0, start) +
            selection.emoji +
            text.slice(end);

        // Move cursor after emoji
        const newPos = start + selection.emoji.length;
        activeInput.setSelectionRange(newPos, newPos);

        activeInput.focus();
    });

    // 🔹 Open picker on emoji button click
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.emoji-btn');
        if (!btn) return;

        // Find related message input
        const form = btn.closest('.form-send-message');
        if (!form) return;

        activeInput = form.querySelector('.message-input');
        if (!activeInput) return;

        picker.togglePicker(btn);
    });
</script>
<script>
let notifySound;

document.addEventListener('DOMContentLoaded', () => {
    notifySound = new Audio("{{ asset('assets/audio/notify.mp3') }}");
    notifySound.volume = 0.7;
});

document.addEventListener('click', function unlockAudio() {
    notifySound.play()
        .then(() => {
            notifySound.pause();
            notifySound.currentTime = 0;
            console.log('🔓 Audio unlocked');
            document.removeEventListener('click', unlockAudio);
        })
        .catch(err => console.error('Unlock failed', err));
});

Pusher.logToConsole = true;

const pusherChat = new Pusher('{{ config("broadcasting.connections.pusher.key") }}', {
    cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
    forceTLS: true
});

let chatId = {{ $chatId ?? 'null' }};
let chatChannel = null;
const currentUserId = {{ auth()->id() }};
let currentPage = 1;
let lastPage = null;
let lastMessageId = null;

document.addEventListener('DOMContentLoaded', function () {

    // Subscribe currently open chat
    if (chatId) {
        subscribeToChat(chatId);
    }

    // Subscribe sidebar chats globally for unread / last message / sound
    document.querySelectorAll('.chat-user').forEach(el => {
        const id = el.dataset.chatId;
        if (!id) return;

        const channel = pusherChat.subscribe(`chat.${id}`);

        channel.bind('new-message', data => {
            // Only visitor messages trigger unread
            if (data.role != 3) return;

            // Update unread badge if chat not active
            if (!isChatActive(id)) {
                const badge = getUnreadBadge(id);
                if (badge) {
                    let count = parseInt(badge.innerText || 0);
                    badge.innerText = ++count;
                    badge.style.display = 'inline-block'; // now it works
                }
                notifySound.currentTime = 0;
                notifySound.play().catch(() => {});
            }else{
                markMessagesRead(id);
            }

            notifySound.currentTime = 0;
            notifySound.play().catch(err => {
                console.error('Sound play failed:', err);
            });

            // Update last message in sidebar
            updateLastMessage(id, data.message);
        });
    });
});

// ================= Active chat messages =================

function subscribeToChat(chatId) {
    if (chatChannel?.name === `chat.${chatId}`) return;

    if (chatChannel) {
        pusherChat.unsubscribe(chatChannel.name);
    }

    chatChannel = pusherChat.subscribe(`chat.${chatId}`);

    chatChannel.bind('new-message', data => {
        if (data.role == 3) {
            notifySound.currentTime = 0;
            notifySound.play().catch(err => console.error('Sound play failed:', err));
        }

        const isAi = data.is_ai == 1 || data.is_ai === true || data.role == 4;
        const userName = isAi ? 'AI Assistant' : (data.user ? data.user.name : (data.role == 3 ? 'Visitor' : 'Agent'));

        appendMessage(data.message, data.role, data.user?.image, data.formatted_created_at, data.is_read, data.id, isAi, userName);

        setTimeout(() => {
            const chatBody = document.querySelector('.chat-history-body');
            chatBody.scrollTop = chatBody.scrollHeight;
        }, 0);

        // Reset unread badge if any
        const badge = getUnreadBadge(chatId);
        if (badge) {
            badge.innerText = 0;
            badge.style.display = 'none';
        }
    });

    chatChannel.bind('messages-read', data => {
        if (data.sender_type === 'agent') {
            document.querySelectorAll('.message-ticks').forEach(el => {
                el.innerHTML = '<i class="bx bx-check-double text-primary"></i>';
            });
        }
    });

    chatChannel.bind('typing', data => {
        if (data.role == 3) { // visitor typing
            const typing = document.getElementById('typing-indicator');
            if (!typing) return;

            typing.style.display = 'block';

            clearTimeout(window.typingTimeout);
            window.typingTimeout = setTimeout(() => {
                typing.style.display = 'none';
            }, 1500);
        }
    });

    chatChannel.bind('activity', data => {
        const ul = document.querySelector('.chat-history');
        ul.appendChild(renderSystemMessage(data.message));

        if (data.chat_status === 'closed') {
            disableChatForm('Chat closed due to inactivity');

            // 🔁 sidebar dataset update
            const el = document.querySelector(`.chat-user[data-chat-id="${data.chat_id}"]`);
            if (el) el.dataset.chatStatus = 'closed';
        }
    });

    // 🤖 AI processing — block/unblock agent send during AI response generation
    chatChannel.bind('ai-processing', data => {
        if (data.processing) {
            disableChatForm('⏳ AI is generating a response... Please wait.');
        } else {
            enableChatForm();
        }
    });

    // 🔄 Agent switched — show system message when agent takes over from AI
    chatChannel.bind('agent-switched', data => {
        const ul = document.querySelector('.chat-history');
        ul.appendChild(renderSystemMessage(data.message));

        const chatBody = document.querySelector('.chat-history-body');
        if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
    });
}

// ================= Helper functions =================

function getUnreadBadge(chatId) {
    return document.querySelector(
        `.chat-user[data-chat-id="${chatId}"] .unread-badge`
    );
}

function isChatActive(chatId) {
    return document
        .querySelector(`.chat-user[data-chat-id="${chatId}"]`)
        ?.classList.contains('active');
}

function updateLastMessage(chatId, message) {
    const el = document.querySelector(
        `.chat-user[data-chat-id="${chatId}"] .last-message`
    );
    if (el) {
        el.innerText = message.length > 30
            ? message.substring(0, 30) + '...'
            : message;
    }
}

function markMessagesRead(chatId) {
    clearTimeout(readTimeout);

    readTimeout = setTimeout(() => {

        fetch("{{ route('admin.chat.markRead') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ chat_id: chatId })
        })
        .then(() => {
            // ✅ hide badge after DB update confirm
            const badge = getUnreadBadge(chatId);
            if (badge) {
                badge.innerText = 0;
                badge.style.display = 'none';
            }
        });

    }, 300);
}

let readTimeout = null;

function renderMessage(text, role, userAvatar = null, created_at = null, is_read = false, msgId = null, is_ai = false, userName = null) {
    const li = document.createElement('li');

    li.className = role != 3
        ? 'chat-message chat-message-right'
        : 'chat-message';

    const defaultAvatar = "{{ asset('assets/images/default.png') }}";
    const avatar = userAvatar || defaultAvatar;

    let senderBadge = '';
    if (is_ai || role == 4) {
        senderBadge = `<div class="mb-1 text-end"><span class="badge bg-label-info py-1 px-2 rounded-pill shadow-xs" style="font-size: 11px; font-weight: 600;"><i class="bx bx-bot me-1"></i> AI Assistant</span></div>`;
    } else if (role != 3) {
        senderBadge = `<div class="mb-1 text-end"><span class="badge bg-label-primary py-1 px-2 rounded-pill shadow-xs" style="font-size: 11px; font-weight: 600;"><i class="bx bx-user me-1"></i> ${escapeHtml(userName || 'Agent')}</span></div>`;
    } else {
        senderBadge = `<div class="mb-1 text-start"><span class="badge bg-label-secondary py-1 px-2 rounded-pill shadow-xs" style="font-size: 11px; font-weight: 600;"><i class="bx bx-user-voice me-1"></i> Visitor</span></div>`;
    }

    const aiBubbleStyle = (is_ai || role == 4)
        ? 'background: rgba(3, 195, 236, 0.09) !important; border: 1px solid rgba(3, 195, 236, 0.35) !important;'
        : '';

    li.innerHTML = `
        <div class="d-flex overflow-hidden">
            ${role == 3 ? `
            <div class="user-avatar flex-shrink-0 me-4">
                <div class="avatar avatar-sm">
                    <img src="${avatar}" class="rounded-circle">
                </div>
            </div>` : ''}

            <div class="chat-message-wrapper flex-grow-1">
                ${senderBadge}
                <div class="chat-message-text" style="${aiBubbleStyle}">
                    <p class="mb-0">${escapeHtml(text)}</p>
                </div>
                <div class="text-end text-body-secondary mt-1 d-flex align-items-center justify-content-end">
                    <small class="me-1">${created_at || ''}</small>
                    ${role != 3 ? `
                        <span class="message-ticks" data-msg-id="${msgId}" style="font-size: 14px; line-height: 1;">
                            ${is_read ? '<i class="bx bx-check-double text-primary"></i>' : '<i class="bx bx-check text-muted"></i>'}
                        </span>
                    ` : ''}
                </div>
            </div>

            ${role != 3 ? `
            <div class="user-avatar flex-shrink-0 ms-4">
                <div class="avatar avatar-sm">
                    ${(is_ai || role == 4)
                        ? `<span class="avatar-initial rounded-circle bg-label-info"><i class="bx bx-bot"></i></span>`
                        : `<img src="${avatar}" class="rounded-circle">`
                    }
                </div>
            </div>` : ''}
        </div>
    `;

    return li;
}

function renderSystemMessage(text) {
    const li = document.createElement('li');
    li.className = 'chat-message chat-system-message';

    let badgeColor;
    if (text === "Visitor opened the chat") {
        badgeColor = 'bg-label-success';
    } else if (text === "Visitor closed the chat") {
        badgeColor = 'bg-label-danger';
    } else {
        badgeColor = 'bg-label-secondary';
    }

    // 🔹 URL detection and replacement
    const urlMatch = text.match(/https?:\/\/[^\s]+/g); // match all URLs
    let formattedText = text;

    if (urlMatch) {
        urlMatch.forEach(url => {
            formattedText = formattedText.replace(
                url,
                `<a href="${url}" target="_blank" style="text-decoration: underline; color: #696cff;">Site</a>`
            );
        });
    }

    li.innerHTML = `
        <div class="d-flex justify-content-center my-2">
            <span class="badge ${badgeColor} px-3 py-1 rounded-pill text-muted">
                ${formattedText}
            </span>
        </div>
    `;

    return li;
}

function appendMessage(text, role, userAvatar = null, created_at = null, is_read = false, msgId = null, is_ai = false, userName = null) {
    const ul = document.querySelector('.chat-history');

    const noMessage = document.getElementById('no-message');
    if (noMessage) {
        noMessage.remove();
    }

    const li = renderMessage(text, role, userAvatar, created_at, is_read, msgId, is_ai, userName);
    ul.appendChild(li);

    // ✅ Scroll chat container to bottom
    const chatBody = document.querySelector('.chat-history-body');
    chatBody.scrollTop = chatBody.scrollHeight;
}

let limit = 20;
let offset = 0;
let loading = false;
let allLoaded = false;

function loadMessages(chatId, prepend = false) {
    if (loading || allLoaded) return;
    loading = true;

    const container = document.querySelector('.chat-history-body');
    const ul = container.querySelector('.chat-history');
    const oldScrollHeight = container.scrollHeight;
    const oldScrollTop = container.scrollTop;

    fetch(`{{ route('admin.chat.messages', ':id') }}`.replace(':id', chatId) + `?limit=${limit}&offset=${offset}&prepend=${prepend ? 1 : 0}`)
        .then(res => res.json())
        .then(data => {
            if (!data.count || !data.data.length) {
                allLoaded = true;
                return;
            }

            let messages = data.data;

            // No need to reverse, backend sends oldest first
            messages.forEach(msg => {
                if (!msg.user && !msg.is_ai) {
                    const li = renderSystemMessage(msg.message);
                    prepend ? ul.prepend(li) : ul.appendChild(li);
                    return;
                }

                const isAi = msg.is_ai == 1 || msg.is_ai === true;
                const role = isAi ? 4 : (msg.user && msg.user.role == 3 ? 3 : 1);
                const userName = isAi ? 'AI Assistant' : (msg.user ? msg.user.name : 'Agent');
                const avatar = msg.user ? msg.user.image : null;

                const li = renderMessage(msg.message, role, avatar, msg.formatted_created_at, msg.is_read, msg.id, isAi, userName);
                prepend ? ul.prepend(li) : ul.appendChild(li);
            });

            // Maintain scroll position
            if (prepend) {
                container.scrollTop = container.scrollHeight - oldScrollHeight + oldScrollTop;
            } else {
                container.scrollTop = container.scrollHeight; // scroll to bottom initially
            }

            offset += data.count;
            allLoaded = !data.has_more;
        })
        .finally(() => {
            loading = false;
        });
}

document.getElementById('load-more-btn')
    ?.addEventListener('click', () => {
        loadMessages(window.chatId, true);
    });

document.querySelectorAll('.chat-user').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        updateSidebar(this.dataset);
        openChat(this.dataset.chatId, this.dataset.chatStatus);
    });
});

let isSending = false;
let typingTimer = null;
let isTyping = false;

document.addEventListener('input', function (e) {

    if (!e.target.classList.contains('message-input')) return;

    const form = e.target.closest('.form-send-message');

    // avoid spam
    if (!isTyping) {
        isTyping = true;

        fetch("{{ route('admin.chat.typing') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                chat_id: form.dataset.chatId
            })
        });
    }

    // reset timer
    clearTimeout(typingTimer);

    typingTimer = setTimeout(() => {
        isTyping = false; // allow next typing request
    }, 1500);
});

document.addEventListener('click', function (e) {

    const btn = e.target.closest('.send-msg-btn');
    if (!btn) return;

    if (isSending) return;

    const form = btn.closest('.form-send-message');
    const input = form.querySelector('.message-input');
    const message = input.value.trim();
    if (!message) return;

    sendMessage(form, input, message);
});

document.addEventListener('keydown', function (e) {

    if (!e.target.classList.contains('message-input')) return;

    // Shift + Enter = new line
    if (e.key === 'Enter' && e.shiftKey) return;

    // Enter press
    if (e.key === 'Enter') {
        e.preventDefault();

        if (isSending) return; // 🚫 disable enter while sending

        const form = e.target.closest('.form-send-message');
        const input = e.target;
        const message = input.value.trim();
        if (!message) return;

        sendMessage(form, input, message);
    }
});

function sendMessage(form, input, message) {

    isSending = true;
    input.disabled = true;

    fetch("{{ route('admin.chat.send') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        credentials: 'same-origin',
        body: JSON.stringify({
            chat_id: form.dataset.chatId,
            message: message
        })
    })
    .then(res => {
        if (res.status === 423) {
            // AI is processing — show alert and keep message in input
            return res.json().then(data => {
                alert(data.message || 'AI is generating a response. Please wait.');
                throw new Error('ai_processing');
            });
        }
        return res.json();
    })
    .then(() => {
        input.value = '';
    })
    .catch(err => {
        if (err.message !== 'ai_processing') {
            console.error('Send message error:', err);
        }
    })
    .finally(() => {
        isSending = false;
        input.disabled = false;
        input.focus();
    });
}

document.addEventListener('DOMContentLoaded', function () {
    let params = new URLSearchParams(window.location.search);
    let urlChatId = params.get('chatId');

    if (urlChatId) {
        openChat(urlChatId);
    }
});

// Avatar click → sidebar open
document.querySelector('[data-target="#app-chat-sidebar-right"]').addEventListener('click', function () {
    document.getElementById('app-chat-sidebar-right').classList.toggle('show');
});

// Close button
document.querySelector('.close-sidebar').addEventListener('click', function () {
    document.getElementById('app-chat-sidebar-right').classList.remove('show');
});

function openChat(chatId, chatStatus = 'open') {

    let getChat = "{{ route('admin.chat.show', ':id') }}".replace(':id', chatId);

    fetch(getChat)
        .then(res => res.text())
        .then(html => {

            const chatHistoryContainer = document.getElementById('app-chat-history');
            const container = document.querySelector('.chat-history-body');
            chatHistoryContainer.innerHTML = html;
            chatHistoryContainer.classList.remove('d-none');
            document.getElementById('app-chat-conversation')?.classList.add('d-none');

            // Active highlight
            document.querySelectorAll('.chat-user').forEach(el => el.classList.remove('active'));
            document.querySelector(`.chat-user[data-chat-id="${chatId}"]`)?.classList.add('active');

            const badge = getUnreadBadge(chatId);
            if (badge) {
                badge.innerText = 0;
                badge.style.display = 'none';
            }

            window.chatId = chatId;

            // 🔹 RESET pagination
            offset = 0;
            allLoaded = false;
            loading = false;

            // 🔹 Clear messages
            const ul = document.querySelector('.chat-history-body .chat-history');
            ul.innerHTML = '';

            // 🔹 Scroll listener
            const chatBody = document.querySelector('.chat-history-body');
            // remove old listener (clone trick)
            const newChatBody = chatBody.cloneNode(true);
            chatBody.parentNode.replaceChild(newChatBody, chatBody);

            newChatBody.addEventListener('scroll', () => {
                if (newChatBody.scrollTop === 0 && !loading && !allLoaded) {
                    loadMessages(window.chatId, true);
                }
            });

            // 🔹 Load messages
            loadMessages(chatId);

            // 🔹 Subscribe pusher
            subscribeToChat(chatId);

            // 🔹 Mark read
            markMessagesRead(chatId);

            // 🔴 IMPORTANT: disable input if chat closed
            if (chatStatus === 'closed') {
                disableChatForm('Chat closed');
            } else {
                enableChatForm();
            }

            initSidebar();
        });
}

function updateSidebar(data) {
    document.getElementById('sidebar-avatar').src   = data.avatar;
    document.getElementById('sidebar-name').innerText  = data.name;
    document.getElementById('sidebar-role').innerText  = data.role;
    document.getElementById('sidebar-email').innerText = data.email;
    document.getElementById('sidebar-phone').innerText = data.phone;
    document.getElementById('sidebar-ip-address').innerText = data.ipaddress;
    document.getElementById('sidebar-country').innerText = data.country;
    document.getElementById('sidebar-city').innerText = data.city;
    document.getElementById('sidebar-device').innerText = data.device;
    document.getElementById('sidebar-browser').innerText = data.browser;
    document.getElementById('sidebar-os').innerText = data.os;
}

function escapeHtml(str) {
    if (!str) return '';

    return str
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function disableChatForm(reason = 'Chat closed') {
    const form = document.querySelector('.form-send-message');
    if (!form) return;

    const input = form.querySelector('.message-input');
    const sendBtn = form.querySelector('.send-msg-btn');
    const emojiBtn = form.querySelector('.emoji-btn');

    input.disabled = true;
    input.placeholder = reason;

    sendBtn.disabled = true;
    emojiBtn.style.pointerEvents = 'none';
    emojiBtn.style.opacity = '0.5';
}

function enableChatForm() {
    const form = document.querySelector('.form-send-message');
    if (!form) return;

    const input = form.querySelector('.message-input');
    const sendBtn = form.querySelector('.send-msg-btn');
    const emojiBtn = form.querySelector('.emoji-btn');

    input.disabled = false;
    input.placeholder = 'Type your message here...';

    sendBtn.disabled = false;
    emojiBtn.style.pointerEvents = 'auto';
    emojiBtn.style.opacity = '1';
}

document.addEventListener('click', function (e) {

    const btn = e.target.closest('.close-chat-btn');
    if (!btn) return;

    e.preventDefault();

    const chatId = btn.dataset.chatId;

    if (!chatId) return;

    if (!confirm('Close this chat?')) return;

    fetch("{{ route('admin.chat.close') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ chat_id: chatId })
    })
    .then(res => res.json())
    .then(() => {
        // optional UX
        disableChatForm('Chat closed');
    });
});

function initSidebar() {
    // Avatar click pe sidebar open karo
    document.querySelectorAll('[data-bs-toggle="sidebar"]').forEach(function(el) {
        el.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            if (!targetId) return;

            const sidebar = document.querySelector(targetId);
            if (!sidebar) return;

            sidebar.classList.toggle('show');

            // Overlay handle karo
            const hasOverlay = this.hasAttribute('data-overlay');
            if (hasOverlay) {
                let overlay = document.querySelector('.sidebar-overlay');
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.className = 'sidebar-overlay';
                    document.body.appendChild(overlay);
                }
                overlay.classList.toggle('show');

                // Overlay click pe sidebar band karo
                overlay.addEventListener('click', function () {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
        });
    });

    // Close button bhi handle karo
    document.querySelectorAll('.close-sidebar').forEach(function(el) {
        el.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const sidebar = document.querySelector(targetId);
            if (sidebar) sidebar.classList.remove('show');

            const overlay = document.querySelector('.sidebar-overlay');
            if (overlay) overlay.classList.remove('show');
        });
    });
}
</script>
@endsection
