<?php

// ============== FUNÇÃO CHECAR SE O CAMPO ESTÁ VAZIO (JSON) ===========
// =====================================================================

function checarVazio($campo, $nomeCampo = ""){

	if($nomeCampo == ""){

		if(empty($campo)){

			$responseError = array(
				'status' => 'erro',
				'erro' => 'Preencha corretamente os campos'
			);

			echo json_encode($responseError);
			exit;
		}

	}else{

		if(empty($campo)){

			$responseError = array(
				'status' => 'erro',
				'campo' => strtolower($nomeCampo),
				'erro' => 'Preencha corretamente o campo'
			);

			echo json_encode($responseError);
			exit;
		}

	}


}

// ======================= FUNÇÃO LIMPAR STRING ========================
// =====================================================================

function clean($string) {
	$string = str_replace(' ', '-', $string);
	$string = str_replace("-", "", $string);
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

function removerCaracEspec($string) {
	$string = preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$string);
	return str_replace('-', ' ', $string);
}

function removerNumeros($string) {
	return preg_replace('/[0-9]+/', '',$string);
}

function sanitizeStringAndSpaces($str) {
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str);
    return $str;
}

function sanitizeString($str) {
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    return $str;
}


// ================== FUNÇÃO CHECAR TAMANHO MÁXIMO =====================
// =====================================================================

function tamanho_max($string, $max_val) {

	if(strlen($string) > $max_val){
		return false;
	}else{
		return true;
	}

}

// ================== FUNÇÃO CHECAR TAMANHO MÍNIMO =====================
// =====================================================================

function tamanho_min($string, $min_val) {

	if(strlen($string) < $min_val){
		return false;
	}else{
		return true;
	}

}

// ======================= FUNÇÃO VERIFICAR CPF ========================
// =====================================================================

function validaCPF($cpf) {
  $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
  if (strlen($cpf) != 11) {
    return false;
  }

  if (preg_match('/(\d)\1{10}/', $cpf)) {
    return false;
  }

  for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
          $d += $cpf[$c] * (($t + 1) - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cpf[$c] != $d) {
          return false;
      }
  }

  return true;
}

// ==================== FUNÇÃO VERIFICAR CARTÃO ========================
// =====================================================================

function validarCartao($number) {

  // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
  $number = preg_replace('/\D/', '', $number);

  // Set the string length and parity
  $number_length = strlen($number);
  $parity = $number_length % 2;

  // Loop through each digit and do the maths
  $total = 0;
  for ($i = 0; $i < $number_length; $i++) {
    $digit = $number[$i];

		// Multiply alternate digits by two
    if($i % 2 == $parity) {
      $digit *= 2;
      // If the sum is two digits, add them together (in effect)
      if ($digit > 9) {
        $digit -= 9;
      }
    }
    // Total up the digits
    $total += $digit;
  }

  // If the total mod 10 equals 0, the number is valid
  return ($total % 10 == 0) ? TRUE : FALSE;

}

// ======================= FUNÇÃO GERAR STRING =========================
// =====================================================================

function gerarString($length = 4) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// ======================= FUNÇÃO GERAR NUMERO =========================
// =====================================================================

function gerarNumero($length = 4) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// FUNÇÃO RETORNAR ESTADOS DO BRASIL
// =================================

function retorna_ufs(){
	return array(
		"AC","AL","AM","AP","BA","CE","DF",
		"ES","GO","MA","MG","MS","MT","PA",
		"PB","PE","PI","PR","RJ","RN","RO",
		"RR","RS","SC","SE","SP","TO"
	);
}

// FUNÇÃO RETORNAR ESTADOS DO BRASIL
// =================================

function retorna_estados(){
	return array(
		'AC' => 'Acre',
		'AL' => 'Alagoas',
		'AP' => 'Amapá',
		'AM' => 'Amazonas',
		'BA' => 'Bahia',
		'CE' => 'Ceará',
		'DF' => 'Distrito Federal',
		'ES' => 'Espirito Santo',
		'GO' => 'Goiás',
		'MA' => 'Maranhão',
		'MS' => 'Mato Grosso do Sul',
		'MT' => 'Mato Grosso',
		'MG' => 'Minas Gerais',
		'PA' => 'Pará',
		'PB' => 'Paraíba',
		'PR' => 'Paraná',
		'PE' => 'Pernambuco',
		'PI' => 'Piauí',
		'RJ' => 'Rio de Janeiro',
		'RN' => 'Rio Grande do Norte',
		'RS' => 'Rio Grande do Sul',
		'RO' => 'Rondônia',
		'RR' => 'Roraima',
		'SC' => 'Santa Catarina',
		'SP' => 'São Paulo',
		'SE' => 'Sergipe',
		'TO' => 'Tocantins'
	);
}

