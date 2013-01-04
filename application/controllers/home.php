<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

    function __construct()
    {  
        parent::__construct();
        if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
        $this->load->view('partials/header', $this->headerViewData());
    }  
	
	public function index()
	{
		$this->load->view('home');
		$this->load->view('partials/footer');
	}
	
}

