<?php
echo head(array(
    'title' => 'Edit City: ' . metadata('super_eight_festivals_city', 'name'),
));
?>

<?php echo flash(); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
