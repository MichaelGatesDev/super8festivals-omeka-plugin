<?php

echo head(array(
    'title' => 'Edit City: ' . ucwords($super_eight_festivals_city->name),
));
?>

<?php echo flash(); ?>

<div style="display: flex; flex-direction: column;">
    <div style="position: relative; width: 100%; height: 100%; ">
        <?php echo $form; ?>
    </div>
</div>

<?php echo foot(); ?>
