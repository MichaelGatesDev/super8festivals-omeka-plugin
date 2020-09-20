<?php
echo head(array(
    'title' => 'Federation',
));

$newsletters = SuperEightFestivalsFederationNewsletter::get_all();
$photos = SuperEightFestivalsFederationPhoto::get_all();
$magazines = SuperEightFestivalsFederationPhoto::get_all();
$by_laws = SuperEightFestivalsFederationBylaw::get_all();

$root_url = "/admin/super-eight-festivals/federation";
?>

<section id="federation" class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2 class="mb-4">Federation</h2>
        </div>
    </div>


    <?= $this->partial("__components/federation-records-page.php", array(
        "admin" => true,
        "root_url" => $root_url,
        "records" => array(
            "newsletters" => $newsletters,
            "photos" => $photos,
            "magazines" => $magazines,
            "by_laws" => $by_laws,
        )
    ));
    ?>

</section>

<?php echo foot(); ?>
