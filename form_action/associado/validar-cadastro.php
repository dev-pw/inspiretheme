<?php
session_start();
include('../util/funcoes_uteis.php');
include('../util/apenas_logado.php');
date_default_timezone_set('America/Sao_Paulo');

$data_cadastro 	= date('Y-m-d H:i:s');

$id_cadastro = $_SESSION['id'];
$id_produto	 = addslashes($_POST['produto']);
$tipo	       = addslashes($_POST['tipo']);

// VERIFICAÇÕES =============================

include('../connection_siga.php');

try {
	// CONEXÃO PDO
  $pdo = conectar();

  // SELECT
	$stmt = $pdo->prepare("SELECT * FROM siga_cad_associados WHERE cod_associado = :cod_associado AND status != 'I'");
  $stmt->execute(array(
    ':cod_associado' => $id_cadastro
  ));

	$num_registros = $stmt->rowCount();

	if($num_registros > 0){

    // INSERT
		$stmt = $pdo->prepare("
    INSERT INTO `siga_servico_associado` (
  		`id_associado`,
      `id_produto`,
  		`valor_pagto`,
  		`taxas`,
  		`valor_liquido`,
  		`data_pagto`,
  		`forma_pagto`,
  		`status_pagto`,
  		`baixa_por`,
  		`link_boleto`,
  		`cod_barras_boleto`,
  		`venc_boleto`,
  		`tid_boleto`,
  		`token_cartao`,
  		`tid_cartao`,
  		`data_cadastro_anuidade`
    ) VALUES (
  		:id_associado,
      :id_produto,
  		:valor_pagto,
  		:taxas,
  		:valor_liquido,
  		:data_pagto,
  		:forma_pagto,
  		:status_pagto,
  		:baixa_por,
  		:link_boleto,
  		:cod_barras_boleto,
  		:venc_boleto,
  		:tid_boleto,
  		:token_cartao,
  		:tid_cartao,
  		:data_cadastro_anuidade
    )");

    $stmt->execute(array(
      ':id_associado'      => $id_cadastro,
      ':id_produto'        => $id_produto,
  		':valor_pagto'       => '',
  		':taxas'             => '',
  		':valor_liquido'     => '',
  		':data_pagto'        => NULL,
  		':forma_pagto'       => '',
  		':status_pagto'      => '',
  		':baixa_por'         => '',
  		':link_boleto'       => '',
  		':cod_barras_boleto' => '',
  		':venc_boleto'       => NULL,
  		':tid_boleto'        => '',
  		':token_cartao'      => '',
  		':tid_cartao'        => '',
  		':data_cadastro_anuidade' => $data_cadastro
    ));

    // MEMBER ID
    $id_pedido = $pdo->lastInsertId();

    echo json_encode(array(
      'status' => 'sucesso',
      'produto' => base64_encode($id_pedido)
    )); exit;

	}else{

    $responseError = array(
      'status' => 'erro',
      'erro' => 'Cadastro não encontrado'
    );
    echo json_encode($responseError);
    exit;

  }

} catch(PDOException $e) {
  $responseError = array(
    'status' => 'erro',
    'erro' => 'Error: ' . $e->getMessage()
  );
  echo json_encode($responseError);
}

exit;

// ==================

?>
