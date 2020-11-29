<?php

$country_loc = $country->get_location();
$city_loc = $city->get_location();

echo head(array(
    'title' => ucwords($city_loc->name) . ", " . ucwords($country_loc->name),
));

$rootURL = "/admin/super-eight-festivals/countries/" . urlencode($country_loc->name) . "/cities/" . urlencode($city_loc->name);
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
            <h2 class="text-capitalize">
                <?= $city_loc->name; ?>&nbsp;
                <span class="text-muted">(<?= $country_loc->name; ?>)</span>
            </h2>
        </div>
    </div>

    <!-- S8F Alerts -->
    <div class="row">
        <div class="col">
            <s8f-alerts-area id="alerts"></s8f-alerts-area>
        </div>
    </div>

    <!--  Description -->
    <div class="row my-5">
        <div class="col">
            <h3>Description</h3>
            <?php $description = $city_loc->description; ?>
            <?php if ($description == null): ?>
                <p>There is no description available for this city.</p>
            <?php else: ?>
                <div class="form-group">
                    <textarea class="form-control" readonly><?= $description; ?></textarea>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!--  City Banner -->
    <div class="row my-5">
        <div class="col">
            <h3>City Banner</h3>
            <?php $city_banner = $city->get_banner(); ?>
            <?php if ($city_banner == null): ?>
                <p>There is no banner available for this city.</p>
                <a class="btn btn-success" href="<?= $rootURL; ?>/banners/add">Add City Banner</a>
            <?php else: ?>
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?= get_relative_path($city_banner->get_file()->get_thumbnail_path()); ?>" alt="<?= $city_banner->get_file()->title; ?>" loading="lazy"/>
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
            <s8f-festivals-table
                    country-id="<?= $country->id; ?>"
                    city-id="<?= $city->id; ?>"
            >
            </s8f-festivals-table>
        </div>
    </div>


</section>

<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-festivals-table.js'></script>

<?php echo foot(); ?>

