<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');
session_start();

include(dirname(__FILE__).'/../util/funcoes_uteis.php');
include(dirname(__FILE__).'/../util/cript.php');
date_default_timezone_set('America/Sao_Paulo');

$email           = addslashes($_POST['email']);
$senha           = addslashes($_POST['senha']);
$datetime        = date('Y-m-d H:i:s');

// VERIFICAÇÕES ============================

// CHECA CAMPOS
checarVazio($email, 'email'); // mesmo id do input
checarVazio($senha, 'senha'); // mesmo id do input

include('../connection_siga.php');

try {
    // CONEXÃO PDO
    $pdo = conectar();

    // PREPARA O SELECT
    $stmt = $pdo->prepare("
        SELECT * FROM siga_cad_associados
        LEFT JOIN siga_servico_associado
        ON siga_servico_associado.id_associado = siga_cad_associados.cod_associado
        LEFT JOIN siga_servico ON siga_servico.id_produto = siga_servico_associado.id_produto
        WHERE email1 = :email AND senha = :senha
        AND status !='I'");

    // EXECUTA O SELECT
    $stmt->execute(array(
        ':email' => $email,
        ':senha' => base64_encode($senha) // Supondo que a senha no banco de dados também esteja codificada em base64
    ));

    // DEBUG DAS CONSULTAS
    // $stmt->debugDumpParams();

    // CONTAGEM DE REGISTROS
    $num_registros = $stmt->rowCount();

    // FETCH DO REGISTRO
    $registro = $stmt->fetch();

    if ($num_registros > 0) {
        // DADOS DO USUÁRIO ENCONTRADO
        $nome         = $registro['nome'];
        $email        = $registro['email1'];
        $cpf          = base64_decode($registro['cpf']);
        $id_cadastro  = $registro["cod_associado"];

        // INSERE LOG DE ACESSO
        $stmt = $pdo->prepare('
            INSERT INTO siga_acessos (
                id_user, data_hora
            ) VALUES (
                :id_user, :data_hora
            )');

        // EXECUTA O INSERT
        $stmt->execute(array(
            ':id_user'  => $id_cadastro,
            ':data_hora' => $datetime
        ));

        // INICIA A SESSÃO
        $_SESSION['id']         = $id_cadastro;
        $_SESSION['cpf']        = $cpf;
        $_SESSION['nome']       = $nome;
        $_SESSION['email']      = $email;
        $_SESSION['carrinho']   = array();

        if ($stmt->rowCount() >= 1) {
            // SUCESSO - RESPONDE COM JSON
            $response = array(
                'status' => 'sucesso'
            );
            echo json_encode($response);
        } else {
            // ERRO NO INSERT - RESPONDE COM JSON
            $responseError = array(
                'status' => 'erro',
                'erro' => 'Ocorreu um erro ao registrar o acesso, tente novamente mais tarde'
            );
            echo json_encode($responseError);
        }
    } else {
        // USUÁRIO NÃO ENCONTRADO - RESPONDE COM JSON
        $responseError = array(
            'status' => 'erro',
            'campo' => 'email',
            'erro' => 'E-mail ou senha inválidos'
        );
        echo json_encode($responseError);
    }
} catch (PDOException $e) {
    // ERRO NO BLOCO TRY - RESPONDE COM JSON
    $responseError = array(
        'status' => 'erro',
        'erro' => 'Error: ' . $e->getMessage()
    );
    echo json_encode($responseError);
}

exit;
?>
