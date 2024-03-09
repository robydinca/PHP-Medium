<?php
function generateSecretKey($length = 32)
{
    return bin2hex(random_bytes($length));
}

// Genera una clave secreta de 32 caracteres (256 bits) y la almacena en una constante SECRET_KEY
define('SECRET_KEY', generateSecretKey());
