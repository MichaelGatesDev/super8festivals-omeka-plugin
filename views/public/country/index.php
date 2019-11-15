<?php
$head = array(
    'title' => $country->name,
);
queue_css_file('country');
echo head($head);
?>

<?php echo flash(); ?>

<section class="container-fluid">

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
                        <a href="">
                            <span>Button</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <div class="button">
                        <a href="">
                            <span>Button</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <div class="button">
                        <a href="">
                            <span>Button</span>
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
                        <a href="">
                            <span>Button</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <div class="button">
                        <a href="">
                            <span>Button</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row button-row">
                <div class="col">
                    <div class="button">
                        <a href="">
                            <span>Button</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- mini-map to show the country in relation to other countries-->
    <div class="country-map" id="country-map">
    </div>


    <!--Display a list of festivals-->
    <h3>Festivals:</h3>
    <ul>
        <li>Example Festival Here</li>
    </ul>

</section>


<?php echo foot(); ?>