// FUNÇÃO RETORNAR PAÍSES DO MUNDO
// =================================

function retorna_paises(){
	return array(
		"África do Sul", "Albânia", "Alemanha", "Andorra", "Angola", "Anguilla", "Antigua", "Arábia Saudita", "Argentina", "Armênia", "Aruba",
		"Austrália", "Áustria", "Azerbaijão", "Bahamas", "Bahrein", "Bangladesh", "Barbados", "Bélgica", "Benin", "Bermudas", "Botsuana",
		"Brasil", "Brunei", "Bulgária", "Burkina Fasso", "botão", "Cabo Verde", "Camarões", "Camboja", "Canadá", "Cazaquistão", "Chade", "Chile",
		"China", "Cidade do Vaticano", "Colômbia", "Congo", "Coréia do Sul", "Costa do Marfim", "Costa Rica", "Croácia", "Dinamarca", "Djibuti", "Dominica",
		"EUA", "Egito", "El Salvador", "Emirados Árabes", "Equador", "Eritréia", "Escócia", "Eslováquia", "Eslovênia", "Espanha", "Estônia", "Etiópia",
		"Fiji", "Filipinas", "Finlândia", "França", "Gabão", "Gâmbia", "Gana", "Geórgia", "Gibraltar", "Granada", "Grécia", "Guadalupe", "Guam", "Guatemala",
		"Guiana", "Guiana Francesa", "Guiné-bissau", "Haiti", "Holanda", "Honduras", "Hong Kong", "Hungria", "Iêmen", "Ilhas Cayman", "Ilhas Cook", "Ilhas Curaçao",
		"Ilhas Marshall", "Ilhas Turks &amp; Caicos", "Ilhas Virgens (brit.)", "Ilhas Virgens(amer.)", "Ilhas Wallis e Futuna", "Índia", "Indonésia", "Inglaterra",
		"Irlanda", "Islândia", "Israel", "Itália", "Jamaica", "Japão", "Jordânia", "Kuwait", "Latvia", "Líbano", "Liechtenstein", "Lituânia", "Luxemburgo", "Macau",
		"Macedônia", "Madagascar", "Malásia", "Malaui", "Mali", "Malta", "Marrocos", "Martinica", "Mauritânia", "Mauritius", "México", "Moldova", "Mônaco",
		"Montserrat", "Nepal", "Nicarágua", "Niger", "Nigéria", "Noruega", "Nova Caledônia", "Nova Zelândia", "Omã", "Palau", "Panamá", "Papua-nova Guiné",
		"Paquistão", "Peru", "Polinésia Francesa", "Polônia", "Porto Rico", "Portugal", "Qatar", "Quênia", "Rep. Dominicana", "Rep. Tcheca", "Reunion", "Romênia",
		"Ruanda", "Rússia", "Saipan", "Samoa Americana", "Senegal", "Serra Leone", "Seychelles", "Singapura", "Síria", "Sri Lanka", "St. Kitts &amp; Nevis",
		"St. Lúcia", "St. Vincent", "Sudão", "Suécia", "Suiça", "Suriname", "Tailândia", "Taiwan", "Tanzânia", "Togo", "Trinidad &amp; Tobago", "Tunísia",
		"Turquia", "Ucrânia", "Uganda", "Uruguai", "Venezuela", "Vietnã", "Zaire", "Zâmbia", "Zimbábue"
	);
}

// MASK
// EXEMPLO DE USO: $doc = mask("###.###.###-##", $doc);

function mask($mask, $str) {
  $str = str_replace(" ", "", $str);

  for ($i = 0; $i < strlen($str); $i++) {
    $mask[strpos($mask, "#")] = $str[$i];
  }

  return $mask;
}


// MASK
// EXEMPLO DE USO: $doc = maskDinheiro($valor);
function maskDinheiro(string $str): string
{
	if (strpos($str, ".") !== false) {
	  $str = substr($str, 0, (strpos($str, ".") + 3));
	}
	$str = clean($str);

    switch (strlen($str)) {
        case 3:
          $str = mask("#,##", $str);
          break;
        case 4:
          $str = mask("##,##", $str);
          break;
        case 5:
          $str = mask("###,##", $str);
          break;
        case 6:
          $str = mask("#.###,##", $str);
          break;
        case 7:
          $str = mask("##.###,##", $str);
          break;
        case 8:
          $str = mask("###.###,##", $str);
          break;
				case 9:
          $str = mask("#.###.###,##", $str);
          break;
				case 10:
          $str = mask("##.###.###,##", $str);
          break;
				case 11:
          $str = mask("###.###.###,##", $str);
          break;
        default:
          $str = mask("###,##", $str);
          break;
      }

    return $str;
}

