<style>
    <?= include 'css/style.css'; ?>
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="<?= get_template_directory_uri() ?>/inc/options/js/style.js"></script>


<div class="wrap">
    <h2 class="title">Opções do Site <span class="small">v<?= $version; ?></span> </h2>
    <div class="row mx-0">
        <div class="border col-lg-3 col-xl-2 p-0">
            <div class="menu d-flex flex-column align-items-start">
                <div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <?php
                $count = 0;
                foreach ($args as $index => $value) :
                    echo '
                    <button class="nav-link" id="v-pills-' . $count . '-tab" data-bs-toggle="pill" data-bs-target="#v-pills-' . $count . '" type="button" role="tab" aria-controls="v-pills-' . $count . '" aria-selected="false"> 
                    <span class="' . $value[1] . ' ms-3 me-3"></span> ' . $index . ' </button>';
                    $count++;
                endforeach; ?>

                </div>
            </div>
        </div>
        <div class="border col-lg-9 col-xl-10 bg-white">
            <div class="p-5">
                <div class="tab-content">
                    <?php
                    $count = 0;
                    foreach ($args as $index => $title) :
                    echo '<div class="tab-pane fade" id="v-pills-' . $count . '" role="tabpanel" aria-labelledby="v-pills-' . $count . '-tab" tabindex="0">
                    <form method="post" action="options.php">';
                    settings_fields(''.$title[0].'');
                    do_settings_sections(''.$title[0].'');
                    submit_button();
                    echo '</form> </div>';
                    $count++;
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
