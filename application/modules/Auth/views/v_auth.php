<!DOCTYPE html>
<html lang="en" oncontextmenu="return false">
    <head>
        <?php
        echo '<base href="' . base_url('Signin') . '"/>';
        echo '<title>{siteTitle}</title>';
        echo meta('Content-type', 'text/html; charset=utf-8', 'equiv');
        echo meta('description', 'Login system ' . $this->bodo->Sys('app_name'));
        echo meta('viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no');
        echo link_tag('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700', 'stylesheet', 'text/css', 'fonts family from googleapis');
        echo link_tag(base_url('assets/css/login-1.css'), 'stylesheet', 'text/css');
        echo link_tag(base_url('assets/plugins/global/plugins.bundle.css'), 'stylesheet', 'text/css');
        echo link_tag(base_url('assets/plugins/custom/prismjs/prismjs.bundle.css'), 'stylesheet', 'text/css');
        echo link_tag(base_url('assets/css/style.bundle.css'), 'stylesheet', 'text/css');
        echo link_tag(base_url('assets/css/themes/layout/header/base/light.css'), 'stylesheet', 'text/css');
        echo link_tag(base_url('assets/css/themes/layout/header/menu/light.css'), 'stylesheet', 'text/css');
        echo link_tag(base_url('assets/css/themes/layout/brand/dark.css'), 'stylesheet', 'text/css');
        echo link_tag(base_url('assets/css/themes/layout/aside/dark.css'), 'stylesheet', 'text/css');
        echo link_tag(base_url('assets/images/systems/' . $this->bodo->Sys('favico')), 'shortcut icon', 'image/ico');
        ?>
    </head>
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
        <div class="d-flex flex-column flex-root">
            <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
                <div class="login-aside d-flex flex-column flex-row-auto" style="background-image:url('<?php echo site_url('assets/images/systems/5039684.jpg'); ?>');background-repeat: no-repeat;background-size: cover;">
                    <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                        <a href="" class="text-center mb-10"> <img src="<?php echo base_url('assets/images/systems/' . $this->bodo->Sys('logo')); ?>" class="max-h-70px" alt="company_logo" /> </a>
                        <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg text-white">
                            <?php echo $this->bodo->Sys('company_name'); ?>
                        </h3>
                    </div>
                    <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"></div>
                </div>
                <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
                    <div class="d-flex flex-column-fluid flex-center">
                        <div class="login-form login-signin">
                            <form id="kt_login_signin_form" class="form" novalidate="novalidate" action="<?php echo base_url('Auth/Signin/'); ?>" method="post">
                                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                                <div class="pb-13 pt-lg-0 pt-5">
                                    <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Welcome to <?php echo $this->bodo->Sys('app_name'); ?></h3>
                                </div>
                                <div class="form-group">
                                    <label class="font-size-h6 font-weight-bolder text-dark">Username</label>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" name="username" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" autocomplete="off" />
                                </div>
                                <div class="pb-lg-0 pb-5">
                                    <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="err_msg" value="<?php echo $this->session->flashdata('err_msg'); ?>"/>
        <input type="hidden" name="succ_msg" value="<?php echo $this->session->flashdata('succ_msg'); ?>"/>
        <?php
        unset($_SESSION['err_msg']);
        unset($_SESSION['succ_msg']);
        ?>
        <script>
            var KTAppSettings = {};
        </script>
        <script src="<?php echo base_url('assets/plugins/global/plugins.bundle.js'); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
        <script>
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: false,
                positionClass: "toast-top-right",
                preventDuplicates: true,
                onclick: null,
                showDuration: "300",
                hideDuration: "2000",
                timeOut: false,
                extendedTimeOut: "2000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };
            var a, b;
            a = $('input[name="err_msg"]').val();
            b = $('input[name="succ_msg"]').val();
            if (a !== "") {
                toastr.error(a);
            } else if (b !== "") {
                toastr.success(b);
            }
            var KTAppSettings = {breakpoints: {sm: 576, md: 768, lg: 992, xl: 1200, xxl: 1200}, colors: {theme: {base: {white: "#ffffff", primary: "#6993FF", secondary: "#E5EAEE", success: "#1BC5BD", info: "#8950FC", warning: "#FFA800", danger: "#F64E60", light: "#F3F6F9", dark: "#212121"}, light: {white: "#ffffff", primary: "#E1E9FF", secondary: "#ECF0F3", success: "#C9F7F5", info: "#EEE5FF", warning: "#FFF4DE", danger: "#FFE2E5", light: "#F3F6F9", dark: "#D6D6E0"}, inverse: {white: "#ffffff", primary: "#ffffff", secondary: "#212121", success: "#ffffff", info: "#ffffff", warning: "#ffffff", danger: "#ffffff", light: "#464E5F", dark: "#ffffff"}}, gray: {"gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121"}}, "font-family": "Poppins"};</script>
        <script src="<?php echo base_url('assets/plugins/custom/prismjs/prismjs.bundle.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/scripts.bundle.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/pages/custom/login/login.js'); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    </body>
</html>
