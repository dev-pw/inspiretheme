<?php
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', 'on');

include('../util/funcoes_uteis.php');
include('../util/apenas_logado.php');
date_default_timezone_set('America/Sao_Paulo');

$id_cadastro     = $_SESSION['id'];
$senha_atual     = addslashes($_POST['senha_atual']);
$senha_nova      = addslashes($_POST['senha_nova']);
$senha_nova_conf = addslashes($_POST['senha_nova_conf']);

checarVazio($id_cadastro); // mesmo id do input
checarVazio($senha_atual, 'senha_atual'); // mesmo id do input
checarVazio($senha_nova, 'senha_nova'); // mesmo id do input
checarVazio($senha_nova_conf, 'senha_nova_conf'); // mesmo id do input

// CHECAR SE SENHAS COINCIDEM
if($senha_nova != $senha_nova_conf){
  echo json_encode(array(
    'status' => 'erro',
    'campo' => 'senha_nova_conf',
    'erro' => 'Senhas não coincidem'
  )); exit;
}


if(!tamanho_min($senha_nova, 8)){
  $responseError = array(
    'status' => 'erro',
    'campo' => 'senha_nova',
    'erro' => 'Mínimo de 8 caracteres'
  );
  echo json_encode($responseError);
  exit;
};

// CHECANDO SE A SENHA TEM CARACTERES ESPECIAIS
if (!preg_match('/[\'^£$%&*()}{@#~?><>,;|=_+¬-]/', $senha_nova)){
  $responseError = array(
    'status' => 'erro',
    'campo' => 'senha_nova',
    'erro' => 'Necessário no mínimo um caractere especial'
  );
  echo json_encode($responseError);
  exit;
}

// CHECANDO SE A SENHA TEM CARACTERES NÚMEROS
if (!preg_match('~[0-9]+~', $senha_nova)) {
  $responseError = array(
    'status' => 'erro',
    'campo' => 'senha_nova',
    'erro' => 'Necessário no mínimo um número'
  );
  echo json_encode($responseError);
  exit;
}


include('../connection_siga.php');

try {
    // CONEXÃO PDO
    $pdo = conectar();
    // SELECT
    $stmt = $pdo->prepare("SELECT * FROM siga_cad_associados WHERE cod_associado = :cod_associado AND senha = :senha");
    $stmt->execute(array(
        ':cod_associado' => $id_cadastro,
        ':senha'         => base64_encode($senha_atual) // Codificar a senha atual em base64 para comparação
    ));

    $registros = $stmt->fetchAll();

    if(count($registros) > 0){

        $stmt = $pdo->prepare('
            UPDATE siga_cad_associados SET
            senha = :senha
            WHERE cod_associado   = :cod_associado
        ');
        $stmt->execute(array(
            ':senha' => base64_encode($senha_nova), // Codificar a nova senha em base64
            ':cod_associado' => $id_cadastro
        ));

        if($stmt->rowCount() >= 1){
            echo json_encode(array(
                'status' => 'sucesso'
            ));
            exit;
        }else{
            echo json_encode(array(
                'status' => 'erro',
                'erro' => 'Ocorreu um erro, tente novamente mais tarde'
            ));
            exit;
        }

    }else{
        // ERRO CADASTRO NAO EXISTE
        echo json_encode(array(
            'status' => 'erro',
            'campo' => 'senha_atual',
            'erro' => 'A senha atual está errada'
        ));
        exit;
    }
} catch(PDOException $e) {
    $responseError = array(
        'status' => 'erro',
        'erro' => 'Error: ' . $e->getMessage()
    );
    echo json_encode($responseError);
}
 catch(PDOException $e) {
  $responseError = array(
    'status' => 'erro',
    'erro' => 'Error: ' . $e->getMessage()
  );
  echo json_encode($responseError);
}


exit;
