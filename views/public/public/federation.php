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
            <li class="nav-item"><a class="nav-link" href="#newsletters">Newsletters</a></li>
            <li class="nav-item"><a class="nav-link" href="#photos">Photos</a></li>
            <li class="nav-item"><a class="nav-link" href="#magazines">Magazines</a></li>
            <li class="nav-item "><a class="nav-link" href="#by-laws">By Laws</a></li>
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
            <div id="carouselExampleIndicators" class="carousel slide container" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active" style="background-image: url(http://placehold.it/400x400);">
                        <img class="d-block w-100" src="http://placehold.it/400x400" alt="First slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
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
        <div class="row records-row" id="newsletters">
            <div class="col">
                <h2 class="mb-4">Newsletters</h2>
                <?php if (count($records = get_all_federation_newsletters()) > 0): ?>
                    <div class="row">
                        <div class="col">
                            <div class="card-columns">
                                <?php foreach ($records as $record): ?>
                                    <?= $this->partial("__components/cards/document-card.php", array("document" => $record)); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p>There are no newsletters here yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <!--Photos-->
        <div class="row records-row" id="photos">
            <div class="col">
                <h2 class="mb-4">Photos</h2>
                <?php if (count($records = get_all_federation_photos()) > 0): ?>
                    <div class="row">
                        <div class="col">
                            <div class="card-columns">
                                <?php foreach ($records as $record): ?>
                                    <?= $this->partial("__components/cards/image-card.php", array("image" => $record)); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p>There are no photos here yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <!--Magazines-->
        <div class="row records-row" id="magazines">
            <div class="col">
                <h2 class="mb-4">Magazines</h2>
                <?php if (count($records = get_all_federation_magazines()) > 0): ?>
                    <div class="row">
                        <div class="col">
                            <div class="card-columns">
                                <?php foreach ($records as $record): ?>
                                    <?= $this->partial("__components/cards/document-card.php", array("document" => $record)); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p>There are no magazines here yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <!--By-Laws-->
        <div class="row records-row" id="by-laws">
            <div class="col">
                <h2 class="mb-4">By-Laws</h2>
                <?php if (count($records = get_all_federation_bylaws()) > 0): ?>
                    <div class="row">
                        <div class="col">
                            <div class="card-columns">
                                <?php foreach ($records as $record): ?>
                                    <?= $this->partial("__components/cards/document-card.php", array("document" => $record)); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p>There are no by-laws here yet.</p>
                <?php endif; ?>
            </div>
        </div>


    </div>

</section>

<?php echo foot(); ?>
