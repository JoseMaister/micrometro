<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__file__).'/pdfmerger/fpdi/fpdi.php';

class Pdfmerge extends FPDI {
    public function __construct()
    {
      parent::__construct();
    }


}