<?php
$head = array(
    'title' => $country->name,
);
echo head($head);
?>

<?php echo flash(); ?>


<p>This is the country controller</p>


<?php echo json_encode($country); ?>

<?php echo foot(); ?>
