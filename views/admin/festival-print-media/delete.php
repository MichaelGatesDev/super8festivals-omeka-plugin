<?php
queue_css_file("admin");
queue_js_file("jquery.min");
queue_js_file("admin");
echo head(array(
    'title' => 'Delete Print Media: ' . (strlen($print_media->title) > 0 ? ucwords($print_media->title) : "Untitled"),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<h2>Are you sure?</h2>
<?php echo $form; ?>

<?php echo foot(); ?>
