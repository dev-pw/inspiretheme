<?php
/**
 * Footer
 * @package WordPress
 * @subpackage pwtheme
 *
*/
if( !is_page(79) ){
    get_template_part('template-parts/sc-news');
}

?>

<footer class="bg-primary py-3">
    <div class="container">
        <div class="row gy-4 align-items-center justify-content-between position-relative">
            <div class="col-12 col-lg-auto position-relative z-1">
                <?= // Redes Sociais
                get_template_part('template-parts/sc-redes-sociais'); ?>
            </div>
            <div class="col l-footer__texto">
                <p class="m-0 text-center text-white"> <?= get_option('copy'); ?> </p>
            </div>
            <div class="col-12 col-lg-auto text-center z-1 position-relative s-bl-pw">
                <a href="https://planetaw.ag/" title="Planeta W - Design + Web" target="_blank">
                    <?= wp_get_attachment_image( 7, 'full', "", ["class" => "img-fluid"]); ?>
                </a>
            </div>
        </div>
    </div>
</footer>

</div><!-- WRAPPER SITE -->

<?php get_template_part('inc/modal-retorno'); ?>

<?php wp_footer(); ?>

</body>
</html>
