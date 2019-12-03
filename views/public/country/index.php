<?php
$head = array(
    'title' => $country->name,
);
queue_css_file('country');
echo head($head);
?>

<?php
$bannerPlaceholderImage = img('placeholder.svg', 'images');
?>

<?php echo flash(); ?>

<section class="container-fluid">

    <div class="row">
        <div class="col d-flex justify-content-center">
            <h2 class="text-capitalize text-center"><?= $country->name; ?></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-6 order-2 col-lg-3 order-1">
            <div class="row button-row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3" href="#" role="button">Posters</a>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3" href="#" role="button">Photos</a>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3" href="#" role="button">Newspapers &amp; Magazines</a>
                </div>
            </div>
        </div>

        <div class="col-12 order-1 col-lg order-lg-2 mb-lg-0 mb-4 d-flex flex-column justify-content-center align-items-center ">
            <div class="d-flex flex-column justify-content-center align-items-center bg-dark" style="background-color:#2e2e2e; color: #FFFFFF;">
                <img class="img-fluid" src="<?= get_banner_for_country($country->id)->path; ?>" alt="Banner Image" style="max-height: 40vh;"/>
            </div>
        </div>

        <div class="col-6 order-3 col-lg-3 order-lg-3">
            <div class="row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3" href="#" role="button">Memorabilia</a>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3" href="#" role="button">Films</a>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3" href="#" role="button">Filmmakers</a>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <a class="btn btn-block btn-lg btn-dark pt-4 pb-4 mb-3" href="#" role="button">Film Catalogs</a>
                </div>
            </div>
        </div>

    </div>


    <!--=========================================================================================-->


    <!--Posters-->
    <section id="posters" class="container d-flex flex-column justify-content-center mt-5">
        <div class="row">
            <div class="col">
                <h3>Posters</h3>
            </div>
        </div>
        <div class="row">
            <?php foreach (get_all_posters_for_country($country->id) as $poster): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img class="img-fluid" src="<?= $poster->path; ?>" alt="<?= $poster->title; ?>"/>
                        <div class="card-body">
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</section>


<?php echo foot(); ?>
