<?php
echo head(array(
    'title' => 'Edit Film Catalog: ' . (strlen($film_catalog->title) > 0 ? ucwords($film_catalog->title) : "Untitled"),
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
            <h2>Edit Film Catalog</h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php echo $form; ?>
        </div>
    </div>

</section>

<script type='module' src='/plugins/SuperEightFestivals/views/shared/javascripts/preview-file.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/shared/javascripts/sort-selects.js'></script>

<?php echo foot(); ?>
