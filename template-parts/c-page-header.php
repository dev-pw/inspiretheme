<?php

if (is_home()):
    $title_header = get_the_title(get_option('page_for_posts'));
endif;

if (is_category()):
    $title_header = single_term_title('', false);
endif;

if (is_single() || is_page()):
    $title_header = get_the_title();
endif;

if (is_404()):
    $title_header = "Página não encontrada";
endif;

if (is_search()):
    $title_header = "Pesquisa";
endif;

?>

<header class="c-page-header">
    <div class="container c-page-header__content">
        <h1 class="c-page-header__title"> <?= $title_header; ?> </h1>
    </div>
</header>

<div class="container my-3">
    <?php get_template_part("template-parts/c-breadcrumbs"); ?>
</div>
