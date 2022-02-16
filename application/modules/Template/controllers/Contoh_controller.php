<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contoh_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('NAMA_MODEL', 'ALIAS');
    }

    public function index() {
        $data = [
            'data' => $this->NAMA_MODEL->index(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'LINK MENU dari database',
            'privilege' => $this->bodo->Check_previlege('LINK MENU dari database'),
            'siteTitle' => 'Master Country | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Country',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Country',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('contoh_view', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Print_pdf() {
        //function untuk print to pdf
        $mpdf = new \Mpdf\Mpdf(['tempDir' => 'assets/tmp/', 'mode' => 'utf-8']);
        $mpdf->SetAuthor($this->bodo->Sys('company_name'));
        $mpdf->SetKeywords($this->bodo->Sys('company_name') . ' - ' . $this->bodo->Sys('app_name'));
        $mpdf->SetCreator(base_url());
        $mpdf->setFooter('{PAGENO}');
        $mpdf->SetWatermarkText('DRAFT');
        $mpdf->SetSubject('My Subject');
        $mpdf->SetTitle('My Title');
        $mpdf->pdf_version = '1.7';
        $mpdf->WriteHTML($this->parser->parse('v_print', []));
        $mpdf->Output();
    }

}
