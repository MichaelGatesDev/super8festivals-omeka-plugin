<?php
echo head(array(
    'title' => 'Edit Filmmaker: ' . ucwords($filmmaker->email),
));
?>

<?php echo flash(); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
