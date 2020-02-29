<?php
echo head(array(
    'title' => 'Edit Film Catalog: ' . ucwords($film_catalog->title),
));
?>

<?php echo flash(); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
