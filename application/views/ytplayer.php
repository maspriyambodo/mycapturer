<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>YT-PLAYER</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.mb.YTPlayer/3.3.9/css/jquery.mb.YTPlayer.min.css" integrity="sha512-+HWFHCZZfMe4XQRKS0bOzQ1r4+G2eknhMqP+FhFIkcmWPJlB4uFaIagSIRCKDOZI3IHc0t7z4+N/g2hIaO/JIw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <style>
            .mb_YTPlayer iframe {
                pointer-events: none;
            }
        </style>
    </head>
    <body>
        <div id="bgndVideo" class="player" style="width:500px !important;height:500px !important;" oncontextmenu="return false;">Video Title</div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mb.YTPlayer/3.3.9/jquery.mb.YTPlayer.js" integrity="sha512-QEsEUG6vCJ4YMCLGNXn9zScVK2FYKyMSntIS5s3P8h1c5kz5320OE5nij835WZqfTt3JrfyyoOTm0JhVWoqJPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                    coverImage: 'https://simbi.kemenag.dev/adminlayanan/assets/uploads/galeri_kua/1101011/1101011_20210801164236.png'
                });
            };
        </script>
    </body>
</html>
