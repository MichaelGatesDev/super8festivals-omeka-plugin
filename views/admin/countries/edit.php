<?php
echo head(array(
    'title' => 'Edit Country: ' . metadata('super_eight_festivals_country', 'name'),
));
?>

<?php echo flash(); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
