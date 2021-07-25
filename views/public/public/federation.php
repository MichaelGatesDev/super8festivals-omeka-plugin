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
            <div id="carousel" class="carousel slide container mb-4" data-bs-ride="carousel">
                <?php if (count($records = SuperEightFestivalsFederationPhoto::get_all()) > 0): ?>
                    <ol class="carousel-indicators">
                        <?php foreach ($records as $index => $record): ?>
                            <li data-bs-target="#carousel" data-bs-slide-to="<?= $index ?>" class="<?= $index == 0 ? "active " : "" ?>"></li>
                        <?php endforeach; ?>
                    </ol>
                <?php endif; ?>
                <div class="carousel-inner">
                    <?php if (count($records = SuperEightFestivalsFederationPhoto::get_all()) == 0): ?>
                        <div class="carousel-item active" style="background-image: url(http://placehold.it/400x400);">
                            <img class="d-block w-100" src="<?= img("placeholder.svg") ?>" alt="" loading="lazy">
                        </div>
                    <?php else: ?>
                        <?php foreach ($records as $index => $record): ?>
                            <?php
                            $file = $record->get_file();
                            ?>
                            <div class="carousel-item <?= $index == 0 ? "active " : "" ?>">
                                <img class="d-block w-100" src="<?= get_relative_path($file->get_path()); ?>" alt="">
                                <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5);">
                                    <h5><?= $file->title; ?></h5>
                                    <p><?= $file->description; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <a class="carousel-control-prev" href="#carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-bs-slide="next">
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

    <div class="row my-5" id="newsletters">
        <div class="col">
            <h3 class="ms-2">Newsletters</h3>
            <div id="newsletters-container"></div>
        </div>
    </div>

    <div class="row my-5" id="photos">
        <div class="col">
            <h3 class="ms-2">Photos</h3>
            <div id="photos-container"></div>
        </div>
    </div>

    <div class="row my-5" id="magazines">
        <div class="col">
            <h3 class="ms-2">Magazines</h3>
            <div id="magazines-container"></div>
        </div>
    </div>

    <div class="row my-5" id="by-laws">
        <div class="col">
            <h3 class="ms-2">By-Laws</h3>
            <div id="bylaws-container"></div>
        </div>
    </div>


</section>

<script type="module" src="/plugins/SuperEightFestivals/views/public/javascripts/components/s8f-card.js"></script>
<script type="module" src="/plugins/SuperEightFestivals/views/public/javascripts/components/s8f-federation-records.js"></script>
<script type="module">
    import { html, render } from "/plugins/SuperEightFestivals/views/shared/javascripts/vendor/lit-html.js";

    const newsletters = <?= json_encode(Super8FestivalsRecord::expand_arr(SuperEightFestivalsFederationNewsletter::get_all())); ?>;
    const photos = <?= json_encode(Super8FestivalsRecord::expand_arr(SuperEightFestivalsFederationPhoto::get_all())); ?>;
    const magazines = <?= json_encode(Super8FestivalsRecord::expand_arr(SuperEightFestivalsFederationMagazine::get_all())); ?>;
    const bylaws = <?= json_encode(Super8FestivalsRecord::expand_arr(SuperEightFestivalsFederationBylaw::get_all())); ?>;

    $(() => {
        render(
            html`
                <s8f-federation-records
                    .sectionId=${"newsletters"}
                    .records=${newsletters}
                >
                </s8f-federation-records>
            `,
            document.getElementById("newsletters-container"),
        );

        render(
            html`
                <s8f-federation-records
                    .sectionId=${"photos"}
                    .records=${photos}
                >
                </s8f-federation-records>
            `,
            document.getElementById("photos-container"),
        );

        render(
            html`
                <s8f-federation-records
                    .sectionId=${"magazines"}
                    .records=${magazines}
                >
                </s8f-federation-records>
            `,
            document.getElementById("magazines-container"),
        );

        render(
            html`
                <s8f-federation-records
                    .sectionId=${"bylaws"}
                    .records=${bylaws}
                >
                </s8f-federation-records>
            `,
            document.getElementById("bylaws-container"),
        );

        if (window.location.hash) {
            document.getElementById(window.location.hash.substring(1)).scrollIntoView();
        }
    });
</script>

<?php echo foot(); ?>
