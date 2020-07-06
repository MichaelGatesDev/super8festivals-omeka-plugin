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
$print_media = get_all_print_media_for_city($city->id);
$memorabilia = get_all_memorabilia_for_city($city->id);
$films = get_all_films_for_city($city->id);
$filmmakers = get_all_filmmakers_for_city($city->id);
$film_catalogs = get_all_film_catalogs_for_city($city->id);
?>

<style>
    iframe {
        width: 100%;
    }
</style>

<div class="container-fluid" id="landing">
    <div class="row">
        <div class="col">
            <h2 class="text-center py-2 title"><?= $city->name; ?></h2>
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

<div class="container px-0 pb-5">

    <!--About-->
    <div class="row">
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

    <!--Posters-->
    <div class="row">
        <div class="col">
            <h3>
                Posters (<?= count($posters); ?>)
            </h3>
            <?php if (count($posters) == 0): ?>
                <p>There are no film catalogs available for this festival.</p>
            <?php else: ?>
                <?php foreach ($posters as $poster): ?>
                    <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $poster)); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!--Photos-->
    <div class="row">
        <div class="col">
            <h3>
                Photos (<?= count($photos); ?>)
            </h3>
            <?php if (count($photos) == 0): ?>
                <p>There are no film catalogs available for this festival.</p>
            <?php else: ?>
                <?php foreach ($photos as $photo): ?>
                    <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $photo)); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!--Print Media -->
    <div class="row">
        <div class="col">
            <h3>
                Print Media (<?= count($print_media); ?>)
            </h3>
            <?php if (count($print_media) == 0): ?>
                <p>There is no print media available for this festival.</p>
            <?php else: ?>
                <?php foreach ($print_media as $print_medium): ?>
                    <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $print_medium)); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!--Memorabilia-->
    <div class="row">
        <div class="col">
            <h3>
                Memorabilia (<?= count($memorabilia); ?>)
            </h3>
            <?php if (count($memorabilia) == 0): ?>
                <p>There is no print media available for this festival.</p>
            <?php else: ?>
                <?php foreach ($memorabilia as $memorabilium): ?>
                    <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $memorabilium)); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!--Films-->
    <div class="row" id="films">
        <div class="col">
            <h3>
                Films (<?= count($films); ?>)
            </h3>
            <?php if (count($films) == 0): ?>
                <p>There is no print media available for this festival.</p>
            <?php else: ?>
                <?php foreach ($films as $film): ?>
                    <?= $this->partial("__components/festival-record-card-video.php", array('record' => $film)); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>


    <div class="row" id="filmmakers">
        <div class="col">
            <h3>Filmmakers</h3>
            <p class="text-muted">
                Here is a collection of filmmakers from <span class="title"><?= $city->name; ?></span>
            </p>
            <?php if (count($filmmakers = get_all_filmmakers_for_city($city->id)) > 0): ?>
                <?php foreach ($filmmakers as $filmmaker): ?>
                    <div class="card d-inline-block m-4">
                        <div class="card-body">
                            <h5 class="card-title text-capitalize"><?= $filmmaker->get_display_name(); ?></h5>
                        </div>
                        <a href="/filmmakers/<?= $filmmaker->id; ?>" class="stretched-link"></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>
                    There are no filmmakers for this city.
                </p>
            <?php endif; ?>
        </div>
    </div>


    <!--Film Catalogs-->
    <div class="row">
        <div class="col">
            <h3>
                Film Catalogs (<?= count($film_catalogs); ?>)
            </h3>
            <?php if (count($film_catalogs) == 0): ?>
                <p>There is no print media available for this festival.</p>
            <?php else: ?>
                <?php foreach ($film_catalogs as $film_catalog): ?>
                    <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $film_catalog)); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>


<?php echo foot(); ?>
