<?php
queue_css_file("admin");
queue_js_file("jquery.min");
echo head(array(
    'title' => 'Add photo for ' . $filmmaker->get_display_name(),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
