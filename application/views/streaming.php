<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Live Streaming</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.mb.YTPlayer/3.3.9/css/jquery.mb.YTPlayer.min.css" integrity="sha512-+HWFHCZZfMe4XQRKS0bOzQ1r4+G2eknhMqP+FhFIkcmWPJlB4uFaIagSIRCKDOZI3IHc0t7z4+N/g2hIaO/JIw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/css/bootstrap.min.css" integrity="sha512-6KY5s6UI5J7SVYuZB4S/CZMyPylqyyNZco376NM2Z8Sb8OxEdp02e1jkKk/wZxIEmjQ6DRCEBhni+gpr9c4tvA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <style>
            body{
                background: linear-gradient(94.05deg, #23509C 0%, #2355BB 43.07%, #4A88FF 92.92%);
            }
            .bg-custom{
                background-color: #506F9A;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
            }
            .btn-custom{
                background-color: #F3F3F3;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.25);
                border-radius: 8px;
            }
            .mb_YTPlayer iframe {
                pointer-events: none;
            }
            .chat_footer{
                padding:0 !important;
                margin-bottom: 0 !important;
            }
            .pict_user_chat{
                width:28px;
                height:28px;
                margin-right:5px;
                float: left;
            }
            .username_chat{
                font-size: 11px;
            }
            .slick-slide{
                width:auto !important;
                margin:0px 10px;
            }
            .bg-carousel{
                background: linear-gradient(90.27deg, #2D6FA0 -16.75%, rgba(69, 156, 207, 0.72) 100.23%);
                opacity: 0.8;
                backdrop-filter: blur(20px);
                padding: 10px 0px;
            }
            .slick_wrap{
                margin:0px 5%;
            }
            #chat_on_mobile{
                cursor: pointer;
                height:36px;
                background: #FFFFFF;
                box-shadow: 0px -6px 12px rgba(0, 0, 0, 0.1);
                border-radius: 10px 10px 0px 0px;
            }
            .title_txt{
                float: left;
                margin:5px 0px;
            }
            .title_icon{
                float: right;
                margin:5px 0px;
            }
            .kt_chat_modol{
                bottom:0;
                right:0;
                padding: 0 !important;
                height:auto;
                position:fixed;
                left:auto;
                top:auto;
                margin:0px;
                box-shadow:0px 0px 60px -15px rgba(0, 0, 0, 0.2);
                border-radius:0.42rem;
                overflow-x:hidden;
                overflow-y:auto;
            }
            .kt_chat_modol .modal-dialog{
                margin:0 !important;
            }
            .scroll {
                position: relative;
            }
            .scroll.scroll-pull{
                padding-right:12px;
                margin-right:-12px;
            }
            .align-items-start {
                -webkit-box-align: start !important;
                -ms-flex-align: start !important;
                align-items: flex-start !important;
            }
            .flex-column {
                -webkit-box-orient: vertical !important;
                -webkit-box-direction: normal !important;
                -ms-flex-direction: column !important;
                flex-direction: column !important;
            }
            .d-flex {
                display: -webkit-box !important;
                display: -ms-flexbox !important;
                display: flex !important;
            }
            .symbol {
                display: inline-block;
                -ms-flex-negative: 0;
                flex-shrink: 0;
                position: relative;
                border-radius: 0.42rem;
            }
            .symbol.symbol-40 > img {
                width: 100%;
                max-width: 40px;
                height: 40px;
            }
            .text-dark-75 {
                color: #3F4254 !important;
            }
            .font-weight-bold {
                font-weight: 500 !important;
            }
            .font-size-sm {
                font-size: 0.925rem;
            }
            .font-size-lg {
                font-size: 1.08rem;
            }
            .text-dark-50 {
                color: #7E8299 !important;
            }
            .max-w-400px {
                max-width: 400px !important;
            }
            .bg-light-success {
                background-color: #C9F7F5 !important;
            }
            .font-weight-bold {
                font-weight: 500 !important;
            }
            .p-5 {
                padding: 1.25rem !important;
            }
            .card.card-custom > .card-footer {
                background-color: transparent;
            }
            .card-footer:last-child {
                border-radius: 0 0 calc(0.42rem - 1px) calc(0.42rem - 1px);
            }
            .align-items-center {
                -webkit-box-align: center !important;
                -ms-flex-align: center !important;
                align-items: center !important;
            }
            .card-footer {
                padding: 2rem 2.25rem;
                background-color: #ffffff;
                border-top: 1px solid #EBEDF3;
            }
            textarea.form-control {
                height: auto;
            }
            .p-0 {
                padding: 0 !important;
            }
            .border-0 {
                border: 0 !important;
            }
            .form-control {
                display: block;
                width: 100%;
                height: calc(1.5em + 1.3rem + 2px);
                padding: 0.65rem 1rem;
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #3F4254;
                background-color: #ffffff;
                background-clip: padding-box;
                border: 1px solid #E4E6EF;
                border-radius: 0.42rem;
                -webkit-box-shadow: none;
                box-shadow: none;
                -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
                transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            }
            textarea {
                overflow: auto;
                resize: vertical;
            }
            input, button, select, optgroup, textarea {
                margin: 0;
                font-family: inherit;
                font-size: inherit;
                line-height: inherit;
            }
            .form-control:focus {
                box-shadow: none !important;
                color: #3F4254;
                background-color: #ffffff;
                border-color: #69b3ff;
                outline: 0;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="<?php echo base_url('assets/images/logo_festival.png'); ?>" alt="Festival Sertifikasiku"/>
                </a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    </ul>
                </div>

                <div class="text-right">
                    <button type="button" class="btn btn-custom ms-2">Masuk</button>
                    <button type="button" class="btn btn-custom ms-2">Daftar</button>
                </div>
            </div>
        </nav>
        <section id="main_webinar" class="my-4 clearfix">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 d-xs-block col-xs-12 col-12 col-md-12 my-4">
                        <div id="bgndVideo" class="player">Video Title</div>
                    </div>
                    <div class="col-lg-4 d-none d-xl-block"><!-- d-sm-none d-xl-block -->
                        <div class="card" style="max-height:600px;height:100%;">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="form-group">
                                        <i class="fas fa-comments"></i>
                                        <b>Live Chat</b>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="overflow: auto;">
                                <div class="form-group mb-2">
                                    <img class="img-fluid pict_user_chat rounded-circle" src="<?php echo base_url('assets/images/unnamed.jpg'); ?>" alt="username"/>
                                    <b class="username_chat">Mamat</b>
                                    <span class="ms-2 text-muted">​Ayooo NTT qm pasti bisa, tunjukan kebolehan qm</span>
                                </div>

                                <div class="form-group mb-2">
                                    <img class="img-fluid pict_user_chat rounded-circle" src="<?php echo base_url('assets/images/unnamed.jpg'); ?>" alt="username"/>
                                    <b class="username_chat">Mamat</b>
                                    <span class="ms-2 text-muted">​Ayooo NTT qm pasti bisa, tunjukan kebolehan qm</span>
                                </div>

                                <div class="form-group mb-2">
                                    <img class="img-fluid pict_user_chat rounded-circle" src="<?php echo base_url('assets/images/unnamed.jpg'); ?>" alt="username"/>
                                    <b class="username_chat">Mamat</b>
                                    <span class="ms-2 text-muted">​Ayooo NTT qm pasti bisa, tunjukan kebolehan qm</span>
                                </div>

                                <div class="form-group mb-2">
                                    <img class="img-fluid pict_user_chat rounded-circle" src="<?php echo base_url('assets/images/unnamed.jpg'); ?>" alt="username"/>
                                    <b class="username_chat">Mamat</b>
                                    <span class="ms-2 text-muted">​Ayooo NTT qm pasti bisa, tunjukan kebolehan qm</span>
                                </div>

                                <div class="form-group mb-2">
                                    <img class="img-fluid pict_user_chat rounded-circle" src="<?php echo base_url('assets/images/unnamed.jpg'); ?>" alt="username"/>
                                    <b class="username_chat">Mamat</b>
                                    <span class="ms-2 text-muted">​Ayooo NTT qm pasti bisa, tunjukan kebolehan qm</span>
                                </div>
                                <div class="form-group mb-2">
                                    <img class="img-fluid pict_user_chat rounded-circle" src="<?php echo base_url('assets/images/unnamed.jpg'); ?>" alt="username"/>
                                    <b class="username_chat">Mamat</b>
                                    <span class="ms-2 text-muted">​Ayooo NTT qm pasti bisa, tunjukan kebolehan qm</span>
                                </div>

                                <div class="form-group mb-2">
                                    <img class="img-fluid pict_user_chat rounded-circle" src="<?php echo base_url('assets/images/unnamed.jpg'); ?>" alt="username"/>
                                    <b class="username_chat">Mamat</b>
                                    <span class="ms-2 text-muted">​Ayooo NTT qm pasti bisa, tunjukan kebolehan qm</span>
                                </div>

                                <div class="form-group mb-2">
                                    <img class="img-fluid pict_user_chat rounded-circle" src="<?php echo base_url('assets/images/unnamed.jpg'); ?>" alt="username"/>
                                    <b class="username_chat">Mamat</b>
                                    <span class="ms-2 text-muted">​Ayooo NTT qm pasti bisa, tunjukan kebolehan qm</span>
                                </div>

                                <div class="form-group mb-2">
                                    <img class="img-fluid pict_user_chat rounded-circle" src="<?php echo base_url('assets/images/unnamed.jpg'); ?>" alt="username"/>
                                    <b class="username_chat">Mamat</b>
                                    <span class="ms-2 text-muted">​Ayooo NTT qm pasti bisa, tunjukan kebolehan qm</span>
                                </div>

                                <div class="form-group mb-2">
                                    <img class="img-fluid pict_user_chat rounded-circle" src="<?php echo base_url('assets/images/unnamed.jpg'); ?>" alt="username"/>
                                    <b class="username_chat">Mamat</b>
                                    <span class="ms-2 text-muted">​Ayooo NTT qm pasti bisa, tunjukan kebolehan qm</span>
                                </div>
                            </div>
                            <div class="card-footer input-group mb-3 chat_footer">
                                <span class="input-group-text"><i class="far fa-smile"></i></span>
                                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <span class="input-group-text"><i class="fas fa-paper-plane"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="webinar_title" class="my-4 clearfix">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 d-xs-block col-xs-12 col-12 col-md-12">
                        <div class="form-group">
                            <h4 class="text-white">Judul Webinar</h4>
                        </div>
                        <p class="text-white" style="text-align: justify !important;">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section id="carousel" class="my-4 bg-carousel clearfix">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <p class="text-white text-center" style="margin:10% 0px;">Bekerja sama dengan:</p>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="your-class slick_wrap">
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz1.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz2.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz3.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz1.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz2.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz3.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz1.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz2.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz3.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz1.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz2.png" class="img-fluid" width="100"/>
                            </div>
                            <div>
                                <img src="http://kenwheeler.github.io/slick/img/fonz3.png" class="img-fluid" width="100"/>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </section>
        <section id="empt_space" class="d-block clearfix my-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 bg-info">
                        <div style="width:100%;height:300px;">
                            <div class="text-center">
                                <h4 style="padding:30% 0px;">300 x 600 px</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2 bg-success">
                        <div style="width:100%;height:300px;">
                            <div class="text-center">
                                <h4 style="padding:35% 0px;">300 x 250 px</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
        </section>

        <section id="chat_on_mobile" class="d-md-block d-lg-none fixed-bottom clearfix" data-bs-toggle="modal" data-bs-target="#kt_chat_modol">
            <div class="container">
                <div class="form-group">
                    <span class="title_txt">Live Chat</span>
                </div>
                <div class="form-group">
                    <span id="title_icon" class="title_icon"><i class="fas fa-chevron-up"></i></span>
                </div>
            </div>
            <div class="clearfix" style="border-bottom:1px solid #6c757d;width:100%;"></div>
        </section>
        <div class="modal fade kt_chat_modol" id="kt_chat_modol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="scroll scroll-pull" data-height="375" data-mobile-height="300" style="overflow: auto; height: 300px;">
                            <!--begin::Messages-->
                            <div class="messages">

                                <!--begin::Message In-->
                                <div class="d-flex flex-column mb-5 align-items-start">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40 mr-3">
                                            <img class="rounded-circle" alt="Pic" src="assets/media/users/300_12.jpg">
                                        </div>
                                        <div class="mx-2">
                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6" style="text-decoration:none;">Matt Pears</a>
                                            <span class="text-muted font-size-sm">2 Hours</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                        How likely are you to recommend our company
                                        to your friends and family?
                                    </div>
                                </div>
                                <!--end::Message In-->

                                <!--begin::Message In-->
                                <div class="d-flex flex-column mb-5 align-items-start">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40 mr-3">
                                            <img class="rounded-circle" alt="Pic" src="assets/media/users/300_12.jpg">
                                        </div>
                                        <div class="mx-2">
                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6" style="text-decoration:none;">Matt Pears</a>
                                            <span class="text-muted font-size-sm">2 Hours</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                        How likely are you to recommend our company
                                        to your friends and family?
                                    </div>
                                </div>
                                <!--end::Message In-->

                            </div>
                            <!--end::Messages-->
                        </div>
                    </div>
                    <div class="card-footer align-items-center">
                        <!--begin::Compose-->
                        <textarea class="form-control border-0 p-0" rows="5" placeholder="Type a message"></textarea>
                        <div class="d-flex align-items-center justify-content-between mt-5">
                            <div class="mr-3">

                            </div>
                            <div>
                                <button type="button" class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6">Send</button>
                                <button type="button" class="btn btn-secondary btn-md text-uppercase font-weight-bold chat-send py-2 px-6" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                            </div>
                        </div>
                        <!--begin::Compose-->
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/js/bootstrap.min.js" integrity="sha512-ewfXo9Gq53e1q1+WDTjaHAGZ8UvCWq0eXONhwDuIoaH8xz2r96uoAYaQCm1oQhnBfRXrvJztNXFsTloJfgbL5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.2/jquery-migrate.min.js" integrity="sha512-3fMsI1vtU2e/tVxZORSEeuMhXnT9By80xlmXlsOku7hNwZSHJjwcOBpmy+uu+fyWwGCLkMvdVbHkeoXdAzBv+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mb.YTPlayer/3.3.9/jquery.mb.YTPlayer.js" integrity="sha512-QEsEUG6vCJ4YMCLGNXn9zScVK2FYKyMSntIS5s3P8h1c5kz5320OE5nij835WZqfTt3JrfyyoOTm0JhVWoqJPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            window.onload = function () {
                document.getElementById("bgndVideo").addEventListener("contextmenu", function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                });
                $("#bgndVideo").YTPlayer({
                    videoURL: 'uSIK2m54CNw',
                    containment: 'self',
                    autoPlay: false,
                    mute: false,
                    startAt: 0,
                    showControls: true,
                    useOnMobile: true,
                    vol: 100,
                    opacity: 1,
                    optimizeDisplay: true,
                    loop: false,
                    showYTLogo: false,
                    remember_last_time: true,
                    stopMovieOnBlur: true,
                    useNoCookie: true,
                    coverImage: '<?php echo base_url('assets/images/ToT4.png'); ?>'
                });
                $('.your-class').slick({
                    slidesToScroll: 1,
                    dots: false,
                    infinite: false,
                    cssEase: 'linear',
                    lazyLoad: 'ondemand',
                    arrows: true,
                    centerMode: false,
                    centerPadding: '60px'
                });
            };
        </script>
    </body>
</html>
