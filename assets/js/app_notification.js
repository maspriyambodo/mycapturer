var pusher = new Pusher('4587e4cb86b14bb98e69', {
    cluster: 'ap1'
});
setInterval(function () {
    pusher.connect();
}, 5000);
var channel = pusher.subscribe('app_notification-channel');
var audio = {};
audio["walk"] = new Audio();
audio["walk"].src = "assets/media/sound/notification_sound.mp3";
channel.bind('app_notification-event', function (data) {
    if ($('#notif_count').length === 0) {
        $('#append_notif').append('<span id="notif_count" class="label label-sm label-danger label-inline text-center" style="margin: -10px 0px 0px 0px;position: absolute;"></span>');
    } else {
        null;
    }
    $('#notif_count').show();
    $('#notif_count').text(data.tot_notif);
    $('#kt_quick_panel_logs').empty();
    audio["walk"].play();
});
function dir_notif() {
    $('#kt_quick_panel_logs').empty();
    $.ajax({
        url: "Notification/Get_notif",
        processData: true,
        success: function (data) {
            if (data[0].title_notif === 'kosong') {
                $('#notif_count').hide();
            } else {
                $('#notif_count').hide();
                $('#kt_quick_panel_logs').append('<button id="btn_notif" type="button" class="btn btn-default btn-xs mb-4" onclick="Read_notif()">mark all as read</button>');
                var i;
                for (i = 0; i < data.length; i++) {
                    $('#kt_quick_panel_logs').append(
                            '<div class="d-flex align-items-center flex-wrap mb-5 bg-light-primary py-4 px-4 rounded-xl">'
                            + '<div class="d-flex flex-column flex-grow-1 mr-2">'
                            + '<a href="' + data[i].url_link + '" class="font-weight-bolder text-dark-75 text-hover-primary font-size-lg mb-1">'
                            + data[i].title_notif
                            + '</a>'
                            + '<span class="font-weight-bold text-muted">'
                            + data[i].syscreatedate
                            + '</span>'
                            + '</div>'
                            + '</div>'
                            );
                }
            }
        },
        error: function (jqXHR) {

        }
    });
}
function Read_notif() {
    $('#kt_quick_panel_logs').empty();
    $.ajax({
        url: "Notification/Mark_all_read",
        processData: true
    });
}