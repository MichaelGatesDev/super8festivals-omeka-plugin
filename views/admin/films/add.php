<?php
queue_css_file("admin");
queue_js_file("jquery.min");
echo head(array(
    'title' => 'Add Film for ' . $festival->get_title(),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
