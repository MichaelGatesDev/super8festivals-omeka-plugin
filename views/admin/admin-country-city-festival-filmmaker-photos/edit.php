<?php
queue_js_file("preview-file");
queue_js_file("sort-selects");
echo head(array(
    'title' => 'Edit filmmaker photo for ' . $filmmaker->get_display_name(),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<script type='module' src='/plugins/SuperEightFestivals/views/shared/javascripts/preview-file.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/shared/javascripts/sort-selects.js'></script>

<?php echo foot(); ?>
