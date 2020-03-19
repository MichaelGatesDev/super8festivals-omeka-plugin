<?php
queue_css_file("admin");
queue_js_file("jquery.min");
echo head(
    array(
        'title' => 'Federation',
    )
);
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
</style>


<h2>Documents</h2>


<h2>Photos</h2>

<?php echo foot(); ?>
