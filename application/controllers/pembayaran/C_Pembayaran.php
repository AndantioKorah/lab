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

    public function pelunasanMassal(){
        $data['cara_bayar'] = $this->general->get('m_cara_bayar_detail', 'id_m_cara_bayar', 2, 1);
        render('pembayaran/V_PelunasanMassal', '', '', $data);
    }

    public function searchPendaftaranPelunasanMassal(){
        $data['list_pendaftaran'] = $this->pembayaran->searchPendaftaranPelunasanMassal($this->input->post());
        $this->load->view('pembayaran/V_PelunasanMassalItem', $data);
    }

    public function submitPelunasanMassal(){
        echo json_encode($this->pembayaran->submitPelunasanMassal($this->input->post()));
    }

    public function loadHistoryPelunasanMassal(){
        $this->load->view('pembayaran/V_HistoryPelunasanMassal', null);
    }

    public function loadHistoryPelunasanMassalItem($bulan, $tahun){
        $data['history'] = $this->pembayaran->loadHistoryPelunasanMassal($bulan, $tahun);
        $this->load->view('pembayaran/V_HistoryPelunasanMassalItem', $data);
    }

    public function deleteHistoryPelunasanMassal($id){
        echo json_encode($this->pembayaran->deleteHistoryPelunasanMassal($id));
    }

    public function detailHistoryPelunasanMassal($id){
        $data['result'] = $this->pembayaran->detailHistoryPelunasanMassal($id);
        $data['id'] = $id;
        $this->load->view('pembayaran/V_DetailHistoryPelunasanMassal', $data);
    }

}
