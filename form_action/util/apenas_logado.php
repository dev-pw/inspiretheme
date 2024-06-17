<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// SE ESTIVER DESLOGADO, REDIRECIONAR PARA LOGIN
if(!isset($_SESSION['nome']) && !isset($_SESSION['email']) ){
  echo '<script type="text/javascript">
          window.location.href = "https://'.$_SERVER["HTTP_HOST"].'/login";

        </script>';
  exit;
}

?>
