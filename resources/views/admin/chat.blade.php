@extends('admin.layout.app')
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
                            <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/1.png"
                                alt="Avatar" class="rounded-circle">
                        </div>
                        <h5 class="mt-4 mb-0">John Doe</h5>
                        <span>Admin</span>
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
                            <div class="flex-shrink-0 avatar avatar-online me-4" data-bs-toggle="sidebar"
                                data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                                <img class="user-avatar rounded-circle cursor-pointer"
                                    src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/1.png"
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
                            @forelse ($user as $val)
                                <li class="chat-contact-list-item mb-1">
                                    <a class="d-flex align-items-center chat-user" href="{{ route('admin.chat.show', $val->id) }}" data-chat-id="{{ $val->id }}">
                                        <div class="flex-shrink-0 avatar avatar-online">
                                            <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/13.png"
                                                alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div class="chat-contact-info flex-grow-1 ms-4">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="chat-contact-name text-truncate m-0 fw-normal">
                                                    {{ $val->name }}
                                                </h6>
                                                <small class="chat-contact-list-item-time">5 Minutes</small>
                                            </div>
                                            <small class="chat-contact-status text-truncate">Refer friends. Get rewards.</small>
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
                <div class="col app-chat-sidebar-right app-sidebar overflow-hidden" id="app-chat-sidebar-right">
                    <div
                        class="sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-6 pt-12">
                        <div class="avatar avatar-xl avatar-online chat-sidebar-avatar">
                            <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/4.png"
                                alt="Avatar" class="rounded-circle">
                        </div>
                        <h5 class="mt-4 mb-0">Felecia Rower</h5>
                        <span>NextJS Developer</span>
                        <i class="icon-base bx bx-x icon-lg cursor-pointer close-sidebar d-block" data-bs-toggle="sidebar"
                            data-overlay="" data-target="#app-chat-sidebar-right"></i>
                    </div>
                    <div class="sidebar-body p-6 pt-0 ps">
                        <div class="my-6">
                            <p class="text-uppercase mb-1 text-body-secondary">About</p>
                            <p class="mb-0">It is a long established fact that a reader will be distracted by the readable
                                content .
                            </p>
                        </div>
                        <div class="my-6">
                            <p class="text-uppercase mb-1 text-body-secondary">Personal Information</p>
                            <ul class="list-unstyled d-grid gap-4 mb-0 ms-2 py-2 text-heading">
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-envelope"></i>
                                    <span class="align-middle ms-2">josephGreen@email.com</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-phone-call"></i>
                                    <span class="align-middle ms-2">+1(123) 456 - 7890</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="icon-base bx bx-time-five"></i>
                                    <span class="align-middle ms-2">Mon - Fri 10AM - 8PM</span>
                                </li>
                            </ul>
                        </div>
                        <div class="my-6">
                            <p class="text-uppercase text-body-secondary mb-1">Options</p>
                            <ul class="list-unstyled d-grid gap-4 ms-2 py-2 text-heading">
                                <li class="cursor-pointer d-flex align-items-center">
                                    <i class="icon-base bx bx-bookmark"></i>
                                    <span class="align-middle ms-2">Add Tag</span>
                                </li>
                                <li class="cursor-pointer d-flex align-items-center">
                                    <i class="icon-base bx bx-star"></i>
                                    <span class="align-middle ms-2">Important Contact</span>
                                </li>
                                <li class="cursor-pointer d-flex align-items-center">
                                    <i class="icon-base bx bx-image-alt"></i>
                                    <span class="align-middle ms-2">Shared Media</span>
                                </li>
                                <li class="cursor-pointer d-flex align-items-center">
                                    <i class="icon-base bx bx-trash"></i>
                                    <span class="align-middle ms-2">Delete Contact</span>
                                </li>
                                <li class="cursor-pointer d-flex align-items-center">
                                    <i class="icon-base bx bx-block"></i>
                                    <span class="align-middle ms-2">Block Contact</span>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex mt-6">
                            <button class="btn btn-danger w-100" data-bs-toggle="sidebar" data-overlay=""
                                data-target="#app-chat-sidebar-right">Delete Contact<i
                                    class="icon-base bx bx-trash icon-sm ms-2"></i></button>
                        </div>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                </div>
                <!-- /Sidebar Right -->
                <div class="app-overlay"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>

