<?php

/**

* Template Name: Recuperar Senha
pwtheme
* Template Post Type: post, page

* @package WordPress

* @subpackage pwtheme

*

*/

get_header();



include(dirname(__FILE__)."/../form_action/util/apenas_deslogado.php");

include(dirname(__FILE__)."/../form_action/connection_siga.php");



date_default_timezone_set('America/Sao_Paulo');

$codigo_recuperar = (isset($_GET['codigo'])) ? $_GET['codigo'] : null;

$agora = date('Y-m-d H:i:s');



// CASO O CODIGO TENHA SIDO PASSADO PELA URL

if(isset($codigo_recuperar)){



  try {

    // CONEXÃO PDO

    $pdo = conectar();



    // SELECT

    $stmt = $pdo->prepare("SELECT * FROM siga_cad_associados WHERE cod_rec_senha = :cod_rec_senha");

    $stmt->bindParam(':cod_rec_senha', $codigo_recuperar);

    $stmt->execute();



    $registros = $stmt->fetchAll();



    if(count($registros) > 0){



      foreach($registros as $reg){

        // DATA DA SOLICITAÇÃO DE ALTERAÇÃO

        $data_rec_senha = date('Y-m-d H:i:s', strtotime($reg['data_rec_senha']));

        // DATA LIMITE DO CÓDIGO GERADO SER ACEITO (DATA ACIMA MAIS 10 MINUTOS)

        $data_rec_senha_limit = date("Y-m-d H:i:s", strtotime($data_rec_senha . "+10 minutes"));

        // DADOS

        $cod_associado = $reg['cod_associado'];

        $email  = $reg['email1'];

        $nome   = $reg['nome'];

      }



      if($agora > $data_rec_senha_limit){

        echo '

        <script type="text/javascript">

        alert("Código expirado, gere um novo código para continuar");

        window.location.href = "'.get_the_permalink(545).'";

        </script>

        ';

      }



    }else{

      echo '

      <script type="text/javascript">

      window.location.href = "'.get_the_permalink(545).'";

      </script>

      ';

    }



  } catch(PDOException $e) {

    echo '

    <script type="text/javascript">

    window.location.href = "'.get_the_permalink(545).'";

    </script>

    ';

  }



}



?>



