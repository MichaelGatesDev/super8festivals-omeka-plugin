<?php
echo head(array(
    'title' => $country->name,
));
?>
<s8f-modal modal-id="modal"></s8f-modal>

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
            <?= $this->partial("__components/alerts.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2 class="text-capitalize mb-4">
                <?= $country->name; ?>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <s8f-cities-table country-id="<?= $country->id; ?>"></s8f-cities-table>
        </div>
    </div>

</section>


<?php echo foot(); ?>

