<?php
echo head(array(
    'title' => 'Edit Country: ' . $country->name,
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
