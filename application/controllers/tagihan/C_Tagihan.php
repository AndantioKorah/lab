<?php

class C_Tagihan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('tagihan/M_Tagihan', 'tagihan');
        $this->load->model('general/M_General', 'general');
        $this->load->model('pendaftaran/M_Pendaftaran', 'pendaftaran');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function loadTagihan($id_pendaftaran){
        $data['id_pendaftaran'] = $id_pendaftaran;
        $data['pendaftaran'] = $this->general->getOne('t_pendaftaran', 'id', $id_pendaftaran, 1);
        $this->load->view('tagihan/V_Tagihan', $data);
    }

    public function loadTagihanHeader($id_pendaftaran){
        $data['sisa_harus_bayar'] = $this->tagihan->countTagihan($id_pendaftaran);
        $data['tagihan'] = $this->general->getOne('t_tagihan', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['pembayaran'] = $this->general->getOne('t_pembayaran', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['uang_muka'] = $this->general->getOne('t_uang_muka', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $this->load->view('tagihan/V_TagihanHeader', $data);
    }

    public function loadRincianTagihan($id_pendaftaran){
        $data['id_pendaftaran'] = $id_pendaftaran;
        $data['rincian_tagihan'] = $this->tagihan->getRincianTagihan($id_pendaftaran);
        $this->session->set_userdata([
            'data_cetak_rincian_tagihan' => $data['rincian_tagihan']
        ]);
        $this->load->view('tagihan/V_RincianTagihan', $data);
    }

    public function cetakRincianTagihanBu($id_pendaftaran){
        $data['data']['rincian_tagihan'] = $this->session->userdata('data_cetak_rincian_tagihan');
        $data['page'] = 'tagihan/V_CetakRincianTagihan';
        // $this->session->set_userdata([
        //     'data_cetak_rincian_tagihan' => null
        // ]);
        $data['pendaftaran'] = $this->pendaftaran->getDataPendaftaran($id_pendaftaran);
        // $this->load->view('tagihan/V_CetakRincianTagihan', $data);
        $this->load->view('cetakan/V_HeaderCetakan', $data);
    }

    public function cetakRincianTagihan($id_pendaftaran){
        $rincian_tagihan = $this->session->userdata('data_cetak_rincian_tagihan');
        list($data['rincian_tagihan'], $data['page_count']) = $this->tagihan->buildDataRincianTagihan($rincian_tagihan, 1);
        $data['pendaftaran'] = $this->pendaftaran->getDataPendaftaran($id_pendaftaran);
        $data['sisa_harus_bayar'] = $this->tagihan->countTagihan($id_pendaftaran);
        $data['data_tagihan'] = $this->general->getOne('t_tagihan', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['pembayaran'] = $this->general->getOne('t_pembayaran', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $data['uang_muka'] = $this->general->getOne('t_uang_muka', 'id_t_pendaftaran', $id_pendaftaran, 1);
        $this->load->view('tagihan/V_CetakRincianTagihan', $data);
    }

    public function cetakRincianTagihanOld($id_pendaftaran){
        $rincian_tagihan = $this->session->userdata('data_cetak_rincian_tagihan');
        list($data['rincian_tagihan'], $data['page_count']) = $this->tagihan->buildDataRincianTagihan($rincian_tagihan);
        $data['pendaftaran'] = $this->pendaftaran->getDataPendaftaran($id_pendaftaran);
        $this->load->view('tagihan/V_CetakRincianTagihanOld', $data);
    }

}
