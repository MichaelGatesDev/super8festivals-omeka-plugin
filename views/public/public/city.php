<?php
$head = array(
    'title' => ucwords($city->name),
);

queue_css_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css");
queue_js_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js");

echo head($head);

$banner = get_city_banner($city->id);
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

    #short-nav-nav ul li {
        margin: 0 0.75em;
    }
</style>

<nav id="short-nav" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom justify-content-center text-center" style="display: none">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#short-nav-nav" aria-controls="short-nav-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-start">
        <div class="navbar-nav">
            <div class="nav-item"><a class="nav-link" href="#">Top of Page</a></div>
        </div>
    </div>
    <div class="collapse navbar-collapse justify-content-center" id="short-nav-nav">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link d-lg-none" href="#">Top of Page</a></li>
            <li class="nav-item"><a class="nav-link" href="#posters">Posters</a></li>
            <li class="nav-item"><a class="nav-link" href="#photos">Photos</a></li>
            <li class="nav-item"><a class="nav-link" href="#print-media">Print Media</a></li>
            <li class="nav-item "><a class="nav-link" href="#memorabilia">Memorabilia</a></li>
            <li class="nav-item"><a class="nav-link" href="#films">Films</a></li>
            <li class="nav-item"><a class="nav-link" href="#filmmakers">Filmmakers</a></li>
            <li class="nav-item"><a class="nav-link" href="#film-catalogs">Film Catalogs</a></li>
        </ul>
    </div>
    <div class="collapse navbar-collapse justify-content-end">
        <div class="navbar-nav">
            <div class="nav-item"><a class="nav-link" href="#">Top of Page</a></div>
        </div>
    </div>
</nav>

<script>
    $(document).ready(() => {
        const elemAdminBar = $("#admin-bar");
        const elemHeader = $("header");

        const totalPrependedHeight = (elemAdminBar.is(":visible") ? elemAdminBar.height() : 0) + elemHeader.height();
        const windowHeight = $(window).height();
        const remainingHeight = windowHeight - totalPrependedHeight;

        const elemLanding = $("#landing");
        elemLanding.css("height", remainingHeight + "px");

        const elemShortNav = $("#short-nav");
        $(window).scroll(function () {
            if ($(window).scrollTop() >= (elemLanding.position().top + elemLanding.outerHeight(true))) {
                elemShortNav.fadeIn(150);
            } else {
                elemShortNav.fadeOut(150);
            }
        });
    });
</script>

<div class="container-fluid overflow-hidden" id="landing">
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

<div class="container-fluid px-0">

    <!--About-->

    <section id="about" class="container mt-5 p-4 bg-light">
        <div class="row">
            <div class="col">
                <h3 class="pt-2 pb-2 title">About</h3>
                <span class="text-muted">
                    Background information about <span class="title"><?= $city->name; ?></span>
                </span>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col">
                <?php $description = $city->description; ?>
                <?php if ($description == null): ?>
                    <p>There is no information available for this city.</p>
                <?php else: ?>
                    <p><?= $description; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!--Posters-->
    <?= $this->partial("__components/records-section-image.php", array(
        "records_name" => "posters",
        "section_id" => "posters",
        "section_title" => "Posters",
        "section_description" => "Here is a collection of {records_name} from festivals held in {country_name}.",
        "section_no_records_msg" => "There are no {records_name} available for {country_name}. If you have any you would like to submit, please <a href='submit'>click here</a>.",
        "city" => $city,
        "record_type" => Super8FestivalsRecordType::FestivalPoster,
    )); ?>

    <!--Photos-->
    <?= $this->partial("__components/records-section-image.php", array(
        "records_name" => "photos",
        "section_id" => "photos",
        "section_title" => "Photos",
        "section_description" => "Here is a collection of {records_name} from festivals held in {country_name}.",
        "section_no_records_msg" => "There are no {records_name} available for {country_name}. If you have any you would like to submit, please <a href='submit'>click here</a>.",
        "city" => $city,
        "record_type" => Super8FestivalsRecordType::FestivalPhoto,
    )); ?>

    <!--Print Media -->
    <?= $this->partial("__components/records-section-document.php", array(
        "records_name" => "print media",
        "section_id" => "print-media",
        "section_title" => "Print Media",
        "section_description" => "Here is a collection of {records_name} from festivals held in {country_name}.",
        "section_no_records_msg" => "There are no {records_name} available for {country_name}. If you have any you would like to submit, please <a href='submit'>click here</a>.",
        "city" => $city,
        "record_type" => Super8FestivalsRecordType::FestivalPrintMedia,
    )); ?>

    <!--Memorabilia-->
    <?= $this->partial("__components/records-section-document.php", array(
        "records_name" => "memorabilia",
        "section_id" => "memorabilia",
        "section_title" => "Memorabilia",
        "section_description" => "Here is a collection of {records_name} from festivals held in {country_name}.",
        "section_no_records_msg" => "There are no {records_name} available for {country_name}. If you have any you would like to submit, please <a href='submit'>click here</a>.",
        "city" => $city,
        "record_type" => Super8FestivalsRecordType::FestivalMemorabilia,
    )); ?>

    <!--Films-->
    <?= $this->partial("__components/records-section-video.php", array(
        "records_name" => "films",
        "section_id" => "films",
        "section_title" => "Films",
        "section_description" => "Here is a collection of {records_name} from festivals held in {country_name}.",
        "section_no_records_msg" => "There are no {records_name} available for {country_name}. If you have any you would like to submit, please <a href='submit'>click here</a>.",
        "city" => $city,
        "record_type" => Super8FestivalsRecordType::FestivalFilm,
    )); ?>

    <!--Filmmakers-->
    <?= $this->partial("__components/records-section-person.php", array(
        "records_name" => "filmmakers",
        "section_id" => "filmmakers",
        "section_title" => "Filmmakers",
        "section_description" => "Here is a collection of {records_name} from festivals held in {country_name}.",
        "section_no_records_msg" => "There are no {records_name} available for {country_name}. If you have any you would like to submit, please <a href='submit'>click here</a>.",
        "city" => $city,
        "record_type" => Super8FestivalsRecordType::FestivalFilmmaker,
    )); ?>

    <!--Film Catalogs-->
    <?= $this->partial("__components/records-section-document.php", array(
        "records_name" => "film catalogs",
        "section_id" => "film-catalogs",
        "section_title" => "Film Catalogs",
        "section_description" => "Here is a collection of {records_name} from festivals held in {country_name}.",
        "section_no_records_msg" => "There are no {records_name} available for {country_name}. If you have any you would like to submit, please <a href='submit'>click here</a>.",
        "city" => $city,
        "record_type" => Super8FestivalsRecordType::FestivalFilmCatalog,
    )); ?>


</div>


<?php echo foot(); ?>
