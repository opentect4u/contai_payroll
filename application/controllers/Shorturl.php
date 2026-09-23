<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shorturl extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('shorturl_model');
    }

    public function index($code = null)
    {
        $long_url = $code ? $this->shorturl_model->resolve($code) : false;

        if ($long_url === false) {
            $this->output->set_status_header(410);
            $this->load->view('shorturl/expired');
            return;
        }

        redirect($long_url);
    }
}
