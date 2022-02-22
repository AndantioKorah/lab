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
                                // ->where('flag_active', 1)
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

        public function searchDokter(){
            $result = null;
            if($this->input->post('search_param') != ''){
                $result =  $this->db->select('*, CONCAT(id,";",nama_dokter,";",alamat,";",nomor_telepon) as custom_value')
                                    ->from('m_dokter')
                                    ->like('nama_dokter', $this->input->post('search_param'))
                                    ->where('flag_active', 1)
                                    // ->limit(20)
                                    ->get()->result_array();
            }
            return $result;            
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
            return $this->db->select('a.*, c.status_tagihan, a.id as id_t_pendaftaran, c.id_m_status_tagihan')
                            ->from('t_pendaftaran a')
                            ->join('m_pasien b', 'a.norm = b.norm')
                            ->join('t_tagihan c', 'a.id = c.id_t_pendaftaran')
                            // ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            // ->where('c.flag_active', 1)
                            ->where('b.id', $id_m_pasien)
                            ->order_by('a.tanggal_pendaftaran', 'desc')
                            ->group_by('a.id')
                            ->get()->result_array();
        }

        public function getDataPendaftaran($id){
            return $this->db->select('a.*, b.id as id_m_pasien, a.id as id_t_pendaftaran, b.nama_pasien, b.alamat, b.nomor_telepon, b.tanggal_lahir, b.jenis_kelamin,
            (select alamat from m_dokter where a.id_m_dokter_pengirim = m_dokter.id and m_dokter.flag_active = 1 limit 1) as alamat_dokter')
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

            $this->db->where('id_t_pendaftaran', $id)
                    ->update('t_tagihan_detail', [
                        'updated_by' => $this->general_library->getId(),
                        'flag_active' => 0
                    ]);

            $this->db->where('id_t_pendaftaran', $id)
                    ->update('t_tindakan', [
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
            } else {
                $data_pendaftaran['id_m_dokter_pengirim'] = null;
                $data_pendaftaran['nama_dokter_pengirim'] = null;
            }
            unset($data_pendaftaran['dokter_pengirim']);

            $cara_bayar = explode(';', $data_pendaftaran['cara_bayar']);
            $data_pendaftaran['id_m_cara_bayar_detail'] = $cara_bayar[0];
            $data_pendaftaran['nama_cara_bayar_detail'] = $cara_bayar[1];
            $data_cara_bayar = $this->db->select('b.*')
                                        ->from('m_cara_bayar_detail a')
                                        ->join('m_cara_bayar b', 'a.id_m_cara_bayar = b.id')
                                        ->where('a.id', $data_pendaftaran['id_m_cara_bayar_detail'])
                                        ->where('a.flag_active', 1)
                                        ->limit(1)
                                        ->get()->row_array();
            if($data_cara_bayar){
                $data_pendaftaran['id_m_cara_bayar'] = $data_cara_bayar['id'];
                $data_pendaftaran['nama_cara_bayar'] = $data_cara_bayar['nama_cara_bayar'];
            }
            unset($data_pendaftaran['cara_bayar']);

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
            $session_id = $data_pendaftaran['session_id'];
            $tanggal_pendaftaran = explode(' ', $data_pendaftaran['tanggal_pendaftaran']);
            $date_tanggal_pendaftaran = explode('-', $tanggal_pendaftaran[0]);
            $last_pendaftaran = $this->db->select('*')
                                        ->from('t_pendaftaran')
                                        ->where('DATE(tanggal_pendaftaran)', $tanggal_pendaftaran[0])
                                        // ->where('flag_active', 1)
                                        ->order_by('nomor_pendaftaran', 'desc')
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

            $cara_bayar = explode(';', $data_pendaftaran['cara_bayar']);
            $data_pendaftaran['id_m_cara_bayar_detail'] = $cara_bayar[0];
            $data_pendaftaran['nama_cara_bayar_detail'] = $cara_bayar[1];
            $data_cara_bayar = $this->db->select('b.*')
                                        ->from('m_cara_bayar_detail a')
                                        ->join('m_cara_bayar b', 'a.id_m_cara_bayar = b.id')
                                        ->where('a.id', $data_pendaftaran['id_m_cara_bayar_detail'])
                                        ->where('a.flag_active', 1)
                                        ->limit(1)
                                        ->get()->row_array();
            if($data_cara_bayar){
                $data_pendaftaran['id_m_cara_bayar'] = $data_cara_bayar['id'];
                $data_pendaftaran['nama_cara_bayar'] = $data_cara_bayar['nama_cara_bayar'];
            }
            unset($data_pendaftaran['cara_bayar']);

            $data_pendaftaran['created_by'] = $this->general_library->getId();

            $this->db->insert('t_pendaftaran', $data_pendaftaran);
            $last_id_pendaftaran = $this->db->insert_id();

            $data_tagihan['id_t_pendaftaran'] = $last_id_pendaftaran;
            $data_tagihan['total_tagihan'] = '0';
            $data_tagihan['id_m_status_tagihan'] = '1';
            $data_tagihan['status_tagihan'] = 'Belum Lunas';
            $data_tagihan['created_by'] = $data_pendaftaran['created_by'];
            $this->db->insert('t_tagihan', $data_tagihan);
            $last_id_tagihan = $this->db->insert_id();

            $this->db->select('*')
            ->from('t_tindakan_pendaftaran as a')
            ->where('a.session_id', $session_id)
            ->where('a.flag_active', 1);
            $getTindakan =  $this->db->get()->result_array();

            $tindakan_tagihan = null;
            $arr_tindakan = null;

            foreach($getTindakan as $gt){
                $last_id_t_tindakan = null;
                $tindakan = array(
                    'id_t_pendaftaran' => $last_id_pendaftaran,
                    'id_m_nm_tindakan' => $gt['id_m_nm_tindakan'],
                    'parent_id_tindakan' => $gt['parent_id_tindakan'],
                    'nama_tindakan' => $gt['nama_tindakan'],
                    'nilai_normal' => $gt['nilai_normal'],
                    'satuan' => $gt['satuan'],
                    'created_by' => $this->general_library->getId()
                );
                if($gt['parent_id_tindakan'] != 0){
                    $arr_tindakan[] = $tindakan;
                } else {
                    $this->db->insert('t_tindakan', $tindakan);
                    $last_id_t_tindakan = $this->db->insert_id();
                    $tindakan_tagihan[$gt['id_m_nm_tindakan']]['id_t_pendaftaran'] = $last_id_pendaftaran;
                    $tindakan_tagihan[$gt['id_m_nm_tindakan']]['id_t_tagihan'] = $last_id_tagihan;
                    $tindakan_tagihan[$gt['id_m_nm_tindakan']]['jenis_tagihan'] = 'Tindakan';
                    $tindakan_tagihan[$gt['id_m_nm_tindakan']]['id_reference'] = $last_id_t_tindakan;
                    $tindakan_tagihan[$gt['id_m_nm_tindakan']]['nama_tagihan'] = $gt['nama_tindakan'];
                    $tindakan_tagihan[$gt['id_m_nm_tindakan']]['biaya'] = $gt['biaya'];
                    $tindakan_tagihan[$gt['id_m_nm_tindakan']]['created_by'] = $this->general_library->getId();
                    $tindakan_tagihan[$gt['id_m_nm_tindakan']]['detail_tindakan'] = null;
                }

                if(isset($tindakan_tagihan[$gt['parent_id_tindakan']])){
                    $tindakan_tagihan[$gt['parent_id_tindakan']]['detail_tindakan'][] = $gt['nama_tindakan'];
                }
                
            }
            if($arr_tindakan){
                $this->db->insert_batch('t_tindakan', $arr_tindakan);
            }

            $i = 0;
            $detail_tagihan = null;
            foreach($tindakan_tagihan as $tt){
                $detail_tagihan[] = $tt;
                if(isset($tt['detail_tindakan'])){
                    $detail_tagihan[$i]['detail_tindakan'] = json_encode($tt['detail_tindakan']);
                }
                $i++;
            }
            $this->db->insert_batch('t_tagihan_detail', $detail_tagihan);

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
                $this->general_library->countTagihan($last_id_pendaftaran);
            }

            return $res;
        }

        public function getDetailPendaftaran($id_t_pendaftaran){
            return $this->db->select('a.*, b.status_tagihan, b.id_m_status_tagihan, c.id as id_m_pasien')
                            ->from('t_pendaftaran a')
                            ->join('t_tagihan b', 'a.id = b.id_t_pendaftaran')
                            ->join('m_pasien c', 'a.norm = c.norm')
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            ->where('a.id', $id_t_pendaftaran)
                            ->limit(1)
                            ->get()->row_array();
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

        public function buildChildren($parent_id, $hasil =[]){
            $w = $this->getChildren($parent_id);
            if(count($w) > 0){ 
                $hasil = array_merge($hasil,$w);
                $i=0;
                foreach($w as $h){
                    $hasil = $this->buildChildren($h->id, $hasil);
                    $i++;
                }
            }
            return $hasil;
        }
        
        public function getChildren($id){
            $return = null;
            return $this->db->select('*')
                            ->from('m_tindakan')
                            ->where('parent_id', $id)
                            ->where('flag_active', 1)
                            ->get()->result();
        }


        public function insertTindakanPendaftaran(){
            
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $session_id = $this->input->post('session_id');
            $id_tindakan = $this->input->post('tindakan');
           
            $this->db->trans_begin();

            $this->db->select('*')
            ->from('t_tindakan_pendaftaran as a')
            ->where('a.id_m_nm_tindakan', $id_tindakan)
            ->where('a.session_id', $session_id)
            ->where('a.flag_active', 1);
             $cekTindakanDouble =  $this->db->get()->result();

             if($cekTindakanDouble){
                $res['code'] = 1;
                $res['message'] = 'Tindakan Sudah ada';
                return $res;
             }

            $this->db->select('*')
                ->from('m_tindakan as a')
                ->where('a.parent_id', $id_tindakan)
                ->where('a.flag_active', 1);
            $cekTindakan =  $this->db->get()->result();
         

            $data = null;
            if($cekTindakan){
                foreach($cekTindakan as $ct){
                    $data[] = $ct;
                    $child = $this->buildChildren($ct->id, []);
                    if($child){
                        foreach($child as $c){
                            $data[] = $c;
                        }
                    }
                }
            }
            $cekTindakan = $data;
          
            $dateOfBirth = $this->input->post('tanggal_lahir');
            $today = date("Y-m-d");
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            $umur = (int)$diff->format('%y');
            $jenis_kelamin = $this->input->post('jenis_kelamin');
            // dd($umur);
            if($umur < 5){
                $kategori_pasien = "Anak 2 - 4 Tahun";
            } else if($umur == 5){
                $kategori_pasien = "Anak 5 Tahun";
            } else if($umur > 5 && $umur < 13) {
                $kategori_pasien = "Anak 6 - 12 Tahun";
            } else {
                $kategori_pasien = null;
            }
            
          
            if($cekTindakan) {
                $this->db->select('a.biaya,a.nama_tindakan,a.nilai_normal, a.satuan')
                ->from('m_tindakan as a')
                ->where('a.id', $id_tindakan)
                ->where('a.flag_active', 1);
                $dataTindakan =  $this->db->get()->result();

                $data = array(
                    'session_id' => $session_id,
                    'nama_tindakan' => $dataTindakan['0']->nama_tindakan,
                    'id_m_nm_tindakan' => $id_tindakan,
                    'created_by' => $this->general_library->getId(),
                    'biaya' => $dataTindakan['0']->biaya
                );

                $this->db->insert('t_tindakan_pendaftaran', $data);
                $last_id_tindakan = $this->db->insert_id();
                
                $arr_tindakan = null; 
               
                foreach($cekTindakan as $tindakan){
                  
                    if($umur < 13){
                        if($tindakan->flag_m_nilai_normal == 1){
                            $this->db->select('a.nilai_normal, a.jenis_kelamin,a.umur')
                            ->from('m_nilai_normal as a')
                            ->where('a.id_m_nm_tindakan', $tindakan->id)
                            ->where('a.kategori_pasien', $kategori_pasien)
                            ->where('a.flag_active', 1);
                            $masterNilaiNormal =  $this->db->get()->result();
                           
                            if($masterNilaiNormal[0]->jenis_kelamin == null){
                                 if($masterNilaiNormal[0]->umur == null){
                                    $nilai_normal = $masterNilaiNormal[0]->nilai_normal;
                                 } else {
                                    if($umur == 0){
                                        $umur = 2;
                                        }
                                    $this->db->select('a.nilai_normal, a.umur')
                                     ->from('m_nilai_normal as a')
                                     ->where('a.id_m_nm_tindakan', $tindakan->id)
                                     ->where('a.umur <=', $umur)
                                     ->where('a.kategori_pasien', $kategori_pasien)
                                     ->where('a.flag_active', 1)
                                     ->order_by('a.umur', 'desc')
                                     ->limit(1);
                                $masterNilaiNormalUmur =  $this->db->get()->result();
                             
                                $nilai_normal = $masterNilaiNormalUmur[0]->nilai_normal;
                                 }
                            } else {
                                if($masterNilaiNormal[0]->umur == null){
                                    $this->db->select('a.nilai_normal, a.umur')
                                    ->from('m_nilai_normal as a')
                                    ->where('a.id_m_nm_tindakan', $tindakan->id)
                                    ->where('a.jenis_kelamin', $jenis_kelamin)
                                    ->where('a.kategori_pasien', $kategori_pasien)
                                    ->where('a.flag_active', 1)
                                    ->order_by('a.umur', 'desc')
                                    ->limit(1);
                                    $masterNilaiNormalJK =  $this->db->get()->result();
                                    $nilai_normal = $masterNilaiNormalJK[0]->nilai_normal;
                                } else {
                                    $this->db->select('a.nilai_normal, a.umur')
                                    ->from('m_nilai_normal as a')
                                    ->where('a.id_m_nm_tindakan', $tindakan->id)
                                    ->where('a.umur <=', $umur)
                                    ->where('a.jenis_kelamin', $jenis_kelamin)
                                    ->where('a.kategori_pasien', $kategori_pasien)
                                    ->where('a.flag_active', 1)
                                    ->order_by('a.umur', 'desc')
                                    ->limit(1);
                                    $masterNilaiNormalJK =  $this->db->get()->result();
                                    $nilai_normal = $masterNilaiNormalJK[0]->nilai_normal;
                                }

                            }
                           
                        } else {
                            $nilai_normal = $tindakan->nilai_normal;
                        }
                    } else {
                        if($tindakan->flag_m_nilai_normal == 1){
                            $this->db->select('a.nilai_normal')
                            ->from('m_nilai_normal as a')
                            ->where('a.id_m_nm_tindakan', $tindakan->id)
                            ->where('a.jenis_kelamin', $jenis_kelamin)
                            ->where('a.kategori_pasien', null)
                            ->where('a.flag_active', 1);
                            $masterNilaiNormal =  $this->db->get()->result();
                            if($masterNilaiNormal){
                                $nilai_normal = $masterNilaiNormal[0]->nilai_normal;
                            } else {
                            $this->db->select('a.nilai_normal')
                            ->from('m_nilai_normal as a')
                            ->where('a.id_m_nm_tindakan', $tindakan->id)
                            ->where('a.kategori_pasien', null)
                            ->where('a.flag_active', 1);
                            $masterNilaiNormalNonJK =  $this->db->get()->result();
                            if($masterNilaiNormalNonJK){
                                $nilai_normal = $masterNilaiNormalNonJK[0]->nilai_normal;
                            } else {
                                $nilai_normal = $tindakan->nilai_normal;
                            }
                            }
                        } else {
                            $nilai_normal = $tindakan->nilai_normal;
                        }
                    }
                    

                    $data = array(
                        'session_id' => $session_id,
                        'id_m_nm_tindakan' => $tindakan->id,
                        'nama_tindakan' => $tindakan->nama_tindakan,
                        'parent_id_tindakan' => $tindakan->parent_id,    
                        'nama_tindakan' => $tindakan->nama_tindakan,
                        'nilai_normal' => $nilai_normal,
                        'satuan' => $tindakan->satuan,
                        'created_by' => $this->general_library->getId()
                    );
                    $arr_tindakan[] = $data;
                }
                $this->db->insert_batch('t_tindakan_pendaftaran', $arr_tindakan);
            } else {
                $this->db->select('a.id,a.biaya,a.nama_tindakan,a.nilai_normal,a.satuan, a.flag_m_nilai_normal')
                        ->from('m_tindakan as a')
                        ->where('a.id', $id_tindakan)
                        ->where('a.flag_active', 1);
                 $dataTindakan =  $this->db->get()->result();

                 if($dataTindakan[0]->flag_m_nilai_normal == 1){
                    $this->db->select('a.nilai_normal, a.umur')
                    ->from('m_nilai_normal as a')
                    ->where('a.id_m_nm_tindakan', $dataTindakan[0]->id)
                    ->where('a.jenis_kelamin', $jenis_kelamin)
                    ->where('a.flag_active', 1)
                    ->limit(1);
                    $masterNilaiNormalJK =  $this->db->get()->result();
                    $nilai_normal = $masterNilaiNormalJK[0]->nilai_normal;
                }  else {
                    $nilai_normal = $dataTindakan[0]->nilai_normal;
                }
                
                 $data = array(
                    'session_id' => $session_id,
                    'id_m_nm_tindakan' => $id_tindakan,
                    'nama_tindakan' => $dataTindakan[0]->nama_tindakan,
                    'nilai_normal' => $nilai_normal,
                    'biaya' => $dataTindakan[0]->biaya,
                    'satuan' => $dataTindakan[0]->satuan,
                    'created_by' => $this->general_library->getId()
                );
                $this->db->insert('t_tindakan_pendaftaran', $data);
                $last_id_tindakan = $this->db->insert_id();

            }
            

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            return $res;
        }

        public function getRincianTindakan($session_id){
            $data = null;
            $list_parent = null;
            $list_id_top_parent = null;
            $list_top_parent = null;
            $tindakan = $this->db->select('a.*, b.parent_id, b.id_m_jns_tindakan, b.id as id_m_tindakan, b.nilai_normal')
                                        ->from('t_tindakan_pendaftaran a')
                                        ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                                        ->where('a.session_id', $session_id)
                                        ->where('a.flag_active', 1)
                                        ->group_by('a.id')
                                        ->get()->result_array();
                                        // dd($tindakan);
           
            if($tindakan){
                $i = 0;
                foreach($tindakan as $t){
                    if($t['parent_id_tindakan'] == 0){
                        $list_id_top_parent[] = $t['id_m_jns_tindakan'];
                        $list_parent[] = $t; 
                        array_splice($tindakan, $i, 1);
                        $i -= 1;
                    }
                    $i++;
                }
                $list_id_top_parent = array_unique($list_id_top_parent);
            // }
            
            $list_top_parent = $this->db->select('*')
                                        ->from('m_jns_tindakan')
                                        ->where_in('id', $list_id_top_parent)
                                        ->get()->result_array();
            if($list_top_parent){
                foreach($list_top_parent as $ltp){
                    $data[$ltp['id']] = $ltp;
                }
                foreach($list_parent as $lp){
                    $data[$lp['id_m_jns_tindakan']]['tindakan'][$lp['id_m_nm_tindakan']] = $lp;
                    $j = 0;
                    foreach($tindakan as $t){
                        if($t['parent_id_tindakan'] == $lp['id_m_nm_tindakan']){
                            $data[$lp['id_m_jns_tindakan']]['tindakan'][$lp['id_m_nm_tindakan']]['detail_tindakan'][] = $t;
                            array_splice($tindakan, $j, 1);
                            $j -= 1;
                        }
                        $j++;
                    }
                }
            }
        }
            // dd($data);
            // fungsi ini akan berhenti jika $tindakan sudah null; tapi belum ada contoh, jadi belum lanjut
            return $data;
        }

        public function delTindakanPendaftaran(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;
            
        
            $id_tindakan = $this->input->post('idtindakan');
            $session_id = $this->input->post('session_id');
     
        
             $this->db->trans_begin();
             $this->db->select('a.id_m_nm_tindakan,b.id')
             ->from('t_tindakan_pendaftaran as a')
             ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
             ->where('a.session_id', $session_id)
             ->where('a.id', $id_tindakan)
             ->where('a.nilai_normal', null)
             ->where('a.flag_active', 1);
              $cekTindakan =  $this->db->get()->result();
                          
           if($cekTindakan){
              foreach($cekTindakan as $tindakan){
              $list_id[] = $tindakan->id;  
              }
              if (in_array($cekTindakan[0]->id_m_nm_tindakan, $list_id)) {
               
                $this->db->select('*')
                    ->from('t_tindakan_pendaftaran as a')
                    ->where('a.parent_id_tindakan', $cekTindakan[0]->id_m_nm_tindakan)
                    ->where('a.session_id', $session_id)
                    ->where('a.flag_active', 1);
                $getTindakan =  $this->db->get()->result();
            
                if($getTindakan){
                    foreach($getTindakan as $tindakan){
                        $this->db->where('id', $tindakan->id)
                        ->update('t_tindakan_pendaftaran', [
                            'updated_by' => $this->general_library->getId(),
                            'flag_active' => 0
                        ]);
                    }
                    $this->db->where('id', $id_tindakan)
                    ->update('t_tindakan_pendaftaran', [
                        'updated_by' => $this->general_library->getId(),
                        'flag_active' => 0
                    ]); 
                
                }  
               
            } else {
              
                $this->db->where('id', $id_tindakan)
                ->update('t_tindakan_pendaftaran', [
                    'updated_by' => $this->general_library->getId(),
                    'flag_active' => 0
                ]);
            }

           } else {
            $this->db->where('id', $id_tindakan)
            ->update('t_tindakan_pendaftaran', [
                'updated_by' => $this->general_library->getId(),
                'flag_active' => 0
            ]); 
           }
           
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

    public function searchMenuListPendaftaran($data){
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
                            ->order_by('a.tanggal_pendaftaran', 'desc')
                            ->group_by('a.id')
                            ->get()->result_array();
    }
}
?>