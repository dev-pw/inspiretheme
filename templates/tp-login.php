<?php
/**
 * Template Name: Login
 * Template Post Type: post, page
 * @package WordPress
 * @subpackage inspiretheme
 *
*/

include(dirname(__FILE__)."/../form_action/util/apenas_deslogado.php");

get_header();

?>


<main role="main">

	<header class="c-page-header">
		<div class="container">
			<h1 class="text-white"><?php the_title(); ?> </h1>
        </div>
    </header>

    <div class="container mt-3">
        <?php get_template_part("template-parts/breadcrumbs"); ?>
    </div>

    <div class="pt-5 u-pb-5">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-6">
                    <form
                    class="shadow border bg-light-subtle p-4 rounded-2 form_login"
                    data-action-caminho="<?php echo get_template_directory_uri() ?>" data-action="associado/login" method="post">

                        <div class="d-flex justify-content-center mb-2">
                            <span class="icon-user-circle-o display-4 text-primary"></span>
                        </div>

                        <p class="text-center fw-bold mb-4 fs-6">Preencha com seus dados de acesso</p>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control border-primary campo-obrigatorio email_mask" name="email" id="email" placeholder="Email" value="">
                            <label for="email" class="fw-bold small text-primary form-label">E-mail <span class="text-danger">*</span>
                              <span class="aviso_label text-danger px-2" id="aviso_label_email" style="display:none"> </span>
                            </label>
                        </div>

                        <!-- SENHA -->
                        <div class="campo-senha">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control border-primary campo-obrigatorio" name="senha" id="senha" placeholder="Senha">
                                <label for="senha" class="fw-bold small text-primary form-label">Senha <span class="text-danger">*</span>
                                    <span class="aviso_label text-danger px-2" id="aviso_label_senha" style="display:none"> </span>
                                </label>
                            </div>
                            <span class="campo-senha__ver" style="color: #105075;"> <span class="icon-eye fs-6"></span> </span>
                        </div>


                        <div class="row">
                            <div class="col-md-12 d-flex align-items-center justify-content-center justify-content-md-end mt-3 mt-md-0">
                                <button type="submit" name="button" class="btn btn-primary rounded-2 text-uppercase w-100">
                                    Acessar
                                    <!-- SPINNER -->
                                    <span class="spinner ms-1" style="display: none">
                                        <div class="spinner-border spinner-border-sm ml-2" role="status">
                                            <span class="sr-only"></span>
                                        </div>
                                    </span>
                                    <!-- SPINNER -->
                                </button>
                            </div>
                        </div>

                    </form>

                    <div class="mt-4">
                      <a href="<?= get_the_permalink(); ?>" class="bg-transparent border-0 link-primary p-0  text-decoration-underline" title="Esqueci a senha">Esqueci a senha</a>
                    </div>

                    <div class="mt-3">
                      <p class="">Não possui cadastro? <a href="<?= get_the_permalink(); ?>" title="Cadastre-se">Clique aqui</a></p>
                    </div>

                </div>

            </div>

        </div>
    </div>
</main>

<?php get_footer(); ?>

