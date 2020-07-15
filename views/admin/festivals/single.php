<?php
echo head(array(
    'title' => $festival->get_title(),
));

$city_url = "/admin/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name);
$root_url = $city_url . "/festivals/" . $festival->id;

$film_catalogs = get_all_film_catalogs_for_festival($festival->id);
$films = get_all_films_for_festival($festival->id);
$memorabilia = get_all_memorabilia_for_festival($festival->id);
$print_medias = get_all_print_media_for_festival($festival->id);
$photos = get_all_photos_for_festival($festival->id);
$posters = get_all_posters_for_festival($festival->id);
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

