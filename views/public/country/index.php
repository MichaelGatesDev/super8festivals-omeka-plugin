<?php
$head = array(
    'title' => $country->name,
);
queue_css_file('country');
echo head($head);
?>

<?
$placeholderImage = img('placeholder.svg', 'images');
?>

<?php echo flash(); ?>

<section class="container-fluid">

    <section class="d-flex flex-column w-100 justify-content-center">
        <!--The name of the country-->
        <div class="row">
            <div class="col">
                <h2 class="country-name"><?= $country->name; ?></h2>
            </div>
        </div>

        <div class="row">

            <div class="col-6 order-2 col-lg-2 order-1">
                <div class="row button-row">
                    <div class="col">
                        <div class="button">
                            <a href="#posters">
                                <span>Posters</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row button-row">
                    <div class="col">
                        <div class="button">
                            <a href="#photos">
                                <span>Photos</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row button-row">
                    <div class="col">
                        <div class="button">
                            <a href="#printMedia">
                                <span>Newspapers &amp; Magazines</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 order-1 col-lg-8 order-lg-2">
                <div class="banner">
                    <a href="">
                        <span>This is where the banner image goes</span>
                    </a>
                </div>
            </div>

            <div class="col-6 order-3 col-lg-2 order-lg-3">
                <div class="row button-row">
                    <div class="col">
                        <div class="button">
                            <a href="#memorabilia">
                                <span>Memorabilia</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row button-row">
                    <div class="col">
                        <div class="button">
                            <a href="#films">
                                <span>Films</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row button-row">
                    <div class="col">
                        <div class="button">
                            <a href="#filmmakers">
                                <span>Film Makers</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row button-row">
                    <div class="col">
                        <div class="button">
                            <a href="#filmCatalogs">
                                <span>Film Catalogs</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!--Posters-->
    <section id="posters" class="vh-100 d-flex flex-column w-100 justify-content-center">
        <div class="row">
            <div class="col">
                <h3>Posters</h3>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis viverra nibh cras pulvinar mattis nunc sed. Quis hendrerit dolor magna eget est lorem. Urna et pharetra pharetra massa. Nunc faucibus a pellentesque
                    sit amet porttitor. A diam maecenas sed enim ut. Vestibulum sed arcu non odio euismod lacinia at quis risus. Senectus et netus et malesuada fames ac turpis egestas integer. Et egestas quis ipsum suspendisse ultrices gravida. Morbi tristique senectus et netus. Nec dui nunc mattis
                    enim ut tellus elementum. Id cursus metus aliquam eleifend mi in nulla. Cras adipiscing enim eu turpis egestas. Senectus et netus et malesuada fames ac. Porttitor lacus luctus accumsan tortor posuere ac ut consequat semper.
                </p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis viverra nibh cras pulvinar mattis nunc sed. Quis hendrerit dolor magna eget est lorem. Urna et pharetra pharetra massa. Nunc faucibus a pellentesque
                    sit amet porttitor. A diam maecenas sed enim ut. Vestibulum sed arcu non odio euismod lacinia at quis risus. Senectus et netus et malesuada fames ac turpis egestas integer. Et egestas quis ipsum suspendisse ultrices gravida. Morbi tristique senectus et netus. Nec dui nunc mattis
                    enim ut tellus elementum. Id cursus metus aliquam eleifend mi in nulla. Cras adipiscing enim eu turpis egestas. Senectus et netus et malesuada fames ac. Porttitor lacus luctus accumsan tortor posuere ac ut consequat semper.
                </p>
            </div>
            <div class="col">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" height="600px" src="<?= img('placeholder.svg', 'images') ?>" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" height="600px" src="<?= img('placeholder.svg', 'images') ?>" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" height="600px" src="<?= img('placeholder.svg', 'images') ?>" alt="Third slide">
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
        </div>
    </section>

</section>


<?php echo foot(); ?>
