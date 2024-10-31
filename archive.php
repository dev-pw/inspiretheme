<?php
/**
 * Archive
 *
 * @package WordPress
 * @subpackage inspiretheme
 *
 */

get_header(); ?>

<main role="main">

	<header class="c-page-header">
        <div class="container">
            <h1 class="text-white"><?= the_archive_title(); ?></h1>
        </div>
    </header>

    <div class="container mt-3">
        <?php get_template_part("template-parts/breadcrumbs"); ?>
    </div>

    <div class="pt-5 u-pb-5">

        <div class="container">

            <?php
            if (have_posts()): ?>

            <div class="mb-5">
                <p class="fs-5 fw-bold lh-base mb-3 text-primary">Pesquisar</p>
                <?php get_search_form(); ?>
            </div>

            <div class="row gy-5 gx-xl-5">

                <?php while (have_posts()):the_post(); ?>
                <article id="article-id-<?php the_id(); ?>" <?php post_class('col-md-6 col-lg-4'); ?>>
                    <?php get_template_part('template-parts/card-post'); ?>
                </article>
                <?php endwhile; ?>

                <div class="d-flex justify-content-center mt-5">
                    <?php paging_nav(); ?>
                </div>

            </div>

            <?php else: ?>

            <div>
                <p class="c-bloco-mensagem c-bloco-mensagem__primary mb-4">Sem posts cadastrados no momento</p>
                <a href="<?php bloginfo('url'); ?>" title="Página inicial" class="btn btn-secondary">Home</a>
            </div>

            <?php endif;
            wp_reset_query(); ?>

        </div>
    </div>
</main>

<?php get_footer(); ?>
