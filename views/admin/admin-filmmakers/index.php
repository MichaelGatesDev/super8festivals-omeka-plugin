<?php
echo head(array(
    'title' => 'Filmmakers',
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
            <s8f-filmmakers-table></s8f-filmmakers-table>
        </div>
    </div>

</section>

<?php echo foot(); ?>

