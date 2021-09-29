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
                <div class="d-flex">
                    <button type="button" class="btn btn-custom ms-4">Masuk</button>
                    <button type="button" class="btn btn-custom ms-4">Daftar</button>
                </div>
            </div>
        </nav>
        <section class="my-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 d-xs-block col-xs-12 col-12 my-4">
                        <div id="bgndVideo" class="player">Video Title</div>
                    </div>
                    <div class="col-md-4"><!-- d-sm-none d-xl-block -->
                        <div class="card" style="height:100%;">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="form-group">
                                        <i class="fas fa-comments"></i>
                                        <b>Live Chat</b>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
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
        <section class="my-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
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
        <section class="my-4 bg-carousel">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <p class="text-white" style="margin:10% 0px;">Bekerja sama dengan:</p>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="your-class">
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
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    dots: false,
                    infinite: true,
                    cssEase: 'linear',
                    autoplay: true,
                    autoplaySpeed: 2000,
                    lazyLoad: 'ondemand',
                    arrows: false,
                    centerMode: true,
                    centerPadding: '60px'
                });
            };
        </script>
    </body>
</html>
