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
    'title' => 'Edit City: ' . metadata('super_eight_festivals_city', 'name'),
));
?>

<?php echo flash(); ?>

<?php
$city = $super_eight_festivals_city;
$country = get_country_by_id($city->country_id);
?>

<div style="display: flex; flex-direction: column;">
    <div style="position: relative; width: 100%; height: 100%; ">
        <?php echo $form; ?>
    </div>

    <!--Posters Section-->
    <div class="row mx-0 mb-0 py-2">
        <div class="col">
            <h2>Posters</h2>
            <button>Upload</button>
            <div style="max-height: 500px; overflow-y: auto; overflow-x: hidden;" class="py-2">
                <div class="card-deck">
                    <?php foreach (get_all_posters_for_country($country->id) as $poster): ?>
                        <div class="card mb-4" style="min-width: 200px;">
                            <img src="<?= $poster->thumbnail; ?>" class="card-img-top" alt="" style="object-fit: contain; width: 100%; height: 150px;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $poster->title; ?></h5>
                                <p class="card-text"><?= $poster->description; ?></p>
                            </div>
                            <div class="card-footer">
                                <p class="text-capitalize">City: <?= get_city_by_id($poster->city_id)->name; ?></p>
                                <a href="/admin/super-eight-festivals/posters/edit/<?= $poster->id; ?>">Edit</a>
                                <a href="/admin/super-eight-festivals/posters/delete/<?= $poster->id; ?>">Delete</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>


</div>

<?php echo foot(); ?>
