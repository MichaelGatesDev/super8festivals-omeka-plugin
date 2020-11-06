<?php
echo head(array(
    'title' => 'Edit Staff: ' . ucwords($staff->get_display_name()),
));
?>

<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <h2>Edit Staff</h2>
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
