<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Terminų valdymo sistema - UAB Ekometrija</title>

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link href="../assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

    <!--begin:: Global Optional Vendors -->
    <link href="../assets/vendors/general/tether/dist/css/tether.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/nouislider/distribute/nouislider.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/owl.carousel/dist/assets/owl.carousel.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/owl.carousel/dist/assets/owl.theme.default.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/summernote/dist/summernote.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/animate.css/animate.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/toastr/build/toastr.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/morris.js/morris.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/sweetalert2/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/general/socicon/css/socicon.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/custom/vendors/line-awesome/css/line-awesome.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/custom/vendors/flaticon/flaticon.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/custom/vendors/flaticon2/flaticon.css" rel="stylesheet" type="text/css" />
    <link href="../assets/vendors/custom/vendors/fontawesome5/css/all.min.css" rel="stylesheet" type="text/css" />

    <link href="../assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="../assets/demo/default/skins/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="../assets/demo/default/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="../assets/demo/default/skins/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="../assets/demo/default/skins/aside/dark.css" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="../assets/media/logos/favicon.ico" />
</head>
<body class="kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    <div id="app">
        <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
            <div class="kt-header-mobile__logo">
                <a href="index.html">
                    <img alt="Logo" src="../assets/media/logos/logo-light.png" />
                </a>
            </div>
            <div class="kt-header-mobile__toolbar">
                <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
                <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
                <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
            </div>
        </div>
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
                @include('partials.sidebar')
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                    @include('partials.navbar')
                    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
                        @include('partials.subnavbar')
                        <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#5d78ff",
                    "dark": "#282a3c",
                    "light": "#ffffff",
                    "primary": "#5867dd",
                    "success": "#34bfa3",
                    "info": "#36a3f7",
                    "warning": "#ffb822",
                    "danger": "#fd3995"
                },
                "base": {
                    "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                    "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
                }
            }
        };
    </script>

    <!--begin:: Global Mandatory Vendors -->
    <script src="../assets/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/popper.js/dist/umd/popper.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/js-cookie/src/js.cookie.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/moment/min/moment.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/sticky-js/dist/sticky.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/wnumb/wNumb.js" type="text/javascript"></script>
    <!--end:: Global Mandatory Vendors -->

    <!--begin:: Global Optional Vendors -->
    <script src="../assets/vendors/general/jquery-form/dist/jquery.form.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/block-ui/jquery.blockUI.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/components/vendors/bootstrap-datepicker/init.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/components/vendors/bootstrap-timepicker/init.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/components/vendors/bootstrap-switch/init.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/select2/dist/js/select2.full.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/ion-rangeslider/js/ion.rangeSlider.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/typeahead.js/dist/typeahead.bundle.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/handlebars/dist/handlebars.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/nouislider/distribute/nouislider.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/owl.carousel/dist/owl.carousel.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/autosize/dist/autosize.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/clipboard/dist/clipboard.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/dropzone/dist/dropzone.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/summernote/dist/summernote.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/markdown/lib/markdown.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/components/vendors/bootstrap-markdown/init.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/bootstrap-notify/bootstrap-notify.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/components/vendors/bootstrap-notify/init.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/jquery-validation/dist/jquery.validate.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/jquery-validation/dist/additional-methods.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/components/vendors/jquery-validation/init.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/toastr/build/toastr.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/raphael/raphael.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/morris.js/morris.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/chart.js/dist/Chart.bundle.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/waypoints/lib/jquery.waypoints.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/counterup/jquery.counterup.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/es6-promise-polyfill/promise.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/components/vendors/sweetalert2/init.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/jquery.repeater/src/lib.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/jquery.repeater/src/jquery.input.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/jquery.repeater/src/repeater.js" type="text/javascript"></script>
    <script src="../assets/vendors/general/dompurify/dist/purify.js" type="text/javascript"></script>

    <script src="../assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
    <script src="../assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="../assets/app/bundle/app.bundle.js" type="text/javascript"></script>

    @yield('footer-js')
</body>
</html>
