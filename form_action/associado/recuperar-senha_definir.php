<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 'on');

session_start();
include(dirname(__FILE__).'/../util/funcoes_uteis.php');
include(dirname(__FILE__).'/../util/cript.php');

$id_senha_nova  = addslashes($_POST['id_senha_nova']);
$nova_senha 	  = addslashes($_POST['nova_senha']);
$conf_senha     = addslashes($_POST['conf_senha']);

checarVazio($nova_senha);
checarVazio($conf_senha);

// ================
// TAMANHOS MÍNIMO

if(!tamanho_min($nova_senha, 8)){
  $responseError = array(
    'status' => 'erro',
    'erro' => 'Mínimo de 8 caracteres'
  );
  echo json_encode($responseError);
  exit;
};

// CHECANDO SE A SENHA TEM CARACTERES ESPECIAIS
if (!preg_match('/[\'^£$%&*()}{@#~?><>,;|=_+¬-]/', $nova_senha)){
  $responseError = array(
    'status' => 'erro',
    'erro' => 'Necessário no mínimo um caractere especial'
  );
  echo json_encode($responseError);
  exit;
}

// CHECANDO SE A SENHA TEM CARACTERES NÚMEROS
if (!preg_match('~[0-9]+~', $nova_senha)) {
  $responseError = array(
    'status' => 'erro',
    'erro' => 'Necessário no mínimo um número'
  );
  echo json_encode($responseError);
  exit;
}

// ================

if(!tamanho_min($conf_senha, 8)){
  $responseError = array(
    'status' => 'erro',
    'erro' => 'Mínimo de 8 caracteres'
  );
  echo json_encode($responseError);
  exit;
};

// CHECANDO SE A SENHA TEM CARACTERES ESPECIAIS
if (!preg_match('/[\'^£$%&*()}{@#~?><>,;|=_+¬-]/', $conf_senha)){
  $responseError = array(
    'status' => 'erro',
    'erro' => 'Necessário no mínimo um caractere especial'
  );
  echo json_encode($responseError);
  exit;
}

// CHECANDO SE A SENHA TEM CARACTERES NÚMEROS
if (!preg_match('~[0-9]+~', $conf_senha)) {
  $responseError = array(
    'status' => 'erro',
    'erro' => 'Necessário no mínimo um número'
  );
  echo json_encode($responseError);
  exit;
}

// CHECANDO SE AS SENHAS SÃO IGUAIS
if ($nova_senha != $conf_senha) {
  $responseError = array(
    'status' => 'erro',
    'erro' => 'As senhas preenchidas devem ser iguais'
  );
  echo json_encode($responseError);
  exit;
}
// ================

// CONEXÃO
include('../connection_siga.php');

try {
	// CONEXÃO PDO
	$pdo = conectar();

  // =================================

  // SELECT
	$stmt = $pdo->prepare("SELECT * FROM siga_cad_associados WHERE cod_associado = :cod_associado AND status != :status");
  $stmt->execute(array(
    ':cod_associado' => $id_senha_nova,
    ':status'        => 'I'
  ));

  $registro = $stmt->fetch();
  $num_registros = $stmt->rowCount();

	if($num_registros > 0){

      $nome  = $registro['nome'];
      $email = $registro['email1'];
      $senha = base64_decode($registro['senha']);

      if($senha == $nova_senha){
        // ERRO CADASTRO NAO EXISTE
        echo json_encode(array(
          'status' => 'erro',
          'erro' => 'A senha inserida já é a senha atual.'
        )); exit;
      }

  }else{
    // ERRO CADASTRO NAO EXISTE
    echo json_encode(array(
      'status' => 'erro',
      'erro' => 'Erro de parâmetros.'
    )); exit;
  }

  // =================================

	// INSERT
  $stmt = $pdo->prepare('UPDATE siga_cad_associados SET senha = :senha WHERE cod_associado = :cod_associado');
  $stmt->execute(array(
    ':senha'         => base64_encode($nova_senha),
    ':cod_associado' => $id_senha_nova
  ));

  if($stmt->rowCount() >= 1){
    $response = array(
       'status' => 'sucesso'
     );
     echo json_encode($response);
     exit;
	}else{
    $responseError = array(
      'status' => 'erro',
      'erro' => 'Erro na atualização, tente novamente mais tarde.'
    );
    echo json_encode($responseError);
    exit;
	}

} catch(PDOException $e) {
	echo "Ocorreu um erro, tente novamente mais tarde.";
}


?>
