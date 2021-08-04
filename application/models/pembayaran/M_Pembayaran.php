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
	}
?>