<?php
$head = array(
    'title' => "Filmmaker",
);
echo head($head);

$films = get_all_films_for_filmmaker($filmmaker->id);
$photos = get_all_photos_for_filmmaker($filmmaker->id);
?>

<section class="container my-5" id="filmmaker">

    <div class="row">
        <div class="col">
            <h2 class="my-4 text-capitalize"><?= html_escape($filmmaker->get_full_name()); ?></h2>
        </div>
    </div>

    <div class="row my-5" id="film-catalogs">
        <div class="col">
            <h3>
                Films (<?= count($films); ?>)
            </h3>
            <?php if (count($films) == 0): ?>
                <p>There are no photos available for this filmmaker.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($films as $film): ?>
                        <?php
                        $information = array();
                        array_push($information, array(
                            "key" => "title",
                            "value" => $film->title == "" ? "Untitled" : $film->title,
                        ));
                        array_push($information, array(
                            "key" => "description",
                            "value" => $film->description == "" ? "No description" : $film->description,
                        ));
                        array_push($information, array(
                            "key" => "festival",
                            "value" => $film->get_festival()->year == 0 ? "Uncategorized" : $film->get_festival()->year,
                        ));
                        array_push($information, array(
                            "key" => "contributor",
                            "value" => $film->contributor_id === 0 ? "No contributor" : $film->get_contributor()->get_display_name(),
                        ));
//                        $filmmaker = $film->get_filmmaker();
//                        $filmmaker_id = $film->filmmaker_id;
//                        array_push($information, array(
//                            "key" => "filmmaker",
//                            "value" => $filmmaker == null || $filmmaker_id == 0 ? "No filmmaker" : "<a href='/filmmakers/$filmmaker_id/'>" . $filmmaker->get_full_name() . "</a>",
//                        ));
                        echo $this->partial("__components/record-card.php", array(
                            'card_width' => '500px',
//                            'preview_height' => '300px',
                            'embed' => $film->embed,
//                            'thumbnail_path' => get_relative_path($poster->get_thumbnail_path()),
//                            'preview_path' => get_relative_path($poster->get_path()),
                            'fancybox_category' => 'films',
                            'information' => $information,
                            'admin' => false,
//                            'edit_url' => $root_url . '/films/' . $film->id . "/edit",
//                            'delete_url' => $root_url . '/films/' . $film->id . "/delete",
                        )); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row my-5" id="film-catalogs">
        <div class="col">
            <h3>
                Photos (<?= count($photos); ?>)
            </h3>
            <?php if (count($photos) == 0): ?>
                <p>There are no photos available for this filmmaker.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($photos as $photo): ?>
                        <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $photo)); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
