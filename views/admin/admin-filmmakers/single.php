<?php
echo head(array(
    'title' => 'Filmmaker: ' . $filmmaker->get_display_name(),
));

$photos = SuperEightFestivalsFilmmakerPhoto::get_by_param('filmmaker_id', $filmmaker->id);
$films = SuperEightFestivalsFestivalFilm::get_by_param('filmmaker_id', $filmmaker->id);

$rootURL = "/admin/super-eight-festivals/filmmakers/" . $filmmaker->id;
?>

<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2 class="text-capitalize"><?= $filmmaker->get_display_name(); ?></h2>
        </div>
    </div>

    <!-- Films -->
    <div class="row" id="films">
        <div class="col">
            <h3>Films (<?= count($films); ?>)</h3>
            <p class="text-muted">Note: You can not upload films on this page.<br/>To add a film, you must navigate to the country -> city -> festival and add it there.</p>
            <?php if (count($films) == 0): ?>
                <p>There are no films available yet.</p>
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
                            "key" => "city",
                            "value" => $film->get_festival()->get_city()->name,
                        ));
                        array_push($information, array(
                            "key" => "festival",
                            "value" => $film->get_festival()->year == 0 ? "Uncategorized" : $film->get_festival()->year,
                        ));
                        array_push($information, array(
                            "key" => "contributor",
                            "value" => $film->contributor_id === 0 ? "No contributor" : $film->get_contributor()->get_display_name(),
                        ));
                        $filmmaker = $film->get_filmmaker();
                        $filmmaker_id = $film->filmmaker_id;
                        if ($film->contributor_id != 0 && $filmmaker != null) {
                            array_push($information, array(
                                "key" => "filmmaker",
                                "value" => $filmmaker == null || $filmmaker_id == 0 ? "No filmmaker" : "<a href='/filmmakers/$filmmaker_id/'>" . $filmmaker->get_full_name() . "</a>",
                            ));
                        }
                        echo $this->partial("__components/record-card.php", array(
                            'card_width' => '500px',
//                        'preview_height' => '300px',
//                        'preview_width' => '100%',
                            'embed' => $film->embed,
//                            'thumbnail_path' => get_relative_path($poster->get_thumbnail_path()),
//                            'preview_path' => get_relative_path($poster->get_path()),
                            'fancybox_category' => 'films',
                            'information' => $information,
                            'admin' => false,
                        )); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row my-4">
        <div class="col">
            <h3>
                Photos (<?= count($photos); ?>)
                <a class="btn btn-success btn-sm" href="<?= $rootURL; ?>/photos/add">Add Photo</a>
            </h3>
            <?php if (count($photos) == 0): ?>
                <p>There are no photos available for this filmaker.</p>
            <?php else: ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="card d-inline-block my-2 mx-2" style="width: 18rem;">
                        <a href="<?= get_relative_path($photo->get_path()) ?>" data-fancybox="fb-filmmaker-photos" data-title="<?= $photo->title; ?>">
                            <img class="card-img-top" src="<?= get_relative_path($photo->get_thumbnail_path()); ?>" alt="<?= $photo->title; ?>" loading="lazy"/>
                        </a>
                        <div class="card-body">
                            <div style="overflow: hidden;">
                                <?= $photo->embed; ?>
                            </div>
                            <p>
                                <span class="font-weight-bold">
                                Title:
                                </span>
                                <?= $photo->title == "" ? "Untitled" : $photo->title; ?>
                            </p>
                            <p class="text-muted">
                                <span class="font-weight-bold text-dark">
                                Description:
                                </span>
                                <?= $photo->description == "" ? "No description available." : $photo->description; ?>
                            </p>
                            <p>
                                <span class="font-weight-bold">
                                Contributor:
                                </span>
                                <?= $photo->contributor ? $photo->contributor->get_display_name() : "No contributor." ?>
                            </p>
                            <div>
                                <a class="btn btn-primary" href="<?= $rootURL; ?>/photos/<?= $photo->id; ?>/edit">Edit</a>
                                <a class="btn btn-danger" href="<?= $rootURL; ?>/photos/<?= $photo->id; ?>/delete">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>


</section>


<?php echo foot(); ?>
