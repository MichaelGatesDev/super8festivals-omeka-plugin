<?php
echo head(array(
    'title' => 'Browse Festivals',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<!-- 'Add Festival' Button -->
<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add Festival')); ?>

<!-- Table of countries (editable) -->
<?php echo $this->partial('__components/tables/editable-record-table.php', array(
    'recordsVar' => 'super_eight_festivals_festival',
    'recordType' => 'SuperEightFestivalsFestival',
    'headers' => array('Name', 'Year', 'City ID', 'Country ID', 'Internal ID'),
    'titleVar' => 'name',
    'metaKeys' => array('year', 'city_id', 'country_id', 'id'),
)); ?>


<?php echo foot(); ?>

