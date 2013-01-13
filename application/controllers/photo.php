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
            $user = $this->ion_auth->user()->row();
            $username = $user->username;
            $userid = $user->id->{'$id'};
            $post['user_id'] = $userid;

            // TODO: simple validation

            // Upload file to S3
            $config['upload_path'] = './temp/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '1000000';
            $config['max_width']  = '1024000';
            $config['max_height']  = '768000';            
            $this->load->library('upload', $config); 
           
            if (!$this->upload->do_upload()):
                $this->messages->add($this->upload->display_errors(), 'error');
            else:
                $data = $this->upload->data();
                $fn = $data['file_name'];
                $type = substr($fn, strrpos($fn, '.') + 1);
                
                $this->load->library('s3');
                $temp_file_path = "./temp/" . $data['file_name'];
                $newFileName = uniqid().".".substr($temp_file_path, strrpos($temp_file_path, '.') + 1);
                $contentPath = "alexose.com/forever/images"; 

                // Check to see if bucket exists.  If not, create it.
                $bucketname = $username . '-' . $userid;
                if (!$this->s3->getBucketLocation($bucketname))
                    $this->s3->putBucket($bucketname);
                
                try {
                    $this->s3->putObject($newFileName, $bucketname, $contentPath, 'private', $type);
                } catch(Exception $error){
                    $this->messages->add($error, 'error');
                }
                echo 'success'; 
                
            endif;


            // TODO: move this to user creation station
            //$this->s3->putBucket($username . '-' . $userid, S3::ACL_PUBLIC_READ);
            

            $id = $this->mongo_db->insert('photos', $post);

        endif;
        redirect('photo');
    }

    // Delete a photo
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

