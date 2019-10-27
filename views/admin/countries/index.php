<?php
echo head(array(
    'title' => html_escape(__('Super 8 Festivals | Countries')),
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<!-- 'Add Country' Button -->
<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add Country')); ?>

<!-- Table of countries (editable) -->
<?php echo $this->partial('__components/tables/editable-record-table.php', array(
    'recordsVar' => 'super_eight_festivals_country',
    'recordType' => 'SuperEightFestivalsCountry',
    'headers' => array('Name', 'Latitude', 'Longitude'),
    'titleVar' => 'name',
    'metaKeys' => array('latitude', 'longitude'),
)); ?>

<?php echo foot(); ?>
