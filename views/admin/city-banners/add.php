<?php
queue_css_file("admin");
queue_js_file("jquery.min");
queue_js_file("preview-file");

echo head(array(
    'title' => 'Add City Banner for ' . $city->name,
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
    #file {
        border: 1px solid red;
    }
</style>

<?php echo $form; ?>

<?php echo foot(); ?>
