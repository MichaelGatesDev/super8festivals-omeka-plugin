<?php
echo head(array(
    'title' => 'Edit Filmmaker: ' . ucwords($filmmaker->get_display_name()),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
