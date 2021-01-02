<?php
$country_loc = $country->get_location();
$city_loc = $city->get_location();
$city_url = "/admin/super-eight-festivals/countries/" . urlencode($country_loc->name) . "/cities/" . urlencode($city_loc->name);
$root_url = $city_url . "/nearby-festivals/" . $festival->id;
?>

<?= $this->partial("__partials/header.php", ["title" => "Nearby Festival: {$festival->get_title()}"]); ?>

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
                Nearby Festival: <?= $festival->get_title(); ?>
            </h2>
        </div>
    </div>

    <!-- S8F Alerts -->
    <div class="row">
        <div class="col">
            <s8f-alerts-area id="alerts"></s8f-alerts-area>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <s8f-nearby-festival-photos-table
                country-id="<?= $country->id; ?>"
                city-id="<?= $city->id; ?>"
                festival-id="<?= $festival->id; ?>"
            >
            </s8f-nearby-festival-photos-table>
        </div>
    </div>

    <div class="row my-5">
        <div class="col">
            <s8f-nearby-festival-print-media-table
                country-id="<?= $country->id; ?>"
                city-id="<?= $city->id; ?>"
                festival-id="<?= $festival->id; ?>"
            >
            </s8f-nearby-festival-print-media-table>
        </div>
    </div>

</section>

<script type='module' src='<?= get_relative_path(__DIR__ . "/../javascripts/components/s8f-nearby-festival-photos-table.js"); ?>'></script>
<script type='module' src='<?= get_relative_path(__DIR__ . "/../javascripts/components/s8f-nearby-festival-print-media-table.js"); ?>'></script>

<?= $this->partial("__partials/footer.php") ?>
