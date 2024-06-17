<section class="u-pt-5 u-pb-5">
    <div class="container">
        <div class="row gy-4 gy-lg-0">

            <div class="col-12 col-md-auto d-md-flex align-items-md-center">
                <h2 class="text-primary mb-0 text-center text-md-start"> Notícias </h2>
            </div>

            <div class="col-12 col-md-7 col-lg-6 d-md-flex align-items-md-center">
                <p class="text-primary mb-0 text-center text-md-start fs-3"> Acompanhe as últimas notícias e dicas sobre saúde ocular </p>
            </div>

            <div class="col-12 mt-5">
                <div class="row gy-5 gy-lg-0">

                    <?php

                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 3
                    );

                    $blog = new WP_Query($args);
                    if ($blog->have_posts()) : while ($blog->have_posts()) : $blog->the_post(); ?>

                    <div class="col-md-6 col-lg-4">
                        <?= get_template_part('template-parts/card-post'); ?>
                    </div>

                    <?php endwhile; endif; wp_reset_postdata(); ?>

                </div>
            </div>

            <div class="col-12 col-lg-auto text-center mt-5">
                <a href="<?= the_permalink(10); ?>" class="btn btn-secondary">VER TODOS</a>
            </div>

        </div>
    </div>
</section>

