<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 'on');


session_start();
include(dirname(__FILE__).'/../util/funcoes_uteis.php');
include(dirname(__FILE__).'/../util/cript.php');

date_default_timezone_set('America/Sao_Paulo');

$data_cadastro  = date('Y-m-d H:i');
$agora          = date('Y-m-d H:i:s');
$email 		        = addslashes($_POST['email']);

checarVazio($email, 'email'); // mesmo id do input

include(dirname(__FILE__).'/../connection_siga.php');

// CODIGO ALEATORIO
$rand = rand();
$randCript = base64_encode($rand)."-".base64_encode(time());
// ===========================================

try {
	// CONEXÃO PDO
  $pdo = conectar();
  // SELECT
	$stmt = $pdo->prepare("SELECT * FROM siga_cad_associados WHERE email1 = :email1 AND status != :status");
  $stmt->execute(array(
    ':email1'    => $email,
    ':status' => 'I'
  ));

  $registro = $stmt->fetch();
  $num_registros = $stmt->rowCount();

	if($num_registros > 0){

      $nome  = $registro['nome'];
      $email = $registro['email1'];

      // ERRO EMAIL
      if(empty($email)){
        echo json_encode(array(
          'status' => 'erro',
          'erro' => 'E-mail inválido.'
        )); exit;
      }

      // UPDATE
        $stmt = $pdo->prepare('UPDATE siga_cad_associados SET data_rec_senha = :data_rec_senha, cod_rec_senha = :cod_rec_senha WHERE email1 = :email1');
        $stmt->execute(array(
          ':data_rec_senha' => $agora,
          ':cod_rec_senha' => $randCript,
          ':email1' => $email
        ));
      // UPDATE

  }else{
    // ERRO CADASTRO NAO EXISTE
    echo json_encode(array(
      'status' => 'erro',
      'erro' => 'O e-mail inserido não possui cadastro.'
    )); exit;
  }

    // ENVIO DE EMAIL
    $subject = utf8_decode('Recuperação de senha - SBC');

    $corpoMSG = utf8_decode('
    <body style="background-color: #EDEDED">
      <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
        <tbody>
          <tr><td height="30" style="background-color: #ffffff">&nbsp;</td></tr>
          <tr width="750" style="background-color: #ffffff; text-align:center">
            <td width="750" align="center" style="background-color: #ffffff"><img src="https://sbc.med.br/site/wp-content/uploads/logo_sbc.png" width="150" alt="">
            </td>
          </tr>
          <tr><td style="background-color: #ffffff" height="30">&nbsp;</td></tr>

          <tr>
            <td>
              <table width="750" border="0" cellspacing="0" cellpadding="0" style="background-color:#ffffff; font-size:16px; font-family: Verdana; color: #525252; line-height: 1.5">
                <tbody>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="50">&nbsp;</td>
                    <td>
                      <p>Prezado(a) <strong>'.$nome.'</strong>, </p>
                      <p>Uma solicitação de recuperação de senha foi realizada.</p>

                      <p> <a href="https://www.sbc.med.br/recuperar-senha/?codigo='.$randCript.'" style="color: #138c9d">Clique aqui</a> para redefinir. </p>
                      <p> <strong> Obs.: </strong> Este link só estará disponível por 10 minutos, caso tenha passado este tempo, solicite novamente a recuperação <a href="https://www.sbc.med.br/recuperar-senha/" style="color: #138c9d"> clicando aqui </a> </p>
                      <p> Caso não tenha solicitado, por favor, ignore este e-mail. </p>

                      <p>Atenciosamente, </p>

                    </td>
                    <td width="50">&nbsp;</td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td style="border-top: 1px solid #eaeaea;">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td><p> <strong> Sociedade Brasileira de Córnea e Banco de Tecidos </strong> </p></td>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td height="20" style="background-color:#105075">&nbsp;</td>
                    <td height="20" style="background-color:#105075">&nbsp;</td>
                    <td height="20" style="background-color:#105075">&nbsp;</td>
                  </tr>

                  <tr style="background-color:#105075">
                    <td>&nbsp;</td>
                    <td align="center">
                      <a href="https://sbc.med.br" style="color: #FFF; text-decoration: none" target="_blank"> <strong> sbc.med.br </strong> </a>
                    </td>
                    <td>&nbsp;</td>
                  </tr>

                  <tr style="background-color:#105075">
                    <td height="20">&nbsp;</td>
                    <td height="20">&nbsp;</td>
                    <td height="20">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
    </body>
  	');

  	include(dirname(__FILE__).'/../util/email_configuracao_sem_copia.php');
    // ENVIO DE EMAIL

    echo json_encode(array(
      'status' => 'sucesso'
    )); exit;


} catch(PDOException $e) {
  $responseError = array(
    'status' => 'erro',
    'erro' => 'Error: ' . $e->getMessage()
  );
  echo json_encode($responseError);
}


exit;
