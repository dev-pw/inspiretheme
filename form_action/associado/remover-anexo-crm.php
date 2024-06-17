<?php
session_start();

include('../util/funcoes_forms.php');
include('../util/apenas_logado.php');
date_default_timezone_set('America/Sao_Paulo');

$id_cadastro  = $_SESSION['id'];

include('../connection_siga.php');

try {
	// CONEXÃO PDO
  $pdo = conectar();
  // SELECT CPF
	$stmt = $pdo->prepare("SELECT * FROM siga_cad_associados WHERE cod_associado = :cod_associado");
  $stmt->execute(array(
		':cod_associado'   => $id_cadastro
  ));

  $registros = $stmt->fetchAll();

	if(count($registros) > 0){

    $stmt = $pdo->prepare('
      UPDATE siga_cad_associados SET
        crm_img = :crm_img
      WHERE cod_associado   = :cod_associado
    ');
    $stmt->execute(array(
      ':crm_img' => '',
      ':cod_associado'   => $id_cadastro
    ));

    if($stmt->rowCount() >= 1){
      echo '<script type="text/javascript">
              window.history.back();
            </script>';
      exit;
    }else{
      echo 'Ocorreu um erro, tente novamente mais tarde. Redirecionando...';
      echo '<script type="text/javascript">
              window.history.back();
            </script>';
      exit;
    }

  }else{
    echo 'Cadastro não encontrado. Redirecionando...';
    echo '<script type="text/javascript">
            window.history.back();
          </script>';
    exit;
  }

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}


exit;
