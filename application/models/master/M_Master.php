<?php
	class M_Master extends CI_Model
	{
		public function __construct()
        {
            parent::__construct();
            $this->db = $this->load->database('main', true);
        }

        public function insert($tablename, $data){
            $this->db->insert($tablename, $data);
        }

        public function insertJenisPemeriksaan(){
            $data = array(
                'nm_jns_tindakan' => $this->input->post('nm_jns_tindakan'),
                'created_by' => $this->general_library->getId()
            );
            $this->db->insert('m_jns_tindakan', $data);

            $dataMtindakan = array(
                'nama_tindakan' => $this->input->post('nm_jns_tindakan'),
                'id_m_jns_tindakan' => 0,
                'flag_active' => 0,
                'created_by' => $this->general_library->getId()
            );
            $this->db->insert('m_tindakan', $dataMtindakan);


        }

        public function deleteJenisPemeriksaan($id){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();
            $this->db->where('id', $id)
                        ->update('m_jns_tindakan',
                        [
                            'flag_active' => 0,
                            'updated_by' => $this->general_library->getId()
                        ]); 
            

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function getMasterTindakan()
        {
            $this->db->select('b.nm_jns_tindakan, a.nama_tindakan, a.biaya, a.nilai_normal, a.satuan,
            a.id as id_tindakan,
            (SELECT (nama_tindakan) FROM m_tindakan where id = a.parent_id and parent_id != 0 and flag_active = 1 limit 1)  as nama_tindakan_parent')
            ->join('m_jns_tindakan as b', 'b.id = a.id_m_jns_tindakan')
            ->where('a.flag_active', 1)
            ->order_by('a.id_m_jns_tindakan', 'asc')
            ->from('m_tindakan as a');
            return $this->db->get()->result_array(); 
        }


        public function createMasterTindakan(){


            $this->db->select('a.nm_jns_tindakan')
            ->from('m_jns_tindakan as a')
            ->where('a.id', $this->input->post('id_m_jns_tindakan'));
             $jnsPemeriksaan =  $this->db->get()->result();
            
              $nama_jns_tindakan = $jnsPemeriksaan[0]->nm_jns_tindakan;
            
             $this->db->select('a.id')
             ->from('m_tindakan as a')
             ->like('a.nama_tindakan', $jnsPemeriksaan[0]->nm_jns_tindakan)
             ->limit(1);
              $parent =  $this->db->get()->result();
             
              if($this->input->post('parent') == 0 || $this->input->post('parent') == ""){
              $parent_id = $parent[0]->id;
              } else {
              $parent_id = $this->input->post('parent');
              }
        
              if($this->input->post('biaya') == 0 || $this->input->post('biaya') == ""){
                $biaya = null;
                } else {
                $biaya = $this->input->post('biaya');
                }  
                
                
              if($this->input->post('nilai_normal') == ""){
                $nilai_normal = null;
                } else {
                $nilai_normal = $this->input->post('nilai_normal');
                }   
                
                if($this->input->post('satuan') == ""){
                $satuan = null;
                } else {
                $satuan = $this->input->post('satuan');
                }  
               

            $data = array(
                'id_m_jns_tindakan' => $this->input->post('id_m_jns_tindakan'),
                'nama_tindakan' => $this->input->post('nama_tindakan'),
                'biaya' => $biaya,
                'nilai_normal' => $nilai_normal,
                'satuan' => $satuan,
                'parent_id' => $parent_id,
                'created_by' => $this->general_library->getId()
            );
            $this->db->insert('m_tindakan', $data);
        }

        
        public function deleteMasterTindakan($id){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();
            $this->db->where('id', $id)
                        ->update('m_tindakan',
                        [
                            'flag_active' => 0,
                            'updated_by' => $this->general_library->getId()
                        ]); 
            

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        function get_option() {
            $this->db->select('*');
            $this->db->from('m_jns_tindakan');
            $this->db->where('flag_active',1);
            $query = $this->db->get();
            return $query->result();
        }

        function get_option_parent() {
            $this->db->select('a.*,
            CONCAT(b.nm_jns_tindakan, " / ", a.nama_tindakan, " / ", a.id ) as nm_tindakan ');
            
            
            $this->db->from('m_tindakan as a');
            $this->db->join('m_jns_tindakan as b', 'b.id = a.id_m_jns_tindakan');
            $this->db->where('a.flag_active',1);
            $this->db->where('a.nilai_normal',null);
            $query = $this->db->get();
            return $query->result();
        }

        public function getMasterTindakanEdit($id){
            return $this->db->select('a.*, b.id as id_jns_tindakan, a.id as id_tindakan, b.nm_jns_tindakan')
                            ->from('m_tindakan a')
                            ->join('m_jns_tindakan b', 'a.id_m_jns_tindakan = b.id')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            ->limit(1)
                            ->get()->row_array();
        }

        public function editMasterTindakanSubmit(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $datapost = $this->input->post();
            
            $this->db->trans_begin();
            $id_tindakan = $datapost['id_tindakan'];

            $data["nama_tindakan"] = $datapost["nama_tindakan"]; 
            if($datapost["biaya"] == ""){
                $data["biaya"] = null;
            } else {
                $data["biaya"] = $datapost["biaya"];
            }
           
            $data["nilai_normal"] = $datapost["nilai_normal"];
            $data["satuan"] = $datapost["satuan"]; 

            $this->db->where('id', $id_tindakan)
                    ->update('m_tindakan', $data);

                    $this->db->where('id', $id_tindakan)
                    ->update('m_tindakan',
                    [
                        'updated_by' => $this->general_library->getId()
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

        public function insertMasterDokter(){
            $data = array(
                'nama_dokter' => $this->input->post('nama_dokter'),
                'nomor_telepon' => $this->input->post('nomor_telepon'),
                'alamat' => $this->input->post('alamat'),
                'fee' => $this->input->post('fee'),
                'created_by' => $this->general_library->getId()
            );
            $this->db->insert('m_dokter', $data);
        }

        public function deleteMasterDokter($id){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();
            $this->db->where('id', $id)
                        ->update('m_dokter',
                        [
                            'flag_active' => 0,
                            'updated_by' => $this->general_library->getId()
                        ]); 
            

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }

        public function getMasterDokterEdit($id){
            return $this->db->select('a.*, a.id as id_dokter')
                            ->from('m_dokter a')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->limit(1)
                            ->get()->row_array();
        }

        public function editMasterDokter(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $datapost = $this->input->post();
            
            $this->db->trans_begin();
            $id_dokter = $datapost['id_dokter'];

            $data["nama_dokter"] = $datapost["nama_dokter"]; 
            $data["nomor_telepon"] = $datapost["nomor_telepon"];
            $data["alamat"] = $datapost["alamat"];
            $data["fee"] = $datapost["fee"];


            $this->db->where('id', $id_dokter)
                    ->update('m_dokter', $data);

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


        public function select2Tindakan(){
            $params = $this->input->post('search_param'); 
    
            
  
            $this->db->select('a.*,a.id as id_tindakan,
            (select nama_tindakan from m_tindakan where id = a.parent_id) as parent,
            CONCAT(b.nm_jns_tindakan, " / ", a.nama_tindakan ) as nm_tindakan ')
            ->from('m_tindakan as a')
            ->join('m_jns_tindakan as b', 'b.id = a.id_m_jns_tindakan')
            ->like('nama_tindakan',$params)
            ->where('a.flag_active', 1);
        return $this->db->get()->result();
        }

        public function getMasterNilaiNormal()
        {
            $this->db->select('a.*, b.nama_tindakan, a.id as id_m_nilai_normal,
            (select nama_tindakan from m_tindakan where id = b.parent_id) as parent')
            ->join('m_tindakan as b', 'b.id = a.id_m_nm_tindakan')
            ->where('a.flag_active', 1)
            ->from('m_nilai_normal as a');
            return $this->db->get()->result_array(); 
        }


        public function createMasterNilaiNormal(){

              if($this->input->post('jenis_kelamin') == ""){
                $jenis_kelamin = null;
                } else {
                $jenis_kelamin = $this->input->post('jenis_kelamin');
                }  
                
                
              if($this->input->post('umur') == ""){
                $umur = null;
                } else {
                $umur = $this->input->post('umur');
                }   
                
            $data = array(
                'id_m_nm_tindakan' => $this->input->post('tindakan'),
                'jenis_kelamin' => $jenis_kelamin,
                'umur' => $umur,
                'nilai_normal' => $this->input->post('nilai_normal'),
                'created_by' => $this->general_library->getId()
            );
            $this->db->insert('m_nilai_normal', $data);

            $this->db->where('id', $this->input->post('tindakan'))
            ->update('m_tindakan',
            [
                'flag_m_nilai_normal' => 1,
                'updated_by' => $this->general_library->getId()
            ]); 
        }


        public function getMasterNilaiNormalEdit($id){
            return $this->db->select('a.*, b.nama_tindakan, a.id as id_m_nilai_normal,
            (select nama_tindakan from m_tindakan where id = b.parent_id) as parent')
                            ->from('m_nilai_normal a')
                            ->join('m_tindakan b', 'a.id_m_nm_tindakan = b.id')
                            ->where('a.id', $id)
                            ->where('a.flag_active', 1)
                            ->where('b.flag_active', 1)
                            ->limit(1)
                            ->get()->row_array();
        }

        public function editMasterNilaiNormalSubmit(){
            $res['code'] = 0;
            $res['message'] = 'ok';
            $res['data'] = null;

            $datapost = $this->input->post();
            
            $this->db->trans_begin();
            $id_m_nilai_normal = $datapost['id_m_nilai_normal'];
            
            if($datapost["nilai_normal"] == ""){
                $data["umur"] = null; 
            } else {
                $data["nilai_normal"] = $datapost["nilai_normal"]; 
            }

            if($datapost["jenis_kelamin"] == ""){
                $data["jenis_kelamin"] = null;  
            } else {
                $data["jenis_kelamin"] = $datapost["jenis_kelamin"];   
            }

            if($datapost["umur"] == ""){
                $data["umur"] = null;
            } else {
                $data["umur"] = $datapost["umur"]; 
            }
        
            $this->db->where('id', $id_m_nilai_normal)
                    ->update('m_nilai_normal', $data);

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

        public function deleteMasterNilaiNormal($id){
            $rs['code'] = 0;
            $rs['message'] = 'OK';

            $this->db->trans_begin();
            $this->db->where('id', $id)
                        ->update('m_nilai_normal',
                        [
                            'flag_active' => 0,
                            'updated_by' => $this->general_library->getId()
                        ]); 
            

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $rs['code'] = 1;
                $rs['message'] = 'Terjadi Kesalahan';
            } else {
                $this->db->trans_commit();
            }

            return $rs;
        }


    
	}
?>