<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correos_archivos {

    function evento_cotizaciones($datos) {
      
      $logo = base_url('template/images/logo.png');
      $accion=$datos['accion'];
      $remitentes=$datos['correo'];
      $cal=$datos['cal'];
      $nombre=$datos['nombre'];

      $CI = & get_instance();
      $CI->load->library('email');
        $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
                <p><b>Evento:</b> $accion</p>

EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');


        $CI->email->to($remitentes);

        $CI->email->subject('Evento de Seguimiento');
        $CI->email->message($mensaje);
        
       $CI->email->attach($cal, $disposition='attachment', $newname = $nombre, $mime='text/calendar');
       $CI->email->send();
    }

}
