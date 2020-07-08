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
            <h2 class="text-center py-2 capitalize"><?= $city->name; ?></h2>
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
    <div class="row my-5" id="about">
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
    <div class="row my-5" id="posters">
        <div class="col">
            <h3>
                Posters (<?= count($posters); ?>)
            </h3>
            <?php if (count($posters) == 0): ?>
                <p>There are no film catalogs available for this festival.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($posters as $poster): ?>
                        <?php
                        $information = array();
                        array_push($information, array(
                            "key" => "title",
                            "value" => $poster->title == "" ? "Untitled" : $poster->title,
                        ));
                        array_push($information, array(
                            "key" => "description",
                            "value" => $poster->description == "" ? "No description" : $poster->description,
                        ));
                        array_push($information, array(
                            "key" => "festival",
                            "value" => $poster->get_festival()->year == 0 ? "Uncategorized" : $poster->get_festival()->year,
                        ));
                        if ($poster->get_contributor()) {
                            array_push($information, array(
                                "key" => "contributor",
                                "value" => $poster->get_contributor()->get_display_name(),
                            ));
                        }
                        echo $this->partial("__components/record-card.php", array(
                            'card_width' => '300px',
                            // 'embed' => $film->embed,
                            'thumbnail_path' => get_relative_path($poster->get_thumbnail_path()),
                            'preview_path' => get_relative_path($poster->get_path()),
                            'fancybox_category' => 'posters',
                            'information' => $information,
                        )); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!--Photos-->
    <div class="row my-5" id="photos">
        <div class="col">
            <h3>
                Photos (<?= count($photos); ?>)
            </h3>
            <?php if (count($photos) == 0): ?>
                <p>There are no film catalogs available for this festival.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($photos as $photo): ?>
                        <?php
                        $information = array();
                        array_push($information, array(
                            "key" => "title",
                            "value" => $photo->title == "" ? "Untitled" : $photo->title,
                        ));
                        array_push($information, array(
                            "key" => "description",
                            "value" => $photo->description == "" ? "No description" : $photo->description,
                        ));
                        array_push($information, array(
                            "key" => "festival",
                            "value" => $photo->get_festival()->year == 0 ? "Uncategorized" : $photo->get_festival()->year,
                        ));
                        if ($photo->get_contributor()) {
                            array_push($information, array(
                                "key" => "contributor",
                                "value" => $photo->get_contributor()->get_display_name(),
                            ));
                        }
                        echo $this->partial("__components/record-card.php", array(
                            'card_width' => '300px',
                            // 'embed' => $film->embed,
                            'thumbnail_path' => get_relative_path($photo->get_thumbnail_path()),
                            'preview_path' => get_relative_path($photo->get_path()),
                            'fancybox_category' => 'photos',
                            'information' => $information,
                        )); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!--Print Media -->
    <div class="row my-5" id="print-media">
        <div class="col">
            <h3>
                Print Media (<?= count($print_media); ?>)
            </h3>
            <?php if (count($print_media) == 0): ?>
                <p>There is no print media available for this festival.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($print_media as $print_medium): ?>
                        <?php
                        $information = array();
                        array_push($information, array(
                            "key" => "title",
                            "value" => $print_medium->title == "" ? "Untitled" : $print_medium->title,
                        ));
                        array_push($information, array(
                            "key" => "description",
                            "value" => $print_medium->description == "" ? "No description" : $print_medium->description,
                        ));
                        array_push($information, array(
                            "key" => "festival",
                            "value" => $print_medium->get_festival()->year == 0 ? "Uncategorized" : $print_medium->get_festival()->year,
                        ));
                        if ($print_medium->get_contributor()) {
                            array_push($information, array(
                                "key" => "contributor",
                                "value" => $print_medium->get_contributor()->get_display_name(),
                            ));
                        }
                        echo $this->partial("__components/record-card.php", array(
                            'card_width' => '300px',
                            // 'embed' => $film->embed,
                            'thumbnail_path' => get_relative_path($print_medium->get_thumbnail_path()),
                            'preview_path' => get_relative_path($print_medium->get_path()),
                            'fancybox_category' => 'print-media',
                            'information' => $information,
                        )); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!--Memorabilia-->
    <div class="row my-5" id="memorabilia">
        <div class="col">
            <h3>
                Memorabilia (<?= count($memorabilia); ?>)
            </h3>
            <?php if (count($memorabilia) == 0): ?>
                <p>There is no print media available for this festival.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($memorabilia as $memorabilium): ?>
                        <?php
                        $information = array();
                        array_push($information, array(
                            "key" => "title",
                            "value" => $memorabilium->title == "" ? "Untitled" : $memorabilium->title,
                        ));
                        array_push($information, array(
                            "key" => "description",
                            "value" => $memorabilium->description == "" ? "No description" : $memorabilium->description,
                        ));
                        array_push($information, array(
                            "key" => "festival",
                            "value" => $memorabilium->get_festival()->year == 0 ? "Uncategorized" : $memorabilium->get_festival()->year,
                        ));
                        if ($memorabilium->get_contributor()) {
                            array_push($information, array(
                                "key" => "contributor",
                                "value" => $memorabilium->get_contributor()->get_display_name(),
                            ));
                        }
                        echo $this->partial("__components/record-card.php", array(
                            'card_width' => '300px',
                            // 'embed' => $film->embed,
                            'thumbnail_path' => get_relative_path($memorabilium->get_thumbnail_path()),
                            'preview_path' => get_relative_path($memorabilium->get_path()),
                            'fancybox_category' => 'memorabilia',
                            'information' => $information,
                        )); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!--Films-->
    <div class="row my-5" id="films">
        <div class="col">
            <h3>
                Films (<?= count($films); ?>)
            </h3>
            <?php if (count($films) == 0): ?>
                <p>There is no print media available for this festival.</p>
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
                        if ($film->get_contributor()) {
                            array_push($information, array(
                                "key" => "contributor",
                                "value" => $film->get_contributor()->get_display_name(),
                            ));
                        }
                        if ($film->get_filmmaker()) {
                            array_push($information, array(
                                "key" => "Filmmaker",
                                "value" => $film->get_filmmaker()->get_display_name(),
                            ));
                        }
                        echo $this->partial("__components/record-card.php", array(
                            'card_width' => '300px',
                            'embed' => $film->embed,
//                            'thumbnail_path' => get_relative_path($film->get_thumbnail_path()),
//                            'preview_path' => get_relative_path($film->get_path()),
//                            'fancybox_category' => 'film',
                            'information' => $information,
                        )); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <div class="row my-5" id="filmmakers">
        <div class="col">
            <h3>Filmmakers</h3>
            <p class="text-muted">
                Here is a collection of filmmakers from <span class="title"><?= $city->name; ?></span>
            </p>
            <?php if (count($filmmakers = get_all_filmmakers_for_city($city->id)) > 0): ?>
                <div class="row row-cols">
                    <?php foreach ($filmmakers as $filmmaker): ?>
                        <div class="card d-inline-block m-4">
                            <div class="card-body">
                                <h5 class="card-title text-capitalize"><?= $filmmaker->get_display_name(); ?></h5>
                            </div>
                            <a href="/filmmakers/<?= $filmmaker->id; ?>" class="stretched-link"></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>
                    There are no filmmakers for this city.
                </p>
            <?php endif; ?>
        </div>
    </div>


    <!--Film Catalogs-->
    <div class="row my-5" id="film-catalogs">
        <div class="col">
            <h3>
                Film Catalogs (<?= count($film_catalogs); ?>)
            </h3>
            <?php if (count($film_catalogs) == 0): ?>
                <p>There is no print media available for this festival.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($film_catalogs as $film_catalog): ?>
                        <?php
                        $information = array();
                        array_push($information, array(
                            "key" => "title",
                            "value" => $film_catalog->title == "" ? "Untitled" : $film_catalog->title,
                        ));
                        array_push($information, array(
                            "key" => "description",
                            "value" => $film_catalog->description == "" ? "No description" : $film_catalog->description,
                        ));
                        array_push($information, array(
                            "key" => "festival",
                            "value" => $film_catalog->get_festival()->year == 0 ? "Uncategorized" : $film_catalog->get_festival()->year,
                        ));
                        if ($film_catalog->get_contributor()) {
                            array_push($information, array(
                                "key" => "contributor",
                                "value" => $film_catalog->get_contributor()->get_display_name(),
                            ));
                        }
                        echo $this->partial("__components/record-card.php", array(
                            'card_width' => '300px',
                            // 'embed' => $film->embed,
                            'thumbnail_path' => get_relative_path($film_catalog->get_thumbnail_path()),
                            'preview_path' => get_relative_path($film_catalog->get_path()),
                            'fancybox_category' => 'film-catalog',
                            'information' => $information,
                        )); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>


<?php echo foot(); ?>
