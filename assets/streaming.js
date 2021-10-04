window.onload = function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "showDuration": "300",
        "hideDuration": "0",
        "timeOut": "0",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    var socket = io.connect('https://live-chat.mycapturer.com');
    socket.on('new_message', function (data) {
        $('#msg_dir').append(
                '<div class="form-group mb-3">'
                + '<div style="float:left;"><img class="img-fluid pict_user_chat rounded-circle" src="assets/images/unnamed.jpg" alt="username"/></div>'
                + '<div style="padding:0px 35px;"><b class="username_chat">Mamat <i class="fas fa-check-circle text-info"></b></i>'
                + '<span class="ms-2 text-muted">' + data.msgtxt + '</span></div>'
                + '</div>'
                );
        $('#msg_dir2').append(
                '<div class="d-flex flex-column mb-5 align-items-start">'
                + '<div class="d-flex align-items-center">'
                + '<div class="symbol symbol-40 mr-3">'
                + '<img class="rounded-circle" alt="Pic" src="assets/media/users/300_12.jpg">'
                + '</div>'
                + '<div class="mx-2">'
                + '<a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6" style="text-decoration:none;">Matt Pears</a>'
                + '<span class="text-muted font-size-sm"></span>'
                + '</div>'
                + '</div>'
                + '<div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">'
                + data.msgtxt
                + '</div>'
                + '</div>'
                );
        $('#msg_dir').animate({
            scrollTop: $('#msg_dir').get(0).scrollHeight
        });
        $('#scroll-pull').animate({
            scrollTop: $('#scroll-pull').get(0).scrollHeight
        });
    });
    document.getElementById("bgndVideo").addEventListener("contextmenu", function (event) {
        event.preventDefault();
        event.stopPropagation();
    });
    $("#bgndVideo").YTPlayer({
        videoURL: 'Op7tywmRV3I',
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
        useNoCookie: true
    });
    $('.sertif-carousel').slick({
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
function Open_chat() {
    $('#scroll-pull').animate({
        scrollTop: $('#scroll-pull').get(0).scrollHeight
    });
}
function Send_chat(id) {
    if (id === 1) {
        var msgtxt = $('input[name="msgtxt"]').val();
        if (msgtxt.length <= 1) {
            toastr.warning('Message is too short! 15 characters minimum');
        } else {
            var dataString = {
                message: msgtxt
            };
            $.ajax({
                type: "POST",
                url: "Streaming/Chat_send/",
                data: dataString,
                dataType: "json",
                cache: false,
                success: function (data) {
                    if (data.success === true) {
                        var socket = io.connect('https://live-chat.mycapturer.com');
                        socket.emit('new_message', {
                            msgtxt: data.msg
                        });
                        $('input[name="msgtxt"]').val('');
                    } else if (data.success === false) {
                        $("#name").val(data.name);
                        $("#email").val(data.email);
                        $("#subject").val(data.subject);
                        $("#message").val(data.message);
                        $("#notif").html(data.notif);
                    }
                }, error: function (xhr, status, error) {
                    alert(error);
                }
            });
        }
    } else if (id === 2) {
        var msgtxt = $('textarea[name="msgtxt2"]').val();
        if (msgtxt.length <= 1) {
            toastr.warning('Message is too short! 15 characters minimum');
        } else {
            var dataString = {
                message: msgtxt
            };
            $.ajax({
                type: "POST",
                url: "Streaming/Chat_send/",
                data: dataString,
                dataType: "json",
                cache: false,
                success: function (data) {
                    if (data.success === true) {
                        var socket = io.connect('https://live-chat.mycapturer.com');
                        socket.emit('new_message', {
                            msgtxt: data.msg
                        });
                        $('textarea[name="msgtxt2"]').val('');
                    } else if (data.success === false) {
                        $("#name").val(data.name);
                        $("#email").val(data.email);
                        $("#subject").val(data.subject);
                        $("#message").val(data.message);
                        $("#notif").html(data.notif);
                    }
                }, error: function (xhr, status, error) {
                    alert(error);
                }
            });
        }
    }


}