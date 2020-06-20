<?php
queue_css_file("admin");
queue_js_file("jquery.min");

echo head(array(
    'title' => 'Delete Federation Photo: ' . (strlen($federation_photo->title) > 0 ? ucwords($federation_photo->title) : "Untitled"),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<h2>Are you sure?</h2>
<?php echo $form; ?>

<?php echo foot(); ?>
