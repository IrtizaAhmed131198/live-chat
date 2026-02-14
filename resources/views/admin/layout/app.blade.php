<!DOCTYPE html>

<html lang="en" class="layout-navbar-fixed layout-compact layout-menu-fixed   " dir="ltr" data-skin="default"
    data-assets-path="" data-base-url="" data-framework="laravel" data-template="vertical-menu-template"
    data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        Dashboard |
        {{ ($title = trim($__env->yieldContent('title'))) ? $title . ' - ' : '' }}{{ config('app.name', 'Live Chat') }}
    </title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="{{ url()->current() }}" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/favicon/favicon.ico" />

    <!-- Include Styles -->
    <!-- $isFront is used to append the front layout styles only on the front layout otherwise the variable will be blank -->
    <!-- BEGIN: Theme CSS-->
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <link rel="preload" as="style" href="{{ asset('assets/css/app-chat-B_Ac8XJQ.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app-chat-B_Ac8XJQ.css') }}" class="" />
    <!-- Fonts Icons -->
    <link rel="preload" as="style" href="{{ asset('assets/css/iconify-DDZnTNbY.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/iconify-DDZnTNbY.css') }}" class="" />
    <!-- BEGIN: Vendor CSS-->
    <link rel="preload" as="style" href="{{ asset('assets/css/pickr-themes-CFnMLNHJ.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/pickr-themes-CFnMLNHJ.css') }}" class="" />
    <!-- Core CSS -->
    <link rel="preload" as="style" href="{{ asset('assets/css/core-CsLdeUI9.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/core-CsLdeUI9.css') }}" class="template-customizer-core-css" />
    <link rel="preload" as="style" href="{{ asset('assets/css/demo-kASxDmGZ.css') }}" />
    <link rel="preload" as="style" href="{{ asset('assets/css/perfect-scrollbar-CfyPsj0y.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo-kASxDmGZ.css') }}" class="" />
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar-CfyPsj0y.css') }}" class="" />
    <!-- Vendor Styles -->
    <link rel="preload" as="style" href="{{ asset('assets/css/perfect-scrollbar-CfyPsj0y.css') }}" />
    <link rel="preload" as="style" href="{{ asset('assets/css/typeahead-CtVgDGc0.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar-CfyPsj0y.css') }}" class="" />
    <link rel="stylesheet" href="{{ asset('assets/css/typeahead-CtVgDGc0.css') }}" class="" />
    <link rel="preload" as="style" href="{{ asset('assets/css/flag-icons-TUQATJgS.css') }}" />
    <link rel="preload" as="style" href="{{ asset('assets/css/apex-charts-DWhxKQx9.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flag-icons-TUQATJgS.css') }}" class="" />
    <link rel="stylesheet" href="{{ asset('assets/css/apex-charts-DWhxKQx9.css') }}" class="" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <!-- Page Styles -->

    <link rel="preload" as="style" href="{{ asset('assets/css/template-customizer-CvTzP1B2.css') }}" />
    <link rel="modulepreload" href="{{ asset('assets/js/template-customizer-CZZ3zmqW.js') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/template-customizer-CvTzP1B2.css') }}" />
    <!-- app CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" class="" />
    <!-- END: app CSS-->
    <!-- In your <head> section -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Before closing </body> tag -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    @yield('css')
</head>

