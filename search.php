<?php
/**
 * Search
 *
 * @package WordPress
 * @subpackage inspiretheme
 *
 */

?>

<?php get_header(); ?>

<main role="main">

    <header class="c-page-header">
        <div class="container">
            <h1 class="text-white mb-0">Pesquisa</h1>
        </div>
    </header>

    <div class="container mt-3">
        <?php get_template_part("template-parts/breadcrumbs"); ?>
    </div>

    <div class="pt-5 u-pb-5">

        <div class="container">

            <p class="c-bloco-mensagem c-bloco-mensagem__primary mb-5"><?php _e('Você pesquisou por:') ?>
                <?php echo get_search_query(); ?>
            </p>

            <?php if (have_posts()): ?>
            <ul class="list-unstyled c-list-search">

                <?php while (have_posts()):the_post(); ?>
                <li id="post-<?php the_ID(); ?>" <?php post_class('item'); ?>>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="text-decoration-none">
                        <h2 class="fs-6"><?php the_title(); ?></h2>
                    </a>
                    <?php if (get_the_category()): ?>
                    <div class="col-auto c-post-metadata" style="font-size: 15px;">
                        <span class="icon-folder me-1 text-dark"></span>
                        <?php the_category(', '); ?>
                    </div>
                    <?php endif; ?>
                </li>
                <?php endwhile; ?>

            </ul>

            <div class="d-flex gap-2 justify-content-center mt-4">
                <?php paging_nav(); ?>
            </div>

            <?php else: ?>

            <div>
                <p class="c-bloco-mensagem c-bloco-mensagem__primary mb-4">Não foram encontrados resultados!</p>
                <a href="<?php bloginfo('url'); ?>" title="Página inicial" class="btn btn-secondary">Home</a>
            </div>

            <?php endif; ?>

        </div>
    </div>

</main>

<?php get_footer(); ?>
