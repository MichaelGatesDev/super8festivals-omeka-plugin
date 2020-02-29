<?php
echo head(array(
    'title' => 'Edit Film Catalog: ' . ucwords($catalog->title),
));
?>

<?php echo flash(); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
