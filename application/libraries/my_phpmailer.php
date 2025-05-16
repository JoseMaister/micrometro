<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_PHPMailer {
public function __construct()
{
    require('phpmailer/class.phpmailer.php');
    require('phpmailer/class.smtp.php');
}
}
?>