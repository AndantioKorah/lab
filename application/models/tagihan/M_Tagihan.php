<?php
	class M_Tagihan extends CI_Model
	{
        public $bios_serial_num;

        public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function countTagihan($id_t_pendaftaran){
            $this->db->trans_begin();

            $new_total_tagihan = 0;
            $sisa_harus_bayar = 0;
            $tagihan = $this->db->select('a.*, b.id_m_cara_bayar')
                                ->from('t_tagihan a')
                                ->join('t_pendaftaran b', 'a.id_t_pendaftaran = b.id')
                                ->where('a.id_t_pendaftaran', $id_t_pendaftaran)
                                ->where('a.flag_active', 1)
                                ->limit(1)
                                ->get()->row_array();
            if($tagihan && $tagihan['id_m_status_tagihan'] == 1 && $tagihan['id_m_cara_bayar'] == 1){
                $detail_tagihan = $this->db->select('*')
                                        ->from('t_tagihan_detail')
                                        ->where('id_t_pendaftaran', $id_t_pendaftaran)
                                        ->where('flag_active', 1)
                                        ->get()->result_array();

                $pembayaran = $this->db->select('*')
                                        ->from('t_pembayaran')
                                        ->where('id_t_pendaftaran', $id_t_pendaftaran)
                                        ->where('flag_active', 1)
                                        ->limit(1)
                                        ->get()->row_array();

                $uang_muka = $this->db->select('*')
                                        ->from('t_uang_muka')
                                        ->where('id_t_pendaftaran', $id_t_pendaftaran)
                                        ->where('flag_active', 1)
                                        ->limit(1)
                                        ->get()->row_array();

                $new_total_tagihan = 0;
                if($detail_tagihan){
                    foreach($detail_tagihan as $dt){
                        $new_total_tagihan += floatval($dt['biaya']);
                    }
                }
                $this->db->where('id_t_pendaftaran', $id_t_pendaftaran)
                            ->update('t_tagihan', 
                        [
                            'total_tagihan' => $new_total_tagihan,
                            'updated_by' => $this->general_library->getId()
                        ]);

                $sisa_harus_bayar = $new_total_tagihan;
                if($uang_muka){
                    $sisa_harus_bayar = $sisa_harus_bayar - floatval($uang_muka['jumlah_pembayaran']);
                }
                if($pembayaran){
                    $sisa_harus_bayar = $sisa_harus_bayar - floatval($pembayaran['jumlah_pembayaran']) - floatval($pembayaran['diskon_nominal']);
                }
            }

            
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }

            return $sisa_harus_bayar;
        }

        public function getRincianTagihanBu($id_pendaftaran){
            $list_jns_tindakan = null;
            $data = null;
            $temp_data = null;
            $detail_tagihan = $this->db->select('a.*, b.id_m_nm_tindakan, c.id_m_jns_tindakan')
                                    ->from('t_tagihan_detail a')
                                    ->join('t_tindakan b', 'a.id_reference = b.id')
                                    ->join('m_tindakan c', 'b.id_m_nm_tindakan = c.id')
                                    ->where('a.id_t_pendaftaran', $id_pendaftaran)
                                    ->where('a.flag_active', 1)
                                    ->where('b.flag_active', 1)
                                    ->order_by('a.created_by', 'desc')
                                    ->get()->result_array();
            if($detail_tagihan){
                foreach($detail_tagihan as $dt){
                    $list_jns_tindakan[] = $dt['id_m_jns_tindakan'];
                }
                $list_jns_tindakan = array_unique($list_jns_tindakan);
            }

            if($list_jns_tindakan){
                $jns_tindakan = $this->db->select('*')
                                    ->from('m_jns_tindakan')
                                    ->where_in('id', $list_jns_tindakan)
                                    // ->where('flag_active', 1)
                                    ->get()->result_array();
                if($jns_tindakan){
                    foreach($jns_tindakan as $j){
                        $data[$j['id']] = $j;
                        $data[$j['id']]['total_biaya'] = 0;
                    }
                }
                foreach($detail_tagihan as $dt){
                    $dt['detail_tindakan'] = json_decode($dt['detail_tindakan']);
                    $data[$dt['id_m_jns_tindakan']]['total_biaya'] += $dt['biaya'];
                    $data[$dt['id_m_jns_tindakan']]['detail_tagihan'][] = $dt;
                }
            }
            // $temp_data = $this->makeAllParent($data);
            // $pages = intval((count($temp_data) / ROW_PER_PAGE_CETAK_TAGIHAN) + 1);
            // dd($temp_data);
            return $data;
        }

        public function getRincianTagihan($id_pendaftaran){
            $ids_parent = null;
            $data = null;
            $list_parent = null;
            $final_data = null;
            $detail_tagihan = $this->db->select('a.*, b.id_m_nm_tindakan, c.id_m_jns_tindakan, c.parent_id')
                                    ->from('t_tagihan_detail a')
                                    ->join('t_tindakan b', 'a.id_reference = b.id')
                                    ->join('m_tindakan c', 'b.id_m_nm_tindakan = c.id')
                                    ->where('a.id_t_pendaftaran', $id_pendaftaran)
                                    ->where('a.flag_active', 1)
                                    ->where('b.flag_active', 1)
                                    ->order_by('a.created_by', 'desc')
                                    ->get()->result_array();
            if($detail_tagihan){
                foreach($detail_tagihan as $dt){
                    $ids_parent[] = $dt['parent_id'];
                }
                $ids_parent = array_unique($ids_parent);
            }

            if($ids_parent){
                $list_parent = $this->db->select('*, id as id_m_nm_tindakan')
                                        ->from('m_tindakan')
                                        ->where_in('id', $ids_parent)
                                        // ->where('flag_active', 1)
                                        ->get()->result_array();
                if($list_parent){
                    $i = 0;
                    $data = null;
                    foreach($list_parent as $lp){
                        $data[$lp['id']] = $lp;
                    }

                    foreach($detail_tagihan as $dt){
                        $data[$dt['parent_id']]['children'][] = $dt;
                    }
                    // dd($data);
                    // foreach($list_parent as $lp){
                    //     $data[$i] = $lp;
                    //     $j = 0;
                    //     foreach($detail_tagihan as $dt){
                    //         if($dt['parent_id'] == $lp['id']){
                    //             $data[$i]['children'][] = $dt;
                    //             unset($detail_tagihan[$j]);
                    //         } else {
                    //             $data[$i]['children'][] = $dt;
                    //         }
                    //         $j++;
                    //     }
                    //     $i++;
                    // }
                    
                    if(count($data) > 0){
                        $temp_data = $data;
                        $data = null;
                        foreach($temp_data as $d){
                            $data[] = $this->getAllParents($d);
                        }
                        $data = mergeParents($data);
                    }
                    if($data){
                        $temp_data = $data;
                        $data = array();
                        foreach($temp_data as $d){
                            $temp = $this->getChild($temp_data, $d['id']);
                            if($temp){
                                foreach($temp as $t){
                                    $final_data[] = $t; 
                                }
                            }
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
                    if(isset($t['children']) && count($t['children']) > 0){
                        // if(!isset($t['id_m_nm_tindakan'])){
                        //     dd($t);
                        // }
                        $list = array_merge($list, $this->getChild($t['children'], $t['id_m_nm_tindakan']));
                    }
                } else if (isset($t['parent_id_tindakan']) && $t['parent_id_tindakan'] == $parent_id) {
                    $temp = $t;
                    unset($temp['children']);
                    $list[] = $temp;
                    if(isset($t['children']) && count($t['children']) > 0){
                        $list = array_merge($list, $this->getChild($t['children'], $t['id_m_nm_tindakan']));
                    }
                } else if($t['id'] == $parent_id) {
                    $temp = $t;
                    unset($temp['children']);
                    $list[] = $temp;
                    if(isset($t['children']) && count($t['children']) > 0){
                        $list = array_merge($list, $this->getChild($t['children'], $t['id']));
                    }
                }
                // dd($t);
            }
            return $list;
        }

        public function getAllParents($tree){
            if($tree['parent_id'] != 0){
                $pr = $this->db->select('*, id as id_m_nm_tindakan')
                            ->from('m_tindakan')
                            ->where('id', $tree['parent_id'])
                            ->get()->row_array();
                $pr['children'][] = $tree;
                $push = $this->getAllParents($pr);
                return $push;
            } else {
                return $tree;
            }
        }

        public function buildDataRincianTagihan($data, $new_format = 0){
            $result = null;
            $i = 0;
            foreach($data as $d){
                $result[$i] = $d;
                $result[$i]['page'] = 1;
                if($d['detail_tagihan']){
                    unset($result[$i]['detail_tagihan']);
                    $i++;
                    foreach($d['detail_tagihan'] as $dtag){
                        $result[$i] = $dtag;
                        $result[$i]['page'] = 1;
                        if($dtag['detail_tindakan']){
                            unset($result[$i]['detail_tindakan']);
                            $i++;
                            if($new_format != 1){
                                foreach($dtag['detail_tindakan'] as $dtin){
                                    $result[$i]['nama_tindakan'] = $dtin;
                                    $result[$i]['page'] = 1;
                                    $i++;
                                }
                            }
                        }
                    }
                }
            }
            if($new_format == 1){
                return [$result, 0];
            }
            // $pages = intval((count($temp_data) / ROW_PER_PAGE_CETAK_TAGIHAN) + 1);
            $i = 0;
            $last_parent_index = 0;
            $last_jns_index = 0;
            $current_page = 0;
            $final_result = null;
            foreach($result as $rs){
                if(isset($result[$i]['nm_jns_tindakan'])){
                    $last_jns_index = $i;
                }
                if(isset($result[$i]['id_t_tagihan'])){
                    $last_parent_index = $i;
                }
                //hitung sekarang page berapa
                $result[$i]['page'] = intval(($i / ROW_PER_PAGE_CETAK_TAGIHAN) + 1);
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
            // foreach($data as $d){
            //     $result[] = $d;
            //     if($d['detail_tagihan']){
            //         foreach($d['detail_tagihan'] as $dtag){
            //             $result[] = $dtag;
            //             if($dtag['detail_tindakan']){
            //                 foreach($dtag['detail_tindakan'] as $dtin){
            //                     $result[] = $dtin;
            //                 }
            //             }
            //         }
            //     }
            // }
            // $i = 0;
            // foreach($result as $rs){
            //     if(isset($result[$i]['detail_tagihan'])){
            //         unset($result[$i]['detail_tagihan']);
            //     } else if(isset($result[$i]['detail_tindakan'])){
            //         unset($result[$i]['detail_tindakan']);
            //     }
            //     $i++;
            // }
            // dd($final_result);
            return [$final_result, $current_page];
        }
	}
?>