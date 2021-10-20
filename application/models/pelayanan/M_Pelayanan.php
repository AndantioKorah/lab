<?php
	class M_Pelayanan extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        	//tampil data
		public function getListTindakan(){
			// return $this->db->get('m_nm_tindakan')->result();
            $this->db->select('a.id as id_tindakan, a.nama_tindakan, a.biaya, b.nm_jns_tindakan,
            CONCAT(b.nm_jns_tindakan, " / ", a.nama_tindakan ) as nm_tindakan
            ')
            // $this->db->select('*')
            ->from('m_nm_tindakan as a')
            ->join('m_jns_tindakan as b', 'b.id = a.id_m_jns_tindakan')
            ->where('a.flag_active', '1');
        return $this->db->get()->result();
		}


        public function insertTindakanOld(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $data_tindakan = $this->input->post('tindakan');
            $id_pendaftaran = $this->input->post('id_pendaftaran');
            $id_tagihan = $this->input->post('id_tagihan');
            // var_dump($data_tindakan);
            // die();
            $this->db->trans_begin();

            foreach($data_tindakan as $tindakan){

                $this->db->select('a.biaya,a.nama_tindakan')
                ->from('m_nm_tindakan as a')
                ->where('a.id', $tindakan)
                ->where('a.flag_active', 1);
                 $dataTindakan =  $this->db->get()->result();
                // var_dump($dataTindakan['0']->biaya);
                // die();

                $data = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_m_nm_tindakan' => $tindakan
                );
                $this->db->insert('t_tindakan', $data);
                $last_id_tindakan = $this->db->insert_id();

                $dataTagihan = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_reference' => $last_id_tindakan,
                    'id_t_tagihan' => $id_tagihan,
                    'jenis_tagihan' => "Tindakan",
                    'nama_tagihan' => $dataTindakan['0']->nama_tindakan,
                    'biaya' => $dataTindakan['0']->biaya,
                );
                $this->db->insert('t_tagihan_detail', $dataTagihan);
            }

            // $last_id_pendaftaran = $this->db->insert_id();

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            return $res;
        }

        public function insertTindakanOld2(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $data_tindakan = $this->input->post('tindakan');
            $id_pendaftaran = $this->input->post('id_pendaftaran');
            $id_tagihan = $this->input->post('id_tagihan');
            $id_tindakan = $this->input->post('tindakan');
            // var_dump($id_tindakan);
            // die();
            $this->db->trans_begin();

            $this->db->select('*')
                ->from('t_tindakan as a')
                ->where('a.id_m_nm_tindakan', $id_tindakan)
                ->where('a.id_t_pendaftaran', $id_pendaftaran)
                ->where('a.flag_active', 1);
            $cekTindakan =  $this->db->get()->result();
            // var_dump($cekTindakan);
            // die();

            if($cekTindakan) {
                $res['code'] = 1;
                $res['message'] = 'Tindakan Sudah ada';
               
            } else {
                $this->db->select('a.biaya,a.nama_tindakan')
                ->from('m_nm_tindakan as a')
                ->where('a.id', $id_tindakan)
                ->where('a.flag_active', 1);
                 $dataTindakan =  $this->db->get()->result();

                $data = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_m_nm_tindakan' => $id_tindakan,
                    'created_by' => $this->general_library->getId()
                );
                $this->db->insert('t_tindakan', $data);
                $last_id_tindakan = $this->db->insert_id();

                $dataTagihan = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_reference' => $last_id_tindakan,
                    'id_t_tagihan' => $id_tagihan,
                    'jenis_tagihan' => "Tindakan",
                    'nama_tagihan' => $dataTindakan['0']->nama_tindakan,
                    'biaya' => $dataTindakan['0']->biaya,
                    'created_by' => $this->general_library->getId()
                );
                $this->db->insert('t_tagihan_detail', $dataTagihan);
            }
            // $last_id_pendaftaran = $this->db->insert_id();

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            return $res;
        }


        public function insertTindakan(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

           
            $id_pendaftaran = $this->input->post('id_pendaftaran');
            $id_tagihan = $this->input->post('id_tagihan');
            $id_tindakan = $this->input->post('tindakan');
            
            // $id_pendaftaran = 2;
            // $id_tagihan = 2;
            // $id_tindakan = 7;

            $this->db->trans_begin();

            $this->db->select('*')
            ->from('t_tindakan as a')
            ->where('a.id_m_nm_tindakan', $id_tindakan)
            ->where('a.id_t_pendaftaran', $id_pendaftaran)
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
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'nama_tindakan' => $dataTindakan['0']->nama_tindakan,
                    'id_m_nm_tindakan' => $id_tindakan,
                    'created_by' => $this->general_library->getId()
                );

                $this->db->insert('t_tindakan', $data);
                $last_id_tindakan = $this->db->insert_id();

                foreach($cekTindakan as $tindakan){
                 
                    if($umur < 13 ){
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
                        'id_t_pendaftaran' => $id_pendaftaran,
                        'id_m_nm_tindakan' => $tindakan->id,
                        'parent_id_tindakan' => $tindakan->parent_id,
                        'nama_tindakan' => $tindakan->nama_tindakan,
                        'nilai_normal' => $nilai_normal,
                        'satuan' => $tindakan->satuan,
                        'created_by' => $this->general_library->getId()
                    );
                    $this->db->insert('t_tindakan', $data);
                    $detail_tindakan[] = $tindakan->nama_tindakan;  
                }

                $dataTagihan = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_reference' => $last_id_tindakan,
                    'id_t_tagihan' => $id_tagihan,
                    'jenis_tagihan' => "Tindakan",
                    'nama_tagihan' => $dataTindakan['0']->nama_tindakan,
                    'detail_tindakan' => json_encode($detail_tindakan),
                    'biaya' => $dataTindakan['0']->biaya,
                    'created_by' => $this->general_library->getId()
                );
                $this->db->insert('t_tagihan_detail', $dataTagihan);

            } else {
              
                $this->db->select('a.biaya,a.nama_tindakan,a.nilai_normal,a.satuan')
                ->from('m_tindakan as a')
                ->where('a.id', $id_tindakan)
                ->where('a.flag_active', 1);
                 $dataTindakan =  $this->db->get()->result();
                

                 $data = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_m_nm_tindakan' => $id_tindakan,
                    'nama_tindakan' => $dataTindakan[0]->nama_tindakan,
                    'nilai_normal' => $dataTindakan[0]->nilai_normal,
                    'satuan' => $dataTindakan[0]->satuan,
                );
                $this->db->insert('t_tindakan', $data);
                $last_id_tindakan = $this->db->insert_id();
                $detail_tindakan[] = $dataTindakan[0]->nama_tindakan;  
                
                $dataTagihan = array(
                    'id_t_pendaftaran' => $id_pendaftaran,
                    'id_reference' => $last_id_tindakan,
                    'id_t_tagihan' => $id_tagihan,
                    'jenis_tagihan' => "Tindakan",
                    'nama_tagihan' => $dataTindakan['0']->nama_tindakan,
                    'detail_tindakan' => json_encode($detail_tindakan),
                    'biaya' => $dataTindakan['0']->biaya,
                    'created_by' => $this->general_library->getId()
                );
                $this->db->insert('t_tagihan_detail', $dataTagihan);
            }
            


            // $last_id_pendaftaran = $this->db->insert_id();

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
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

        public function getTindakanPasienOld($id_pendaftaran)
    {
        // $id_pendaftaran = $this->input->post('id_pendaftaran');
        $this->db->select('a.id, a.id_m_nm_tindakan, b.nama_tindakan, b.biaya, c.nm_jns_tindakan, a.status')
            ->from('t_tindakan as a')
            ->join('m_nm_tindakan as b', 'b.id = a.id_m_nm_tindakan')
            ->join('m_jns_tindakan as c', 'c.id = b.id_m_jns_tindakan')
            ->where('a.id_t_pendaftaran', $id_pendaftaran)
            ->order_by('a.id', 'desc')
            ->where('a.flag_active', '1');
        return $this->db->get()->result_array();
    }

    public function getTindakanPasien($id_pendaftaran)
    {
        // $id_pendaftaran = $this->input->post('id_pendaftaran');
        $this->db->select('a.id, a.id_m_nm_tindakan, b.*')
            ->from('t_tindakan as a')
            ->join('m_tindakan as b', 'b.id = a.id_m_nm_tindakan')
            ->where('a.id_t_pendaftaran', $id_pendaftaran)
            ->order_by('a.id', 'desc')
            ->where('a.flag_active', '1');
        return $this->db->get()->result_array();
    }

    public function buildChildrenForDelete($parent_id, $hasil = [], $id_pendaftaran = 0){
        $w = $this->getChildrenForDelete($parent_id, $id_pendaftaran);
        if(count($w) > 0){ 
            $hasil = array_merge($hasil,$w);
            $i=0;
            foreach($w as $h){
                $hasil = $this->buildChildrenForDelete($h->id, $hasil, $id_pendaftaran);
                $i++;
            }
        }
        return $hasil;
    }

    public function getChildrenForDelete($id, $id_pendaftaran){
        $return = null;
        return $this->db->select('a.id_m_nm_tindakan, b.id, a.id as id_t_tindakan')
                        ->from('t_tindakan as a')
                        ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                        ->where('a.id_t_pendaftaran', $id_pendaftaran)
                        ->where('b.parent_id', $id)
                        ->where('a.flag_active', 1)
                        ->get()->result();
        // return $this->db->select('*')
        //                 ->from('m_tindakan')
        //                 ->where('parent_id', $id)
        //                 ->where('flag_active', 1)
        //                 ->get()->result();
    }
    
    public function delTindakanPasien(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
    
        $id_tindakan = $this->input->post('idtindakan');
        $id_pendaftaran = $this->input->post('id_pendaftaran');
        // $id_tindakan = 504;
        // $id_pendaftaran = 41;

        $this->db->select('a.id_m_nm_tindakan, b.id, a.id as id_t_tindakan')
                ->from('t_tindakan as a')
                ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                ->where('a.id_t_pendaftaran', $id_pendaftaran)
                ->where('a.id', $id_tindakan)
                // ->where('a.nilai_normal', null)
                ->where('a.flag_active', 1);
        $cekTindakan =  $this->db->get()->result();

        $data_lengkap = null;
        if($cekTindakan){
            foreach($cekTindakan as $ct){
                $data_lengkap[] = $ct;
                $child = $this->buildChildrenForDelete($ct->id, [], $id_pendaftaran);
                if($child){
                    foreach($child as $c){
                        $data_lengkap[] = $c;
                    }
                }
            }
        }

        $list_id_tindakan = null;
        if($data_lengkap){
            foreach($data_lengkap as $d){
                $list_id_tindakan[] = $d->id_t_tindakan;
            }
            $this->db->where_in('id', $list_id_tindakan)
                     ->update('t_tindakan', [
                         'updated_by' => $this->general_library->getId(),
                         'flag_active' => 0
                     ]);
            
            $this->db->where('id_reference', $id_tindakan)
                    ->where('id_t_pendaftaran', $id_pendaftaran)
                    ->update('t_tagihan_detail', [
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

    public function delTindakanPasienBu(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        
    
        $id_tindakan = $this->input->post('idtindakan');
        $id_pendaftaran = $this->input->post('id_pendaftaran');
 
    
         $this->db->trans_begin();
        //  $this->db->select('*')
        //  ->from('t_tindakan as a')
        //  ->where('a.id', $id_tindakan)
        //  ->where('a.flag_active', 1);
        //   $cekTindakan =  $this->db->get()->result();

        $this->db->select('a.id_m_nm_tindakan,b.id')
        ->from('t_tindakan as a')
        ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
        ->where('a.id_t_pendaftaran', $id_pendaftaran)
        ->where('a.id', $id_tindakan)
        ->where('a.nilai_normal', null)
        ->where('a.flag_active', 1);
         $cekTindakan =  $this->db->get()->result();
         
         if($cekTindakan){
         foreach($cekTindakan as $tindakan){
            $list_id[] = $tindakan->id;  
         }
         if (in_array($cekTindakan[0]->id_m_nm_tindakan, $list_id)) 
         {
            
             $this->db->select('*')
                 ->from('t_tindakan as a')
                 ->where('a.parent_id_tindakan', $cekTindakan[0]->id_m_nm_tindakan)
                 ->where('a.id_t_pendaftaran', $id_pendaftaran)
                 ->where('a.flag_active', 1);
             $getTindakan =  $this->db->get()->result();
            
           
             if($getTindakan){
                 foreach($getTindakan as $tindakan){
                     $this->db->where('id', $tindakan->id)
                     ->update('t_tindakan', [
                         'updated_by' => $this->general_library->getId(),
                         'flag_active' => 0
                     ]);
                 }
                 $this->db->where('id', $id_tindakan)
                 ->update('t_tindakan', [
                     'updated_by' => $this->general_library->getId(),
                     'flag_active' => 0
                 ]); 
                 
                 $this->db->where('id_reference', $id_tindakan)
                 ->where('id_t_pendaftaran', $id_pendaftaran)
                ->update('t_tagihan_detail', [
                    'updated_by' => $this->general_library->getId(),
                    'flag_active' => 0
                ]);
             } else {
                $this->db->where('id', $id_tindakan)
                ->update('t_tindakan', [
                    'updated_by' => $this->general_library->getId(),
                    'flag_active' => 0
                ]);
    
                $this->db->where('id_reference', $id_tindakan)
                ->where('id_t_pendaftaran', $id_pendaftaran)
               ->update('t_tagihan_detail', [
                   'updated_by' => $this->general_library->getId(),
                   'flag_active' => 0
               ]);
             }  
            
         } else {
           
             $this->db->where('id', $id_tindakan)
             ->update('t_tindakan', [
                 'updated_by' => $this->general_library->getId(),
                 'flag_active' => 0
             ]);
 
             $this->db->where('id_reference', $id_tindakan)
             ->where('id_t_pendaftaran', $id_pendaftaran)
            ->update('t_tagihan_detail', [
                'updated_by' => $this->general_library->getId(),
                'flag_active' => 0
            ]);
         }
         } else {
            $this->db->where('id', $id_tindakan)
            ->update('t_tindakan', [
                'updated_by' => $this->general_library->getId(),
                'flag_active' => 0
            ]);

            $this->db->where('id_reference', $id_tindakan)
            ->where('id_t_pendaftaran', $id_pendaftaran)
           ->update('t_tagihan_detail', [
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

    public function getTagihan($id_pendaftaran){
        $this->db->select('*')
        ->from('t_tagihan as a')
        ->where('a.id_t_pendaftaran', $id_pendaftaran)
        ->where('a.flag_active', '1');
    return $this->db->get()->result();
    }

    public function getDataPasien($id_pendaftaran){
        $this->db->select('b.tanggal_lahir, b.jenis_kelamin, b.id as id_m_pasien')
        ->from('t_pendaftaran as a')
        ->join('m_pasien as b', 'b.norm = a.norm')
        ->where('a.id', $id_pendaftaran)
        ->where('a.flag_active', '1');
    return $this->db->get()->result();
    }


    public function select2TindakanOld(){
        // return $this->db->get('m_nm_tindakan')->result();
        $params = $this->input->post('search_param'); 
        // var_dump($query);
        // die();

        $this->db->select('a.id as id_tindakan, a.nama_tindakan, a.biaya, b.nm_jns_tindakan,
        CONCAT(b.nm_jns_tindakan, " / ", a.nama_tindakan ) as nm_tindakan
        ')
        ->from('m_nm_tindakan as a')
        ->join('m_jns_tindakan as b', 'b.id = a.id_m_jns_tindakan')
        ->like('nama_tindakan',$params)
        ->where('a.flag_active', '1');
        return $this->db->get()->result();
    }

    public function select2TindakanBU(){
        $params = $this->input->post('search_param'); 

        
        $this->db->select('a.id')
        ->from('m_tindakan as a')
        ->where('a.parent_id', 0);
        // ->where('a.flag_active', 1);
        $cekTindakan =  $this->db->get()->result();
        
         if($cekTindakan){
            foreach($cekTindakan as $tindakan){
            $list_id[] = $tindakan->id;  
            }
         }
        //  $list_id = ['1','2','8'];

        $this->db->select('a.*,a.id as id_tindakan,
        CONCAT(b.nm_jns_tindakan, " / ", a.nama_tindakan ) as nm_tindakan ')
        ->from('m_tindakan as a')
        ->join('m_jns_tindakan as b', 'b.id = a.id_m_jns_tindakan')
        ->like('nama_tindakan',$params)
        // ->or_like('b.nm_jns_tindakan',$params)
        ->where_in('a.parent_id', $list_id)
        ->where('a.flag_active', 1);
    return $this->db->get()->result();
    }

    public function select2Tindakan(){
        $params = $this->input->post('search_param'); 

        
        $this->db->select('a.id')
        ->from('m_tindakan as a')
        ->where('a.parent_id', 0);
        // ->where('a.flag_active', 1);
        $cekTindakan =  $this->db->get()->result();
        
         if($cekTindakan){
            foreach($cekTindakan as $tindakan){
            $list_id[] = $tindakan->id;  
            }
         }
        //  $list_id = ['1','2','8'];

        $this->db->select('a.*,a.id as id_tindakan,
        CONCAT(b.nm_jns_tindakan, " / ", (SELECT nama_tindakan FROM m_tindakan WHERE id = a.parent_id), " / ", a.nama_tindakan ) as nm_tindakan ')
        ->from('m_tindakan as a')
        ->join('m_jns_tindakan as b', 'b.id = a.id_m_jns_tindakan')
        ->like('nama_tindakan',$params)
        // ->or_like('b.nm_jns_tindakan',$params)
        // ->where_in('a.parent_id', $list_id)
        ->where('a.biaya is not null')
        ->where('a.flag_active', 1);
    return $this->db->get()->result();
    }



    public function selesaiTindakan(){
        $res['code'] = 0;
        $res['message'] = 'ok';
        $res['data'] = null;
        

        $id_pendaftaran = $this->input->post('id_pendaftaran');
 
        $this->db->trans_begin();

        $this->db->where('id_t_pendaftaran', $id_pendaftaran)
                ->update('t_tindakan', [
                    'updated_by' => $this->general_library->getId(),
                    'status' => 1
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


    public function getRincianTindakanss($id_pendaftaran){
        $list_parent_id = null;
        $data = null;
        $detail_tindakan = $this->db->select('a.*, b.nilai_normal, b.satuan, b.id_m_jns_tindakan, b.id as id_m_tindakan, b.parent_id, b.nama_tindakan')
                                ->from('t_tindakan a')
                                ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                                ->where('a.id_t_pendaftaran', $id_pendaftaran)
                                ->where('a.flag_active', 1)
                                ->where('b.flag_active', 1)
                                ->order_by('a.id', 'asc')
                                ->get()->result_array();
       
        if($detail_tindakan){
            foreach($detail_tindakan as $dt){
                    $list_parent_id[] = $dt['id_m_jns_tindakan'];  
            }
            $list_parent_id = array_unique($list_parent_id);
        }
        // var_dump($list_jns_tindakan);
        // die();

        if($list_parent_id){
            $jns_tindakan = $this->db->select('a.id,a.nm_jns_tindakan')
                                ->from('m_jns_tindakan as a')
                                ->where_in('a.id', $list_parent_id)
                                // ->where('a.flag_active', 1)
                                ->get()->result_array();
            if($jns_tindakan){
                foreach($jns_tindakan as $j){
                    $data[$j['id']] = $j;
                }
            }
            foreach($detail_tindakan as $dt){
                $data[$dt['id_m_jns_tindakan']]['detail_tindakan'][] = $dt;
            }
        }
        return $data;
    }

    public function getRincianTindakanBu($id_pendaftaran){
        $data = null;
        $list_parent = null;
        $list_id_top_parent = null;
        $list_top_parent = null;
        $tindakan = $this->db->select('a.*, b.parent_id, b.id_m_jns_tindakan, b.id as id_m_tindakan, a.nilai_normal')
                                    ->from('t_tindakan a')
                                    ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                                    ->where('a.id_t_pendaftaran', $id_pendaftaran)
                                    ->where('a.flag_active', 1)
                                    ->group_by('a.id')
                                    ->get()->result_array();
                                    // dd(json_encode($tindakan));
       
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
                            $data[$lp['id_m_jns_tindakan']]['tindakan'][$lp['id_m_nm_tindakan']]['detail_tindakan'][$t['id_m_nm_tindakan']] = $t;
                            array_splice($tindakan, $j, 1);
                            $j -= 1;
                        }
                        $j++;
                    }
                }
            }
        }
        $data = $this->keepSearchParent($data, $tindakan);
        // dd($data);
        // fungsi ini akan berhenti jika $tindakan sudah null; tapi belum ada contoh, jadi belum lanjut
        return $data;
    }

    public function keepSearchParent($data, $tindakan){
        if($tindakan){
            $list_parent = null;
            foreach($tindakan as $t){
                $list_parent[] = $t['parent_id_tindakan'];
            }
            foreach($data as $d){
                    
            }
        } else {
            return $data;
        }
    }
    
    public function getAllParents1($parent_id){
        $parent = array();
        $child = $this->db->select('*')
                        ->from('m_tindakan')
                        ->where('id', $parent_id)
                        ->get()->row_array();
                        // dd($child);
        $parent[] = $child;
        if ($child['parent_id'] == 0) {
            return $parent;
        } else {
            $push = $this->getAllParents1($child['parent_id']);
            array_push($parent, $push);
            return $parent;
        }  
    }

    public function getAllParentsss($tree, $list = []){
        // $list = array();
        if($tree['parent_id'] == 0){
            return $tree;
        } else {
            $pr = $this->db->select('*, id as id_m_nm_tindakan')
                            ->from('m_tindakan')
                            ->where('id', $tree['parent_id'])
                            ->get()->row_array();
            if($pr){
                $pr['children'][] = $tree;
                // $list = $pr;
                // $this->getAllParents($pr, $list);
                array_push($list, $this->getAllParents($pr, $list));
                return $list;
            }
        }
        // return $tree;
    }

    public function getAllParents($tree, $list = []){
        if($tree['parent_id'] != 0){
            $pr = $this->db->select('*, id as id_m_nm_tindakan')
                            ->from('m_tindakan')
                            ->where('id', $tree['parent_id'])
                            ->get()->row_array();
            if($pr){
                $pr['children'][] = $tree;
                $list = $pr;
                $this->getAllParents($list, $list);
            }
            return $list;
        }
        return $tree;
    }

    public function getRincianTindakan($id_pendaftaran, $id_tindakan = 0){
        $data = null;
        $parents = null;
        
        if($id_tindakan == 0){
            $parents = $this->db->select('a.*, b.parent_id, b.id_m_jns_tindakan, b.id as id_m_tindakan, a.nilai_normal, b.biaya')
                                ->from('t_tindakan a')
                                ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                                ->where('a.id_t_pendaftaran', $id_pendaftaran)
                                ->where('a.parent_id_tindakan', 0)
                                ->where('a.flag_active', 1)
                                ->group_by('a.id')
                                ->get()->result_array();
        } else {
            $parents = $this->db->select('a.*, b.parent_id, b.id_m_jns_tindakan, b.id as id_m_tindakan, a.nilai_normal, b.biaya')
                                ->from('t_tindakan a')
                                ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                                ->where('a.id_t_pendaftaran', $id_pendaftaran)
                                ->where('a.id', $id_tindakan)
                                ->where('a.parent_id_tindakan', 0)
                                ->where('a.flag_active', 1)
                                ->group_by('a.id')
                                ->get()->result_array();
        }

        $src_arr = $this->db->select('a.*, b.no_urut, a.id as id_t_tindakan')
                            ->from('t_tindakan a')
                            ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                            ->where('a.id_t_pendaftaran', $id_pendaftaran)
                            // ->where('a.parent_id_tindakan !=', 0)
                            ->where('a.flag_active', 1)
                            ->group_by('a.id')
                            ->get()->result_array();

        function arraySortByNoUrut($a, $b) {
            return $a['no_urut'] - $b['no_urut'];
        }

        $ids_top_parent = null;
        if($parents && $src_arr){
            $i = 0;
            foreach($parents as $pr){
                $ids_top_parent[] = $pr['parent_id'];
                $parents[$i]['children'] = $this->buildtree($src_arr, $pr['id_m_nm_tindakan'], []);
                if($parents[$i]['children']){
                    usort($parents[$i]['children'], 'arraySortByNoUrut');
                }
                $i++;
            }
        }
        // dd($src_arr);
        if($ids_top_parent){
            $list_top_parent = $this->db->select('*, id as id_m_nm_tindakan, parent_id as parent_id_tindakan')
                                    ->from('m_tindakan')
                                    ->where_in('id', $ids_top_parent)
                                    ->get()->result_array();
            if($list_top_parent){
                $i = 0;
                foreach($list_top_parent as $lp){
                    $data[$i] = $lp;
                    // if($i == 0){
                    //     dd(count($list_top_parent));
                    // }
                    // dd(json_encode($list_top_parent));
                    foreach($parents as $pr){
                        if($lp['id'] == $pr['parent_id']){
                            $data[$i]['children'][] = $pr;
                            // dd(json_encode($data[$i]));
                        }
                    }
                    $i++;
                }
                $temp_data = $data;
                // dd($temp_data);
                $i = 0;
                $data = null;
                foreach($temp_data as $ttp){
                    $data[$i] = $this->getAllParents1($ttp['parent_id']);
                    dd($data[$i]);
                    // while($data[$i]['parent_id'] != 0){
                    //     echo('searching....      ;');
                    //     $data[$i] = $this->getAllParents($ttp);
                    // }
                    $i++;
                }
                dd($data);
                $data = $this->mergeParents($data);
                // dd($data);
            }
        }
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // dd('');
        // dd($data);
        $final_data = null;
        // dd($data);
        $i = 0;
        if($data){
            foreach($data as $d){
                // $temp = $this->fetch_recursive($data);
                $temp = $this->getChild($data, $d['id']);
                if($temp){
                    foreach($temp as $t){
                        $final_data[] = $t; 
                    }
                }
                $i++;
            }
            if($final_data){
                $i = 0;
                $cip = 0;
                $list_padding = null;
                foreach($final_data as $f){
                    if(isset($f['id_m_jns_tindakan']) && $f['id_m_jns_tindakan'] == 0){
                        $final_data[$i]['padding-left'] = LEFT_PADDING_DEFAULT;
                    } else {
                        $list_padding[$f['id_m_nm_tindakan']] = LEFT_PADDING_RINCIAN_TINDAKAN;
                        
                        if((isset($f['parent_id_tindakan']) && $f['parent_id_tindakan'] == 0) || (isset($f['id_m_jns_tindakan']) && $f['id_m_jns_tindakan'] != 0)){
                            if(isset($list_padding[$f['parent_id']])){
                                $final_data[$i]['padding-left'] = floatval($list_padding[$f['parent_id']]) + LEFT_PADDING_RINCIAN_TINDAKAN;
                            } else {
                                $final_data[$i]['padding-left'] = LEFT_PADDING_RINCIAN_TINDAKAN;
                            }
                        } else {
                            $final_data[$i]['padding-left'] = floatval($list_padding[$f['parent_id_tindakan']]) + LEFT_PADDING_RINCIAN_TINDAKAN;
                        }
                        $list_padding[$f['id_m_nm_tindakan']] = $final_data[$i]['padding-left'];
                    }
                    $i++;
                }
            }
        }
        // dd($final_data);
        return $final_data;
    }

    public function mergeParents($data){
        $i = 0;
        $list_top_parent = array();
        $final_result = null;
        foreach($data as $d){
            if(isset($final_result[$d['id']])){
                if(count($d['children']) > 0){
                    foreach($d['children'] as $ch){
                        $final_result[$d['id']]['children'][] = $ch;
                    }
                }
            } else {
                $final_result[$d['id']] = $d;
            }
            $i++;
        }
        return $final_result;
    }

    public function getRincianTindakanForEdit($id_pendaftaran, $id_t_tindakan){
        $data = null;
        
        $parents = $this->db->select('a.*, b.parent_id, b.id_m_jns_tindakan, b.id as id_m_tindakan, a.nilai_normal, b.biaya')
                            ->from('t_tindakan a')
                            ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                            ->where('a.id_t_pendaftaran', $id_pendaftaran)
                            ->where('a.id', $id_t_tindakan)
                            ->where('a.parent_id_tindakan', 0)
                            ->where('a.flag_active', 1)
                            ->group_by('a.id')
                            ->get()->result_array();

        $src_arr = $this->db->select('a.*, b.no_urut, a.id as id_t_tindakan')
                            ->from('t_tindakan a')
                            ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                            ->where('a.id_t_pendaftaran', $id_pendaftaran)
                            ->where('a.parent_id_tindakan !=', 0)
                            ->where('a.flag_active', 1)
                            ->group_by('a.id')
                            ->get()->result_array();

        function arraySortByNoUrut($a, $b) {
            return $a['no_urut'] - $b['no_urut'];
        }
        $ids_top_parent = null;
        if($parents && $src_arr){
            $i = 0;
            foreach($parents as $pr){
                $ids_top_parent[] = $pr['parent_id'];
                $parents[$i]['children'] = $this->buildtree($src_arr, $pr['id_m_nm_tindakan'], []);
                if($parents[$i]['children']){
                    usort($parents[$i]['children'], 'arraySortByNoUrut');
                }
                $i++;
            }
        }

        if($ids_top_parent){
            $list_top_parent = $this->db->select('*')
                                    ->from('m_tindakan')
                                    ->where_in('id', $ids_top_parent)
                                    ->get()->result_array();
            if($list_top_parent){
                $i = 0;
                foreach($list_top_parent as $lp){
                    $data[$i] = $lp;
                    foreach($parents as $pr){
                        if($lp['id'] == $pr['parent_id']){
                            $data[$i]['children'][] = $pr;
                        }
                    }
                    $i++;
                }
            }
        }
       
        $final_data = null;
        $i = 0;
        if($data){
            foreach($data as $d){
                // $temp = $this->fetch_recursive($data);
                $temp = $this->getChild($data, $d['id']);
                if($temp){
                    foreach($temp as $t){
                        $final_data[] = $t; 
                    }
                }
                $i++;
            }
            if($final_data){
                $i = 0;
                $cip = 0;
                $list_padding = null;
                foreach($final_data as $f){
                    if(isset($f['id_m_jns_tindakan']) && $f['id_m_jns_tindakan'] == 0){
                        $final_data[$i]['padding-left'] = LEFT_PADDING_DEFAULT;
                    } else {
                        $list_padding[$f['id_m_nm_tindakan']] = LEFT_PADDING_RINCIAN_TINDAKAN;
                        if(($f['parent_id_tindakan'] == 0) || (isset($f['id_m_jns_tindakan']) && $f['id_m_jns_tindakan'] != 0)){
                            if(isset($list_padding[$f['parent_id']])){
                                $final_data[$i]['padding-left'] = floatval($list_padding[$f['parent_id']]) + LEFT_PADDING_RINCIAN_TINDAKAN;
                            } else {
                                $final_data[$i]['padding-left'] = LEFT_PADDING_RINCIAN_TINDAKAN;
                            }
                        } else {
                            $final_data[$i]['padding-left'] = floatval($list_padding[$f['parent_id_tindakan']]) + LEFT_PADDING_RINCIAN_TINDAKAN;
                        }
                        $list_padding[$f['id_m_nm_tindakan']] = $final_data[$i]['padding-left'];
                    }
                    $i++;
                }
            }
        }
        return $final_data;
    }

    public function getChild($tree, $parent_id = 0, $list = array()){
        foreach($tree as $t){
            if(isset($t['parent_id']) && $t['parent_id'] == $parent_id){
                $temp = $t;
                unset($temp['children']);
                $list[] = $temp;
                if(count($t['children']) > 0){
                    $list = array_merge($list, $this->getChild($t['children'], $t['id_m_nm_tindakan']));
                }
            } else if (isset($t['parent_id_tindakan']) && $t['parent_id_tindakan'] == $parent_id) {
                $temp = $t;
                unset($temp['children']);
                $list[] = $temp;
                if(count($t['children']) > 0){
                    $list = array_merge($list, $this->getChild($t['children'], $t['id_m_nm_tindakan']));
                }
            } else if($t['id'] == $parent_id) {
                $temp = $t;
                unset($temp['children']);
                $list[] = $temp;
                if(count($t['children']) > 0){
                    $list = array_merge($list, $this->getChild($t['children'], $t['id']));
                }
            }
            // dd($t);
        }
        return $list;
    }

    function fetch_recursive($tree, $parent_id = 0, $parentfound = false, $list = array())
    {
        foreach($tree as $k => $v)
        {
            if($parentfound || $k == $parent_id)
            {
                $rowdata = array();
                foreach($v as $field => $value)
                    if($field != 'children')
                        $rowdata[$field] = $value;
                $list[] = $rowdata;
                if(count($v['children']) > 0)
                    $list = array_merge($list, $this->fetch_recursive($v['children'], $parent_id, true));
            }
            elseif(count($v['children']) > 0)
                $list = array_merge($list, $this->fetch_recursive($v['children'], $parent_id));
        }
        return $list;
    }

    public function buildtree($src_arr, $parent_id = 0, $tree = array()){
        foreach($src_arr as $idx => $row)
        {
            if($row['parent_id_tindakan'] == $parent_id)
            {
                foreach($row as $k => $v)
                    $tree[$row['id']][$k] = $v;
                unset($src_arr[$idx]);
                $tree[$row['id']]['children'] = $this->buildtree($src_arr, $row['id_m_nm_tindakan']);
            }
        }
        ksort($tree);
        return $tree;
    }

    public function createHasil($id_t_tindakan, $data, $id_pendaftaran)
    {
        $this->db->where('id', $id_t_tindakan)
                ->where('id_t_pendaftaran', $id_pendaftaran);
        $result = $this->db->update('t_tindakan', $data);        
    }

    public function buildDataPrintTindakan($data){
        $result = null;
        $i = 0;
        foreach($data as $d){
           
            $result[$i] = $d;
            $result[$i]['page'] = 1;
           

            if($d['tindakan']){
                unset($result[$i]['tindakan']);
                $i++;
                foreach($d['tindakan'] as $tind){
                    $result[$i] = $tind;
                    $result[$i]['page'] = 1;
                    $i++;
                    if(isset($tind['detail_tindakan'])){
                        unset($result[$i]['detail_tindakan']);
                        // $i++;
                        foreach($tind['detail_tindakan'] as $dtin){
                            $result[$i] = $dtin;
                            $result[$i]['page'] = 1;
                            $i++;
                        } 
                    }
                }
                
            }
        }
      
        $i = 0;
        $last_parent_index = 0;
        $last_jns_index = 0;
        $current_page = 0;
        $final_result = null;
        foreach($result as $rs){

            if(isset($result[$i]['nm_jns_tindakan'])){
                $last_jns_index = $i;
                if($result[$i]['id'] == 27){
                    unset($result[$i]);
                }
            }
           
            if(isset($result[$i]['id_t_pendaftaran']) && $result[$i]['parent_id_tindakan'] == '0'){
                $last_parent_index = $i;
                if($result[$i]['id_m_jns_tindakan'] == 27){
                    unset($result[$i]);
                }
               
            }
            //hitung sekarang page berapa
            $result[$i]['page'] = intval(($i / ROW_PER_PAGE_CETAK_TINDAKAN) + 1);
            $current_page = $result[$i]['page'];
            //masukkan data ke index final_result dimana index == page 
            $final_result[$current_page][] = $result[$i];
            //jika halaman data current index != data current index sebelumnya, samakan halaman data ini dengan parent dari data ini
            if(isset($result[$i-1]) && 
                (intval($result[$i]['page']) != intval($result[$i-1]['page']))
            ){
                $final_result[$current_page] = null;
                //jika data sebelum parent ini adalah data jns, samakan halaman data jns dengan data parent ini  
                if(($last_parent_index - 1) == $last_jns_index){
                    $result[$last_jns_index]['page'] = $current_page;
                    $final_result[$current_page][] = $result[$last_jns_index];
                    //hapus data jns di halaman sebelumnya
                    unset($final_result[$current_page-1][$last_jns_index]);
                }
                //ambil data parent, dan samakan halaman dengan data ini
                for($j = $last_parent_index; $j <= $i; $j++){
                    $result[$j]['page'] = $result[$i]['page'];
                    $final_result[$current_page][] = $result[$j];
                    //hapus data parent di halaman sebelumnya
                    unset($final_result[$current_page-1][$j]);
                }
            }
            $i++;
            
           
        }
        return [$final_result, $current_page];
    }

    public function buildDataPrintTindakanNew($data){
        $result = null;
        $i = 0;
        foreach($data as $d){
            $result[$i] = $d;
            $result[$i]['page'] = 1;
            $i++;
        }
        $i = 0;
        $last_parent_index = 0;
        $last_jns_index = 0;
        $current_page = 0;
        $final_result = null;
        foreach($result as $rs){
            if(isset($result[$i]['id_m_jns_tindakan']) && $result[$i]['id_m_jns_tindakan'] == 0){
                $last_jns_index = $i;
                if($result[$i]['id'] == 27){
                    unset($result[$i]);
                }
            }
           
            if(isset($result[$i]['id_t_pendaftaran']) && $result[$i]['parent_id_tindakan'] == '0'){
                $last_parent_index = $i;
                if($result[$i]['id_m_jns_tindakan'] == 27){
                    unset($result[$i]);
                }
               
            }

            //hitung sekarang page berapa
            $result[$i]['page'] = intval(($i / ROW_PER_PAGE_CETAK_TINDAKAN) + 1);
            $current_page = $result[$i]['page'];
            //masukkan data ke index final_result dimana index == page 
            $final_result[$current_page][] = $result[$i];
            //jika halaman data current index != data current index sebelumnya, samakan halaman data ini dengan parent dari data ini
            if(isset($result[$i-1]) && 
                (intval($result[$i]['page']) != intval($result[$i-1]['page']))
            ){
                $final_result[$current_page] = null;
                //jika data sebelum parent ini adalah data jns, samakan halaman data jns dengan data parent ini  
                if(($last_parent_index - 1) == $last_jns_index){
                    $result[$last_jns_index]['page'] = $current_page;
                    $final_result[$current_page][] = $result[$last_jns_index];
                    //hapus data jns di halaman sebelumnya
                    unset($final_result[$current_page-1][$last_jns_index]);
                }
                //ambil data parent, dan samakan halaman dengan data ini
                for($j = $last_parent_index; $j <= $i; $j++){
                    $result[$j]['page'] = $result[$i]['page'];
                    $final_result[$current_page][] = $result[$j];
                    //hapus data parent di halaman sebelumnya
                    unset($final_result[$current_page-1][$j]);
                }
            }
            $i++;
           
        }
        return [$final_result, $current_page];
    }

    public function getDataForEditTindakan($id){
        $parent = $this->db->select('*')
                        ->from('t_tindakan')
                        ->where('id', $id)
                        ->where('flag_active', 1)
                        ->get()->row_array();
        // $child = $this->db->select('*')
        //                 ->from('t_tindakan')
        //                 ->where('parent_id_tindakan', $parent['id_m_nm_tindakan'])
        //                 ->where('flag_active', 1)
        //                 ->get()->result_array();
        return [$parent, null];
    }
       
}
?>