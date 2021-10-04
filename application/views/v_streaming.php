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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="<?php echo base_url('assets/streaming.css'); ?>"/>
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
        <section id="main_webinar" class="clearfix main_webinar">
            <div class="container">
                <div class="row pt-4">
                    <div class="col-lg-8 d-xs-block col-xs-12 col-12 col-md-12">
                        <div id="bgndVideo" class="player"></div>
                    </div>
                    <div class="col-lg-4 d-none d-xl-block"><!-- d-sm-none d-xl-block -->
                        <div class="card live-chat-lg">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="form-group">
                                        <i class="fas fa-comments"></i>
                                        <b>Live Chat</b>
                                    </div>
                                </div>
                            </div>
                            <div id="msg_dir" class="card-body"></div>
                            <div class="card-footer input-group mb-3 chat_footer">
                                <input type="text" class="form-control" name="msgtxt" autocomplete="off" onkeypress="Javascript: if (event.keyCode === 13) Send_chat(1);">
                                <button type="button" class="input-group-text" onclick="Send_chat(1)"><i class="fas fa-paper-plane"></i></button>                             
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-4">
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
            <div class="row bg-carousel">
                <div class="col-md-2">
                    <div class="form-group">
                        <p class="text-white text-center" style="margin:10% 0px;">Bekerja sama dengan:</p>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="sertif-carousel slick_wrap">
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
            <div style="padding:40px 0px;"></div>
        </section>
        <section class="second_webinar">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 bg-info">
                        <div style="width:100%;height:300px;">
                            <div class="text-center">
                                <h4>300 x 600 px</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2 bg-success">
                        <div style="width:100%;height:300px;">
                            <div class="text-center">
                                <h4>300 x 250 px</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
        </section>
        <section id="chat_on_mobile" class="d-md-block d-lg-none fixed-bottom clearfix" data-bs-toggle="modal" data-bs-target="#kt_chat_modol" onclick="Open_chat()">
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
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fas fa-comments"></i><b> Live Chat</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="scroll-pull" class="scroll scroll-pull" data-height="375" data-mobile-height="300">
                            <!--begin::Messages-->
                            <div id="msg_dir2" class="messages"></div>
                            <!--end::Messages-->
                        </div>
                    </div>
                    <div class="card-footer align-items-center">
                        <!--begin::Compose-->
                        <textarea name="msgtxt2" class="form-control border-0 p-0" rows="4" placeholder="Type a message" onkeypress="Javascript: if (event.keyCode === 13) Send_chat(2);"></textarea>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <div class="mr-3"></div>
                            <div>
                                <button type="button" class="btn btn-primary text-uppercase font-weight-bold chat-send py-2 px-6" onclick="Send_chat(2)">Send</button>
                                <button type="button" class="btn btn-secondary text-uppercase font-weight-bold chat-send py-2 px-6" data-bs-dismiss="modal" aria-label="Close">Close</button>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="node_modules/socket.io/node_modules/socket.io-client/socket.io.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/streaming.js'); ?>"></script>
    </body>
</html>
