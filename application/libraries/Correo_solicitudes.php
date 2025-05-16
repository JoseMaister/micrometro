<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Correo_solictudes {

    function correos_solictudes($datos)
{
    $id = $datos['id'];
    $correos = $datos['correo'];

    $logo = base_url('template/images/logo.png');
    $url = base_url('solicitudes_pago/ver_pago/') . $id;
    $idCompleto = "Solicitud de Pago" . str_pad($id, 6, "0", STR_PAD_LEFT);

    $remitentes = array('tickets@masmetrologia.com', $correos);
    
    $CI = & get_instance();
    $CI->load->library('email');

    $mensaje = <<<EOD

               <img width='400' src='$logo'><br>
               <h1><font face="Arial">SIGA-MAS</font></h1>
               <h2>Se te ha asignado el QR</h2>
               <p><b>QR: </b> $idCompleto</p>

               <a href='$url' class='btn btn-primary'>Ver QR</a>
EOD;

        $CI->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');

        $CI->email->to($remitentes);

        $CI->email->subject('Se ha enviado Solicitud de Pago para revision');
        $CI->email->message($mensaje);

        $CI->email->send();
    
}


}
