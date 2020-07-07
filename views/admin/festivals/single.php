<?php
echo head(array(
    'title' => $festival->get_title(),
));

$rootURL = "/admin/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name) . "/festivals/" . $festival->id;

$film_catalogs = get_all_film_catalogs_for_festival($festival->id);
$films = get_all_films_for_festival($festival->id);
$memorabilia = get_all_memorabilia_for_festival($festival->id);
$print_medias = get_all_print_media_for_festival($festival->id);
$photos = get_all_photos_for_festival($festival->id);
$posters = get_all_posters_for_festival($festival->id);
?>


<style>
    iframe {
        width: auto;
    }
</style>

<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2 class="text-capitalize">
                <?= $festival->get_title(); ?>
                <a class="btn btn-primary" href='<?= $rootURL; ?>/edit'>Edit</a>
                <a class="btn btn-danger" href='<?= $rootURL; ?>/delete'>Delete</a>
            </h2>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <h3>
                Film Catalogs (<?= count($film_catalogs); ?>)
                <a class="btn btn-success btn-sm" href="<?= $rootURL; ?>/film-catalogs/add">Add Film Catalog</a>
            </h3>
            <?php if (count($film_catalogs) == 0): ?>
                <p>There are no film catalogs available for this festival.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($film_catalogs as $film_catalog): ?>
                        <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $film_catalog)); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>
                Films (<?= count($films); ?>)
                <a class="btn btn-success btn-sm" href="<?= $rootURL; ?>/films/add">Add Film</a>
            </h3>
            <?php if (count($films) == 0): ?>
                <p>There are no films available for this festival.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($films as $film): ?>
                        <?= $this->partial("__components/festival-record-card-video.php", array('record' => $film)); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>
                Memorabilia (<?= count($memorabilia); ?>)
                <a class="btn btn-success btn-sm" href="<?= $rootURL; ?>/memorabilia/add">Add Memorabilia</a>
            </h3>
            <?php if (count($memorabilia) == 0): ?>
                <p>There are no memorabilia available for this festival.</p>
            <?php else: ?>
                <?php foreach ($memorabilia as $memorabilium): ?>
                    <div class="card d-inline-block my-2 mx-2" style="width: 18rem;">
                        <a href="<?= get_relative_path($memorabilium->get_path()) ?>" data-fancybox="fb-memorabilia" data-title="<?= $memorabilium->title; ?>">
                            <img class="card-img-top" src="<?= get_relative_path($memorabilium->get_thumbnail_path()); ?>" alt="<?= $memorabilium->title; ?>"/>
                        </a>
                        <div class="card-body">
                            <p>
                                <span class="font-weight-bold">
                                Title:
                                </span>
                                <?= $memorabilium->title == "" ? "Untitled" : $memorabilium->title; ?>
                            </p>
                            <p class="text-muted">
                                <span class="font-weight-bold text-dark">
                                Description:
                                </span>
                                <?= $memorabilium->description == "" ? "No description available." : $memorabilium->description; ?>
                            </p>
                            <p>
                                <span class="font-weight-bold">
                                Contributor:
                                </span>
                                <?= $memorabilium->contributor ? $memorabilium->contributor->get_display_name() : "No contributor." ?>
                            </p>
                            <div>
                                <a class="btn btn-primary" href="<?= $rootURL; ?>/memorabilia/<?= $memorabilium->id; ?>/edit">Edit</a>
                                <a class="btn btn-danger" href="<?= $rootURL; ?>/memorabilia/<?= $memorabilium->id; ?>/delete">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>
                Print Media (<?= count($print_medias); ?>)
                <a class="btn btn-success btn-sm" href="<?= $rootURL; ?>/print-media/add">Add Print Media</a>
            </h3>
            <?php if (count($print_medias) == 0): ?>
                <p>There is no print media available for this festival.</p>
            <?php else: ?>
                <?php foreach ($print_medias as $print_media): ?>
                    <div class="card d-inline-block my-2 mx-2" style="width: 18rem;">
                        <a href="<?= get_relative_path($print_media->get_path()) ?>" data-fancybox="fb-print-media" data-title="<?= $print_media->title; ?>">
                            <img class="card-img-top" src="<?= get_relative_path($print_media->get_thumbnail_path()); ?>" alt="<?= $print_media->title; ?>"/>
                        </a>
                        <div class="card-body">
                            <p>
                                <span class="font-weight-bold">
                                Title:
                                </span>
                                <?= $print_media->title == "" ? "Untitled" : $print_media->title; ?>
                            </p>
                            <p class="text-muted">
                                <span class="font-weight-bold text-dark">
                                Description:
                                </span>
                                <?= $print_media->description == "" ? "No description available." : $print_media->description; ?>
                            </p>
                            <p>
                                <span class="font-weight-bold">
                                Contributor:
                                </span>
                                <?= $print_media->contributor ? $print_media->contributor->get_display_name() : "No contributor." ?>
                            </p>
                            <div>
                                <a class="btn btn-primary" href="<?= $rootURL; ?>/print-media/<?= $print_media->id; ?>/edit">Edit</a>
                                <a class="btn btn-danger" href="<?= $rootURL; ?>/print-media/<?= $print_media->id; ?>/delete">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>
                Photos (<?= count($photos); ?>)
                <a class="btn btn-success btn-sm" href="<?= $rootURL; ?>/photos/add">Add Photo</a>
            </h3>
            <?php if (count($photos) == 0): ?>
                <p>There are no photos available for this festival.</p>
            <?php else: ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="card d-inline-block my-2 mx-2" style="width: 18rem;">
                        <a href="<?= get_relative_path($photo->get_path()) ?>" data-fancybox="fb-photos" data-title="<?= $photo->title; ?>">
                            <img class="card-img-top" src="<?= get_relative_path($photo->get_thumbnail_path()); ?>" alt="<?= $photo->title; ?>"/>
                        </a>
                        <div class="card-body">
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

    <div class="row">
        <div class="col">
            <h3>
                Posters (<?= count($posters); ?>)
                <a class="btn btn-success btn-sm" href="<?= $rootURL; ?>/posters/add">Add Poster</a>
            </h3>
            <?php if (count($posters) == 0): ?>
                <p>There are no posters available for this festival.</p>
            <?php else: ?>
                <?php foreach ($posters as $poster): ?>
                    <div class="card d-inline-block my-2 mx-2" style="width: 18rem;">
                        <a href="<?= get_relative_path($poster->get_path()) ?>" data-fancybox="fb-posters" data-title="<?= $poster->title; ?>">
                            <img class="card-img-top" src="<?= get_relative_path($poster->get_thumbnail_path()); ?>" alt="<?= $poster->title; ?>"/>
                        </a>
                        <div class="card-body">
                            <p>
                                <span class="font-weight-bold">
                                Title:
                                </span>
                                <?= $poster->title == "" ? "Untitled" : $poster->title; ?>
                            </p>
                            <p class="text-muted">
                                <span class="font-weight-bold text-dark">
                                Description:
                                </span>
                                <?= $poster->description == "" ? "No description available." : $poster->description; ?>
                            </p>
                            <p>
                                <span class="font-weight-bold">
                                Contributor:
                                </span>
                                <?= $poster->contributor ? $poster->contributor->get_display_name() : "No contributor." ?>
                            </p>
                            <div>
                                <a class="btn btn-primary" href="<?= $rootURL; ?>/posters/<?= $poster->id; ?>/edit">Edit</a>
                                <a class="btn btn-danger" href="<?= $rootURL; ?>/posters/<?= $poster->id; ?>/delete">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>


</section>

<?php echo foot(); ?>

