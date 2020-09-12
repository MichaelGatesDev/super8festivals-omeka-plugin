<?php
echo head(array(
    'title' => 'Countries',
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
            <?= $this->partial("__components/alerts.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <s8f-countries-table></s8f-countries-table>
        </div>
    </div>

</section>

<?php echo foot(); ?>

