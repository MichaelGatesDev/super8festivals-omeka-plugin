<?php
// fancybox
queue_css_url("//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css");
queue_js_url("//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js");
$head = array(
    'title' => $country->name,
);
echo head($head);
?>

<?php
$banner = get_banner_for_country($country->id);
$posters = get_all_posters_for_country($country->id);
$photos = get_all_photos_for_country($country->id);
$printMedias = get_all_print_media_for_country($country->id);
$memorabilias = get_all_memorabilia_for_country($country->id);
$films = get_all_films_for_country($country->id);
$filmmakers = get_all_filmmakers_for_country($country->id);
?>

<?php echo flash(); ?>

<!--Embedded style because omeka loading order is a pain in the sass-->
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
                <h2 class="text-capitalize text-center size-2 pt-2 pb-2"><?= $country->name; ?></h2>
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
                <div class="d-flex flex-column justify-content-center align-items-center bg-dark" style="background-color:#2e2e2e; color: #FFFFFF;">
                    <img class="img-fluid d-none d-lg-block" src="<?= $banner != null ? $banner->path : img("placeholder.svg") ?>" alt="Banner Image"/>
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
                    Here a collection of posters from festivals held in <span class="text-capitalize"><?= $country->name; ?></span>.
                    Click one to enlarge it on your screen.
                </span>
            </div>
        </div>
        <div class="row d-flex flex-row justify-content-center pt-4">
            <?php if (count($posters) > 0): ?>
                <div class="card-columns">
                    <?php foreach ($posters as $poster): ?>
                        <div class="card mb-4 shadow-sm display-inline-block">
                            <img class="img-fluid w-100" src="<?= $poster->thumbnail; ?>" alt="<?= $poster->title; ?>"/>
                            <div class="card-body">
                                <h5 class="card-title"><?= $poster->title; ?></h5>
                                <p class="card-text"><?= $poster->description; ?></p>
                            </div>
                            <a href="<?= $poster->path; ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $poster->title; ?>"></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="col">
                    <p>There are no posters available for this country. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                </div>
            <?php endif; ?>
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
        <div class="row d-flex flex-row justify-content-center pt-4">
            <?php if (count($photos) > 0): ?>
                <div class="card-columns">
                    <?php foreach ($photos as $photo): ?>
                        <div class="card mb-4 shadow-sm display-inline-block">
                            <img class="img-fluid w-100" src="<?= $photo->thumbnail; ?>" alt="<?= $photo->title; ?>"/>
                            <div class="card-body">
                                <h5 class="card-title"><?= $photo->title; ?></h5>
                                <p class="card-text"><?= $photo->description; ?></p>
                            </div>
                            <a href="<?= $photo->path; ?>" class="stretched-link" data-fancybox="fb-photos" data-title="<?= $photo->title; ?>"></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="col">
                    <p>There are no photos available for this country. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!--Print Media -->
    <section id="print-media" class="container d-flex flex-column justify-content-center mt-5 p-4 bg-light ">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Print Media</h3>
            </div>
        </div>
        <div class="row d-flex flex-row justify-content-center pt-4">
            <?php if (count($printMedias) > 0): ?>
                <div class="card-columns">
                    <?php foreach ($printMedias as $printMedia): ?>
                        <div class="card mb-4 shadow-sm display-inline-block">
                            <img class="img-fluid w-100" src="<?= $printMedia->thumbnail; ?>" alt=""/>
                            <a href="<?= $printMedia->path; ?>" class="stretched-link" data-fancybox="fb-printMedias" data-title=""></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="col">
                    <p>There is no print media available for this country. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!--Memorabilia-->
    <section id="memorabilia" class="container d-flex flex-column justify-content-center mt-5 p-4 bg-light ">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Memorabilia</h3>
            </div>
        </div>
        <div class="row d-flex flex-row justify-content-center pt-4">
            <?php if (count($memorabilias) > 0): ?>
                <div class="card-columns">
                    <?php foreach ($memorabilias as $memorabilia): ?>
                        <div class="card mb-4 shadow-sm display-inline-block">
                            <img class="img-fluid w-100" src="<?= $memorabilia->thumbnail; ?>" alt=""/>
                            <a href="<?= $memorabilia->path; ?>" class="stretched-link" data-fancybox="fb-memorabilias" data-title=""></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="col">
                    <p>There is no memoriabilia available for this country. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!--Films-->
    <section id="films" class="container d-flex flex-column justify-content-center mt-5 p-4 bg-light ">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Films</h3>
            </div>
        </div>
        <div class="row d-flex flex-row justify-content-center pt-4">
            <?php if (count($films) > 0): ?>
                <?php foreach ($films as $film): ?>
                    <div class="col-md-4 ">
                        <div class="card mb-4 shadow-sm">
                            <img alt="" class="card-img-top embed-responsive-item" style="object-fit: cover;" src="<?= $film->thumbnail != null ? $film->thumbnail : "https://placehold.it/280x140/abc" ?>">
                            <a href="<?= $film->url; ?>" class="stretched-link" data-fancybox="fb-films" data-title=""></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col">
                    <p>There are no films available for this country. If you have any you would like to submit, please <a href="/submit">click here</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!--Filmmakers-->
    <section id="filmmakers" class="container d-flex flex-column justify-content-center mt-5 p-4 bg-light ">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2">Filmmakers</h3>
            </div>
        </div>
        <div class="row d-flex flex-row justify-content-center pt-4">
            <div class="col">
                <?php if (count($filmmakers) > 0): ?>
                    <div class="card-group">
                        <?php foreach ($filmmakers as $filmmaker): ?>
                            <div class="card mb-4 shadow-sm display-inline-block">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <?php $cover_photo = $filmmaker->cover_photo_url; ?>
                                    <img alt="" class="card-img-top embed-responsive-item" style="object-fit: cover;" src="<?= $cover_photo != null ? $cover_photo : "https://placehold.it/280x140/abc" ?>">
                                </div>
                                <div class="card-body">
                                    <p class="card-title text-capitalize">
                                        <?php if ($filmmaker->organization_name != null): ?>
                                            <?= $filmmaker->organization_name; ?>
                                        <?php else: ?>
                                            <?php echo $filmmaker->first_name; ?>
                                            <?php echo $filmmaker->last_name; ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="card-text"></p>
                                    <a href="<?= $cover_photo; ?>" class="stretched-link" data-fancybox="fb-filmmakers" data-title=""></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>There is no information about filmmakers available.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>


</section>


<?php echo foot(); ?>
