<?php
/**
* Page painel associado
*
* Template Name: Painel
* Template Post Type: page
*
* @package WordPress
* @subpackage sbv
*
*/

$msg_erro = "";

// ÁREA APENAS PARA LOGADOS
include(dirname(__FILE__)."/../form_action/util/apenas_logado.php");
include(dirname(__FILE__)."/../form_action/connection_siga.php");
include(dirname(__FILE__)."/../include/status-associacao.php"); // verifica status da associação

get_header();

// USUÁRIO
try {
  $pdo = conectar();

  $exibir_renovacao = false;

  $stmt = $pdo->prepare("
    SELECT * FROM siga_servico
    LEFT JOIN siga_categoria ON siga_servico.id_categoria = siga_categoria.id_categoria
    WHERE venda_status != 'I'
    AND data_final > '".date("Y-m-d")."'
    AND siga_servico.id_produto NOT IN (SELECT id_produto FROM siga_servico_associado WHERE id_associado = '".$_SESSION['id']."' AND status_pagto = 'Pago' )
  ");
  $stmt->execute();
  $produtos = $stmt->fetchAll();
  $num_produtos = $stmt->rowCount();

  foreach ($produtos as $key => $produto) {

    if($associacao_nome_produto != $produto['produto']){
      $exibir_renovacao = true;
    }

  }

} catch(PDOException $e) {
$responseError = array(
  'status' => 'erro',
  'erro' => 'Error: ' . $e->getMessage()
);
echo json_encode($responseError);
}

?>

<style media="screen">
  .item_painel{
    position: relative;
    overflow: hidden;
    background: linear-gradient(45deg, #121212, transparent) #105075;
    width: 100%;
    min-height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    color: #FFF;
    font-weight: 600;
    padding: 20px;
    text-align: center;
    transition: .2s all ease-in;
    margin-bottom: 20px;
  }

  .item_painel:hover{
    color: #FFF;
    transform: scale(1.03);
  }

  .item_painel_icone{
    width: 100%;
    height: 100%;
    position: absolute;
    opacity: 0.09;
    font-size: 5em;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .item_painel_logout{
    position: relative;
    overflow: hidden;
    background: #dc3545;
    width: 100%;
    min-height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    color: #FFF;
    font-weight: 600;
    padding: 20px;
    text-align: center;
    transition: .2s all ease-in;
  }

  .item_painel_logout:hover{
    color: #FFF;
    background: #d9534f;
  }

</style>

<main>

  <header class="c-page-header">
  <div class="container">
    <h1 class="text-white"><?php the_title(); ?></h1>
      </div>
  </header>

<div class="container my-5">

    <div class="l-page-content">
      <div class="container">

        <div class="row">

          <div class="col-lg-12">

            <?php if(empty($msg_erro)){ ?>


          <h5 class="mb-2 pb-1">Bem vindo(a), <strong class="text-primary"><?php echo ucwords($_SESSION['nome']) ?></strong> </h5>
          <h6 class="mb-4 pb-1">
            <?php $validade_associacao = ($associacao_ativa && !is_null($associacao_validade)) ? ' | Válida até:</span> <strong class="text-success">'.$associacao_validade.'</strong>' : ''; ?>
            <?php echo ($associacao_ativa) ? '<p class="mb-1">Status da associação: <strong class="text-success">Ativa - '.$associacao_categoria.'</strong> '.$validade_associacao.' </p>': '<p>Status da associação: <strong class="text-danger">Inativa</strong> </p>'; ?>
           </h6>


          <div class="row gx-xl-5">

            <!--  -->
            <!--  -->

            <?php if($num_produtos > 0 && ($associacao_validade != '31/12/'.date('Y') || is_null($associacao_validade) ) ){ ?>
              <div class="col-md-12">
                <a class="item_painel hover-grow fs-5" href="#" style="min-height: 130px; position: relative; overflow: hidden;" data-bs-toggle="modal" data-bs-target="#modalNovoMembro" id="btn_novo_titular">
                  <span>
                    <?php echo ($associacao_ativa) ? 'Renove sua associação!' : 'Seja um associado!'; ?>
                    <br>
                    <span style="color: #ffffffd1"> <?php echo ($associacao_ativa) ? 'Clique aqui para renovar a sua associação com a SBC' : 'Clique aqui para se tornar um associado SBC'; ?>  </span>
                  </span>
                </a>
              </div>

              <!-- MODAL FORM -->
              <!-- Modal -->
              <div class="modal fade" id="modalNovoMembro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalNovoMembroLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">

                    <div class="modal-body shadow-lg p-4 p-lg-5">
                      <div class="col-lg-12 d-flex justify-content-between">
                        <h4 class="text-primary text-start mb-4"> <strong> <?php echo ($associacao_ativa) ? 'Renove sua associação!' : 'Seja um associado!'; ?> </strong></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <form
                      class="c-form-1 c-box-radius form_validar_cad mt-2"
                      method="POST"
                      action="#"
                      data-action-caminho="<?php echo get_template_directory_uri()?>"
                      data-action="associado/validar-cadastro"
                      >

                      <div class="row g-2">

                        <div class="col-lg-12">

                          <div class="form-floating">
                            <select class="form-select border-primary campo-obrigatorio w-100" name="produto" id="produto" aria-label="Associação">
                              <option value="" disabled selected>Selecione a anuidade</option>
                              <?php foreach ($produtos as $key => $produto) {  ?>
                                <option value="<?php echo $produto['id_produto'] ?>"><?php echo $produto['produto'] ?> - R$<?php echo $produto['valor'] ?>,00</option>
                              <?php } ?>
                            </select>
                            <label for="produto" class="text-primary fw-bold">Associação <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_produto" style="display:none"></span></label>
                          </div>

                          <!--  -->

                        </div>

                        <div class="col-xl-12 d-flex justify-content-center justify-content-md-end mt-4">
                          <button type="submit" class="btn btn-primary w-100">
                            Enviar
                            <!-- SPINNER -->
                            <span class="spinner" style="display: none">
                               <div class="spinner-border spinner-border-sm ml-2" role="status">
                                  <span class="sr-only"></span>
                               </div>
                            </span>
                            <!-- SPINNER -->
                          </button>
                        </div>

                      </div>

                    </form>


                  </div>

                </div>
              </div>
            </div>
          <?php } ?>


            <!--  -->
            <!--  -->

            <!--  -->
            <?php if($associacao_ativa){ ?>
              <div class="col-md-6 col-lg-4 col-xl-3 d-none">
                <a class="item_painel hover-grow " href="<?= get_the_permalink(9313); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                  <span>
                      <p class="mb-1 fs-6"> Encontre seu médico </p>
                      <p class="fs-6 mb-0"><small> Clique aqui e faça parte!</small></p>
                    </span>
                  <span class="item_painel_icone"><i class="fa-solid fa-globe"></i></span>
                </a>
              </div>
            <?php } ?>
            <!--  -->

            <?php if($associacao_ativa){ ?>
            <div class="col-md-6 col-lg-4 col-xl-3 d-none">
              <a class="item_painel hover-grow " href="<?= get_the_permalink(6158); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Certificados, anuidades e <br> logs de acesso</span>
                <span class="item_painel_icone"><i class="fa-solid fa-certificate"></i></span>
              </a>
            </div>
          <?php } ?>
          <!--  -->

          <?php if($associacao_ativa){ ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <a class="item_painel hover-grow " href="<?= get_the_permalink(732); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span> Cálculo de LIOs </span>
                <span class="item_painel_icone"><i class="fa-solid fa-globe"></i></span>
              </a>
            </div>
          <?php } ?>

          <?php if($associacao_ativa){ ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <a class="item_painel hover-grow " href="<?= get_post_type_archive_link('post-privado'); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Publicações</span>
                <span class="item_painel_icone"><i class="fa-solid fa-newspaper"></i></span>
              </a>
            </div>
            <!--  -->
          <?php } ?>


          <?php if($associacao_ativa){ ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <a class="item_painel hover-grow " href="<?= get_the_permalink(741); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span> Tabela Antimicrobianos </span>
                <span class="item_painel_icone"><i class="fa-solid fa-layer-group"></i></span>
              </a>
            </div>
          <?php } ?>

          <?php if($associacao_ativa){ ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <a class="item_painel hover-grow " href="<?= get_post_type_archive_link('video'); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span> Vídeos Cirúrgicos </span>
                <span class="item_painel_icone"><i class="fa-solid fa-layer-group"></i></span>
              </a>
            </div>
          <?php } ?>

          <?php if($associacao_ativa){ ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <a class="item_painel hover-grow " href="<?= get_the_permalink(746); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Webinars</span>
                <span class="item_painel_icone"><i class="fa-solid fa-newspaper"></i></span>
              </a>
            </div>
            <!--  -->
          <?php } ?>

          <?php if($associacao_ativa){ ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <a class="item_painel hover-grow " href="https://chat.whatsapp.com/HZB7ywwxTLvLmqXIoxpKIi" target="_blank" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Grupo WhatsApp</span>
                <span class="item_painel_icone"> <i class="fa-brands fa-whatsapp"></i> </span>
              </a>
            </div>
            <!--  -->
          <?php } ?>


            <?php if($associacao_ativa){ ?>
            <!--  -->
            <div class="col-md-6 col-lg-4 col-xl-3 d-none">
              <a class="item_painel hover-grow " href="<?= get_the_permalink(9052); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Vídeos</span>
                <span class="item_painel_icone"><i class="fa-solid fa-play"></i></span>
              </a>
            </div>
            <!--  -->
          <?php } ?>

          <?php if($associacao_ativa){ ?>
            <div class="col-md-6 col-lg-4 col-xl-3 d-none">
              <a class="item_painel hover-grow " href="<?= get_the_permalink(3919); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Curso Fundamentos do Glaucoma</span>
                <span class="item_painel_icone"><i class="fa-brands fa-leanpub"></i></span>
              </a>
            </div>
          <?php } ?>

          <?php if($associacao_ativa){ ?>
            <div class="col-md-6 col-lg-4 col-xl-3 d-none">
              <a class="item_painel hover-grow " href="<?= get_the_permalink(9064); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Documentos contábeis</span>
                <span class="item_painel_icone"><i class="fa-solid fa-calendar-days"></i></span>
              </a>
            </div>
          <?php } ?>

          <?php if($associacao_ativa){ ?>
                <div class="col-md-3">
                  <a class="item_painel hover-grow " href="<?php echo get_site_url(); ?>/encontre-seu-medico-dados/" style="min-height: 130px; position: relative; overflow: hidden;">
                    <span>
                      <p class="mb-1"> Encontre seu médico </p>
                      <p><small> Clique aqui e faça parte!</small></p>
                    </span>
                    <span class="item_painel_icone"><i class="fa-solid fa-globe"></i></span>
                  </a>
                </div>
              <?php } ?>

            <div class="col-md-6 col-lg-4 col-xl-3">
              <a class="item_painel hover-grow " href="<?= get_the_permalink('760'); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Certificados e recibos</span>
                <span class="item_painel_icone"><i class="fa-solid fa-address-book"></i></span>
              </a>
            </div>

            <div class="col-md-6 col-lg-4 col-xl-3 d-none">
              <a class="item_painel hover-grow " href="<?= get_the_permalink(9085); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Fale Conosco</span>
                <span class="item_painel_icone"><i class="fa-solid fa-address-book"></i></span>
              </a>
            </div>


            <div class="col-md-6 col-lg-4 col-xl-3">
                <a class="item_painel hover-grow " href="<?= get_the_permalink('595'); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                  <span>Atualização de cadastro</span>
                  <span class="item_painel_icone"><i class="fa-solid fa-pen"></i></span>
                </a>
              </div>
            <!--  -->

            <div class="col-md-6 col-lg-4 col-xl-3">
              <a class="item_painel hover-grow " href="<?= get_the_permalink('690'); ?>" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Redefinir senha</span>
                <span class="item_painel_icone"><i class="fa-solid fa-key"></i></span>
              </a>
            </div>

            <div class="col-md-6 col-lg-4 col-xl-3">
              <a class="item_painel_logout hover-grow" href="<?= get_template_directory_uri(); ?>/form_action/associado/logout.php" style="min-height: 130px; position: relative; overflow: hidden;">
                <span>Sair</span>
              </a>
            </div>
            <!--  -->

        </div>


      <?php }else{ ?>
        <h3 class="col-lg-12 mb-4"> Aconteceu um erro inesperado </h3>

        <div class="col-lg-12">
          <div class="bg-light px-0 py-2 p-md-4">
            <div class="col-lg-12">
              <p>Por favor, entre em contato com essa mensagem de erro em mãos para mais detalhes.</p>
              <div class="bg-white p-3">
                <div class="col-lg-12">
                  <p> <small> <strong>Mensagem de erro:</strong> </small> </p>
                  <pre style="white-space: pre-wrap;  word-break: break-word;" class="mb-0"><?= trim($msg_erro); ?></pre>
                </div>
              </div>

            </div>
          </div>
        </div>
      <?php } ?>

          </div>
        </div>


      </div>
    </div>
</div>

</main>

<?php get_footer(); ?>
