<?php
echo head(array(
    'title' => 'Delete Film Catalog: ' . ucwords($film_catalog->title),
));
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<h2>Are you sure?</h2>
<?php echo $form; ?>

<?php echo foot(); ?>
