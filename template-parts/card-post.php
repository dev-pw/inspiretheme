<?php

    (has_post_thumbnail()) ? $img = get_post_thumbnail_id($post->ID) : $img = 61;

    if(get_post_type() == 'video'){
        (has_post_thumbnail()) ? $img = get_post_thumbnail_id($post->ID) : $img = 821;
    }

?>

<div class="c-card-post u-hover-translate-y-top-2 rounded-4 overflow-hidden h-100">

    <div>
        <a href="<?= the_permalink(); ?>" class="text-decoration-none" title="<?= the_title(); ?>">
            <?= wp_get_attachment_image( $img, 'full', '', ['class' => 'img-fluid c-card-post__image']); ?>
        </a>
    </div>

    <div class="p-4 text-white bg-primary h-100">

        <div class="gx-3 row">
            <div class="col-auto" style="font-size: 14px;">
                <span class="icon-calendar me-1 text-white"></span>
                <span class="small">
                    <?= get_the_date('d/m/Y'); ?>
                </span>
            </div>
            <?php if (has_category()): ?>
            <div class="col-auto c-post-metadata c-post-metadata--light" style="font-size: 14px;">
                <span class="icon-folder me-1 text-white"></span>
                <?php the_category(', '); ?>
            </div>
            <?php endif; ?>
        </div>
        <hr>
        <div>
            <a href="<?= the_permalink(); ?>" class="text-decoration-none text-white" title="<?= the_title(); ?>">
                <h2 class="fs-5 lh-base mb-0">
                    <?= the_title(); ?>
                </h2>
            </a>
        </div>
    </div>
</div>