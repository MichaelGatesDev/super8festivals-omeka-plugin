<?php
echo head(array(
    'title' => ucwords($country->get_location()->name),
));
?>

<section class="container">

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <!-- Omeka Alerts -->
    <div class="row">
        <div class="col">
            <?= $this->partial("__partials/flash.php"); ?>
        </div>
    </div>

    <!-- S8F Alerts -->
    <div class="row">
        <div class="col">
            <s8f-alerts-area id="alerts"></s8f-alerts-area>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2 class="text-capitalize mb-4">
                <?= $country->get_location()->name; ?>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <s8f-cities-table
                    country-id="<?= $country->id; ?>"
            >
            </s8f-cities-table>
        </div>
    </div>

</section>

<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-cities-table.js'></script>

<?php echo foot(); ?>

