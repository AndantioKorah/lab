<?php
	class M_Pembayaran extends CI_Model
	{
        public $bios_serial_num;

        public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function createPembayaran($data){
            $rs['code'] = 0;
            $rs['message'] = 'ok';

            $data['diskon_presentase'] = clearString($data['diskon_presentase']);
            $data['diskon_nominal'] = clearString($data['diskon_nominal']);
            $data['jumlah_pembayaran'] = clearString($data['jumlah_pembayaran']);
            $data['kembalian'] = clearString($data['kembalian']);

            $this->db->trans_begin();

            $bank = explode(";", $data['bank']);
            $data['nama_bank'] = $bank[1];
            $data['id_m_bank'] = $bank[0];
            unset($data['bank']);
            
            $tanggal = explode(" ", $data['tanggal_pembayaran']);
            $only_date = explode("-", $tanggal[0]);
            $nopem = KODE_TRANSAKSI_PEMBAYARAN.$only_date[2].$only_date[1].$only_date[0];
            $counter_nopem = 1;
            $exist = $this->db->select('*')
                            ->from('t_pembayaran')
                            ->where('DATE(tanggal_pembayaran)', $tanggal[0])
                            ->order_by('tanggal_pembayaran', 'desc')
                            ->limit(1)
                            ->get()->row_array();
            if($exist){
                $last_nopem = substr($exist['nomor_pembayaran'], 10, 4);
                $counter_nopem = floatval(ltrim($last_nopem, '0')) + 1;
            }
            $data['nomor_pembayaran'] = $nopem.str_pad($counter_nopem, 4, '0', STR_PAD_LEFT);
            $data['created_by'] = $this->general_library->getId();


            $this->db->insert('t_pembayaran', $data);

            $this->db->where('id_t_pendaftaran', $data['id_t_pendaftaran'])
                    ->update('t_tagihan', 
                [
                    'updated_by' => $this->general_library->getId(),
                    'status_tagihan' => 'Lunas',
                    'id_m_status_tagihan' => 2
                ]);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 0;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function deletePembayaran($id_pendaftaran){
            $rs['code'] = 0;
            $rs['message'] = 'ok';

            $this->db->trans_begin();

            $this->db->where('id_t_pendaftaran', $id_pendaftaran)
                    ->update('t_pembayaran', 
                [
                    'updated_by' => $this->general_library->getId(),
                    'flag_active' => 0
                ]);

            $this->db->where('id_t_pendaftaran', $id_pendaftaran)
                    ->update('t_tagihan', 
                [
                    'updated_by' => $this->general_library->getId(),
                    'status_tagihan' => 'Belum Lunas',
                    'id_m_status_tagihan' => 1
                ]);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 0;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function createUangMuka($data){
            $rs['code'] = 0;
            $rs['message'] = 'ok';

            $data['jumlah_pembayaran'] = clearString($data['jumlah_pembayaran']);

            $this->db->trans_begin();

            $bank = explode(";", $data['bank']);
            $data['nama_bank'] = $bank[1];
            $data['id_m_bank'] = $bank[0];
            unset($data['bank']);
            
            $tanggal = explode(" ", $data['tanggal_pembayaran']);
            $only_date = explode("-", $tanggal[0]);
            $nopem = KODE_TRANSAKSI_UANG_MUKA.$only_date[2].$only_date[1].$only_date[0];
            $counter_nopem = 1;
            $exist = $this->db->select('*')
                            ->from('t_uang_muka')
                            ->where('DATE(tanggal_pembayaran)', $tanggal[0])
                            ->order_by('tanggal_pembayaran', 'desc')
                            ->limit(1)
                            ->get()->row_array();
            if($exist){
                $last_nopem = substr($exist['nomor_pembayaran'], 10, 4);
                $counter_nopem = floatval(ltrim($last_nopem, '0')) + 1;
            }
            $data['nomor_pembayaran'] = $nopem.str_pad($counter_nopem, 4, '0', STR_PAD_LEFT);
            $data['created_by'] = $this->general_library->getId();


            $this->db->insert('t_uang_muka', $data);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 0;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function deleteUangMuka($id_pendaftaran){
            $rs['code'] = 0;
            $rs['message'] = 'ok';

            $this->db->trans_begin();

            $this->db->where('id_t_pendaftaran', $id_pendaftaran)
                    ->update('t_uang_muka', 
                [
                    'updated_by' => $this->general_library->getId(),
                    'flag_active' => 0
                ]);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 0;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function getRincianTagihan($id_pendaftaran){
            $detail_tagihan = $this->db->select('a.*, c.id_m_jns_tindakan, d.nm_jns_tindakan')
            ->from('t_tagihan_detail a')
            ->join('t_tindakan b', 'a.id_reference = b.id')
            ->join('m_tindakan c', 'b.id_m_nm_tindakan = c.id')
            ->join('m_jns_tindakan d', 'c.id_m_jns_tindakan = d.id')
            ->where('a.id_t_pendaftaran', $id_pendaftaran)
            ->where('a.flag_active', 1)
            ->where('b.flag_active', 1)
            ->order_by('a.id', 'asc')
            ->group_by('c.id_m_jns_tindakan')
            ->get()->result_array();

            return $detail_tagihan;

        }

        public function searchPendaftaranPelunasanMassal($data){
            list($tanggal_awal, $tanggal_akhir) = explodeRangeDate($data['range_tanggal']);
            return $this->db->select('a.*, c.status_tagihan, a.id as id_t_pendaftaran, c.id_m_status_tagihan, b.nama_pasien, c.total_tagihan, b.id as id_m_pasien')
                            ->from('t_pendaftaran a')
                            ->join('m_pasien b', 'a.norm = b.norm')
                            ->join('t_tagihan c', 'a.id = c.id_t_pendaftaran')
                            // ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            // ->where('c.flag_active', 1)
                            ->where('a.tanggal_pendaftaran > ', $tanggal_awal.' 00:00:00')
                            ->where('a.tanggal_pendaftaran < ', $tanggal_akhir.' 23:59:59')
                            ->where('a.id_m_cara_bayar_detail', $data['cara_bayar'])
                            ->order_by('a.tanggal_pendaftaran', 'desc')
                            ->group_by('a.id')
                            ->get()->result_array();
        }

        public function submitPelunasanMassal($data){
            // dd($data);
            $rs['code'] = 0;
            $rs['message'] = 'ok';
            
            if(!$data){
                $rs['code'] = 1;
                $rs['message'] = 'Tidak Ada Data Untuk Pelunasan';
                return $rs;
            }

            $this->db->trans_begin();

            $only_date = explode("-", date('Y-m-d'));
            $nopem = KODE_TRANSAKSI_UANG_MUKA.$only_date[2].$only_date[1].$only_date[0];
            $counter_nopem = 1;
            $exist = $this->db->select('*')
                            ->from('t_uang_muka')
                            ->where('DATE(tanggal_pembayaran)', date('Y-m-d'))
                            ->order_by('tanggal_pembayaran', 'desc')
                            ->limit(1)
                            ->get()->row_array();
            if($exist){
                $last_nopem = substr($exist['nomor_pembayaran'], 10, 4);
                $counter_nopem = floatval(ltrim($last_nopem, '0')) + 1;
            }
            $nopem = $nopem.str_pad($counter_nopem, 4, '0', STR_PAD_LEFT);

            $pendaftaran = $this->db->select('a.*, b.id as id_t_tagihan, b.total_tagihan')
                                    ->from('t_pendaftaran a')
                                    ->join('t_tagihan b', 'a.id = b.id_t_pendaftaran')
                                    ->where_in('a.id', $data['id_pelunasan_massal'])
                                    ->get()->result_array();
            if($pendaftaran){
                $pembayaran = null;
                $i = 0;
                $total_tagihan = 0;
                foreach($pendaftaran as $p){
                    $total_tagihan += floatval($p['total_tagihan']);
                    $pembayaran[$i]['id_t_pendaftaran'] = $p['id'];
                    $pembayaran[$i]['tanggal_pembayaran'] = date('Y-m-d H:i:s');
                    $pembayaran[$i]['nama_pembayar'] = $p['nama_cara_bayar_detail'];
                    $pembayaran[$i]['cara_pembayaran'] = 'tunai';
                    $pembayaran[$i]['jumlah_pembayaran'] = 0;
                    $pembayaran[$i]['nomor_pembayaran'] = $nopem;
                    $pembayaran[$i]['created_by'] = $this->general_library->getId();
                    $i++;
                }
                $this->db->insert_batch('t_pembayaran', $pembayaran);
                
                $this->db->where_in('id_t_pendaftaran', $data['id_pelunasan_massal'])
                        ->update('t_tagihan',
                        [
                            'updated_by' => $this->general_library->getId(),
                            'status_tagihan' => 'Lunas',
                            'id_m_status_tagihan' => 2
                        ]);
                
                $this->db->insert('t_pelunasan_massal', 
                [
                    'list_id_t_pendaftaran' => json_encode($data['id_pelunasan_massal']),
                    'nomor_pembayaran' => $nopem,
                    'id_m_cara_bayar_detail' => $pendaftaran[0]['id_m_cara_bayar_detail'],
                    'nama_cara_bayar_detail' => $pendaftaran[0]['nama_cara_bayar_detail'],
                    'total_tagihan' => $total_tagihan,
                    'created_by' => $this->general_library->getId()
                ]);
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'Tagihan Tidak Ditemukan';
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }
            return $rs;
        }

        public function loadHistoryPelunasanMassal($bulan){
            return $this->db->select('a.*, b.nama as nama_user')
                            ->from('t_pelunasan_massal a')
                            ->join('m_user b', 'a.created_by = b.id')
                            ->where('MONTH(a.created_date)', $bulan)
                            ->where('a.flag_active', 1)
                            ->get()->result_array();
        }

        public function deleteHistoryPelunasanMassal($id){
            $rs['code'] = 0;
            $rs['message'] = 'ok';

            $this->db->trans_begin();

            $data = $this->db->select('*')
                            ->from('t_pelunasan_massal')
                            ->where('id', $id)
                            ->where('flag_active', 1)
                            ->get()->row_array();
            if($data){
                $this->db->where_in('id_t_pendaftaran', json_decode($data['list_id_t_pendaftaran']))
                    ->update('t_pembayaran', 
                [
                    'updated_by' => $this->general_library->getId(),
                    'flag_active' => 0
                ]);

                $this->db->where_in('id_t_pendaftaran', json_decode($data['list_id_t_pendaftaran']))
                    ->update('t_tagihan', 
                [
                    'updated_by' => $this->general_library->getId(),
                    'status_tagihan' => 'Belum Lunas',
                    'id_m_status_tagihan' => 1
                ]);

                $this->db->where('id', $id)
                        ->update('t_pelunasan_massal',
                        [
                            'flag_active' => 0,
                            'updated_by' => $this->general_library->getId()
                        ]);
            } else {
                $rs['code'] = 1;
                $rs['message'] = 'Data Tidak Ditemukan';
            }

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }
            return $rs;
        }

        public function detailHistoryPelunasanMassal($id){
            $result = null;
            $data_pm = $this->db->select('*')
                                ->from('t_pelunasan_massal')
                                ->where('id', $id)
                                ->get()->row_array();
            if($data_pm){
                $result = $this->db->select('a.*, b.total_tagihan, c.nama_pasien')
                                ->from('t_pendaftaran a')
                                ->join('t_tagihan b', 'a.id = b.id_t_pendaftaran')
                                ->join('m_pasien c', 'a.norm = c.norm')
                                ->where_in('a.id', json_decode($data_pm['list_id_t_pendaftaran']))
                                ->where('a.flag_active', 1)
                                ->get()->result_array();
            }
            return $result;
        }
	}
?>