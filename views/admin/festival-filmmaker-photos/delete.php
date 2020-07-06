<?php
echo head(array(
    'title' => 'Delete filmmaker photo for ' . $filmmaker->get_display_name(),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<h2>Are you sure?</h2>
<?php echo $form; ?>

<?php echo foot(); ?>
