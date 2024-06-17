<?php
/**
 * Template Name: Contato
 * Template Post Type: post, page
 * @package WordPress
 * @subpackage pwtheme
 *
*/

get_header();

?>

<main>

    <header class="c-page-header">
		<div class="container">
			<h1 class="text-white"><?php the_title(); ?></h1>
        </div>
    </header>


    <div class="container mt-3">
        <?php get_template_part("template-parts/breadcrumbs"); ?>
    </div>

    <div class="pt-5 u-pb-5">
        <div class="container">
            <div class="row gx-xl-5 justify-content-between">

                <div class="col-lg-4 mb-5">

                    <article class="bg-terciary p-4 mb-4 text-white d-none">
                        <h2 class="h5 mb-3 text-white">Atendimento presencial e online</h2>
                        <p class="m-0"> Seg a Sex, das 08h às 18h </p>
                    </article>

                    <article class="bg-terciary p-4 mb-4 text-white d-none">
                        <h2 class="h5 mb-3 text-white">Fale Conosco</h2>
                        <p class="m-0"> Email: <a href="mailto:<?= get_option('info_1'); ?>" class="text-white"><?= get_option('info_1'); ?></a></p>
                        <p class="m-0"> Telefone: <a href="tel:55<?= get_option('info_3'); ?>" class="text-white"><?= get_option('info_3'); ?></a></p>
                    </article>

                    <article class="bg-terciary p-4 mb-4 text-white">
                        <h2 class="h5 mb-3 text-white">Endereço</h2>
                        <!-- <p class="m-0"> <?//= get_option('info_2'); ?> </p> -->
                        <p class="m-0">Rua Casa do Ator, 1117 - 2 andar - Vila Olímpia - CEP: 04546-004</p>
                    </article>

                </div>

                <article class="col-lg">
                    <div class="bg-light p-4">

                        <h2 class="fs-5 fw-bold lh-base mb-3 text-primary">Formulário de Contato</h2>
                        <form
                        class="forms-contato form_contato"
                        data-action-caminho="<?= get_template_directory_uri(); ?>"
                        data-action="contato/inserir" method="POST">

                            <input type="hidden" name="website" value="">
                            <div class="row g-2">

                                <div class="col-xl-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control border-primary text-dark" required id="campo-nome" placeholder="nome" name="nome">
                                        <label for="campo-nome" class="fw-bold small text-primary form-label">Nome 
                                            <span class="text-danger" id="aviso_label_nome">*</span> 
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control border-primary text-dark" required id="campo-email" placeholder="e-mail" name="email">
                                        <label for="campo-email" class="fw-bold small text-primary form-label">E-mail 
                                            <span class="text-danger" id="aviso_label_email">*</span> 
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control border-primary text-dark tel_mask" required id="campo-telefone" placeholder="telefone" name="telefone">
                                        <label for="campo-telefone" class="fw-bold small text-primary form-label">Telefone 
                                            <span class="text-danger" id="aviso_label_telefone">*</span> 
                                        </label>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control border-primary text-dark" required id="campo-assunto" placeholder="assunto" name="assunto">
                                        <label for="campo-assunto" class="fw-bold small text-primary form-label">Assunto 
                                            <span class="text-danger" id="aviso_label_assunto">*</span> 
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control border-primary text-dark" required placeholder="Deixe sua mensagem" id="campo-mensagem" name="mensagem" style="height: 100px"></textarea>
                                        <label for="campo-mensagem" class="fw-bold small text-primary form-label">Deixe sua mensagem 
                                            <span class="text-danger" id="aviso_label_message">*</span> 
                                        </label>
                                    </div>

                                </div>

                                <div>
                                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                    <div class="g-recaptcha" data-sitekey="6Ldi9mApAAAAAI9GOdkMIOm8xBDhkGwWSsfeqNLC" style="margin:10px 0px;"></div>
                                </div>

                                <div class="col-xl-12 d-flex justify-content-center justify-content-md-end">
                                    <button type="submit" class="btn btn-secondary">Enviar</button>
                                </div>

                            </div>

                        </form>

                    </div>

                </article>
            </div>
        </div>
    </div>

    <div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3656.207258943606!2d-46.68648972388286!3d-23.596898762900313!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce574ec2cf2fd7%3A0xbbd43d638faf5c39!2sR.%20Casa%20do%20Ator%2C%201117%20-%202%20andar%20-%20Vila%20Ol%C3%ADmpia%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2004546-004!5e0!3m2!1spt-BR!2sbr!4v1706112171121!5m2!1spt-BR!2sbr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

</main>

<?php get_footer(); ?>

