<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');
session_start();
include('../util/funcoes_uteis.php');
include('../util/cript.php');
date_default_timezone_set('America/Sao_Paulo');

$categoria     = addslashes( $_POST['categoria'] );
$id            = addslashes( $_POST['id'] );
$id_produto    = addslashes( $_POST['id_produto'] );
$nome_completo = addslashes( $_POST['nome_completo']);
$nome_email    = addslashes( $_POST['nome_completo']);
$cpf           = addslashes( $_POST['cpf'] );
$rg            = addslashes( $_POST['rg'] );
$data_nasc     = addslashes( $_POST['data_nasc'] );
$data_nasc     = str_replace('/', '-', $data_nasc);
$nacionalidade = addslashes( $_POST['nacionalidade'] );
$sexo          = addslashes( $_POST['sexo'] );
$crm           = addslashes( $_POST['crm'] );
$crm_uf        = addslashes( $_POST['crm_uf'] );
$telefone      = addslashes( $_POST['telefone'] );
$celular       = addslashes( $_POST['celular'] );
$email         = addslashes( $_POST['email'] );
$cep           = addslashes( $_POST['cep'] );
$rua           = addslashes( $_POST['rua'] );
$numero        = addslashes( $_POST['numero'] );
$complemento   = addslashes( $_POST['complemento'] );
$bairro        = addslashes( $_POST['bairro'] );
$cidade        = addslashes( $_POST['cidade'] );
$estado        = addslashes( $_POST['estado'] );
// $senha         = addslashes($_POST['senha']);
// $imagem_crm    = $_FILES['imagem_crm'];
$imagem_crm = $_FILES['anexo_crm'];
$imagem_crm_atual = $_POST['imagem_crm_atual']; // PARA NÃO ZERAR NO UPDATE

// PARA DEFINIR QUAL TIPO DE ATUALIZAÇÃO DEVE SER FEITA
$funcao_form = $_POST['funcao_form']; // PARA NÃO ZERAR NO UPDATE

// atualizar_logado

// VERIFICAÇÕES ============================

// CHECA CAMPOS
// SÓ TER OBRIGATORIEDADE CASO SEJA O FORMULÁRIO DE ATUALIZAÇÃO PARA RENOVAR ASSOCIAÇÃO
// echo "ansjfdjkbajfbasfnbadbskeabjgbrj 4aasdsd132";
// exit;;
if(!isset($funcao_form) && $funcao_form != 'atualizar_logado'){
  checarVazio($categoria,     'categoria'); // mesmo id do input
}
checarVazio($nome_completo, 'nome'); // mesmo id do input
checarVazio($cpf,           'cpf'); // mesmo id do input

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

// checarVazio($rg,            'rg'); // mesmo id do input
checarVazio($data_nasc,     'data_nasc'); // mesmo id do input
checarVazio($nacionalidade, 'nacionalidade'); // mesmo id do input
checarVazio($sexo,          'sexo'); // mesmo id do input
checarVazio($crm,           'crm'); // mesmo id do input
checarVazio($crm_uf,        'crm_uf'); // mesmo id do input
// if(!isset( $_POST['imagem_crm_atual'] )){
//   checarVazio($imagem_crm['name'],  'imagem_crm'); // mesmo id do input
// }
// checarVazio($telefone,      'telefone'); // mesmo id do input
checarVazio($celular,       'celular'); // mesmo id do input
checarVazio($email,         'email'); // mesmo id do input
checarVazio($cep,           'cep'); // mesmo id do input
checarVazio($rua,           'rua'); // mesmo id do input
checarVazio($numero,        'numero'); // mesmo id do input
// checarVazio($complemento,   'complemento'); // mesmo id do input
checarVazio($bairro,        'bairro'); // mesmo id do input
checarVazio($cidade,        'cidade'); // mesmo id do input
checarVazio($estado,        'estado'); // mesmo id do input
// checarVazio($senha,         'senha'); // mesmo id do input

$data_nasc = date("Y-m-d", strtotime($data_nasc));

//arrumar data
// $data_ano = substr($data_nasc,0,4);
// $data_mes = substr($data_nasc,5,2);
// $data_dia = substr($data_nasc,8,2);
// $data_nasc = $data_dia.'-'.$data_mes.'-'.$data_ano;

// TAMANHOS MÍNIMO
if(!tamanho_min($nome_completo, 5)){
  $responseError = array(
    'status' => 'erro',
    'campo' => 'nome',
    'erro' => 'Mínimo de 5 caracteres'
  );
  echo json_encode($responseError);
  exit;
};

// UPLOAD DE IMAGEM =============

// Se a foto estiver sido selecionada
// Se a foto estiver sido selecionada

// UPLOAD DOS DOSCUMENTOS
// ======================
$extensoes = array("jpg", "jpeg", "png", "pdf", "txt", "docx", "doc", "heic");

$crm_anexo_caminho = upload_arquivo($imagem_crm, $extensoes, 'crm', $destino = 'associado', $imagem_crm_atual);

include('../connection_siga.php');

try {
	// CONEXÃO PDO
  $pdo = conectar();

  // INSERT
  $stmt = $pdo->prepare('
    UPDATE siga_cad_associados SET
      data_nasc = :data_nasc,
      nome      = :nome,
      rg        = :rg,
      email1    = :email1,
      celular   = :celular,
      tel_com   = :tel_com,
      cep       = :cep,
      endereco  = :endereco,
      num       = :num,
      compl     = :compl,
      bairro    = :bairro,
      cidade    = :cidade,
      estado    = :estado,
      nacionalidade = :nacionalidade,
      sexo      = :sexo,
      data_atualizacao = :data_atualizacao,
      crm       = :crm,
      crm_uf    = :crm_uf,
      crm_img   = :crm_img
    WHERE cpf   = :cpf
  ');
  $stmt->execute(array(
    ':data_nasc' => $data_nasc,
    ':nome'      => $nome_completo,
    ':rg'        => $rg,
    ':email1'    => $email,
    ':celular'   => $celular,
    ':tel_com'   => $telefone,
    ':cep'       => $cep,
    ':endereco'  => $rua,
    ':num'       => $numero,
    ':compl'     => $complemento,
    ':bairro'    => $bairro,
    ':cidade'    => $cidade,
    ':estado'    => $estado,
    ':nacionalidade' => $nacionalidade,
    ':sexo'      => $sexo,
    ':data_atualizacao' => date("Y-m-d H:i:s"),
    ':crm'       => $crm,
    ':crm_uf'    => $crm_uf,
    ':crm_img'   => $crm_anexo_caminho,
    ':cpf'       => base64_encode($cpf)
  ));

  if($stmt->rowCount() >= 1){

    $_SESSION['nome'] = $nome_completo;

    $response = array(
      'status' => 'sucesso',
      'pagina' => 'atualizacao',
      'cpf'    => base64_encode($cpf),
      'produto' => $id_produto
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

// var_dump($crm_imagem);
exit;

?>
