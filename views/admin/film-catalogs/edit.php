<?php
echo head(array(
    'title' => 'Edit Film Catalog: ' . ucwords($film_catalog->title),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
