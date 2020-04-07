<?php
$head = array(
    'title' => ucwords($city->name),
);

queue_css_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css");
queue_js_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js");

echo head($head);

$banner = get_active_city_banner($city->id);
$festivals = get_all_festivals_in_city($city->id);
?>

<style>
    @media (min-width: 576px) {
        .card-columns {
            column-count: 2;
        }
    }

    @media (min-width: 768px) {
        .card-columns {
            column-count: 2;
        }
    }

    @media (min-width: 992px) {
        .card-columns {
            column-count: 3;
        }
    }

    @media (min-width: 1200px) {
        .card-columns {
            column-count: 4;
        }
    }
</style>

<section class="container-fluid px-0 overflow-hidden">

    <!--Header & Buttons-->
    <section id="top2" class="pl-4 pr-4" style="height: 690px;">

        <div class="row">
            <div class="col d-flex justify-content-center">
                <h2 class="text-capitalize text-center size-2 pt-2 pb-2"><?= $city->name; ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-6 order-2 col-lg-3 order-1">
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
    </section>


    <!--Posters-->
    <section id="posters" class="container d-flex flex-column justify-content-center mt-5 p-4 bg-light">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Posters</h3>
                <span class="text-muted">
                    Here a collection of posters from festivals held in <span class="text-capitalize"><?= $city->name; ?></span>.
                    Click one to enlarge it on your screen.
                </span>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col">
                <?php if (count(get_all_posters_for_city($city->id)) > 0): ?>
                    <?php foreach ($festivals as $festival): ?>
                        <?php
                        $posters = get_all_posters_for_festival($festival->id);
                        ?>
                        <div class="row">
                            <div class="col">
                                <h4 class="title"><?= strpos($festival->title, "default festival") ? "uncategorized" : $festival->title; ?></h4>
                                <div class="card-columns">
                                    <?php foreach ($posters as $poster): ?>
                                        <div class="card mb-4 shadow-sm display-inline-block">
                                            <img class="img-fluid w-100" src="<?= get_relative_path($poster->get_thumbnail_path()); ?>" alt="<?= $poster->title; ?>"/>
                                            <a href="<?= get_relative_path($poster->get_path()); ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $poster->title; ?>"></a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>There are no posters available for this city. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!--Photos-->
    <section id="photos" class="container d-flex flex-column justify-content-center mt-5 p-4">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Photos</h3>
                <span class="text-muted">
                    Here a collection of photos from festivals held in <span class="text-capitalize"><?= $country->name; ?></span>.
                    Click one to enlarge it on your screen.
                </span>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col">
                <?php if (count(get_all_photos_for_city($city->id)) > 0): ?>
                    <?php foreach ($festivals as $festival): ?>
                        <?php
                        $photos = get_all_posters_for_festival($festival->id);
                        ?>
                        <div class="row">
                            <div class="col">
                                <h4 class="title"><?= strpos($festival->title, "default festival") ? "uncategorized" : $festival->title; ?></h4>
                                <div class="card-columns">
                                    <?php foreach ($photos as $photo): ?>
                                        <div class="card mb-4 shadow-sm display-inline-block">
                                            <img class="img-fluid w-100" src="<?= get_relative_path($photo->get_thumbnail_path()); ?>" alt="<?= $photo->title; ?>"/>
                                            <a href="<?= get_relative_path($photo->get_path()); ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $photo->title; ?>"></a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>There are no photos available for this city. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!--Print Media -->
    <section id="print-media" class="container d-flex flex-column justify-content-center mt-5 p-4 bg-light ">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Print Media</h3>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col">
                <?php if (count(get_all_print_media_for_city($city->id)) > 0): ?>
                    <?php foreach ($festivals as $festival): ?>
                        <?php
                        $printMedia = get_all_print_media_for_festival($festival->id);
                        ?>
                        <div class="row">
                            <div class="col">
                                <h4 class="title"><?= strpos($festival->title, "default festival") ? "uncategorized" : $festival->title; ?></h4>
                                <div class="card-columns">
                                    <?php foreach ($printMedia as $media): ?>
                                        <div class="card mb-4 shadow-sm display-inline-block">
                                            <img class="img-fluid w-100" src="<?= get_relative_path($media->get_thumbnail_path()); ?>" alt="<?= $media->title; ?>"/>
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $media->title; ?>></h5>
                                                <p class="card-text"><?= $media->description; ?></p>
                                            </div>
                                            <a href="<?= get_relative_path($media->get_path()); ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $media->title; ?>"></a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>There is no print media available for this city. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!--Memorabilia-->
    <section id="memorabilia" class="container d-flex flex-column justify-content-center mt-5 p-4 bg-light ">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Memorabilia</h3>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col">
                <?php if (count(get_all_memorabilia_for_city($city->id)) > 0): ?>
                    <?php foreach ($festivals as $festival): ?>
                        <?php
                        $memorabilia = get_all_memorabilia_for_festival($festival->id);
                        ?>
                        <div class="row">
                            <div class="col">
                                <h4 class="title"><?= strpos($festival->title, "default festival") ? "uncategorized" : $festival->title; ?></h4>
                                <div class="card-columns">
                                    <?php foreach ($memorabilia as $film_catalog): ?>
                                        <div class="card mb-4 shadow-sm display-inline-block">
                                            <img class="img-fluid w-100" src="<?= get_relative_path($film_catalog->get_thumbnail_path()); ?>" alt="<?= $film_catalog->title; ?>"/>
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $film_catalog->title; ?>></h5>
                                                <p class="card-text"><?= $film_catalog->description; ?></p>
                                            </div>
                                            <a href="<?= get_relative_path($film_catalog->get_path()); ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $film_catalog->title; ?>"></a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>There are no memorabilia available for this city. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!--Films-->
    <section id="films" class="container d-flex flex-column justify-content-center mt-5 p-4 bg-light ">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Films</h3>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col">
                <?php if (count(get_all_films_for_city($city->id)) > 0): ?>
                    <?php foreach ($festivals as $festival): ?>
                        <?php
                        $films = get_all_films_for_festival($festival->id);
                        ?>
                        <div class="row">
                            <div class="col">
                                <h4 class="title"><?= strpos($festival->title, "default festival") ? "uncategorized" : $festival->title; ?></h4>
                                <div class="card-columns">
                                    <?php foreach ($films as $film_catalog): ?>
                                        <div class="card mb-4 shadow-sm display-inline-block">
                                            <img class="img-fluid w-100" src="<?= get_relative_path($film_catalog->get_thumbnail_path()); ?>" alt="<?= $film_catalog->title; ?>"/>
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $film_catalog->title; ?>></h5>
                                                <p class="card-text"><?= $film_catalog->description; ?></p>
                                            </div>
                                            <a href="<?= get_relative_path($film_catalog->get_path()); ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $film_catalog->title; ?>"></a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>There are no films available for this city. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!--Filmmakers-->
    <section id="filmmakers" class="container d-flex flex-column justify-content-center mt-5 p-4 bg-light ">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Filmmakers</h3>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col">
                <?php if (count(get_all_filmmakers_for_city($city->id)) > 0): ?>
                    <?php foreach ($festivals as $festival): ?>
                        <?php
                        $filmmakers = get_all_filmmakers_for_festival($festival->id);
                        ?>
                        <div class="row">
                            <div class="col">
                                <h4 class="title"><?= strpos($festival->title, "default festival") ? "uncategorized" : $festival->title; ?></h4>
                                <div class="card-columns">
                                    <?php foreach ($filmmakers as $film_catalog): ?>
                                        <div class="card mb-4 shadow-sm display-inline-block">
                                            <img class="img-fluid w-100" src="<?= get_relative_path($film_catalog->get_thumbnail_path()); ?>" alt="<?= $film_catalog->title; ?>"/>
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $film_catalog->title; ?>></h5>
                                                <p class="card-text"><?= $film_catalog->description; ?></p>
                                            </div>
                                            <a href="<?= get_relative_path($film_catalog->get_path()); ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $film_catalog->title; ?>"></a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>There are no filmmakers available for this city. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!--Filmmakers-->
    <section id="filmmakers" class="container d-flex flex-column justify-content-center mt-5 p-4 bg-light ">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Film Catalogs</h3>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col">
                <?php if (count(get_all_film_catalogs_for_city($city->id)) > 0): ?>
                    <?php foreach ($festivals as $festival): ?>
                        <?php
                        $film_catalogs = get_all_film_catalogs_for_festival($festival->id);
                        ?>
                        <div class="row">
                            <div class="col">
                                <h4 class="title"><?= strpos($festival->title, "default festival") ? "uncategorized" : $festival->title; ?></h4>
                                <div class="card-columns">
                                    <?php foreach ($film_catalogs as $film_catalog): ?>
                                        <div class="card mb-4 shadow-sm display-inline-block">
                                            <img class="img-fluid w-100" src="<?= get_relative_path($film_catalog->get_thumbnail_path()); ?>" alt="<?= $film_catalog->title; ?>"/>
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $film_catalog->title; ?>></h5>
                                                <p class="card-text"><?= $film_catalog->description; ?></p>
                                            </div>
                                            <a href="<?= get_relative_path($film_catalog->get_path()); ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $film_catalog->title; ?>"></a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>There are no filmmakers available for this city. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>


</section>


<?php echo foot(); ?>
