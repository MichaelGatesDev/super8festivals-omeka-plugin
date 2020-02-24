<?php
echo head(array(
    'title' => ucwords($city->name),
));
?>


<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>


<h2>Festivals</h2>

<!-- 'Add City' Button -->
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/festivals/add', 'text' => 'Add Festival')); ?>

<?=
$this->partial('__components/tables/FestivalsTable.php',
    array(
        'festivalsVar' => get_all_festivals_in_city($city->id),
    )
);
?>


<?php echo foot(); ?>
