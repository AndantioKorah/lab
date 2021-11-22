<?php

class C_Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('laporan/M_Laporan', 'laporan');
        $this->load->model('general/M_General', 'general');
        $this->load->model('tagihan/M_Tagihan', 'tagihan');
        $this->load->model('pendaftaran/M_Pendaftaran', 'pendaftaran');
        $this->load->model('pembayaran/M_Pembayaran', 'pembayaran');
        $this->load->model('pelayanan/M_Pelayanan', 'pelayanan');
        $this->load->model('user/M_User', 'user');
        if(!$this->general_library->isNotMenu()){
            redirect('logout');
        };
    }

    public function laporanPendaftaranPerPasien(){
        $data['dokter'] = $this->general->getAllWithOrder('m_dokter', 'nama_dokter', 'asc');
        render('laporan/V_LaporanPendaftaranPerPasien', null, null, $data);
    }

    public function searchLaporanPendaftaranPerPasien(){
        $data['parameter'] = $this->input->post();
        $data['result'] = $this->laporan->searchLaporanPendaftaranPerPasien();
        $this->session->set_userdata([
            'result_laporan_pendaftaran_per_pasien' => json_encode($data)
        ]);
        
        $this->load->view('laporan/V_LaporanPendaftaranPerPasienResult', $data);
    }

    public function saveResultLaporanPendaftaranPerPasien(){
        $params = json_decode($this->session->userdata('result_laporan_pendaftaran_per_pasien'), true);
        $data['parameter'] = $params['parameter'];
        $data['result'] = $params['result'];
        $this->load->view('laporan/V_LaporanPendaftaranPerPasienExcel', $data);
    }

    public function printResultLaporanPendaftaranPerPasien(){
        $params = json_decode($this->session->userdata('result_laporan_pendaftaran_per_pasien'), true);
        $data['parameter'] = $params['parameter'];
        $data['result'] = $params['result'];
        $this->load->view('laporan/V_LaporanPendaftaranPerPasienPrint', $data);
    }

    public function laporanRekapHarian(){
        render('laporan/V_LaporanRekapHarian', null, null, null);
    }

    public function searchLaporanRekapHarian(){
        $data['parameter'] = $this->input->post();
        list($data['result'], $data['jumlah_pendaftaran'], $data['total_uang_muka'],
        $data['total_pembayaran'], $data['total_belum_bayar'], $data['total_penerimaan']) 
        = $this->laporan->searchLaporanRekapHarian();
        $this->session->set_userdata([
            'result_rekap_harian' => json_encode($data)
        ]);
        $this->load->view('laporan/V_LaporanRekapHarianResult', $data);
    }

    public function printLaporanRekapHarian(){
        $params = json_decode($this->session->userdata('result_rekap_harian'), true);
        $data['parameter'] = $params['parameter'];
        $data['result'] = $params['result'];
        $data['jumlah_pendaftaran'] = $params['jumlah_pendaftaran'];
        $data['total_uang_muka'] = $params['total_uang_muka'];
        $data['total_pembayaran'] = $params['total_pembayaran'];
        $data['total_belum_bayar'] = $params['total_belum_bayar'];
        $data['total_penerimaan'] = $params['total_penerimaan'];
        $this->load->view('laporan/V_LaporanRekapHarianPrint', $data);
    }

    public function saveLaporanRekapHarian(){
        $params = json_decode($this->session->userdata('result_rekap_harian'), true);
        $data['parameter'] = $params['parameter'];
        $data['result'] = $params['result'];
        $data['jumlah_pendaftaran'] = $params['jumlah_pendaftaran'];
        $data['total_uang_muka'] = $params['total_uang_muka'];
        $data['total_pembayaran'] = $params['total_pembayaran'];
        $data['total_belum_bayar'] = $params['total_belum_bayar'];
        $data['total_penerimaan'] = $params['total_penerimaan'];
        $this->load->view('laporan/V_LaporanRekapHarianExcel', $data);
    }

    public function laporanFeeDokter(){
        $data['dokter'] = $this->general->getAllWithOrder('m_dokter', 'nama_dokter', 'asc');
        render('laporan/V_LaporanFeeDokter', null, null, $data);
    }

    public function searchLaporanFeeDokter(){
        $data['parameter'] = $this->input->post();
        $data['result'] = $this->laporan->searchLaporanFeeDokter();
        // dd($data['result']);
        $this->session->set_userdata([
            'result_laporan_fee_dokter' => json_encode($data)
        ]);
        $this->load->view('laporan/V_LaporanFeeDokterResult', $data);
    }

    public function printResultLaporanFeeDokter(){
        $params = json_decode($this->session->userdata('result_laporan_fee_dokter'), true);
        $data['parameter'] = $params['parameter'];
        $data['result'] = $params['result'];
        $this->load->view('laporan/V_LaporanFeeDokterPrint', $data);
    }

    public function saveResultLaporanFeeDokter(){
        $params = json_decode($this->session->userdata('result_laporan_fee_dokter'), true);
        $data['parameter'] = $params['parameter'];
        $data['result'] = $params['result'];
        $this->load->view('laporan/V_LaporanFeeDokterExcel', $data);
    }
    

}
