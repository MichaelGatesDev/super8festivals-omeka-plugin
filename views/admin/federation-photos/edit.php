<?php
queue_css_file("admin");
queue_js_file("jquery.min");
queue_js_file("preview-file");
queue_js_file("sort-selects");
echo head(array(
    'title' => 'Edit Federation Photo: ' . (strlen($federation_photo->title) > 0 ? ucwords($federation_photo->title) : "Untitled"),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
