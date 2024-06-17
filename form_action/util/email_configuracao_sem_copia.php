<?php

// NECESSÁRIO ESTAR ANTES DE TUDO
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// CAMINHO PARA OS ARQUIVOS PHPMAILER BAIXADOS
require dirname(__FILE__).'/../../lib/phpmailer/src/PHPMailer.php';
require dirname(__FILE__).'/../../lib/phpmailer/src/SMTP.php';
require dirname(__FILE__).'/../../lib/phpmailer/src/Exception.php';
require_once dirname(__FILE__).'/../../lib/phpmailer/src/OAuth.php';
// ATUALIZAR AS INFORMAÇÕES ABAIXO BASEADO NO SERVIDOR DO EMAIL

$mail = new PHPMailer(true);

$mail->SMTPDebug = 0; // ATIVA O DEBUGGIN PARA VERIFICAÇÃO DE ERROS (remover quando finalizados os testes)
$mail->IsSMTP(); // DEFINE O PADRÃO SMTP
$mail->Host = "email-ssl.com.br"; // HOST DO SMTP
$mail->SMTPAuth = true;
$mail->Username = "no-reply@dominio"; // EMAIL
$mail->Password = ""; // SENHA
$mail->SMTPSecure = "tls"; // SE O SMTP TIVER CRIPTOGRAFIA, USAR ESTA LINHA
$mail->Port = 587; // PORTA
$mail->From = "no-reply@dominio"; // MESMO EMAIL DO USERNAME
$mail->FromName = utf8_decode('SEU SITE'); // NOME DO REMETENTE

$mail->addAddress($email); // EMAIL DO DESTINATÁRIO

$mail->IsHTML(true); // DEFINE QUE O E-MAIL SERÁ ENVIADO COMO HTML
$mail->setLanguage('pt');
$mail->Subject = $subject;
$mail->MsgHTML($corpoMSG);

try {
    $mail->send();
} catch (Exception $e) {
    $responseError = array(
      'status' => 'erro',
      'erro' => "Mailer Error: " . $mail->ErrorInfo
    );
    echo json_encode($responseError);
    exit;
}

?>
