<?php
echo head(array(
    'title' => 'Edit Festival: ' . ucwords($festival->getDisplayName()),
));
?>

<?php echo flash(); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
