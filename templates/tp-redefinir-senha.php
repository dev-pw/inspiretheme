<?php

/**

* Page

*

* Template Naminspirethemeinir senha

* Template Post Type: page

*

* @package WordPress

* @subpackage inspiretheme

*

*/



// ÁREA APENAS PARA DESLOGADOS

include(dirname(__FILE__)."/../form_action/connection_siga.php");

include(dirname(__FILE__)."/../form_action/util/apenas_logado.php");

date_default_timezone_set('America/Sao_Paulo');





get_header();

?>





<main>

  <header class="c-page-header">

  <div class="container">

    <h1 class="text-white">Redefinir Senha</h1>

      </div>

  </header>



  <div class="container py-5">

    <div class="pad-5">



      <div class="l-page-content">

        <div class="container">



          <div class="row">





            <div class="col-lg-6 offset-lg-3">



                <!-- FORM RECUPERAR SENHA -->

                <form class="c-form-1 border bg-light p-5 rounded form_redef_senha border p-5" data-action-caminho="<?php echo get_template_directory_uri()?>" data-action="associado/redefinir-senha" method="post">



                  <!-- SENHA ATUAL -->

                  <div class="campo-senha">



                    <div class="form-floating mb-3">

                      <input type="password" class="form-control border-primary campo-obrigatorio" name="senha_atual" id="senha_atual" placeholder="Nova senha:">

                      <label for="senha_atual" class="fw-bold small text-primary form-label">Senha atual <span class="text-secondary">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_senha_atual" style="display:none"> </span></label>

                    </div>

                    <span class="campo-senha__ver" style="color: #105075;"> <span class="icon-eye fs-6"></span> </span>



                  </div>



                  <!-- NOVA SENHA -->

                  <div class="campo-senha">



                    <div class="form-floating mb-3">

                      <input type="password" class="form-control border-primary campo-obrigatorio" name="senha_nova" id="senha_nova" placeholder="Nova senha:">

                      <label for="senha_nova" class="fw-bold small text-primary form-label">Nova senha <span class="text-secondary">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_senha_nova" style="display:none"> </span></label>

                    </div>

                    <span class="campo-senha__ver" style="color: #105075;"> <span class="icon-eye fs-6"></span> </span>



                  </div>



                  <!-- CONFIRMAR NOVA SENHA -->

                  <div class="campo-senha">



                    <div class="form-floating mb-3">

                      <input type="password" class="form-control border-primary campo-obrigatorio" name="senha_nova_conf" id="senha_nova_conf" placeholder="Confirmar nova senha:">

                      <label for="senha_nova_conf" class="fw-bold small text-primary form-label">Confirmar nova senha <span class="text-secondary">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_senha_nova_conf" style="display:none"> </span></label>

                    </div>

                    <span class="campo-senha__ver" style="color: #105075;"> <span class="icon-eye fs-6"></span> </span>



                  </div>



                  <div class="row">



                    <div class="col-md-6 d-flex justify-content-center align-items-center justify-content-md-start mt-4">

                      <small>

                        <u><a href="<?php bloginfo('url')?>/painel" title="Voltar" class="text-primary">Voltar</a></u>

                      </small>

                    </div>





                    <div class="col-md-6 d-flex justify-content-center justify-content-md-end mt-4">

                      <button type="submit" name="button" class="btn btn-primary ">

                        Enviar

                        <!-- SPINNER -->

                        <span class="spinner" style="display: none">

                          <div class="spinner-border spinner-border-sm ml-2" role="status">

                            <span class="sr-only">Loading...</span>

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

    </div>

  </div>



</main>



<?php get_footer(); ?>

