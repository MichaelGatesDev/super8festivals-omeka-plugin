<?php
echo head(array(
    'title' => $festival->id
));

$city_url = "/admin/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name);
$root_url = $city_url . "/festivals/" . $festival->id;

$film_catalogs = SuperEightFestivalsFestivalFilmCatalog::get_by_param('festival_id', $festival->id);
$films = SuperEightFestivalsFestivalFilm::get_by_param('festival_id', $festival->id);
$memorabilia = SuperEightFestivalsFestivalMemorabilia::get_by_param('festival_id', $festival->id);
$print_medias = SuperEightFestivalsFestivalPrintMedia::get_by_param('festival_id', $festival->id);
$photos = SuperEightFestivalsFestivalPhoto::get_by_param('festival_id', $festival->id);
$posters = SuperEightFestivalsFestivalPoster::get_by_param('festival_id', $festival->id);
?>


<style>
    iframe {
        width: 100%;
    }

    .container > .row:not(:first-child):not(:nth-child(2)) {
        margin: 3em 0;
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
                <a class="btn btn-primary" href='<?= $root_url; ?>/edit'>Edit</a>
                <a class="btn btn-danger" href='<?= $root_url; ?>/delete'>Delete</a>
            </h2>
        </div>
    </div>

    <?= $this->partial("__components/records-page.php", array(
        "admin" => true,
        "root_url" => $root_url,
        "filmmakers_url" => $city_url . "/filmmakers",
        "records" => array(
            "posters" => $posters,
            "photos" => $photos,
            "print_media" => $print_medias,
            "memorabilia" => $memorabilia,
            "films" => $films,
            "film_catalogs" => $film_catalogs,
        )
    ));
    ?>

</section>

<?php echo foot(); ?>

