<?php
queue_css_file("admin");
queue_js_file("jquery.min");
echo head(
    array(
        'title' => 'Debug',
    )
);
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<h2>Generated [missing] thumbnails</h2>

<style>
</style>

<?php echo foot(); ?>
