<?php
$country_loc = $country->get_location();
$city_loc = $city->get_location();
$city_url = "/admin/super-eight-festivals/countries/" . urlencode($country_loc->name) . "/cities/" . urlencode($city_loc->name);
$root_url = $city_url . "/festivals/" . $festival->id;

$film_catalogs = SuperEightFestivalsFestivalFilmCatalog::get_by_param('festival_id', $festival->id);
$films = SuperEightFestivalsFestivalFilm::get_by_param('festival_id', $festival->id);
$memorabilia = SuperEightFestivalsFestivalMemorabilia::get_by_param('festival_id', $festival->id);
$print_medias = SuperEightFestivalsFestivalPrintMedia::get_by_param('festival_id', $festival->id);
$photos = SuperEightFestivalsFestivalPhoto::get_by_param('festival_id', $festival->id);
$posters = SuperEightFestivalsFestivalPoster::get_by_param('festival_id', $festival->id);
?>

<?= $this->partial("__partials/header.php", ["title" => "Festival: {$festival->id}"]); ?>

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
            </h2>
        </div>
    </div>

    <!-- S8F Alerts -->
    <div class="row">
        <div class="col">
            <s8f-alerts-area id="alerts"></s8f-alerts-area>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <s8f-festival-films-table
                country-id="<?= $country->id; ?>"
                city-id="<?= $city->id; ?>"
                festival-id="<?= $festival->id; ?>"
            >
            </s8f-festival-films-table>
        </div>
    </div>

    <?php
    //    $this->partial("__components/records-page.php", array(
    //        "admin" => true,
    //        "root_url" => $root_url,
    //        "filmmakers_url" => $city_url . "/filmmakers",
    //        "records" => array(
    //            "posters" => $posters,
    //            "photos" => $photos,
    //            "print_media" => $print_medias,
    //            "memorabilia" => $memorabilia,
    //            "films" => $films,
    //            "film_catalogs" => $film_catalogs,
    //        )
    //    ));
    ?>

</section>

<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-festival-films-table.js'></script>

<?= $this->partial("__partials/footer.php") ?>
