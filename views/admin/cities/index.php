<?php
echo head(array(
    'title' => html_escape(__('Super 8 Festivals | Cities')),
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<!-- 'Add City' Button -->
<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add City')); ?>

<!-- Table of countries (editable) -->
<?php echo $this->partial('__components/tables/editable-record-table.php', array(
    'recordsVar' => 'super_eight_festivals_city',
    'recordType' => 'SuperEightFestivalsCity',
    'headers' => array('Name', 'Latitude', 'Longitude', 'Parent Country'),
    'titleVar' => 'name',
    'metaKeys' => array('latitude', 'longitude', 'country_id'),
)); ?>

<?php echo foot(); ?>