<main role="main">



  <header class="c-page-header">

    <div class="container">

      <h1 class="text-white"><?php the_title(); ?>

      </h1>

    </div>

  </header>



  <div class="container mt-3">

    <?php get_template_part("template-parts/breadcrumbs"); ?>

  </div>



  <div class="pt-5 u-pb-5">



    <!--  -->





    <div class="container">

      <div class="row justify-content-center">

        <div class="col-lg-6">



          <?php if(isset($codigo_recuperar)){ ?>



            <form

            class="shadow border bg-light-subtle p-4 rounded-2 form_rec_senha_definir"

            data-action-caminho="<?php echo get_template_directory_uri()?>"

            data-action="associado/recuperar-senha_definir"

            method="POST">



            <input type="hidden" name="id_senha_nova" id="id_senha_nova" value="<?php echo $cod_associado; ?>">



            <div class="d-flex justify-content-center mb-2">

                <span class="icon-user-circle-o display-4 text-primary"></span>

            </div>



            <h5 class="text-center mb-4">

              <?php if(!empty($nome)){ ?>

                Redefinir senha <br> <span class="text-primary text-capitalize d-block mt-2"> <?php echo $nome; ?> </span>

              <?php } ?>

            </h5>



            <!-- NOVA SENHA -->

            <div class="campo-senha">

                <div class="form-floating mb-3">

                    <input type="password" class="form-control border-primary campo-obrigatorio" name="nova_senha" id="nova_senha" placeholder="Senha">

                    <label for="nova_senha" class="fw-bold small text-primary form-label">Nova senha <span class="text-danger">*</span>

                        <span class="aviso_label text-danger px-2" id="aviso_label_nova_senha" style="display:none"> </span></label>

                </div>

                <span class="campo-senha__ver" style="color: #105075;"> <span class="icon-eye fs-6"></span> </span>

            </div>



            <!-- NOVA SENHA CONF -->

            <div class="campo-senha">

                <div class="form-floating mb-3">

                    <input type="password" class="form-control border-primary campo-obrigatorio" name="conf_senha" id="conf_senha" placeholder="Senha">

                    <label for="conf_senha" class="fw-bold small text-primary form-label">Confirmar nova senha <span class="text-danger">*</span>

                        <span class="aviso_label text-danger px-2" id="aviso_label_conf_senha" style="display:none"> </span></label>

                </div>

                <span class="campo-senha__ver" style="color: #105075;"> <span class="icon-eye fs-6"></span> </span>

            </div>



            <small style="font-size: 12.5px;" class="my-3">

              <p class="mb-1 fw-bold">Requisitos para senha válida:</p>

              <ul class="ms-3">

                <li>Mínimo de 8 caracteres</li>

                <li>1 número</li>

                <li>1 caractere especial</li>

              </ul>

            </small>





            <div class="justify-content-center">

              <button type="submit" class="btn btn-primary w-100">

                Enviar

                <!-- SPINNER -->

                <span class="spinner ms-1" style="display: none">

                    <div class="spinner-border spinner-border-sm ml-2" role="status">

                        <span class="sr-only"></span>

                    </div>

                </span>

                <!-- SPINNER -->

              </button>

            </div>

          </form>



        <?php }else{ ?>



          <form

          class="shadow border bg-light-subtle p-4 rounded-2 form_rec_senha"

          data-action-caminho="<?php echo get_template_directory_uri()?>"

          data-action="associado/recuperar-senha"

          method="POST">



          <div class="d-flex justify-content-center mb-2">

              <span class="icon-user-circle-o display-4 text-primary"></span>

          </div>



          <h4>

            <?php if(!empty($nome)){ ?>

              Redefinir senha<br> <span class="text-primary text-capitalize"> <?php echo $nome; ?> </span>

            <?php } ?>

          </h4>



          <p class="text-center fw-bold mb-3 fs-6">Digite seu e-mail cadastrado para recuperar a senha</p>



          <!--

          <div class="form-floating">

            <input type="text" class="form-control rounded-0 mb-3 cpf_mask" name="cpf_user" id="floatingInputEsqueciSenha" placeholder="Esqueci a senha" />

            <label for="floatingInputEsqueciSenha" class="fw-bold small text-secondary">CPF</label>

          </div>

          -->



          <div class="form-floating mb-3">

              <input type="email" class="form-control border-primary campo-obrigatorio email_mask" name="email" id="email" placeholder="Email" value="">

              <label for="email" class="fw-bold small text-primary form-label">E-mail <span class="text-danger">*</span>

                <span class="aviso_label text-danger px-2" id="aviso_label_email" style="display:none"> </span>

              </label>

          </div>



          <div class="justify-content-center">

            <button type="submit" class="btn btn-primary w-100">

              Enviar

              <!-- SPINNER -->

              <span class="spinner ms-1" style="display: none">

                  <div class="spinner-border spinner-border-sm ml-2" role="status">

                      <span class="sr-only"></span>

                  </div>

              </span>

              <!-- SPINNER -->

            </button>

          </div>

        </form>



      <?php } ?>





      <div class="mt-3">

        <a href="<?= get_the_permalink(164); ?>" class="bg-transparent border-0 link-primary p-0 small text-decoration-underline" title="Login">Voltar para a tela de  login</a>

      </div>



      <div class="mt-3">

        <p class="small">Não possui cadastro? <a href="<?= get_the_permalink(162); ?>" title="Cadastre-se">Clique aqui</a></p>

      </div>



    </div>

  </div>

</div>



<!--  -->





</div>



</main>



<?php get_footer(); ?>

