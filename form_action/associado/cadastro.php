<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 'on');

include('../util/funcoes_uteis.php');
include('../util/cript.php');
date_default_timezone_set('America/Sao_Paulo');

$nome_completo = addslashes( $_POST['nome_completo'] );
$email         = addslashes( $_POST['email'] );
$cpf           = addslashes( $_POST['cpf'] );

$telefone      = addslashes( $_POST['tel'] );
$crm           = addslashes( $_POST['crm'] );
$crm_uf        = addslashes( $_POST['crm_uf'] );

$cep           = addslashes( $_POST['cep'] );
$endereco      = addslashes( $_POST['endereco'] );
$num           = addslashes( $_POST['num'] );
$compl         = addslashes( $_POST['compl'] );
$bairro        = addslashes( $_POST['bairro'] );
$cidade        = addslashes( $_POST['cidade'] );
$estado        = addslashes( $_POST['estado'] );
$senha         = addslashes( $_POST['senha'] );

// VERIFICAÇÕES ============================

// CHECA CAMPOS

checarVazio($nome_completo, 'nome_completo'); // mesmo id do input
checarVazio($email,         'email'); // mesmo id do input
checarVazio($cpf,           'cpf'); // mesmo id do input
checarVazio($telefone, 'telefone'); // mesmo id do input
checarVazio($crm,      'crm'); // mesmo id do input
checarVazio($crm_uf,   'crm_uf'); // mesmo id do input

// VERIFICA CPF
$cpf = clean($cpf);
if(!validaCPF($cpf)){
  $responseError = array(
    'status' => 'erro',
    'campo' => 'cpf',
    'erro' => 'CPF inválido'
  );
  echo json_encode($responseError);
  exit;
}
// VERIFICA CPF

checarVazio($cep,      'cep'); // mesmo id do input
checarVazio($endereco, 'endereco'); // mesmo id do input
checarVazio($num,      'num'); // mesmo id do input
checarVazio($bairro,   'bairro'); // mesmo id do input
checarVazio($cidade,   'cidade'); // mesmo id do input
checarVazio($estado,   'estado'); // mesmo id do input
checarVazio($senha,    'senha'); // mesmo id do input


if(!tamanho_min($senha, 8)){
  $responseError = array(
    'status' => 'erro',
    'campo' => 'senha',
    'erro' => 'Mínimo de 8 caracteres'
  );
  echo json_encode($responseError);
  exit;
};

// CHECANDO SE A SENHA TEM CARACTERES ESPECIAIS
if (!preg_match('/[\'^£$%&*()}{@#~?><>,;|=_+¬-]/', $senha)){
  $responseError = array(
    'status' => 'erro',
    'campo' => 'senha',
    'erro' => 'Necessário no mínimo um caractere especial'
  );
  echo json_encode($responseError);
  exit;
}

