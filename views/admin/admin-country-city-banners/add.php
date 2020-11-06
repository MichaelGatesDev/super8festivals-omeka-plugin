<?php
echo head(array(
    'title' => 'Add City Banner for ' . $city->name,
));
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
            <h3>Add City Banner</h3>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php echo $form; ?>
        </div>
    </div>

</section>


<script type='module' src='/plugins/SuperEightFestivals/views/shared/javascripts/preview-file.js'></script>

<?php echo foot(); ?>
