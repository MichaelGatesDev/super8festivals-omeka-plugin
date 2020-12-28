<?php
echo head(array(
    'title' => 'Debug',
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<h2>Dropped All Tables</h2>

<?php echo foot(); ?>
