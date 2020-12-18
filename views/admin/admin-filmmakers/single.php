<?= $this->partial("__partials/header.php", ["title" => "Staff: " . ucwords($filmmaker->get_person()->get_name())]); ?>

<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

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
            <h2 class="text-capitalize"><?= $filmmaker->get_person()->get_name(); ?></h2>
        </div>
    </div>

    <!-- Films -->
    <div class="row my-4" id="films">
        <div class="col">
            <s8f-filmmaker-films-table filmmaker-id="<?= $filmmaker->id; ?>"></s8f-filmmaker-films-table>
        </div>
    </div>

    <!-- Photos -->
    <div class="row my-4" id="photos">
        <div class="col">
            <s8f-filmmaker-photos-table filmmaker-id="<?= $filmmaker->id; ?>"></s8f-filmmaker-photos-table>
        </div>
    </div>

</section>

<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-filmmaker-films-table.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-filmmaker-photos-table.js'></script>

<?= $this->partial("__partials/footer.php") ?>
