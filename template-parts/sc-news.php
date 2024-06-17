<section id="associado" style="background: url(<?= wp_get_attachment_image_src( 138, 'full')[0]; ?>) no-repeat; background-size: cover; background-position: center;">
    <div class="container u-pt-5 u-pb-5">
        <div class="row gy-4 justify-content-between align-items-center">

            <div class="col-lg-6 text-white">
                <h2 class="h3 mb-4" style="max-width: 460px;">Para receber nossos informativos, cadastre-se abaixo </h2>
                <form
                class="form_news"
                data-action-caminho="<?= get_template_directory_uri(); ?>"
                data-action="newsletter/inserir" method="POST">
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control text-white" name="nome-news" id="floatingInputGridNome" placeholder="Nome">
                                <label for="floatingInputGridNome">Nome</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="email" class="form-control text-white" name="email-news" id="floatingInputGridEmail" placeholder="Email">
                                <label for="floatingInputGridEmail">Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" class="btn btn-light w-100 text-primary" value="ENVIAR">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
