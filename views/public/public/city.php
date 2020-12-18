<?php
$head = array(
    'title' => ucwords($city->get_location()->name),
);

queue_css_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css");
queue_js_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js");

echo head($head);

$banner = $city->get_banner();
?>

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
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#print-media" role="button" style="height: 100px;">Print Media</a>
                </div>
            </div>
        </div>

        <div class="col-12 order-1 col-lg order-lg-2 mb-lg-0 mb-4 d-flex flex-column justify-content-center align-items-center ">
            <div class="d-flex flex-column justify-content-center align-items-center bg-dark w-100 h-100" style="background-color:#2e2e2e; color: #FFFFFF;">
                <img class="img-fluid d-none d-lg-block w-100 city-banner" src="<?= $banner ? get_relative_path($banner->get_file()->get_path()) : img("placeholder.svg") ?>" alt="" loading="lazy"/>
            </div>
        </div>

        <div class="col-6 order-3 col-lg-3 order-lg-3">
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
            <div class="row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#nearby-festivals" role="button"
                       style="height: 100px;">Nearby Festivals</a>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="container px-0 py-5" id="city">

    <div class="row">
        <div class="col">
            <h2 class="my-4 text-capitalize"><?= $city->get_location()->name; ?></h2>
        </div>
    </div>

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

    <div class="row my-5">
        <div class="col">
            <h3>Posters</h3>
            <div id="posters"></div>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <h3>Photos</h3>
            <div id="photos"></div>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <h3>Print Media</h3>
            <div id="print-media"></div>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <h3>Films</h3>
            <div id="films"></div>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <h3>Filmmakers</h3>
            <div id="filmmakers"></div>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <h3>Film Catalogs</h3>
            <div id="film-catalogs"></div>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <h3>Nearby Festivals</h3>
            <div id="nearby-festivals">
                TBD
            </div>
        </div>
    </div>

</section>


<script type="module" src="/plugins/SuperEightFestivals/views/public/javascripts/components/s8f-embed-record-cards.js"></script>
<script type="module" src="/plugins/SuperEightFestivals/views/public/javascripts/components/s8f-file-record-cards.js"></script>
<script type="module" src="/plugins/SuperEightFestivals/views/public/javascripts/components/s8f-person-record-cards.js"></script>
<script type="module">
    import { html, render } from "/plugins/SuperEightFestivals/views/shared/javascripts/vendor/lit-html.js";
    import API, { HTTPRequestMethod } from "/plugins/SuperEightFestivals/views/shared/javascripts/api.js";

    const fetchPosters = () => API.performRequest(API.constructURL(["countries", "<?= $city->get_country()->id; ?>", "cities", "<?= $city->id; ?>", "posters"]), HTTPRequestMethod.GET);
    const fetchPhotos = () => API.performRequest(API.constructURL(["countries", "<?= $city->get_country()->id; ?>", "cities", "<?= $city->id; ?>", "photos"]), HTTPRequestMethod.GET);
    const fetchPrintMedia = () => API.performRequest(API.constructURL(["countries", "<?= $city->get_country()->id; ?>", "cities", "<?= $city->id; ?>", "print-media"]), HTTPRequestMethod.GET);
    const fetchFilmCatalogs = () => API.performRequest(API.constructURL(["countries", "<?= $city->get_country()->id; ?>", "cities", "<?= $city->id; ?>", "film-catalogs"]), HTTPRequestMethod.GET);
    const fetchFilms = () => API.performRequest(API.constructURL(["countries", "<?= $city->get_country()->id; ?>", "cities", "<?= $city->id; ?>", "films"]), HTTPRequestMethod.GET);
    const fetchFilmmakers = () => API.performRequest(API.constructURL(["countries", "<?= $city->get_country()->id; ?>", "cities", "<?= $city->id; ?>", "filmmakers"]), HTTPRequestMethod.GET);

    $(() => {
        fetchPosters().then((posters) => {
            render(
                html`<s8f-file-record-cards .files=${posters}></s8f-file-record-cards>`,
                document.getElementById("posters"),
            );
        });
        fetchPhotos().then((photos) => {
            render(
                html`<s8f-file-record-cards .files=${photos}></s8f-file-record-cards>`,
                document.getElementById("photos"),
            );
        });
        fetchPrintMedia().then((printMedia) => {
            render(
                html`<s8f-file-record-cards .files=${printMedia}></s8f-file-record-cards>`,
                document.getElementById("print-media"),
            );
        });
        fetchFilmCatalogs().then((filmCatalogs) => {
            render(
                html`<s8f-file-record-cards .files=${filmCatalogs}></s8f-file-record-cards>`,
                document.getElementById("film-catalogs"),
            );
        });
        fetchFilms().then((films) => {
            render(
                html`<s8f-embed-record-cards .embeds=${films.map((film => ({ ...film, ...film.filmmaker_film })))}></s8f-embed-record-cards>`,
                document.getElementById("films"),
            );
        });
        fetchFilmmakers().then((filmmakers) => {
            render(
                html`<s8f-person-record-cards .persons=${filmmakers.map((filmmaker) => ({ ...filmmaker, url: `/filmmakers/${filmmaker.id}` }))}></s8f-person-record-cards>`,
                document.getElementById("filmmakers"),
            );
        });
    });
</script>


<?php echo foot(); ?>
