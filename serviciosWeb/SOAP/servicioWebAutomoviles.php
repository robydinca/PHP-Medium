<?php
include 'GestionAutomoviles.class.php';
$soap = new SoapServer(null, array('uri' => 'http://localhost:8080/'));
$soap->setClass('GestionAutomoviles');
$soap->handle();
?>