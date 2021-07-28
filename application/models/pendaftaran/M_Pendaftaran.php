<?php
	class M_Pendaftaran extends CI_Model
	{
        public $bios_serial_num;

        public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function checkIfNormExist($norm){
            return $this->db->select('*')
                            ->from('m_pasien')
                            ->where('norm', $norm)
                            ->where('flag_active', 1)
                            ->limit(1)
                            ->get()->row_array();
        }

        public function createPasien(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $data = $this->input->post();
            
            $this->db->trans_begin();

            $last_norm = $this->db->select('MAX(norm) as norm')
                                ->from('m_pasien')
                                ->where('flag_active', 1)
                                ->get()->row_array();

            $data['norm'] = generateNorm($last_norm['norm']);
            
            $warga_negara = explode(';', $data['warga_negara']);
            $data['id_m_negara'] = $warga_negara[0];
            $data['kewarganegaraan'] = $warga_negara[1];
            unset($data['warga_negara']);

            if($data['goldar'] != 0){
                $goldar = explode(';', $data['goldar']);
                $data['id_m_golongan_darah'] = $goldar[0];
                $data['golongan_darah'] = $goldar[1];
            } else {
                $data['id_m_golongan_darah'] = 0;
                $data['golongan_darah'] = 'TIDAK TAHU';
            }
            unset($data['goldar']);

            $pekerjaan = $this->db->select('*')
                                ->from('m_pekerjaan')
                                ->where('id', $data['id_m_pekerjaan'])
                                ->where('flag_active', 1)
                                ->get()->row_array();
            if($pekerjaan){
                $data['nama_pekerjaan'] = $pekerjaan['nama_pekerjaan'];
            }
                                
            $tanggal_lahir = explode('-', $data['tanggal_lahir']);
            if(count($tanggal_lahir) > 1){
                $data['tanggal_lahir'] = $tanggal_lahir[2].'-'.$tanggal_lahir[1].'-'.$tanggal_lahir[0];
            }

            $data['created_by'] = $this->general_library->getId();
            
            $data["nama_pasien"] = strtoupper($data["nama_pasien"]); 
            $data["jenis_kelamin"] = strtoupper($data["jenis_kelamin"]); 
            $data["tempat_lahir"] = strtoupper($data["tempat_lahir"]);
            $data["tanggal_lahir"] = strtoupper($data["tanggal_lahir"]);
            $data["alamat"] = strtoupper($data["alamat"]);
            $data["nomor_telepon"] = strtoupper($data["nomor_telepon"]);
            $data["jenis_identitas"] = strtoupper($data["jenis_identitas"]); 
            $data["nomor_identitas"] = strtoupper($data["nomor_identitas"]);
            $data["norm"] = strtoupper($data["norm"]); 
            $data["id_m_negara"] = strtoupper($data["id_m_negara"]); 
            $data["kewarganegaraan"] = strtoupper($data["kewarganegaraan"]); 
            $data["created_by"] = strtoupper($data["created_by"]); 

            $this->db->insert('m_pasien', $data);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $res['code'] = 1;
                $res['message'] = 'Terjadi Kesalahan';
                $res['data'] = null;
            } else {
                $this->db->trans_commit();
                $res['data'] = $this->db->select('*')
                                        ->from('m_pasien')
                                        ->where('norm', $data['norm'])
                                        ->where('flag_active', 1)
                                        ->limit(1)
                                        ->get()->row_array();
            }

            return $res;
        }

        public function searchPasien(){
            $result = null;
            if($this->input->post('search_param') != ''){
                // $result =  $this->db->select('*, CONCAT(norm," / ",nama_pasien) as custom_text')
                //                         ->from('m_pasien')
                //                         ->or_like('nama_pasien', $this->input->post('search_param'))
                //                         ->or_like('norm', $this->input->post('search_param'))
                //                         ->or_like('nomor_identitas', $this->input->post('search_param'))
                //                         ->or_like('tanggal_lahir', $this->input->post('search_param'))
                //                         ->where('flag_active', 1)
                //                         ->order_by('nama_pasien', 'asc')
                //                         ->limit(10)
                //                         ->get()->result_array();
                $nama_pasien =  $this->db->select('*, CONCAT(norm," / ",nama_pasien) as custom_text')
                                        ->from('m_pasien')
                                        ->like('nama_pasien', $this->input->post('search_param'))
                                        ->where('flag_active', 1)
                                        ->limit(5)
                                        ->get()->result_array();

                $norm =  $this->db->select('*, CONCAT(norm," / ",nama_pasien) as custom_text')
                                        ->from('m_pasien')
                                        ->like('norm', $this->input->post('search_param'))
                                        ->where('flag_active', 1)
                                        ->limit(5)
                                        ->get()->result_array();

                $no_identitas =  $this->db->select('*, CONCAT(norm," / ",nama_pasien) as custom_text')
                                        ->from('m_pasien')
                                        ->like('nomor_identitas', $this->input->post('search_param'))
                                        ->where('flag_active', 1)
                                        ->limit(5)
                                        ->get()->result_array();

                $tanggal_lahir =  $this->db->select('*, CONCAT(norm," / ",nama_pasien) as custom_text')
                                        ->from('m_pasien')
                                        ->like('tanggal_lahir', $this->input->post('search_param'))
                                        ->where('flag_active', 1)
                                        ->limit(5)
                                        ->get()->result_array();

                if($nama_pasien){
                    foreach($nama_pasien as $np){
                        $result[] = $np;
                    }
                }
                if($norm){
                    foreach($norm as $n){
                        $result[] = $n;
                    }
                }
                if($no_identitas){
                    foreach($no_identitas as $ni){
                        $result[] = $ni;
                    }
                }
                if($tanggal_lahir){
                    foreach($tanggal_lahir as $tl){
                        $result[] = $tl;
                    }
                }
            }
            return $result;
        }

        public function getDataPasienById($id_m_pasien){
            return $this->db->select('*')
                            ->from('m_pasien')
                            ->where('id', $id_m_pasien)
                            ->where('flag_active', 1)
                            ->limit(1)
                            ->get()->row_array();
        }

        public function getDataPasienByNorm($norm){
            return $this->db->select('*')
                            ->from('m_pasien')
                            ->where('norm', $norm)
                            ->where('flag_active', 1)
                            ->limit(1)
                            ->get()->row_array();
        }

        public function getListPendaftaranPasienById($id_m_pasien){
            return $this->db->select('a.*, c.*, a.id as id_t_pendaftaran')
                            ->from('t_pendaftaran a')
                            ->join('m_pasien b', 'a.norm = b.norm')
                            ->join('t_tagihan c', 'a.id = c.id_t_pendaftaran')
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            ->where('c.flag_active', 1)
                            ->where('b.id', $id_m_pasien)
                            ->order_by('a.tanggal_pendaftaran', 'desc')
                            ->group_by('a.id')
                            ->get()->result_array();
        }

        public function getDataPendaftaran($id){
            return $this->db->select('a.*, b.id as id_m_pasien, a.id as id_t_pendaftaran')
                            ->from('t_pendaftaran a')
                            ->join('m_pasien b', 'a.norm = b.norm')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            ->group_by('a.id')
                            ->limit(1)
                            ->get()->row_array();
        }

        public function deletePendaftaranLab($id){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;
            
            //cek jika ada tagihan disini

            $this->db->trans_begin();

            $this->db->where('id', $id)
                    ->update('t_pendaftaran', [
                        'updated_by' => $this->general_library->getId(),
                        'flag_active' => 0
                    ]);

            $this->db->where('id_t_pendaftaran', $id)
                    ->update('t_tagihan', [
                        'updated_by' => $this->general_library->getId(),
                        'flag_active' => 0
                    ]);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $res['code'] = 1;
                $res['message'] = 'Terjadi Kesalahan';
                $res['data'] = null;
            } else {
                $this->db->trans_commit();
            }

            return $res;
        }
        
        public function editPendaftaranLab(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $data_pendaftaran = $this->input->post();
            $id_t_pendaftaran = $data_pendaftaran['id_t_pendaftaran'];
            unset($data_pendaftaran['id_t_pendaftaran']);

            //cek jika ada tagihan di bawah tanggal pendaftaran setelah edit

            $this->db->trans_begin();

            $tanggal_pendaftaran = explode(' ', $data_pendaftaran['tanggal_pendaftaran']);
            $date_tanggal_pendaftaran = explode('-', $tanggal_pendaftaran[0]);
            
            $dpjp = explode(';', $data_pendaftaran['dpjp']);
            $data_pendaftaran['id_m_dpjp'] = $dpjp[0];
            $data_pendaftaran['nama_dokter_dpjp'] = $dpjp[1];
            unset($data_pendaftaran['dpjp']);

            if($data_pendaftaran['dokter_pengirim'] != '0'){
                $dokter_pengirim = explode(';', $data_pendaftaran['dokter_pengirim']);
                $data_pendaftaran['id_m_dokter_pengirim'] = $dokter_pengirim[0];
                $data_pendaftaran['nama_dokter_pengirim'] = $dokter_pengirim[1];
            }
            unset($data_pendaftaran['dokter_pengirim']);

            $data_pendaftaran['updated_by'] = $this->general_library->getId();
            $this->db->where('id', $id_t_pendaftaran)
                    ->update('t_pendaftaran', $data_pendaftaran);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $data_pendaftaran = null;
                $data_tagihan = null;
                $res['code'] = 1;
                $res['message'] = 'Terjadi Kesalahan';
                $res['data'] = null;
            } else {
                $this->db->trans_commit();
                $res['data'] = $data_pendaftaran;
            }

            return $res;
        }

        public function pendaftaranLab(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $data_pendaftaran = $this->input->post();

            $this->db->trans_begin();

            $tanggal_pendaftaran = explode(' ', $data_pendaftaran['tanggal_pendaftaran']);
            $date_tanggal_pendaftaran = explode('-', $tanggal_pendaftaran[0]);
            $last_pendaftaran = $this->db->select('*')
                                        ->from('t_pendaftaran')
                                        ->where('DATE(tanggal_pendaftaran)', $tanggal_pendaftaran[0])
                                        ->where('flag_active', 1)
                                        ->order_by('tanggal_pendaftaran', 'desc')
                                        ->limit(1)
                                        ->get()->row_array();
            $counter_nomor_pendaftaran = 1;
            if($last_pendaftaran){
                $lnp = substr($last_pendaftaran['nomor_pendaftaran'], 8, 5);
                $counter_nomor_pendaftaran = floatval(ltrim($lnp, '0')) + 1;
            }
            $data_pendaftaran['nomor_pendaftaran'] = $date_tanggal_pendaftaran[0].$date_tanggal_pendaftaran[1].$date_tanggal_pendaftaran[2]
                                                    .str_pad($counter_nomor_pendaftaran, 5, '0', STR_PAD_LEFT);
            
            $dpjp = explode(';', $data_pendaftaran['dpjp']);
            $data_pendaftaran['id_m_dpjp'] = $dpjp[0];
            $data_pendaftaran['nama_dokter_dpjp'] = $dpjp[1];
            unset($data_pendaftaran['dpjp']);

            if($data_pendaftaran['dokter_pengirim'] != '0'){
                $dokter_pengirim = explode(';', $data_pendaftaran['dokter_pengirim']);
                $data_pendaftaran['id_m_dokter_pengirim'] = $dokter_pengirim[0];
                $data_pendaftaran['nama_dokter_pengirim'] = $dokter_pengirim[1];
            }
            unset($data_pendaftaran['dokter_pengirim']);

            $data_pendaftaran['created_by'] = $this->general_library->getId();

            $this->db->insert('t_pendaftaran', $data_pendaftaran);
            $last_id_pendaftaran = $this->db->insert_id();

            $data_tagihan['id_t_pendaftaran'] = $last_id_pendaftaran;
            $data_tagihan['total_tagihan'] = '0';
            $data_tagihan['id_m_status_tagihan'] = '1';
            $data_tagihan['status_tagihan'] = 'Belum Lunas';
            $data_tagihan['created_by'] = $data_pendaftaran['created_by'];
            $this->db->insert('t_tagihan', $data_tagihan);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $data_pendaftaran = null;
                $data_tagihan = null;
                $res['code'] = 1;
                $res['message'] = 'Terjadi Kesalahan';
                $res['data'] = null;
            } else {
                $this->db->trans_commit();
                $res['data'] = $data_pendaftaran;
            }

            return $res;
        }

        public function editDataPasien(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $data = $this->input->post();
            
            $this->db->trans_begin();

            $id_m_pasien = $data['id_m_pasien'];
            unset($data['id_m_pasien']);

            $warga_negara = explode(';', $data['warga_negara']);
            $data['id_m_negara'] = $warga_negara[0];
            $data['kewarganegaraan'] = $warga_negara[1];
            unset($data['warga_negara']);

            if($data['goldar'] != 0){
                $goldar = explode(';', $data['goldar']);
                $data['id_m_golongan_darah'] = $goldar[0];
                $data['golongan_darah'] = $goldar[1];
            } else {
                $data['id_m_golongan_darah'] = 0;
                $data['golongan_darah'] = 'TIDAK TAHU';
            }
            unset($data['goldar']);

            $pekerjaan = $this->db->select('*')
                                ->from('m_pekerjaan')
                                ->where('id', $data['id_m_pekerjaan'])
                                ->where('flag_active', 1)
                                ->get()->row_array();
            if($pekerjaan){
                $data['nama_pekerjaan'] = $pekerjaan['nama_pekerjaan'];
            }
                                
            $tanggal_lahir = explode('-', $data['tanggal_lahir']);
            if(count($tanggal_lahir) > 1){
                $data['tanggal_lahir'] = $tanggal_lahir[2].'-'.$tanggal_lahir[1].'-'.$tanggal_lahir[0];
            }

            $data['updated_by'] = $this->general_library->getId();
            
            $data["nama_pasien"] = strtoupper($data["nama_pasien"]); 
            $data["jenis_kelamin"] = strtoupper($data["jenis_kelamin"]); 
            $data["tempat_lahir"] = strtoupper($data["tempat_lahir"]);
            $data["tanggal_lahir"] = strtoupper($data["tanggal_lahir"]);
            $data["alamat"] = strtoupper($data["alamat"]);
            $data["nomor_telepon"] = strtoupper($data["nomor_telepon"]);
            $data["jenis_identitas"] = strtoupper($data["jenis_identitas"]); 
            $data["nomor_identitas"] = strtoupper($data["nomor_identitas"]);
            $data["norm"] = strtoupper($data["norm"]); 
            $data["id_m_negara"] = strtoupper($data["id_m_negara"]); 
            $data["kewarganegaraan"] = strtoupper($data["kewarganegaraan"]); 
            $data["updated_by"] = strtoupper($data["updated_by"]); 

            $this->db->where('id', $id_m_pasien)
                    ->update('m_pasien', $data);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $res['code'] = 1;
                $res['message'] = 'Terjadi Kesalahan';
                $res['data'] = null;
            } else {
                $this->db->trans_commit();
            }

            return $res;
        }
	}
?>