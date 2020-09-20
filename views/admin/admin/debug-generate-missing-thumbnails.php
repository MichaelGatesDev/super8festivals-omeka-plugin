<?php
echo head(array(
    'title' => 'Debug',
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<h2>Generated [missing] thumbnails</h2>

<?php echo foot(); ?>
