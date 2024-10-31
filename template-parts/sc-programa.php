<section style="background: url(<?= wp_get_attachment_image_src(26, 'full')[0]; ?>) no-repeat center/cover;">
    <div class="container u-py-5">
        <div class="row justify-content-lg-end">
            <div class="col-md-6">
                <h2> <?= get_the_title(23); ?> </h2>
                <p> <?= get_the_excerpt(23); ?> </p>
                <a href="<?= the_permalink(23); ?>" target="_blank" class="btn btn-secondary" rel="noopener noreferrer"> Saiba mais </a>
            </div>
        </div>
    </div>
</section>