// ============== FUNÇÃO CHECAR SE O TEM LINK OU CONTEÚDO SUSPEITO PARA EVITAR SPAM ===========
// ============================================================================================

function checarSpam($campo){

	if( (strpos($campo, 'https') !== false) || (strpos($campo, 'http') !== false) || (strpos($campo, '.com') !== false) || (strpos($campo, '?????') !== false) ){
	  echo json_encode(array(
      'status' => 'erro',
			'erro' => 'Informações inseridas de forma inválida, por favor, não inserir links nos campos. Tente novamente.'
		)); exit;
	}

}


// ============== FUNÇÃO UPLOAD DE ARQUIVOS ===========
// ====================================================

/*
* $arquivo	 				OBRIGATÓRIO
* $extensoes 				OBRIGATÓRIO (array) => EXEMPLO: $extensoes = array("jpg", "jpeg", "png", "pdf", "txt", "docx", "doc");
* $prefixo_retorno 	OPCIONAL => prefixo que o nome do arquivo terá quando salva no servidor
* $destino				 	RECOMENDÁVEL, MAS OPCIONAL => pasta de destino dentro da pasta de arquivos
* $arquivo_atual	  OPCIONAL => para casos de atualização (se for informado, será comparado se existe arquivo atual e se o arquivo informado foi enviado)
*/

// EXEMPLO
// $extensoes = array("jpg", "jpeg", "png", "pdf", "txt", "docx", "doc", "heic");
// $arquivo_caminho = upload_arquivo($arquivo, $extensoes, 'prefixo_arquivo');


function upload_arquivo($arquivo, $extensoes, $prefixo_retorno = 'arquivo', $destino = 'geral', $arquivo_atual = null){

  // Se o arquivo estiver sido selecionado
  if(!empty($arquivo['name'])) {

    // Pega extensão do arquivo
    $array = explode('.', $arquivo["name"]);
    $ext = end($array);
    $ext = strtolower($ext);

    if(in_array($ext, $extensoes) ){

      $tamanho = 10000000; // TAMANHO 10MB

      // Verifica se o tamanho do arquivo é maior que o tamanho permitido
      if($arquivo["size"] > $tamanho) {
        echo json_encode(array(
          'status' => 'erro',
          'erro' => 'O arquivo deve ter no máximo 10MB'
        )); exit;
      }

			// CRIA DIRETÓRIO COM O CAMINHO DO PARÂMETRO ATUAL SE NÃO JÁ EXISTIR
      if (!file_exists(__DIR__."/../arquivos/".$destino)) {
          mkdir( __DIR__."/../arquivos/".$destino, 0777, true);
      }

      // CRIA DIRETÓRIO COM O ANO ATUAL SE NÃO JÁ EXISTIR
      if (!file_exists(__DIR__."/../arquivos/".$destino."/".date("Y"))) {
          mkdir( __DIR__."/../arquivos/".$destino."/".date("Y"), 0777, true);
      }

      // CRIA DIRETÓRIO COM O MÈS ATUAL SE NÃO JÁ EXISTIR
      if (!file_exists(__DIR__."/../arquivos/".$destino."/".date("Y")."/".date("m"))) {
          mkdir( __DIR__."/../arquivos/".$destino."/".date("Y")."/".date("m"), 0777, true);
      }

      $nome_arquivo = $prefixo_retorno.'-'.md5(uniqid(time())) . "." . $ext; // Gera um nome único para o arquivo
      $nome_arquivo_retorno = "../arquivos/" . $destino ."/".date("Y")."/".date("m")."/". $nome_arquivo; // Caminho de onde ficará o arquivo

      move_uploaded_file($arquivo["tmp_name"], $nome_arquivo_retorno); // Faz o upload do arquivo para seu respectivo caminho

      $nome_arquivo_retorno = "arquivos/" . $destino . "/".date("Y")."/".date("m")."/" .  $nome_arquivo;


    }else{

      $mensagem_extensao = "Envie um arquivo de um dos seguintes tipos: ";
      foreach ($extensoes as $key => $extensao) {
        $mensagem_extensao .= $extensao.", ";
      }
      $mensagem_extensao = substr($mensagem_extensao, 0, -2).".";

      echo json_encode(array(
        'status' => 'erro',
        'erro' => $mensagem_extensao
      )); exit;
    }

  }else{

    // SE O CAMPO DE ARQUIVO ATUAL ESTIVER COM VALOR, O USUÁRIO NÃO ATUALIZOU A FOTO, ENTÃO O VALOR SERÁ MANTIDO IGUAL
    if(isset($arquivo_atual) && !empty($arquivo_atual)){
      $nome_arquivo_retorno = $arquivo_atual;
    }else{
      $nome_arquivo_retorno = '';
    }
  }

  return $nome_arquivo_retorno;

}

?>
