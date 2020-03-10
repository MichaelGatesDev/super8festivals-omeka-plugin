<?php
echo head(array(
    'title' => 'Delete City: ' . $city->name,
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<h2>Are you sure?</h2>
<?php echo $form; ?>

<?php echo foot(); ?>
