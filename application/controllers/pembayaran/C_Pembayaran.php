<?php

class C_Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('pembayaran/M_Pembayaran', 'pembayaran');
        $this->load->model('general/M_General', 'general');
        $this->load->model('pendaftaran/M_Pendaftaran', 'pendaftaran');
        $this->load->model('tagihan/M_Tagihan', 'tagihan');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function loadPembayaran($id_pendaftaran){
        $data['id_t_pendaftaran'] = $id_pendaftaran;
        $data['pembayaran'] = $this->general->getOne('t_pembayaran', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['list_bank'] = $this->general->getAllWithOrder('m_bank', 'nama_bank', 'asc', 0);
        $this->load->view('pembayaran/V_Pembayaran', $data);
    }

    public function createPembayaran(){
        echo json_encode($this->pembayaran->createPembayaran($this->input->post()));
    }

    public function deletePembayaran($id_pendaftaran){
        echo json_encode($this->pembayaran->deletePembayaran($id_pendaftaran));
    }

    public function loadUangMuka($id_pendaftaran){
        $data['id_t_pendaftaran'] = $id_pendaftaran;
        $data['uangmuka'] = $this->general->getOne('t_uang_muka', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['tagihan'] = $this->general->getOne('t_tagihan', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['list_bank'] = $this->general->getAllWithOrder('m_bank', 'nama_bank', 'asc', 0);
        $this->load->view('pembayaran/V_UangMuka', $data);
    }

    public function createUangMuka(){
        echo json_encode($this->pembayaran->createUangMuka($this->input->post()));
    }

    public function deleteUangMuka($id_pendaftaran){
        echo json_encode($this->pembayaran->deleteUangMuka($id_pendaftaran));
    }

    public function cetakKwitansiPembayaran($id_pendaftaran){
        $data['pendaftaran'] = $this->pendaftaran->getDataPendaftaran($id_pendaftaran);
        $data['pembayaran'] = $this->general->getOne('t_pembayaran', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['tagihan'] = $this->general->getOne('t_tagihan', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['rincian_tagihan'] = $this->pembayaran->getRincianTagihan($id_pendaftaran);
        $this->load->view('pembayaran/V_KwitansiPembayaran', $data);
    }

    public function cetakKwitansiUangMuka($id_pendaftaran){
        $data['pendaftaran'] = $this->pendaftaran->getDataPendaftaran($id_pendaftaran);
        $data['uang_muka'] = $this->general->getOne('t_uang_muka', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['tagihan'] = $this->general->getOne('t_tagihan', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['rincian_tagihan'] = $this->pembayaran->getRincianTagihan($id_pendaftaran);
        $this->load->view('pembayaran/V_KwitansiUangMuka', $data);
    }

}
