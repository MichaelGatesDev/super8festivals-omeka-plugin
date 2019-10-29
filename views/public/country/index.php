<?php
$head = array(
    'title' => html_escape(__('Super 8 Festivals | About')),
);
echo head($head);
?>

<?php echo flash(); ?>


<p>This is the country controller</p>


<?php echo json_encode($country); ?>

<?php echo foot(); ?>
