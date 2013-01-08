<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends MY_Controller {

    function __construct()
    {  
        parent::__construct();
        if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
        $this->load->library('form_validation');
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
        if (!$this->input->post()):
            $this->messages->add('There was a problem with your upload.', 'error');
            redirect('photo');
        else:
            $post = $this->input->post();
            $post['user_id'] = '';

            $id = $this->mongo_db->insert('photos', $post);

        endif;
        redirect('photo');
    }

    // Archive a photo
    public function delete($id)
    {
        // Rather than straight up delete it, we'll mark it for archive.
        if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');

        $id = new MongoId($id);
        $success = $this->mongo_db
            ->where(array('_id' => $id))
            ->set(array('archived' => true))
            ->update('photos');
	
        if ($success)
            $this->messages->add('Photo deleted.', 'error');
        else
            $this->messages->add('There was a problem with your deletion.', 'error');
        redirect('photo');
    }
}

