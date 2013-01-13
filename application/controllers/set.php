<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set extends MY_Controller {

    function __construct()
    {  
        parent::__construct();
        if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
        $this->load->library('form_validation');
        $this->load->view('partials/header', $this->headerViewData());
    }

	public function index($id=false)
	{
        if (!$id):
            // List all available sets 
            $this->data['sets'] = $this->mongo_db   
                ->get('set');

            $this->load->view('set/index', $this->data);
            $this->load->view('partials/footer');
            return;
        endif;

        // List specific set
        $this->data['sets'] = $this->mongo_db   
            ->where('set', $id)
            ->get('set');

        var_dump($this->data['sets']);
        $this->load->view('set/index', $this->data);
        $this->load->view('partials/footer');
    }

    // POST a new set via form
    public function add()
    {
        if (!$this->input->post()):
            $this->messages->add('There was a problem with your request.', 'error');
            redirect('set');
        else:
            $post = $this->input->post();
            $user = $this->ion_auth->user()->row();
            $username = $user->username;
            $userid = $user->id->{'$id'};
            
            // TODO: simple validation
             
            $id = $this->mongo_db->insert('set', $post);

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

