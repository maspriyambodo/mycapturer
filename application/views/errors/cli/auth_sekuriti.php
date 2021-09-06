<!DOCTYPE html>
<html lang="en" >
    <head>
        <base href="<?php echo base_url('Auth/'); ?>">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
        <title>Security system</title>
        <meta name="description" content="failed login page"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>        <!--end::Fonts-->
        <link href="<?php echo base_url('assets/css/pages/error/error-6.css?v=7.0.6'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/plugins/global/plugins.bundle.css?v=7.0.6'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/style.bundle.css?v=7.0.6'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/themes/layout/header/base/light.css?v=7.0.6'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/themes/layout/header/menu/light.css?v=7.0.6'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/themes/layout/brand/dark.css?v=7.0.6'); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/themes/layout/aside/dark.css?v=7.0.6'); ?>" rel="stylesheet" type="text/css"/>        <!--end::Layout Themes-->
        <link href="<?php echo base_url('assets/images/systems/' . $this->bodo->Sys('favico')); ?>" rel="shortcut icon"/>
    </head>
    <body  id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
        <div class="d-flex flex-column flex-root">
            <div class="error error-6 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url(<?php echo base_url('assets/media/error/bg5.jpg'); ?>);">
                <div class="d-flex flex-column flex-row-fluid text-center">
                    <h1 class="error-title font-weight-boldest text-dark mb-12" style="margin-top: 12rem;">Oops...</h1>
                    <p class="font-size-h3 text-muted font-weight-normal">
                        sorry you have exceeded the limit
                    </p>
                    <p class="font-size-h3 text-muted font-weight-normal">
                        wait until the system returns to the login page
                    </p>
                    <p class="font-size-h3 text-muted font-weight-normal">
                        or contact the support team!
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>