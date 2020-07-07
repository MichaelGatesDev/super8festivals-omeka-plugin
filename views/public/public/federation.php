<?php
$head = array(
    'title' => "Federation",
);

queue_css_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css");
queue_js_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js");

echo head($head);

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

    .carousel-inner > .carousel-item {
        height: 500px;
    }

    .carousel-inner > .carousel-item img {
        height: 500px;
        object-fit: cover;
    }

    .records-row {
        margin: 4em 0;
    }
</style>

<div class="container-fluid overflow-hidden" id="landing">
    <div class="row">
        <div class="col">
            <h2 class="text-center py-2 title">Federation</h2>
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

        <div class="col-12 order-1 col-lg order-lg-2 mb-lg-0 mb-4 d-flex flex-column">
            <div id="carouselIndicators" class="carousel slide container" data-ride="carousel">
                <?php if (count($records = get_all_federation_photos()) > 0): ?>
                    <ol class="carousel-indicators">
                        <?php foreach ($records as $index => $record): ?>
                            <li data-target="#carouselIndicators" data-slide-to="<?= $index ?>" class="<?= $index == 0 ? "active " : "" ?>"></li>
                        <?php endforeach; ?>
                    </ol>
                <?php endif; ?>
                <div class="carousel-inner">
                    <?php if (count($records = get_all_federation_photos()) == 0): ?>
                        <div class="carousel-item active" style="background-image: url(http://placehold.it/400x400);">
                            <img class="d-block w-100" src="http://placehold.it/400x400" alt="First slide">
                        </div>
                    <?php else: ?>
                        <?php foreach ($records as $index => $record): ?>
                            <div class="carousel-item <?= $index == 0 ? "active " : "" ?>" style="background-image: url(<?= get_relative_path($record->get_path()); ?>);">
                                <img class="d-block w-100" src="<?= get_relative_path($record->get_path()); ?>" alt="<?= $record->title; ?>">
                                <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5);">
                                    <h5><?= $record->get_meta_title() ?></h5>
                                    <p><?= $record->description; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
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

<section class="container-fluid" id="countries-list">

    <div class="container py-2">


        <!--Newsletters-->
        <div class="row mb-4">
            <div class="col">
                <h3>Newsletters</h3>
                <?php $newsletters = get_all_federation_newsletters(); ?>
                <?php if (count($newsletters) == 0): ?>
                    <p>There are no newsletters available for the federation.</p>
                <?php else: ?>
                    <div class="row row-cols">
                        <?php foreach ($newsletters as $newsletter): ?>
                            <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $newsletter)); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!--Photos-->
        <div class="row my-4">
            <div class="col bg-light">
                <h3>Photos</h3>
                <?php $photos = get_all_federation_photos(); ?>
                <?php if (count($photos) == 0): ?>
                    <p>There are no photos available for the federation.</p>
                <?php else: ?>
                    <div class="row row-cols">
                        <?php foreach ($photos as $photo): ?>
                            <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $photo)); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!--Magazines-->
        <div class="row my-4">
            <div class="col">
                <h3>Magazines</h3>
                <?php $magazines = get_all_federation_magazines(); ?>
                <?php if (count($magazines) == 0): ?>
                    <p>There are no magazines available for the federation.</p>
                <?php else: ?>
                    <div class="row row-cols">
                        <?php foreach ($magazines as $magazine): ?>
                            <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $magazine)); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!--By-Laws-->
        <div class="row my-4">
            <div class="col bg-light">
                <h3>By-Laws</h3>
                <?php $bylaws = get_all_federation_bylaws(); ?>
                <?php if (count($bylaws) == 0): ?>
                    <p>There are no by-laws available for the federation.</p>
                <?php else: ?>
                    <div class="row row-cols">
                        <?php foreach ($bylaws as $bylaw): ?>
                            <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $bylaw)); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

</section>

<?php echo foot(); ?>
