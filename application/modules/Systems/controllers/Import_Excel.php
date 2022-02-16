<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//modul contoh import data dari excel
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Import_Excel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_import', 'model');
        $this->user = Dekrip($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Systems/Users/index/',
            'privilege' => $this->bodo->Check_previlege('Systems/Users/index/'),
            'siteTitle' => 'Import Data',
            'pagetitle' => 'Import Data',
            'breadcrumb' => [
                0 => [
                    'nama' => 'index',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('import/upload', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Upload() {
        $file = $_FILES['dbtxt'];
        /*
         * Array
          (
          [name] => Daftar Aplikasi Bimas Islam.xlsx
          [type] => application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
          [tmp_name] => /tmp/phpbcxiR5
          [error] => 0
          [size] => 11013
          )
         */
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        for ($i = 1; $i < count($sheetData); $i++) {
            $field = $sheetData[$i]['0'];
            $field1 = $sheetData[$i]['1'];
            $field2 = $sheetData[$i]['2'];
            $data[] = [
                'no' => $field,
                'nama' => $field1,
                'nama2' => $field2
            ];
        }
        $this->model->Insert($data);
    }

}
