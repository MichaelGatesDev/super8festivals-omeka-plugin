<?php
$head = array(
    'title' => __('Super 8 Festivals | Edit "%s"', metadata('super_eight_festivals_city', 'name'))
);
echo head($head);
?>

<?php echo flash(); ?>

<?php echo $form; ?>

<?php echo foot(); ?>
