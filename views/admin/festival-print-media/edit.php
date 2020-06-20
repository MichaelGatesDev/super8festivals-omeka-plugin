<?php
queue_css_file("admin");
queue_js_file("jquery.min");
queue_js_file("preview-file");
queue_js_file("sort-selects");
echo head(array(
    'title' => 'Edit Print Media: ' . (strlen($print_media->title) > 0 ? ucwords($print_media->title) : "Untitled"),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