<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('admin.layout.sidebar')
            <div class="layout-page">
                @include('admin.layout.header')
                <div class="content-wrapper">
                    @yield('content')
                    @include('admin.layout.footer')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <link rel="modulepreload" href="{{ asset('assets/js/helpers-0nSKkh37.js') }}" />
    <script type="module" src="{{ asset('assets/js/helpers-0nSKkh37.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <link rel="modulepreload" href="{{ asset('assets/js/config-BoP0Nie5.js') }}" />
    <script type="module" src="{{ asset('assets/js/config-BoP0Nie5.js') }}"></script>
    {{-- <link rel="modulepreload" href="{{ asset('assets/js/jquery-Bou6iJJX.js') }}" /> --}}
    {{-- <link rel="modulepreload" href="{{ asset('assets/js/jquery-NjmgXMI-.js') }}" /> --}}
    <link rel="modulepreload" href="{{ asset('assets/js/_commonjsHelpers-D6-XlEtG.js') }}" />
    {{-- <link rel="modulepreload" href="{{ asset('assets/js/jquery-BQXThELV.js') }}" /> --}}
    <link rel="modulepreload" href="{{ asset('assets/js/popper-MwzM93Hw.js') }}" />
    <link rel="modulepreload" href="{{ asset('assets/js/bootstrap-D6PdghTj.js') }}" />
    <link rel="modulepreload" href="{{ asset('assets/js/autocomplete-js-BLyOkDc2.js') }}" />
    {{-- <script type="module" src="{{ asset('assets/js/jquery-Bou6iJJX.js') }}"></script> --}}
    <script type="module" src="{{ asset('assets/js/popper-MwzM93Hw.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/bootstrap-D6PdghTj.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/autocomplete-js-BLyOkDc2.js') }}"></script>
    <link rel="modulepreload" href="{{ asset('assets/js/pickr-71-TLRtn.js') }}" />
    <link rel="modulepreload" href="{{ asset('assets/js/_commonjsHelpers-D6-XlEtG.js') }}" />
    <script type="module" src="{{ asset('assets/js/pickr-71-TLRtn.js') }}"></script>
    <link rel="modulepreload" href="{{ asset('assets/js/perfect-scrollbar-D2XDwrzR.js') }}" />
    <link rel="modulepreload" href="{{ asset('assets/js/_commonjsHelpers-D6-XlEtG.js') }}" />
    <link rel="modulepreload" href="{{ asset('assets/js/hammer-DLEdXtvS.js') }}" />
    <link rel="modulepreload" href="{{ asset('assets/js/menu-Cc3Gq5JA.js') }}" />
    <script type="module" src="{{ asset('assets/js/perfect-scrollbar-D2XDwrzR.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/hammer-DLEdXtvS.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/menu-Cc3Gq5JA.js') }}"></script>
    {{-- <link rel="modulepreload" href="{{ asset('assets/js/main-CGh5h70G.js') }}" /><script type="module" src="{{ asset('assets/js/main-CGh5h70G.js') }}"></script> --}}
    <link rel="modulepreload" href="{{ asset('assets/js/app-chat-B0MYhsTQ.js') }}" />
    <script type="module" src="{{ asset('assets/js/app-chat-B0MYhsTQ.js') }}"></script>

    <link rel="modulepreload" href="{{ asset('assets/js/app-T1DpEqax.js') }}" />
    <script type="module" src="{{ asset('assets/js/app-T1DpEqax.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

    <script>
        Pusher.logToConsole = true;
        document.addEventListener('DOMContentLoaded', function() {

            // 1️⃣ Hide badge if no unread notifications
            const badge = document.getElementById('notificationBadge');
            const badge2 = document.getElementById('notificationBadge2');
            if (parseInt(badge.innerText) === 0) {
                badge.classList.add('d-none');
                badge2.classList.add('d-none');
            }

            // 2️⃣ Mark all as read click
            document.querySelector('.dropdown-notifications-all').addEventListener('click', function() {
                fetch("{{ route('notifications.markRead') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            badge.classList.add('d-none');
                            badge2.classList.add('d-none');
                            document.querySelectorAll('#notificationList .badge-dot').forEach(el => el
                                .remove());
                        }
                    });
            });

            // 3️⃣ Pusher listener for new notifications
            var pusher = new Pusher("6d2b8f974bbba728216c", {
                cluster: "ap1"
            });
            var channel = pusher.subscribe('admin-notifications');

            channel.bind('visitor-joined', function(data) {
                Swal.fire({
                    icon: 'info',
                    title: 'New Visitor 🎉',
                    html: `<p>${data.website.domain} just visited.</p>`,
                    showConfirmButton: true,
                    confirmButtonText: 'Start Chat',
                    allowOutsideClick: false,
                    preConfirm: () => {
                        return fetch("{{ route('admin.chat.start') }}", {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    visitor_id: data.visitor.id,
                                    website_id: data.website.id
                                })
                            })
                            .then(res => res.json())
                            .then(resp => {
                                window.location.href = "{{ route('admin.chat') }}" +
                                    "?chatId=" + resp.chat_id;
                            })
                            .catch(err => {
                                Swal.showValidationMessage('Failed to start chat');
                                console.error(err);
                            });
                    }
                });

                // Append to dropdown notification
                const html = `
                <li class="list-group-item dropdown-notifications-item">
                    <strong>New Visitor</strong><br>
                    <small>${data.website.domain}</small>
                    <span class="badge badge-dot"></span>
                </li>
            `;
                document.getElementById('notificationList').insertAdjacentHTML('afterbegin', html);
                document.getElementById('notificationBadge').classList.remove('d-none');
            });
        });
    </script>

    @yield('js')

    {{-- <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize template customizer after DOM is loaded
            if (window.TemplateCustomizer) {
                try {
                    // Get the skin currently applied to the document
                    const appliedSkin = document.documentElement.getAttribute('data-skin') || "default";

                    window.templateCustomizer = new TemplateCustomizer({
                        defaultTextDir: "ltr",
                        defaultTheme: "light",
                        defaultSkin: appliedSkin,
                        defaultSemiDark: false,
                        defaultShowDropdownOnHover: "1",
                        displayCustomizer: "1",
                        lang: 'en',
                        'controls': ["color", "theme", "skins", "semiDark", "layoutCollapsed",
                            "layoutNavbarOptions", "headerType", "contentLayout", "rtl"
                        ],
                    });

                    // Ensure color is applied on page load
                } catch (error) {
                    console.warn('Template customizer initialization error:', error);
                }
            }
        });
    </script> --}}
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5DDHKGP');
    </script>

</body>

</html>
