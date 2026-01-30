<!DOCTYPE html>

<html lang="en" class="  layout-menu-fixed   customizer-hide" dir="ltr" data-skin="default"
    data-assets-path="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/"
    data-base-url="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo-1"
    data-framework="laravel" data-template="blank-menu-template" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        Login Basic - Pages | sneat
        - Sneat Bootstrap 5 HTML + Laravel Admin Template
    </title>
    <meta name="description"
        content="Most Powerful &amp; Comprehensive Bootstrap 5 + Laravel HTML Admin Dashboard Template built for developers!" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5" />
    <meta property="og:title" content="Sneat Bootstrap 5 HTML + Laravel Admin Template by ThemeSelection" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="https://themeselection.com/item/sneat-dashboard-pro-laravel/" />
    <meta property="og:image"
        content="https://ts-assets.b-cdn.net/ts-assets/sneat/sneat-bootstrap-laravel-admin-template/marketing/sneat-bootstrap-laravel-admin-template-smm.png" />
    <meta property="og:description"
        content="Most Powerful &amp; Comprehensive Bootstrap 5 + Laravel HTML Admin Dashboard Template built for developers!" />
    <meta property="og:site_name" content="ThemeSelection" />
    <meta name="robots" content="noindex, nofollow" />
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="ZyS4RInKtto0hBChsuoktHMNJ8OujnPNYesBiXij" />
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://themeselection.com/item/sneat-dashboard-pro-laravel/" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}" />

    <!-- Include Styles -->
    <!-- $isFront is used to append the front layout styles only on the front layout otherwise the variable will be blank -->
    <!-- BEGIN: Theme CSS-->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

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
    <!-- Page Styles -->
    <link rel="preload" as="style" href="{{ asset('assets/css/page-auth-BuDPj25M.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/page-auth-BuDPj25M.css') }}" class="" />
    <!-- app CSS -->
    <link rel="modulepreload" href="{{ asset('assets/js/app-l0sNRNKZ.js') }}" />
    <script type="module" src="{{ asset('assets/js/app-l0sNRNKZ.js') }}"></script>

    <!-- Include Scripts for customizer, helper, analytics, config -->
    <!-- $isFront is used to append the front layout scriptsIncludes only on the front layout otherwise the variable will be blank -->
    <!-- laravel style -->
    <link rel="modulepreload" href="{{ asset('assets/js/helpers-0nSKkh37.js') }}" />
    <script type="module" src="{{ asset('assets/js/helpers-0nSKkh37.js') }}"></script>
    <link rel="preload" as="style" href="{{ asset('assets/css/template-customizer-CvTzP1B2.css') }}" />
    <link rel="modulepreload" href="{{ asset('assets/js/template-customizer-CZZ3zmqW.js') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/template-customizer-CvTzP1B2.css') }}" />
    <script type="module" src="{{ asset('assets/js/template-customizer-CZZ3zmqW.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <link rel="modulepreload"
        href="{{ asset('assets/js/config-BoP0Nie5.js') }}" />
    <script type="module"
        src="{{ asset('assets/js/config-BoP0Nie5.js') }}">
    </script>
    <script type="module">
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
    </script>
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
</head>

