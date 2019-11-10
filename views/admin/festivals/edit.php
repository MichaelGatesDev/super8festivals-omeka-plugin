<?php
echo head(array(
    'title' => 'Edit Festival: ' . metadata('super_eight_festivals_festival', 'name'),
));
?>

<?php echo flash(); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
