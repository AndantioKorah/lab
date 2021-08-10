<?php

class C_Pelayanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('pelayanan/M_Pelayanan', 'pelayanan');
        $this->load->model('pendaftaran/M_Pendaftaran', 'pendaftaran');
        $this->load->model('tagihan/M_Tagihan', 'tagihan');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }


    public function loadViewInputTindakan($id_pendaftaran){
        $data['list_tindakan'] = $this->pelayanan->getListTindakan();
        $data['tindakan_pasien'] = $this->pelayanan->getTindakanPasien($id_pendaftaran);
        $data['id_tagihan'] = $this->pelayanan->getTagihan($id_pendaftaran);
       
        $data['id_pendaftaran'] = $id_pendaftaran;
        $data['rincian_tindakan'] = $this->pelayanan->getRincianTindakan($id_pendaftaran);
        $this->session->set_userdata([
            'list_tindakan_pasien' => $data['rincian_tindakan']
        ]);
        // var_dump($data['rincian_tindakan']);
        // die();
        // $this->load->view('pelayanan/V_tes', $data);
        $this->load->view('pelayanan/V_InputTindakanPasien', $data);
    }


    public function insertTindakan(){
        echo json_encode($this->pelayanan->insertTindakan());
    }


    public function getTindakanPasien()
    {
        echo json_encode($this->pelayanan->getTindakanPasienOld());
    }

    public function select2Tindakan()
    {
        echo json_encode($this->pelayanan->select2Tindakan());
    }
    

    public function delTindakanPasien()
    {
        echo json_encode($this->pelayanan->delTindakanPasien());
    }

    public function selesaiTindakan()
    {
        echo json_encode($this->pelayanan->selesaiTindakan());
    }


    public function createHasil()
    {

        for ($count = 0; $count < count($_POST['hasil']); $count++) {
            $id_t_tindakan = $_POST['id_t_tindakan'][$count];
            $data = array(
                'hasil' => $_POST['hasil'][$count],
                'nilai_normal' => $_POST['nilai_normal'][$count],
                'satuan' => $_POST['satuan'][$count],
            );
            // var_dump($data);
            // die();
            $this->pelayanan->createHasil($id_t_tindakan, $data);

        }

        echo json_encode($data);
    }

    public function cetakHasil($id_pendaftaran){
        list($data['rincian_tindakan'], $data['page_count']) = $this->pelayanan->buildDataPrintTindakan($this->session->userdata('list_tindakan_pasien'));
        $data['pendaftaran'] = $this->pendaftaran->getDataPendaftaran($id_pendaftaran);
        $this->load->view('pelayanan/V_CetakRincianTindakan', $data);        
    }

}
