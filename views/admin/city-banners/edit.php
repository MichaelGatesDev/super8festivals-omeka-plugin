<?php
queue_css_file("admin");
queue_js_file("jquery.min");
queue_js_file("preview-file");

echo head(array(
    'title' => 'Edit City Banner for ' . $city->name,
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
