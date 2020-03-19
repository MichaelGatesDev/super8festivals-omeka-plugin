<?php
queue_css_file("admin");
queue_js_file("jquery.min");
queue_js_file("admin");
echo head(array(
    'title' => 'Add Print Media',
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
