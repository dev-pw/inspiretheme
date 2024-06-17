<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// SE ESTIVER LOGADO, REDIRECIONAR PARA ÁREA INTERNA
if(isset($_SESSION['nome']) && $_SESSION['email']){
  echo '<script type="text/javascript">
          window.location.href = "https://'.$_SERVER["HTTP_HOST"].'/painel/";
        </script>';
  exit;
}

?>