const pusherChat = new Pusher('6d2b8f974bbba728216c', {
    cluster: 'ap1',
    forceTLS: true
});

let chatId = {{ $chatId ?? 'null' }};
let chatChannel = null;
const currentUserId = {{ auth()->id() }};

document.addEventListener('DOMContentLoaded', function () {
    if (currentUserId) {
        subscribeToChat(currentUserId);
    }
});

function subscribeToChat(currentUserId) {
    if (chatChannel) {
        pusherChat.unsubscribe(chatChannel.name);
    }

    const channelName = `chat.${currentUserId}`;
    chatChannel = pusherChat.subscribe(channelName);

    // ✅ SAME EVENT NAME AS BACKEND
    chatChannel.bind('new-message', function (data) {
        appendMessage(data.message, data.role);
    });
}

function appendMessage(text, role) {
    const ul = document.querySelector('.chat-history');

    const noMessage = document.getElementById('no-message');
    if (noMessage) {
        noMessage.remove();
    }

    const li = document.createElement('li');
    li.className = role != 3
        ? 'chat-message chat-message-right'
        : 'chat-message';

    li.innerHTML = `
        <div class="d-flex overflow-hidden">
            ${role == 3 ? `
            <div class="user-avatar flex-shrink-0 me-4">
                <div class="avatar avatar-sm">
                    <img src="{{ asset('assets/images/default.png') }}" class="rounded-circle">
                </div>
            </div>` : ''}

            <div class="chat-message-wrapper flex-grow-1">
                <div class="chat-message-text">
                    <p class="mb-0">${text}</p>
                </div>
            </div>

            ${role != 3 ? `
            <div class="user-avatar flex-shrink-0 ms-4">
                <div class="avatar avatar-sm">
                    <img src="{{ asset('assets/images/default.png') }}" class="rounded-circle">
                </div>
            </div>` : ''}
        </div>
    `;

    ul.appendChild(li);
    ul.scrollTop = ul.scrollHeight;
}

document.querySelectorAll('.chat-user').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        openChat(this.dataset.chatId);
    });
});

document.addEventListener('click', function (e) {
    if (e.target.closest('.send-msg-btn')) {
        const form = e.target.closest('.form-send-message');
        const input = form.querySelector('.message-input');
        const message = input.value.trim();
        if (!message) return;

        const chatId = form.dataset.chatId;

        fetch("{{ route('admin.chat.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                chat_id: chatId,
                message: message
            })
        })
        .then(res => res.json())
        .then(() => {
            appendMessage(message, 2);
            input.value = '';
        })
        .catch(err => console.error(err));
    }
});

document.addEventListener('DOMContentLoaded', function () {
    let params = new URLSearchParams(window.location.search);
    let urlChatId = params.get('chatId');

    if (urlChatId) {
        openChat(urlChatId);
    }
});

function openChat(chatId) {
    let getChat = "{{ route('admin.chat.show', ':id') }}";
    getChat = getChat.replace(':id', chatId);

    fetch(getChat)
        .then(res => res.text())
        .then(html => {
            document.getElementById('app-chat-history').innerHTML = html;
            document.getElementById('app-chat-history').classList.remove('d-none');

            // Hide empty state
            document.getElementById('app-chat-conversation')?.classList.add('d-none');

            // Highlight active chat
            document.querySelectorAll('.chat-user').forEach(el =>
                el.classList.remove('active')
            );
            document
                .querySelector(`.chat-user[data-chat-id="${chatId}"]`)
                ?.classList.add('active');

            subscribeToChat(chatId);
        });
}

</script>
@endsection
