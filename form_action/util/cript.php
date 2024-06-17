<?php
// ======= CRIPTOGRAFIA =======
// ============================

// CIFRA
$cipher = "aes-256-cbc";

// CHAVES DE SEGURANÇA
$encryption_key = " ";
$iv = " ";


// FUNÇÃO CRIPTOGRAFIA

function criptografar($var){

  global $cipher;
  global $encryption_key;
  global $iv;

  return openssl_encrypt($var, $cipher, $encryption_key, 0, $iv);
}

// FUNÇÃO DESCRIPTOGRAFIA

function descriptografar($var){

  global $cipher;
  global $encryption_key;
  global $iv;

  return openssl_decrypt($var, $cipher, $encryption_key, 0, $iv);
}

?>
