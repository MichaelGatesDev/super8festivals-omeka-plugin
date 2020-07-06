<?php
echo head(array(
    'title' => 'Add Filmmaker for ' . $festival->get_title(),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
