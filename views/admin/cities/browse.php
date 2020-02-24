<?php
echo head(array(
    'title' => 'Browse Cities',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<!-- 'Add City' Button -->
<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add City')); ?>

<?=
$this->partial('__components/tables/CitiesTable.php',
    array(
        'citiesVar' => get_all_cities(),
    )
);
?>

<?php echo foot(); ?>

