<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		$this->load->view('p');
	}

    public function hendra($name) {
        // $data['name'] = $name;
        // $this->load->view('test', $data);
    
        $this->load->view('p');
    }
}
