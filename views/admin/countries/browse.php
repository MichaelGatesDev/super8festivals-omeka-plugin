<?php
echo head(array(
    'title' => 'Browse Countries',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<!-- 'Add City' Button -->
<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add Country')); ?>

<?= $this->partial('__components/tables/CountriesTable.php',
    array(
        'countriesVar' => get_all_countries(),
    )
); ?>

<?php echo foot(); ?>

