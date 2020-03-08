<?php
echo head(array(
    'title' => 'Edit Banner: ' . $banner->id,
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
