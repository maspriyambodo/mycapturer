<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class App_notification {

    private $CI;

    public function __construct() {
        $this->CI = &get_instance();
        $this->pusher_option = [
            'cluster' => 'ap1',
            'useTLS' => true
        ];
        $this->pusher = new Pusher\Pusher(
                '4587e4cb86b14bb98e69',
                '9c0c9ad504eeb5598286',
                '1030899',
                $this->pusher_option
        );
    }

    public function Count_notif() {
        $tot_count = $this->CI->bodo->Count_notif();
        return $this->pusher->trigger('app_notification-channel', 'app_notification-event', ['tot_notif' => $tot_count]);
    }

}
