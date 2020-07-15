<?php
$head = array(
    'title' => ucwords($city->name),
);

queue_css_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css");
queue_js_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js");

echo head($head);

$banner = get_city_banner($city->id);
$festivals = get_all_festivals_in_city($city->id);

$posters = get_all_posters_for_city($city->id);
$photos = get_all_photos_for_city($city->id);
$print_medias = get_all_print_media_for_city($city->id);
$memorabilia = get_all_memorabilia_for_city($city->id);
$films = get_all_films_for_city($city->id);
$filmmakers = get_all_filmmakers_for_city($city->id);
$film_catalogs = get_all_film_catalogs_for_city($city->id);
?>

<style>
    #about, #posters, #photos, #print-media, #memorabilia, #films, #filmmakers, #film-catalogs {
        margin: 4em auto;
    }
</style>

<div class="container-fluid" id="landing">
    <div class="row">
        <div class="col">
            <h2 class="text-center py-2 text-capitalize"><?= $city->name; ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-6 order-2 col-lg-3 order-1">
            <div class="row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#about" role="button" style="height: 100px;">About</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#posters" role="button" style="height: 100px;">Posters</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#photos" role="button" style="height: 100px;">Photos</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#print-media" role="button" style="height: 100px;">Print
                        Media</a>
                </div>
            </div>
        </div>

        <div class="col-12 order-1 col-lg order-lg-2 mb-lg-0 mb-4 d-flex flex-column justify-content-center align-items-center ">
            <div class="d-flex flex-column justify-content-center align-items-center bg-dark w-100 h-100" style="background-color:#2e2e2e; color: #FFFFFF;">
                <img class="img-fluid d-none d-lg-block w-100" src="<?= $banner != null ? get_relative_path($banner->get_path()) : img("placeholder.svg") ?>" alt="Banner Image"/>
            </div>
        </div>

        <div class="col-6 order-3 col-lg-3 order-lg-3">
            <div class="row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#memorabilia" role="button"
                       style="height: 100px;">Memorabilia</a>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#films" role="button" style="height: 100px;">Films</a>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#filmmakers" role="button" style="height: 100px;">Filmmakers</a>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#film-catalogs" role="button" style="height: 100px;">Film
                        Catalogs</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container px-0 py-5">

    <!--About-->
    <div class="row" id="about">
        <div class="col">
            <h3>About</h3>
            <p class="text-muted">
                Background information about <span class="title"><?= $city->name; ?></span>
            </p>
            <?php $description = $city->description; ?>
            <?php if ($description == null): ?>
                <p>There is no information available for this city.</p>
            <?php else: ?>
                <p><?= $description; ?></p>
            <?php endif; ?>
        </div>
    </div>


    <?= $this->partial("__components/records-page.php", array(
        "admin" => false,
//        "root_url" => $root_url,
        "records" => array(
            "posters" => $posters,
            "photos" => $photos,
            "print_media" => $print_medias,
            "memorabilia" => $memorabilia,
            "films" => $films,
            "filmmakers" => $filmmakers,
            "film_catalogs" => $film_catalogs,
        )
    ));
    ?>

</div>


<?php echo foot(); ?>
