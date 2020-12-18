<?php
$head = array(
    'title' => "Federation",
);

queue_css_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css");
queue_js_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js");

echo head($head);
?>

<style>
    #short-nav-nav ul li {
        margin: 0 0.75em;
    }

    .carousel-inner > .carousel-item {
        height: 500px;
    }

    .carousel-inner > .carousel-item img {
        height: 500px;
        object-fit: cover;
    }
</style>

<div class="container-fluid overflow-hidden" id="landing">
    <div class="row">
        <div class="col">
            <h2 class="text-center mb-4 title">Federation</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-6 order-2 col-lg-3 order-1">
            <div class="row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#newsletters" role="button" style="height: 100px;">Newsletters</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#photos" role="button" style="height: 100px;">Photos</a>
                </div>
            </div>
        </div>

        <div class="col-12 order-1 col-lg order-lg-2 mb-lg-0 d-flex flex-column">
            <div id="carousel" class="carousel slide container mb-4" data-ride="carousel">
                <?php if (count($records = SuperEightFestivalsFederationPhoto::get_all()) > 0): ?>
                    <ol class="carousel-indicators">
                        <?php foreach ($records as $index => $record): ?>
                            <li data-target="#carousel" data-slide-to="<?= $index ?>" class="<?= $index == 0 ? "active " : "" ?>"></li>
                        <?php endforeach; ?>
                    </ol>
                <?php endif; ?>
                <div class="carousel-inner">
                    <?php if (count($records = SuperEightFestivalsFederationPhoto::get_all()) == 0): ?>
                        <div class="carousel-item active" style="background-image: url(http://placehold.it/400x400);">
                            <img class="d-block w-100" src="http://placehold.it/400x400" alt="First slide" loading="lazy">
                        </div>
                    <?php else: ?>
                        <?php foreach ($records as $index => $record): ?>
                            <?php
                            $file = $record->get_file();
                            ?>
                            <div class="carousel-item <?= $index == 0 ? "active " : "" ?>">
                                <img class="d-block w-100" src="<?= get_relative_path($file->get_path()); ?>" alt="<?= $file->title; ?>">
                                <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5);">
                                    <h5><?= $file->title; ?></h5>
                                    <p><?= $file->description; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div class="col-6 order-3 col-lg-3 order-lg-3">
            <div class="row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#magazines" role="button" style="height: 100px;">Magazines</a>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3 d-flex align-items-center justify-content-center" href="#by-laws" role="button" style="height: 100px;">By-Laws</a>
                </div>
            </div>
        </div>
    </div>
</div>


<section class="container my-5" id="federation">

    <div class="row">
        <div class="col">
            <h2 class="my-4">Federation</h2>
        </div>
    </div>

    <div class="row my-5" id="filmmaker-films">
        <div class="col">
            <h3>Newsletters</h3>
            <div id="newsletters"></div>
        </div>
    </div>

    <div class="row my-5" id="filmmaker-photos">
        <div class="col">
            <h3>Photos</h3>
            <div id="photos"></div>
        </div>
    </div>

    <div class="row my-5" id="filmmaker-photos">
        <div class="col">
            <h3>Magazines</h3>
            <div id="magazines"></div>
        </div>
    </div>

    <div class="row my-5" id="filmmaker-photos">
        <div class="col">
            <h3>By-Laws</h3>
            <div id="by-laws"></div>
        </div>
    </div>

</section>


<script type="module" src="/plugins/SuperEightFestivals/views/public/javascripts/components/s8f-embed-record-cards.js"></script>
<script type="module" src="/plugins/SuperEightFestivals/views/public/javascripts/components/s8f-file-record-cards.js"></script>
<script type="module">
    import { html, render } from "/plugins/SuperEightFestivals/views/shared/javascripts/vendor/lit-html.js";
    import API, { HTTPRequestMethod } from "/plugins/SuperEightFestivals/views/shared/javascripts/api.js";

    const fetchNewsletters = () => API.performRequest(API.constructURL(["federation", "newsletters"]), HTTPRequestMethod.GET);
    const fetchPhotos = () => API.performRequest(API.constructURL(["federation", "photos"]), HTTPRequestMethod.GET);
    const fetchMagazines = () => API.performRequest(API.constructURL(["federation", "magazines"]), HTTPRequestMethod.GET);
    const fetchBylaws = () => API.performRequest(API.constructURL(["federation", "bylaws"]), HTTPRequestMethod.GET);

    $(() => {
        fetchNewsletters().then((newsletters) => {
            render(
                html`<s8f-file-record-cards .files=${newsletters}></s8f-file-record-cards>`,
                document.getElementById("newsletters"),
            );
        });
        fetchPhotos().then((photos) => {
            render(
                html`<s8f-file-record-cards .files=${photos}></s8f-file-record-cards>`,
                document.getElementById("photos"),
            );
        });
        fetchPhotos().then((magazines) => {
            render(
                html`<s8f-file-record-cards .files=${magazines}></s8f-file-record-cards>`,
                document.getElementById("magazines"),
            );
        });
        fetchPhotos().then((bylaws) => {
            render(
                html`<s8f-file-record-cards .files=${bylaws}></s8f-file-record-cards>`,
                document.getElementById("by-laws"),
            );
        });
    });
</script>

<?php echo foot(); ?>
