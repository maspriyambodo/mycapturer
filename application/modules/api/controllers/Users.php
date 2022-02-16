<?php

defined('BASEPATH') OR exit('trying to signin from backdoor?');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Systems/M_users', 'model');
        $this->load->model('Auth/M_auth', 'model2');
        $this->auth();
    }

    /* EXAMPLE CURL
     * $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://localhost/sertifikasiku/api/absensi/index/',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
      'uname: your_username',
      'pwd: your_password'
      ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      echo $response;
     */

    private function auth() {
        $header = getallheaders();
        if ($header['Uname'] and $header['Pwd']) {
            $data = [
                'uname' => $header['Uname'],
                'pwd' => $header['Pwd']
            ];
            $exec = $this->model2->Signin($data);
            if (!empty($exec) and ($exec->limit_login == 0 or $exec->limit_login != 3)) {
                $hashed = $exec->pwd;
                if (password_verify($data['pwd'], $hashed)) {
                    $this->bodo->Set_session($exec);
                    $this->model2->Remove_penalty($data);
                    //success login user
                    return $this->uri->segment(3) . '()';
                } else {
                    $this->Attempt(1);
                    header('HTTP/1.0 401 Unauthorized');
                    echo '<p>Access denied. your password was incorrect</p>';
                    exit;
                }
            } elseif (!empty($exec) and ($exec->limit_login == 3)) {
                header('HTTP/1.0 401 Unauthorized');
                echo '<p>Access denied. your account was blocked</p>';
                exit;
            } else {
                header('HTTP/1.0 401 Unauthorized');
                echo '<p>Access denied. username not registered!</p>';
                exit;
            }
        } else {
            $this->Attempt(2);
            header('HTTP/1.0 401 Unauthorized');
            // User will be presented with the username/password prompt
            // If they hit cancel, they will see this access denied message.
            echo '<p>Access denied. you don`t have permission</p>';
            exit;
        }
    }

    private function Attempt($id) {
        $attempt = $this->session->userdata('attempt');
        $attempt++;
        $this->session->set_userdata('attempt', $attempt);
        $data = [
            'uname' => Post_input("username"),
            'attempt' => $attempt
        ];
        switch ($id) {
            case 1:
                $this->model2->Penalty($data);
                if ($attempt == 3) {
                    $this->session->set_tempdata('blocked_account', true, 300);
                    blocked_account();
                }
            case 2:
                if ($attempt == 5) {
                    $this->session->set_tempdata('auth_sekuriti', true, 360);
                    show_404();
                }
        }
    }

    public function index() {
        $list = $this->model->lists();
        $data = [];
        $no = Post_input("start");
        $privilege = $this->bodo->Check_previlege('api/Absensi/index/');
        foreach ($list as $users) {
            $id_user = Enkrip($users->id_absensi);
            $no++;
            $row = [];
            $row['no'] = $no;
            $row['id_absensi'] = $id_user;
            $row['email'] = $users->email;
            $row['role_name'] = $users->role_name;
            $row['fullname'] = $users->fullname;
            $row['telp'] = $users->telp;
            $row['pekerjaan'] = $users->pekerjaan;
            $row['time_start'] = $users->time_start;
            $row['nama_sesi'] = $users->nama_sesi;
            $row['nama_materi'] = $users->nama_materi;
            $row['narasumber'] = $users->narasumber;
            $row['title_narsum'] = $users->title_narsum;
            $row['rating_materi'] = $users->rating_materi;
            $row['waktu_absen'] = $users->waktu_absen;
            $data[] = $row;
        }
        return $this->_list($data, $privilege);
    }

    private function _list($data, $privilege) {
        if ($privilege['read']) {
            $output = [
                "draw" => Post_input('draw'),
                "recordsTotal" => $this->model->count_all(),
                "recordsFiltered" => $this->model->count_filtered(),
                "data" => $data
            ];
        } else {
            $output = [
                "draw" => Post_input('draw'),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
        }
        return ToJson($output);
    }

}
