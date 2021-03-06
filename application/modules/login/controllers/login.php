<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        
        parent::__construct();
        if($this->session->userdata('is_login'))redirect('home');
    }
	public function index($param='')
	{
		if($param == 'error')
			$param = 'Incorrect username or password';
			
		$data = array('title'=>'Login','message'=>$param,'base_url'=>base_url());
		$this->load->view('login',$data);
	}
	
	
	public function do_login(){


		$data = $this->input->post(null,true);
		$is_login = $this->db->get_where('user',array(
										'username'=>$data['username'],
										'password'=>md5(trim($data['password'])),
										))->row();
		if($is_login){
			
			$session_set = array(
				
				'is_login'	=> true,
				'nama'		=> $is_login->nama,
				'nik'		=> $is_login->nik,
				'id_user'	=> $is_login->id_user,
				'username'	=> $is_login->username,
				'jabatan_id'=> $is_login->jabatan_id,
				'photo'      => $is_login->photo
			);
			$this->db->update('user',array('last_login'=>date('Y-m-d H:i:s')),array('id_user'=>$is_login->id_user));
			$this->session->set_userdata($session_set);
			redirect('home');
		}else{
			
			redirect('login/index/error');
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
