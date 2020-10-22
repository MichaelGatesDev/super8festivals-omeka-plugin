<?php
echo head(array(
    'title' => ucwords($city->name) . ", " . ucwords($country->name),
));

$rootURL = "/admin/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name);
?>

<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2 class="text-capitalize"><?= $city->name; ?> <span class="text-muted">(<?= $country->name; ?>)</span></h2>
        </div>
    </div>

    <!-- S8F Alerts -->
    <div class="row">
        <div class="col">
            <s8f-alerts-area id="alerts"></s8f-alerts-area>
        </div>
    </div>

    <!--    Description -->
    <div class="row my-5">
        <div class="col">
            <h3>
                Description
                <a class="btn btn-primary btn-sm" href="<?= $rootURL; ?>/edit">Edit Description</a>
            </h3>
            <?php $description = $city->description; ?>
            <?php if ($description == null): ?>
                <p>There is no description available for this city.</p>
            <?php else: ?>
                <?= $description; ?>
            <?php endif; ?>
        </div>
    </div>

    <!--    City Banner -->
    <div class="row my-5">
        <div class="col">
            <h3>City Banner</h3>
            <?php $city_banner = $city->get_banner(); ?>
            <?php if ($city_banner == null): ?>
                <p>There is no banner available for this city.</p>
                <a class="btn btn-success" href="<?= $rootURL; ?>/banners/add">Add City Banner</a>
            <?php else: ?>
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?= get_relative_path($city_banner->get_thumbnail_path()); ?>" alt="<?= $city_banner->title; ?>" loading="lazy"/>
                    <div class="card-body">
                        <a class="btn btn-primary" href="<?= $rootURL; ?>/banners/<?= $city_banner->id; ?>/edit">Edit</a>
                        <a class="btn btn-danger" href="<?= $rootURL; ?>/banners/<?= $city_banner->id; ?>/delete">Delete</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <s8f-festivals-table country-id="<?= $country->id; ?>" city-id="<?= $city->id; ?>"></s8f-festivals-table>
        </div>
    </div>


</section>


<?php echo foot(); ?>

