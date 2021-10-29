<?php

class C_Error extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('general/M_General', 'general');
    }

    public function catchErrorException(){
        $data = json_decode($this->input->post(), true);
        
        dd('asd');
    }
}
