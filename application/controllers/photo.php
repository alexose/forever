<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends MY_Controller {

    function __construct()
    {  
        parent::__construct();
        if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
        $this->load->view('partials/header', $this->headerViewData());
    }

	public function index()
	{
        // List all available photos

        // Example insert
        // $id = $this->mongo_db->insert($this->collections['users'], $data);

        $userid = '50e3897058a399235c000000';

        // Example read
        $this->data['photos'] = $this->mongo_db   
            ->where('owner_id', $userid)
            ->get('photos');

        //var_dump($this->data);

		$this->load->view('photo/index', $this->data);
		$this->load->view('partials/footer');
	
    }

    // POST a photo via form
    public function add()
    {
        if (!isset($this->input->post)):
            $this->messages->add('There was a problem with your upload.', 'error');
            redirect('photo');
        endif;

		$this->load->view('photo/index', $this->data);
		$this->load->view('partials/footer');

    }

    // DELETE a photo
    public function delete($id)
    {
        if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');

		$this->load->view('photo/index', $this->data);
		$this->load->view('partials/footer');
    }
}