<body>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
    <!-- Layout Content -->
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Login -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href=""
                                class="app-brand-link gap-2">
                                <span class="app-brand-logo demo"><span class="text-primary">

                                        <svg width="25" viewBox="0 0 25 42" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <defs>
                                                <path
                                                    d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                                                    id="path-1"></path>
                                                <path
                                                    d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                                                    id="path-3"></path>
                                                <path
                                                    d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                                                    id="path-4"></path>
                                                <path
                                                    d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                                                    id="path-5"></path>
                                            </defs>
                                            <g id="g-app-brand" stroke="none" stroke-width="1" fill="none"
                                                fill-rule="evenodd">
                                                <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                                                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                                                            <mask id="mask-2" fill="white">
                                                                <use xlink:href="#path-1"></use>
                                                            </mask>
                                                            <use fill="currentColor" xlink:href="#path-1"></use>
                                                            <g id="Path-3" mask="url(#mask-2)">
                                                                <use fill="currentColor" xlink:href="#path-3"></use>
                                                                <use fill-opacity="0.2" fill="#FFFFFF"
                                                                    xlink:href="#path-3"></use>
                                                            </g>
                                                            <g id="Path-4" mask="url(#mask-2)">
                                                                <use fill="currentColor" xlink:href="#path-4"></use>
                                                                <use fill-opacity="0.2" fill="#FFFFFF"
                                                                    xlink:href="#path-4"></use>
                                                            </g>
                                                        </g>
                                                        <g id="Triangle"
                                                            transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                                            <use fill="currentColor" xlink:href="#path-5"></use>
                                                            <use fill-opacity="0.2" fill="#FFFFFF"
                                                                xlink:href="#path-5"></use>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </span>
                                </span>
                                <span class="app-brand-text demo text-heading fw-bold">sneat</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">Welcome to sneat! 👋</h4>
                        <p class="mb-6">Please sign-in to your account and start the adventure</p>

                        <form id="formAuthentication" class="mb-6" action="{{ route('login.post') }}"
                            method="POST">
                            @csrf
                            <div class="mb-6 form-control-validation">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Enter your email" autofocus
                                    value="{{ old('email') }}" />
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-6 form-password-toggle form-control-validation">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-7">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="remember-me"
                                            name="remember" />
                                        <label class="form-check-label" for="remember-me"> Remember Me </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="{{ route('register') }}">
                                <span>Create an account</span>
                            </a>
                        </p>

                        <div class="divider my-6">
                            <div class="divider-text">or</div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="javascript:;"
                                class="btn btn-sm btn-icon rounded-circle btn-text-facebook me-1_5">
                                <i class="icon-base bx bxl-facebook-circle icon-20px"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-sm btn-icon rounded-circle btn-text-twitter me-1_5">
                                <i class="icon-base bx bxl-twitter icon-20px"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-sm btn-icon rounded-circle btn-text-github me-1_5">
                                <i class="icon-base bx bxl-github icon-20px"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-sm btn-icon rounded-circle btn-text-google-plus">
                                <i class="icon-base bx bxl-google icon-20px"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>
    <!--/ Content -->
    <!--/ Layout Content -->


    {{-- <div class="buy-now">
    <a href="https://themeselection.com/item/sneat-dashboard-pro-laravel/" target="_blank" class="btn btn-danger btn-buy-now">Buy Now</a>
  </div> --}}


    <!-- Include Scripts -->
    <!-- $isFront is used to append the front layout scripts only on the front layout otherwise the variable will be blank -->
    <!-- BEGIN: Vendor JS-->

    <link rel="modulepreload"
        href="{{ asset('assets/js/jquery-Bou6iJJX.js') }}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/jquery-NjmgXMI-.js') }}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/_commonjsHelpers-D6-XlEtG.js') }}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/jquery-BQXThELV.js') }}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/popper-MwzM93Hw.js') }}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/bootstrap-D6PdghTj.js') }}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/autocomplete-js-BLyOkDc2.js') }}" />
    <script type="module"
        src="{{ asset('assets/js/jquery-Bou6iJJX.js') }}">
    </script>
    <script type="module"
        src="{{ asset('assets/js/popper-MwzM93Hw.js') }}">
    </script>
    <script type="module"
        src="{{ asset('assets/js/bootstrap-D6PdghTj.js') }}">
    </script>
    <script type="module"
        src="{{ asset('assets/js/autocomplete-js-BLyOkDc2.js') }}">
    </script>
    <link rel="modulepreload"
        href="{{ asset('assets/js/pickr-71-TLRtn.js') }}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/_commonjsHelpers-D6-XlEtG.js') }}" />
    <script type="module"
        src="{{ asset('assets/js/pickr-71-TLRtn.js') }}">
    </script>
    <link rel="modulepreload"
        href="{{ asset('assets/js/perfect-scrollbar-D2XDwrzR.js') }}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/_commonjsHelpers-D6-XlEtG.js') }}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/hammer-DLEdXtvS.js') }}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/menu-Cc3Gq5JA.js') }}" />
    <script type="module"
        src="{{ asset('assets/js/perfect-scrollbar-D2XDwrzR.js') }}">
    </script>
    <script type="module"
        src="{{ asset('assets/js/hammer-DLEdXtvS.js') }}">
    </script>
    <script type="module"
        src="{{ asset('assets/js/menu-Cc3Gq5JA.js') }}">
    </script>
    <link rel="modulepreload"
        href="{{asset("assets/js/popular-DHD2IDQ4.js")}}" />
    <link rel="modulepreload"
        href="{{ asset('assets/js/_commonjsHelpers-D6-XlEtG.js') }}" />
    <link rel="modulepreload"
        href="{{asset("assets/js/bootstrap5-B8xweYSi.js")}}" />
    <link rel="modulepreload"
        href="{{asset("assets/js/index-eQWVPmsa.js")}}" />
    <link rel="modulepreload"
        href="{{asset("assets/js/auto-focus-gx3LVEfk.js")}}" />
    <script type="module"
        src="{{asset("assets/js/popular-DHD2IDQ4.js")}}">
    </script>
    <script type="module"
        src="{{asset("assets/js/bootstrap5-B8xweYSi.js")}}">
    </script>
    <script type="module"
        src="{{asset("assets/js/auto-focus-gx3LVEfk.js")}}">
    </script><!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <link rel="modulepreload"
        href="{{ asset('assets/js/main-CGh5h70G.js') }}" />
    <script type="module"
        src="{{ asset('assets/js/main-CGh5h70G.js') }}">
    </script>
    <!-- END: Theme JS-->
    <!-- Pricing Modal JS-->
    <!-- END: Pricing Modal JS-->
    <!-- BEGIN: Page JS-->
    <link rel="modulepreload"
        href="{{asset("assets/js/pages-auth-D0KVgRoL.js")}}" />
    <script type="module"
        src="{{asset("assets/js/pages-auth-D0KVgRoL.js")}}">
    </script><!-- END: Page JS-->

    <!-- app JS -->
    <link rel="modulepreload"
        href="{{ asset('assets/js/app-T1DpEqax.js') }}" />
    <script type="module"
        src="{{ asset('assets/js/app-T1DpEqax.js') }}">
    </script><!-- END: app JS-->
</body>

</html>
