<!-- Start Banner 
============================================= -->
<section id="banner">

    <div class="swiper">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <?php
            $args = array(
                'post_type' => 'banners',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'ASC',
                'post_status' => 'publish',
            );

            $image = new WP_Query($args);
            if ($image->have_posts()) : while ($image->have_posts()) : $image->the_post();

                    $desktop = get_field('imagem_desktop');
                    $mobile = get_field('imagem_mobile');
                    $target = get_field('link_de_destino');
                    $link_inserido = get_field('inserir_link');
                    $use_page = get_field('pagina_interna');
                    $page_link = get_field('selecione_a_pagina');
                    $links = get_field('link');

                    if ($links) {
                        if ($use_page == 'true') {
                            $link = 'href="' . get_the_permalink($page_link) . '"';
                        } else if ($link_inserido) {
                            $link = 'href="' . $link_inserido . '"';
                        } else {
                            $link = '';
                        }
                    }
                    ($target == 'true') ? $targ = 'target="_blank"' : $targ = '';

            ?>

                    <div class="swiper-slide">
                        <a <?= $link . $targ; ?>>
                            <picture>
                                <source srcset="<?= $desktop['url']; ?>" media="(min-width: 768px)">
                                <img src="<?= $mobile['url']; ?>" alt="<?= get_the_title(); ?>" class="img-fluid w-100">
                            </picture>
                        </a>
                    </div>

            <?php endwhile;
            endif;
            wp_reset_postdata(); ?>

        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

    </div>

</section>

<script>
    jQuery(document).ready(function($) {
        // SWIPER
        const swiper = new Swiper('#banner .swiper', {
            // Optional parameters
            loop: true,

            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

        });

        var body = $('body');
    });
</script>

<!-- End Banner -->
