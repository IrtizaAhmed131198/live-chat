<div class="chat-history-wrapper">
    <div class="chat-history-header border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex overflow-hidden align-items-center">
                <i class="icon-base bx bx-menu icon-lg cursor-pointer d-lg-none d-block me-4"
                    data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-contacts"></i>
                <div class="flex-shrink-0 avatar avatar-online">
                    <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/avatars/4.png"
                        alt="Avatar" class="rounded-circle" data-bs-toggle="sidebar" data-overlay=""
                        data-target="#app-chat-sidebar-right">
                </div>
                <div class="chat-contact-info flex-grow-1 ms-4">
                    <h6 class="m-0 fw-normal">{{ $user->name }}</h6>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button
                        class="btn btn-icon btn-text-secondary text-secondary rounded-pill dropdown-toggle hide-arrow"
                        data-bs-toggle="dropdown" aria-expanded="true" id="chat-header-actions"><i
                            class="icon-base bx bx-dots-vertical-rounded icon-md"></i></button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">
                        <a class="dropdown-item" href="javascript:void(0);">View Contact</a>
                        <a class="dropdown-item" href="javascript:void(0);">Mute Notifications</a>
                        <a class="dropdown-item" href="javascript:void(0);">Block Contact</a>
                        <a class="dropdown-item" href="javascript:void(0);">Clear Chat</a>
                        <a class="dropdown-item" href="javascript:void(0);">Report</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="chat-history-body ps">

        <ul class="list-unstyled chat-history">
            @forelse($messages as $msg)
                <li class="chat-message {{ $msg->sender === 'agent' ? 'chat-message-right' : '' }}">
                    <div class="d-flex overflow-hidden">

                        @if($msg->sender === 'visitor')
                            <div class="user-avatar flex-shrink-0 me-4">
                                <div class="avatar avatar-sm">
                                    <img src="{{ asset('assets/images/default.png') }}"
                                        class="rounded-circle">
                                </div>
                            </div>
                        @endif

                        <div class="chat-message-wrapper flex-grow-1">
                            <div class="chat-message-text">
                                <p class="mb-0">{{ $msg->message }}</p>
                            </div>
                            <div class="text-body-secondary mt-1 {{ $msg->sender === 'agent' ? 'text-end' : '' }}">
                                <small>{{ $msg->created_at->format('h:i A') }}</small>
                            </div>
                        </div>

                        @if($msg->sender === 'agent')
                            <div class="user-avatar flex-shrink-0 ms-4">
                                <div class="avatar avatar-sm">
                                    <img src="{{ asset('assets/images/default.png') }}"
                                        class="rounded-circle">
                                </div>
                            </div>
                        @endif

                    </div>
                </li>
            @empty
                <li class="text-center text-muted py-3" id="no-message">
                    No messages yet
                </li>
            @endforelse
        </ul>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </div>
    <!-- Chat message form -->
    <div class="chat-history-footer shadow-xs">
        <form class="form-send-message d-flex justify-content-between align-items-center " data-chat-id="{{ $chatId }}">
            <input class="form-control message-input border-0 me-4 shadow-none"
                placeholder="Type your message here...">
            <div class="message-actions d-flex align-items-center">
                <label for="attach-doc" class="form-label mb-0">
                    <span class="btn btn-text-secondary btn-icon rounded-pill cursor-pointer mx-1">
                        <i class="icon-base bx bx-paperclip icon-md text-heading"></i>
                    </span>
                    <input type="file" id="attach-doc" hidden="">
                </label>
                <button type="button" class="btn btn-primary d-flex send-msg-btn">
                    <span class="align-middle d-md-inline-block d-none">Send</span>
                    <i class="icon-base bx bx-paper-plane icon-sm ms-md-2 ms-0"></i>
                </button>
            </div>
        </form>
    </div>
</div>
