<?php

// ---- STYLES ----
// -- START BOOTSTRAP --
queue_css_url('//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
// -- END BOOTSTRAP --

// ---- SCRIPTS ----
// -- START BOOTSTRAP --
queue_js_url("https://code.jquery.com/jquery-3.3.1.slim.min.js");
queue_js_url("https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js");
queue_js_url("https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js");
// -- END BOOTSTRAP --
// jQuery
queue_js_url("https://code.jquery.com/jquery-3.4.1.min.js");


echo head(array(
    'title' => 'Edit Country: ' . $country->name,
));

?>

<?php echo flash(); ?>


<div style="display: flex; flex-direction: column;">
    <h2>General Information</h2>
    <div style="position: relative; width: 100%; height: 100%; ">
        <?php echo $form; ?>
    </div>

    <div class="row">
        <div class="col">
            <h2>Posters</h2>
            <div style="max-height: 400px; overflow-y: scroll;">
                <div class="card-columns">
                    <?php foreach (get_all_posters_for_country($country->id) as $poster): ?>
                        <div class="card">
                            <img src="<?= $poster->path; ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= $poster->title; ?></h5>
                                <p class="card-text"><?= $poster->description; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <h2>Photos</h2>
            <div style="max-height: 400px; overflow-y: scroll;">
                <div class="card-columns">
                    <?php foreach (get_all_photos_for_country($country->id) as $photo): ?>
                        <div class="card">
                            <img src="<?= $photo->path; ?>" class="card-img-top" alt="">
                            <div class="card-body">
                                <h5 class="card-title"><?= $photo->title; ?></h5>
                                <p class="card-text"><?= $photo->description; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <h2>Newspapers &amp; Magazines</h2>
            <div style="max-height: 400px; overflow-y: scroll;">
                <div class="card-columns">
                    <?php foreach (get_all_print_media_for_country($country->id) as $media): ?>
                        <div class="card">
                            <img src="<?= $media->path; ?>" class="card-img-top" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


</div>


<?php echo foot(); ?>
