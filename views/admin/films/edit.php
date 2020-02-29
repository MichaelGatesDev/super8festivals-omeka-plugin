<?php
echo head(array(
    'title' => 'Edit Film: ' . ucwords($film->title),
));
?>

<?php echo flash(); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
