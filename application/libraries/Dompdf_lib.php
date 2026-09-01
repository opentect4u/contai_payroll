<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Dompdf_lib {

    protected $options;

    public function __construct()
    {
        // Ensure the path is correct
        require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

        // Optional: set default options
        $this->options = new Options();
        $this->options->set('isRemoteEnabled', true);   // enable remote images/CSS
        $this->options->set('isHtml5ParserEnabled', true);
        // $this->options->set('defaultFont', 'DejaVu Sans');

        // You can instantiate Dompdf here or via load() if you want different options per call
    }

    /**
     * Returns a Dompdf instance with the default options
     */
    public function load()
    {
        return new Dompdf($this->options);
    }
}
