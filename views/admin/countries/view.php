<?php
echo head(array(
    'title' => ucfirst($country->name),
));
?>

<?php echo flash(); ?>


<h2>Cities</h2>

<!-- 'Add City' Button -->
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/cities/add', 'text' => 'Add City')); ?>

<?=
$this->partial('__components/tables/CitiesTable.php',
    array(
        'citiesVar' => get_all_cities_in_country($country->id),
    )
);
?>

<?php echo foot(); ?>
