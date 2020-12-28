<?php
$country_loc = $country->get_location();
$city_loc = $city->get_location();
$rootURL = "/admin/super-eight-festivals/countries/" . urlencode($country_loc->name) . "/cities/" . urlencode($city_loc->name);
?>

<?= $this->partial("__partials/header.php", ["title" => ucwords($country_loc->name)]); ?>

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
                <?= $city_loc->name; ?>
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
            <s8f-city-banner
                country-id="<?= $country->id; ?>"
                city-id="<?= $city->id; ?>"
            ></s8f-city-banner>
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
<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-city-banner.js'></script>

<?= $this->partial("__partials/footer.php") ?>