// CHECANDO SE A SENHA TEM CARACTERES NÚMEROS
if (!preg_match('~[0-9]+~', $senha)) {
  $responseError = array(
    'status' => 'erro',
    'campo' => 'senha',
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
	$stmt = $pdo->prepare("SELECT * FROM siga_cad_associados WHERE cpf = :cpf AND status != :status ");
	$stmt->execute(array(
		':cpf' => base64_encode($cpf),
		':status' => 'I'
  ));

	$registros = $stmt->fetchAll();

	if(count($registros) > 0){
    $responseError = array(
      'status' => 'erro',
      'campo' => 'cpf',
      'erro' => 'CPF já foi cadastrado'
    );
    echo json_encode($responseError);
    exit;
	}
  // ==============

  // SELECT
	$stmt = $pdo->prepare("SELECT * FROM siga_cad_associados WHERE email1 = :email AND status != :status ");
	$stmt->execute(array(
		':email' => $email,
		':status' => 'I'
  ));

	$registros = $stmt->fetchAll();

	if(count($registros) > 0){
    $responseError = array(
      'status' => 'erro',
      'campo' => 'email',
      'erro' => 'E-mail já foi cadastrado'
    );
    echo json_encode($responseError);
    exit;
	}

  // ==============

	// INSERT
  $stmt = $pdo->prepare('
    INSERT INTO siga_cad_associados (
      nome,
      cpf,
      email1,
      senha,
      data_cadastro,
      tel_com,
      crm,
      crm_uf,
      cep,
      endereco,
      num,
      compl,
      bairro,
      cidade,
      estado
    ) VALUES (
      :nome,
      :cpf,
      :email1,
      :senha,
      :data_cadastro,
      :tel_com,
      :crm,
      :crm_uf,
      :cep,
      :endereco,
      :num,
      :compl,
      :bairro,
      :cidade,
      :estado
    )');

    $telefone;
    $crm;
    $crm_uf;

  $stmt->execute(array(
    ':nome' => $nome_completo,
    ':cpf' => base64_encode($cpf),
    ':email1' => $email,
    ':senha' => base64_encode($senha),
    ':data_cadastro' => date('Y-m-d H:i:s'),
    ':tel_com' => $telefone,
    ':crm' => $crm,
    ':crm_uf' => $crm_uf,
    ':cep' => $cep,
    ':endereco' => $endereco,
    ':num' => $num,
    ':compl' => $compl,
    ':bairro' => $bairro,
    ':cidade' => $cidade,
    ':estado' => $estado
  ));

  $id_cadastro = $pdo->lastInsertId();

  // ===============

  // SELECT
	$stmt = $pdo->prepare("SELECT * FROM siga_servico WHERE venda_status = :venda_status ORDER BY id_produto DESC LIMIT 1");
	$stmt->execute(array(
    ':venda_status' => 'A'
  ));
	$registros = $stmt->fetchAll();

  foreach ($registros as $key => $registro) {
    $id_produto = $registro['id_produto'];
  }

  // ==============


  if(date('Y') == '2024'){
    $status_pagto = 'Pago';
    $forma_pagto = 'Isento';
  }else{
    $status_pagto = NULL;
    $forma_pagto = NULL;
  }


  // INSERT
  $stmt = $pdo->prepare('
  INSERT INTO siga_servico_associado (
    `id_associado`,
    `id_produto`,
    `data_cadastro_anuidade`,
    `status_pagto`,
    `forma_pagto`
  ) VALUES (
    :id_associado,
    :id_produto,
    :data_cadastro_anuidade,
    :status_pagto,
    :forma_pagto
  )');

  $stmt->execute(array(
    ':id_associado' => $id_cadastro,
    ':id_produto' => $id_produto,
    ':data_cadastro_anuidade' => date("Y-m-d H:i:s"),
    ':status_pagto' => $status_pagto,
    ':forma_pagto' => $forma_pagto
  ));

  $assunto = utf8_decode('SBC - Novo cadastro realizado');
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



                    <p>Olá, doutor(a)! <strong>'.$nome.'</strong>, </p>
                    <p>Parabéns! Agora você já é um <strong>associado da SBC - Sociedade Brasileira de Córnea e Banco de Tecidos</strong> e pode começar a usufruir de diversos <strong>benefícios</strong> em sua <strong>área médica:</strong></p>
                  </td>
                  <td width="50">&nbsp;</td>
                </tr>

                <tr>
                  <td height="30">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
				  <tr>
					  <td height="30">&nbsp;</td>
                  <td>
					<ul>
					  <li>Participação de um <strong>Canal no WhatsApp</strong> Exclusivo para Discussão de Casos e demais assuntos de interesse da oftalmologia nacional: Participe ativamente de um canal no WhatsApp de discussão de casos com os maiores experts na área de córnea, superfície ocular e banco de tecidos. Basta clicar no link abaixo e participar:
						  <a href="https://chat.whatsapp.com/HZB7ywwxTLvLmqXIoxpKIi" target="_blank">chat.whatsapp.com/HZB7ywwxTLvLmqXIoxpKIi</a></li>
					  <li><strong>Acesso Fácil a Informações Importantes de sua Prática Oftalmológica:</strong> Links para cálculo de LIOs tóricas, Nomogramas para anel intra-corneano, Nomogramas de Laser de Femtosegundo para correção de astigmatismo pós-transplante de córnea (AK), Tabela atualizada de antimicrobianos </li>
					  <li><strong>Acesso Irrestrito a Todos os Webinars SBC Gravados:</strong> Você terá acesso a todos os webinars gravados até o momento e poderá participar online dos próximos webinars.</li>
					  <li><strong>Divulgação do Médico Especialista na Plataforma da SBC através da funcionalidade “ENCONTRE O SEU MÉDICO”.</strong> Iremos manter os seus dados atualizados em nossa plataforma para consulta via geolocalização.</li>
					  <li><strong>Descontos Exclusivos em Eventos Científicos:</strong> Tarifas reduzidas para participar de congressos e simpósios relacionados a especialidade de córnea, superfície ocular e banco de tecidos oculares: ótima oportunidade para expandir os seus conhecimentos e network.</li>
					  <li><strong>Descontos nas Publicações Editadas pela SBC:</strong> Receba descontos em nossas futuras publicações.</li>
					  <li>Tópicos fortificados para tratamento de ceratites infecciosas.</li>
					  <li><strong>Acesso Prioritário ao Boletim Informativo SBC:</strong> Receba em primeira mão as mais recentes novidades e insights da especialidade diretamente na sua caixa de entrada de e-mail, garantindo que você esteja sempre um passo à frente.</li>
					  <li><strong>Acesso a Revista On-line da SBC:</strong> Desfrute e compartilhe relato de casos e trabalhos na futura revista on-line da SBC.</li>
					  <li><strong>Participação nas Redes Sociais da SBC:</strong> Você poderá participar ativamente de nossas redes sociais incluindo postagens, vídeos e atualizações em nossa área de atuação.</li>
					</ul>
				  </td>
                  <td>&nbsp;</td>

				  </tr>

                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>

                <tr>
                  <td width="50">&nbsp;</td>
                  <td>
                    <p>Aproveite e se inscreva também no <a href="https://www.instagram.com/sbc.med.br/">instagram</a> da SBC</p>
                    <p>Seja muito bem-vindo(a) e que nossa parceria possa render bons frutos para a oftalmologia, refletindo assim na melhoria da saúde ocular dos brasileiros. </p>
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
                  <td><p style="text-align: center"> Dr. José Alvaro Pereira Gomes </p></td>
                  <td>&nbsp;</td>
                </tr>

				  <tr>
                  <td>&nbsp;</td>
                  <td><p style="text-align: center"> Presidente SBC </p></td>
                  <td>&nbsp;</td>
                </tr>

				  <tr>
                  <td>&nbsp;</td>
                  <td><p style="text-align: center"> Gestão 2024-2025 </p></td>
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

  $subject = utf8_decode($assunto);

  include('../util/email_configuracao.php');

  // Iniciando sessão
  $_SESSION['id'] 		= $id_cadastro;
  $_SESSION['cpf'] 		= $cpf;
  $_SESSION['nome'] 	= $nome_completo;
  $_SESSION['carrinho'] = array();

  if($stmt->rowCount() >= 1){
    $response = array(
      'status' => 'sucesso'
    );
    echo json_encode($response);
  }else{
    $responseError = array(
      'status' => 'erro',
      'erro' => 'Ocorreu um erro, tente novamente mais tarde'
    );
    echo json_encode($responseError);
  }

} catch(PDOException $e) {
  $responseError = array(
    'status' => 'erro',
    'erro' => 'Error: ' . $e->getMessage()
  );
  echo json_encode($responseError);
}

?>
