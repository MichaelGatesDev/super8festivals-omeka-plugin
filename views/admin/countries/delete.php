<?php
echo head(array(
    'title' => 'Delete Country: ' . $country->name,
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<div title="<?php echo $pageTitle; ?>">
    <h2>Are you sure?</h2>
    <?php echo $form; ?>
</div>

<?php echo foot(); ?>
