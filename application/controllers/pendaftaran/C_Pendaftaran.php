<?php

class C_Pendaftaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
        $this->load->model('pendaftaran/M_Pendaftaran', 'pendaftaran');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }
    
    public function pendaftaran(){
        $data['id_m_pasien'] = $this->session->userdata('ID_PENDAFTARAN_PASIEN');
        $this->session->set_userdata([
            'ID_PENDAFTARAN_PASIEN' => null,
            'session_id' => date("YmdHis")
        ]);
      
        $data['dokter'] = $this->general->getAllWithOrder('m_dokter', 'nama_dokter', 'asc');
        $data['cara_bayar_detail'] = $this->general->getAllWithOrder('m_cara_bayar_detail', 'nama_cara_bayar_detail', 'asc');
        render('pendaftaran/V_Pendaftaran', '', 'pendaftaran', $data);
    }

    public function loadFormPasienBaru(){
        // $data['provinsi'] = $this->general->getAllWithOrder('m_provinsi', 'nama_provinsi', 'asc');
        // $data['kota'] = $this->general->getWithOrder('m_kabupaten_kota', 'id_m_provinsi', '71', 'nama_kabupaten_kota', 'asc');
        // $data['kecamatan'] = $this->general->getWithOrder('m_kecamatan', 'id_m_kabupaten_kota', '7171', 'nama_kecamatan', 'asc');
        // $data['kelurahan'] = $this->general->getWithOrder('m_kelurahan', 'id_m_kecamatan' ,'717106' ,'nama_kelurahan', 'asc');
        $data['pekerjaan'] = $this->general->getAllWithOrder('m_pekerjaan', 'nama_pekerjaan', 'asc');
        $data['golongan_darah'] = $this->general->getAllWithOrder('m_golongan_darah', 'golongan_darah', 'asc');
        $data['negara'] = $this->general->getAllWithOrder('m_negara', 'nama_negara', 'asc');
        $this->load->view('pendaftaran/V_FormPasienBaru', $data);
    }

    public function createPasien(){
        echo json_encode($this->pendaftaran->createPasien());
    }

    public function searchPasienForPendaftaran(){
        echo json_encode($this->pendaftaran->searchPasien());
    }

    public function getDataPasienById($id_m_pasien){
        $res = $this->pendaftaran->getDataPasienById($id_m_pasien);
        if($res){
            if($res['tanggal_lahir'] == '0000-00-00'){
                $res['umur'] = '-';                
            } else {
                $res['umur'] = countDiffDateLengkap($res['tanggal_lahir'], date('Y-m-d'), ['tahun']);
            }
        }
        echo json_encode($res);
    }

    public function pendaftaranLab(){
        echo json_encode($this->pendaftaran->pendaftaranLab());
    }

    public function searchPasien(){
        $data['result'] = $this->pendaftaran->searchPasien();
        $this->load->view('pendaftaran/V_ResultSearchPasienNavBar', $data);
    }

    public function editDataPasienForm($norm, $callback = null){
        $data['pekerjaan'] = $this->general->getAllWithOrder('m_pekerjaan', 'nama_pekerjaan', 'asc');
        $data['golongan_darah'] = $this->general->getAllWithOrder('m_golongan_darah', 'golongan_darah', 'asc');
        $data['negara'] = $this->general->getAllWithOrder('m_negara', 'nama_negara', 'asc');
        $data['result'] = $this->pendaftaran->getDataPasienByNorm($norm);
        $data['callback'] = $callback;
        $this->load->view('pendaftaran/V_EditDataPasien', $data);
    }

    public function editDataPasien(){
        echo json_encode($this->pendaftaran->editDataPasien());
    }

    public function dataPasien($id_m_pasien){
        $data['id_m_pasien'] = $id_m_pasien;
        render('pendaftaran/V_DataPasien', '', 'pendaftaran', $data);
    }

    public function loadProfilPasien($id_m_pasien){
        $data['pasien'] = $this->pendaftaran->getDataPasienById($id_m_pasien);
        $this->load->view('pendaftaran/V_ProfilPasienLeft', $data);
    }

    public function loadListPendaftaranPasien($id_m_pasien){
        $data['list_pendaftaran'] = $this->pendaftaran->getListPendaftaranPasienById($id_m_pasien);
        $this->load->view('pendaftaran/V_ListPendaftaranPasien', $data);
    }

    public function editDataPendaftaran($id_t_pendaftaran, $callback, $key_callback){
        $data['dokter'] = $this->general->getAllWithOrder('m_dokter', 'nama_dokter', 'asc');
        $data['pendaftaran'] = $this->pendaftaran->getDataPendaftaran($id_t_pendaftaran);
        $data['tagihan'] = $this->general->getOne('t_tagihan', 'id_t_pendaftaran', $id_t_pendaftaran);
        $data['cara_bayar_detail'] = $this->general->getAllWithOrder('m_cara_bayar_detail', 'nama_cara_bayar_detail', 'asc');
        $data['callback'] = $callback;
        $data['key_callback'] = $key_callback;
        $this->load->view('pendaftaran/V_EditDataPendaftaran', $data);
    }

    public function editPendaftaranLab(){
        echo json_encode($this->pendaftaran->editPendaftaranLab());
    }

    public function deletePendaftaranLab($id){
        echo json_encode($this->pendaftaran->deletePendaftaranLab($id));
    }

    public function fillIdPasienPendaftaran($id_m_pasien){
        $this->session->set_userdata([
            'ID_PENDAFTARAN_PASIEN' => $id_m_pasien
        ]);
    }

    public function loadDetailPendaftaran($id_t_pendaftaran){
        $data['pendaftaran'] = $this->pendaftaran->getDetailPendaftaran($id_t_pendaftaran);
        $this->load->view('pendaftaran/V_DetailPendaftaranLeft', $data);
    }
    
    public function insertTindakanPendaftaran(){
        echo json_encode($this->pendaftaran->insertTindakanPendaftaran());
    }


    public function loadTindakanPendaftaran($session_id){

        $data['rincian_tindakan'] = $this->pendaftaran->getRincianTindakan($session_id);
        $this->session->set_userdata([
            'list_tindakan_pasien' => $data['rincian_tindakan']
        ]);

        $this->load->view('pendaftaran/V_TindakanPendaftaran', $data);
    }

    public function delTindakanPendaftaran()
    {
        echo json_encode($this->pendaftaran->delTindakanPendaftaran());
    }

    public function menuListPendaftaran(){
        render('pendaftaran/V_MenuListPendaftaran', '', 'list_pendaftaran', null);
    }

    public function searchMenuListPendaftaran(){
        $data['list_pendaftaran'] = $this->pendaftaran->searchMenuListPendaftaran($this->input->post());
        $this->load->view('pendaftaran/V_ResultMenuListPendaftaran', $data);

    }

}
